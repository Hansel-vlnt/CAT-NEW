# LAPORAN PENGUJIAN QA & AUDIT KEAMANAN (REAL TEST)
**Platform CBT Abdi Praja Edukasi**

- **Tanggal Pengujian**: 29 Oktober 2026
- **Peran Penguji**: QA Lead & Application Security Tester
- **Target Sistem**: Web CBT (Admin Portal & Siswa Portal)
- **Metodologi**: Real Data Testing (tanpa data mockup palsu), Dynamic Testing (DAST), Boundary Check, Role-Based Access Control (RBAC) Audit
- **Basis Data Uji**: Database Real Replica (74 Paket Soal Riil, 4.262 Butir Soal, 177 Akun Pengguna Riil)
- **Status Rilis**: ⛔ **TUNDA RILIS (BLOCKER)** — Terdapat 3 celah **CRITICAL** dan 2 bug **HIGH/FATAL ERROR 500** yang harus diperbaiki sebelum sistem layak produksi.

---

## 1. Ringkasan Eksekutif

Pengujian menyeluruh telah dilaksanakan pada seluruh alur kerja Administrator dan Siswa menggunakan basis data riil yang ada di sistem. Fitur utama ujian siswa (katalog paket, auto-save AJAX jawaban, timer, formula matematika KaTeX, evaluasi skor, dan pembahasan konseptual) berfungsi dengan baik.

Namun, dari sisi **Keamanan (Security)** dan **Ketahanan Sistem (Error Resilience)** ditemukan kerentanan serius yang dapat mengakibatkan:
1. **Penghapusan massal seluruh siswa** oleh sembarang pengguna login via link HTTP GET.
2. **Kebocoran seluruh voucher lisensi berbayar** kepada akun siswa.
3. **Crash fatal (HTTP 500)** pada setiap kali halaman 404 dibuka dan pada saat mengunduh laporan nilai Excel.
4. **Manipulasi waktu pengerjaan ujian (cheat)** melalui browser client-side.

---

## 2. Matriks Temuan Cacat (Defect Matrix)

| ID | Modul | Deskripsi Singkat | Severity | Prioritas |
| :--- | :--- | :--- | :---: | :---: |
| **SEC-01** | Master Siswa | Route `GET /master/siswa/delete-all` menghapus seluruh siswa tanpa proteksi role & CSRF | 🔴 CRITICAL | P0 |
| **SEC-02** | Voucher | Halaman `/vouchers` dapat diakses dan dimanipulasi langsung oleh Siswa | 🔴 CRITICAL | P0 |
| **SEC-03** | CRUD Admin | Seluruh endpoint di grup `/crud/*` tidak memiliki validasi role Admin | 🔴 CRITICAL | P0 |
| **SYS-01** | Core Layout | Global 404 handler crash HTTP 500 karena null pointer di `layouts/app.blade.php` | 🟠 HIGH | P0 |
| **SYS-02** | Laporan | Ekspor nilai Excel crash HTTP 500 karena API `Excel::create` versi 2.x usang | 🟠 HIGH | P1 |
| **SEC-04** | Laporan PDF | IDOR pada `/cetak/pdf/hasil-ujian-persiswa/{siswa}/{soal}` | 🟡 MEDIUM | P1 |
| **EXAM-01**| Ujian Siswa | Waktu ujian tersimpan di client (`localStorage`), rentan manipulasi & reset timer | 🟡 MEDIUM | P1 |
| **EXAM-02**| Ujian Siswa | Retake ujian menghapus permanen riwayat nilai lama tanpa ada arsip | 🟡 MEDIUM | P2 |
| **CODE-01**| Blade View | Pemanggilan fungsi `header()` dan `exit()` mentah di template Blade | 🔵 LOW | P2 |

---

## 3. Rincian Defect & Petunjuk Perbaikan untuk Maintainer

### [SEC-01] CRITICAL: Route `GET /master/siswa/delete-all` Tanpa Hak Akses & CSRF
* **File Terdampak**:
  - `routes/web.php` (Baris 78)
  - `app/Http/Controllers/SiswaController.php` (Baris 490 - 500)
* **Kondisi Saat Ini**:
  Route didefinisikan dengan HTTP `GET` dan hanya dibungkus middleware `auth` biasa:
  ```php
  // routes/web.php
  Route::group(['prefix' => 'siswa'], function () {
      Route::get('delete-all', 'SiswaController@deleteAll');
  });

  // SiswaController.php
  public function deleteAll()
  {
      $users = User::where('status', 'S')->get();
      foreach ($users as $key => $value) {
          $jawab = Jawab::where('id_user', $value->id)->first();
          if ($jawab) { $jawab->delete(); }
      }
      User::where('status', 'S')->delete();
  }
  ```
* **Dampak**: 
  Setiap siswa atau user yang telah login cukup mengakses URL `http://.../master/siswa/delete-all` di browser (atau melalui injeksi tag `<img src="...">`), maka seluruh 176 siswa beserta data ujiannya di tabel `users` dan `jawabs` akan terhapus seketika.
* **Solusi Perbaikan**:
  1. Hapus route HTTP `GET` tersebut.
  2. Jika fungsi pembersihan massal memang dibutuhkan untuk Administrator, ganti menjadi method `DELETE` atau `POST` dengan verifikasi password Admin dan middleware khusus admin:
  ```php
  // Solusi:
  Route::delete('delete-all', 'SiswaController@deleteAll')
      ->middleware(['auth', 'admin'])
      ->name('master.siswa.delete_all');
  ```
  Di dalam `deleteAll()`, tambahkan validasi tegas:
  ```php
  if (auth()->user()->status !== 'A') {
      abort(403, 'Akses Ditolak: Hanya Administrator yang diizinkan.');
  }
  ```

---

### [SEC-02] CRITICAL: Halaman Manajemen Voucher Lisensi Terbuka untuk Siswa
* **File Terdampak**:
  - `routes/web.php` (Baris 10 - 12)
  - `app/Http/Controllers/HomeController.php` (Baris 79 - 160)
* **Kondisi Saat Ini**:
  Endpoint manajemen voucher lisensi berada di luar filter role Admin:
  ```php
  // routes/web.php
  Route::get('vouchers', 'HomeController@vouchers')->name('vouchers');
  Route::post('vouchers', 'HomeController@vouchers_save')->name('vouchers.save');
  Route::delete('vouchers', 'HomeController@vouchers_delete')->name('vouchers.delete');
  ```
  Pada `HomeController.php`, method `vouchers()` mengambil seluruh voucher yang belum terpakai (`whereNull("used_by")`) tanpa mengecek apakah pengguna berstatus `'A'`.
* **Dampak**:
  Siswa gratisan dapat membuka URL `/vouchers`, menyalin kode voucher yang aktif, menambah voucher baru, atau menghapus voucher milik sekolah.
* **Solusi Perbaikan**:
  Bungkus route ke dalam middleware role Admin atau tambahkan guard pada awal controller:
  ```php
  // Di HomeController.php
  public function vouchers()
  {
      if (auth()->user()->status !== 'A') {
          return redirect()->route('siswa.ujian')->with('error', 'Akses ditolak.');
      }
      ...
  }
  ```

---

### [SEC-03] CRITICAL: Endpoint CRUD Administratif Tidak Memvalidasi Hak Akses
* **File Terdampak**:
  - `routes/web.php` (Baris 26 - 49)
  - `app/Http/Controllers/CrudController.php` (Baris 27 - 35, 283 - 287, 30-33)
* **Kondisi Saat Ini**:
  Grup route `Route::group(['prefix' => 'crud'])` menangani operasi administratif sensitif seperti:
  - `POST /crud/delete-siswa`
  - `POST /crud/simpan-soal`
  - `POST /crud/simpan-detail-soal`
  - `POST /crud/update-profil-sekolah`
  - `POST /crud/reset-ujian`
  Constructor `CrudController` hanya memanggil `$this->middleware('auth');`.
* **Dampak**:
  Siswa dapat mengirim AJAX POST untuk menghapus siswa lain (`id_siswa`), memodifikasi kunci jawaban butir soal (`simpan-detail-soal`), atau mengubah profil sekolah.
* **Solusi Perbaikan**:
  Buat middleware `AdminOnly` atau tambahkan pengecekan role di constructor atau di method aksi yang hanya boleh dijalankan Admin:
  ```php
  if (auth()->user()->status !== 'A') {
      return response()->json(['error' => 'Unauthorized'], 403);
  }
  ```

---

### [SYS-01] HIGH: Global 404 Handler Crash Fatal HTTP 500
* **File Terdampak**:
  - `resources/views/layouts/app.blade.php` (Baris 459 & Baris 477)
  - `resources/views/errors/404.blade.php` (Baris 1)
* **Kondisi Saat Ini**:
  File `resources/views/errors/404.blade.php` menggunakan `@extends('layouts.app')`.
  Ketika request URL tidak cocok (404), route resolution selesai sebelum session/auth ter-binding pada layout utama jika diakses guest, atau variabel `$user` tidak dioper oleh error handler:
  ```php
  // Baris 459 layouts/app.blade.php
  @if(Auth::user()->gambar != "") // Crash jika Auth::user() null

  // Baris 477 layouts/app.blade.php
  @if($user->status == 'A') // Crash karena $user tidak didefinisikan di view 404
  ```
* **Dampak**:
  Setiap kali tamu atau pengguna membuka URL yang salah/pindah, aplikasi tidak menampilkan halaman 404 yang rapi, melainkan melempar pesan fatal Laravel Ignition / HTTP 500 (`Attempt to read property "gambar" on null`).
* **Solusi Perbaikan**:
  Ubah view `resources/views/errors/404.blade.php` agar menjadi **halaman mandiri (standalone)** tanpa me-`@extends('layouts.app')`, lengkap dengan tombol *"Kembali ke Beranda"* yang mengarah ke `{{ url('/') }}`.

---

### [SYS-02] HIGH: Export Laporan Nilai Excel Gagal Total (Crash 500)
* **File Terdampak**:
  - `app/Http/Controllers/LaporanController.php` (Baris 135 - 153)
* **Kondisi Saat Ini**:
  Aplikasi terpasang dependency `maatwebsite/excel` versi 3.1 di `composer.json`, tetapi controller masih memanggil method statis usang dari versi 2.1:
  ```php
  // LaporanController.php baris 143
  Excel::create('Laporan Nilai', function ($excel) use (...) {
      ...
  })->download('xlsx');
  ```
* **Dampak**:
  Admin tidak dapat mengekspor rekap hasil ujian kelas ke Excel (Error: `Call to undefined method Maatwebsite\Excel\Excel::create()`).
* **Solusi Perbaikan**:
  Buat export class baru menggunakan Artisan:
  ```bash
  php artisan make:export HasilUjianPerKelasExport --view=laporan.excel.excel_hasil_ujian_perkelas
  ```
  Dan panggil di `LaporanController.php`:
  ```php
  use Maatwebsite\Excel\Facades\Excel;
  use App\Exports\HasilUjianPerKelasExport;

  public function excelHasilUjianPerkelas(Request $request)
  {
      return Excel::download(new HasilUjianPerKelasExport($request->soal), 'laporan-nilai.xlsx');
  }
  ```

---

### [SEC-04] MEDIUM: IDOR Pada Cetak PDF Hasil Ujian Siswa
* **File Terdampak**:
  - `routes/web.php` (Baris 119)
  - `app/Http/Controllers/LaporanController.php` (Baris 154 - 172)
* **Kondisi Saat Ini**:
  Route `/cetak/pdf/hasil-ujian-persiswa/{siswa}/{soal}` menerima parameter ID siswa sembarang dan langsung merender PDF nilai tanpa memverifikasi apakah pemohon adalah siswa yang bersangkutan atau guru/admin:
  ```php
  $siswa = User::where('id', $request->siswa)->first();
  ...
  return $pdf->setPaper('legal')->stream('hasil_ujian.pdf');
  ```
* **Dampak**:
  Siswa dapat melihat rapor hasil ujian dan riwayat jawaban siswa lain hanya dengan mengganti parameter `{siswa}` pada URL.
* **Solusi Perbaikan**:
  Tambahkan guard identitas:
  ```php
  if (auth()->user()->status !== 'A' && auth()->user()->id != $request->siswa) {
      abort(403, 'Akses ditolak: Anda hanya dapat mencetak hasil ujian milik sendiri.');
  }
  ```

---

### [EXAM-01] MEDIUM: Timer Ujian Berbasis Client (`localStorage`) Rentan Manipulasi
* **File Terdampak**:
  - `resources/views/halaman-siswa/detail_ujian.blade.php` (Baris 755 - 757, 540 - 581)
  - `app/Http/Controllers/SiswaController.php` (Baris 386 - 410)
* **Kondisi Saat Ini**:
  Waktu batas ujian disimpan di browser siswa:
  ```javascript
  localStorage.setItem(endKey, (Date.now() + (waktuUjian * 1000)).toString());
  ```
  Ketika siswa mengirim jawaban (`POST /siswa/ujian/kirim-jawaban`), backend tidak membandingkan jam pengerjaan siswa dengan durasi paket yang diperbolehkan.
* **Dampak**:
  Siswa dapat menambah waktu melalui DevTools Console atau mereset waktu ujian kembali ke awal dengan membersihkan cache/`localStorage`.
* **Solusi Perbaikan**:
  Simpan waktu mulai ujian di server (misal di tabel sesi ujian atau cache Redis/Session) saat tombol "Mulai" ditekan. Pada endpoint `jawab` dan `kirimJawaban`, tolak jika `now() > start_time + durasi_detik + batas_toleransi_jaringan`.

---

### [EXAM-02] MEDIUM: Retake Ujian Menghapus Hasil Lama Tanpa Arsip
* **File Terdampak**:
  - `app/Http/Controllers/SiswaController.php` (Baris 316 - 320)
* **Kondisi Saat Ini**:
  ```php
  Jawab::where('id_soal', $detail_soal->id_soal)
      ->where('id_user', auth()->user()->id)
      ->where('status', 1)
      ->delete();
  ```
* **Dampak**:
  Ketika siswa mencoba paket soal yang sama untuk kedua kalinya, jawaban pertama yang sudah dinilai langsung terhapus permanen dari database. Guru/Admin kehilangan data riwayat perkembangan belajar siswa sebelumnya.
* **Solusi Perbaikan**:
  Pertahankan baris lama dan gunakan kolom nomor percobaan `attempt_number` atau buat tabel rekapitulasi `hasil_ujians`.

---

### [CODE-01] LOW: Kode `header()` dan `exit()` di Dalam Template Blade
* **File Terdampak**:
  - `resources/views/halaman-siswa/detail_ujian.blade.php` (Baris 9 - 12)
* **Kondisi Saat Ini**:
  ```php
  if($check && $tryCount >= 3){
      header("Location: /siswa/ujian/finish/".$soal->id."");
      exit();
  }
  ```
* **Solusi Perbaikan**:
  Pindahkan logika ini ke dalam method `SiswaController@detailUjian`:
  ```php
  if ($check && $tryCount >= 3) {
      return redirect('/siswa/ujian/finish/' . $soal->id);
  }
  ```

---

## 4. Hasil Verifikasi Alur Fungsional Riil (Real Data Verifications)

Pengujian fungsional berjalan pada data asli sistem:
1. **Paket Soal Riil #8 ("Latihan Kecerdasan #2")**:
   - 100 butir soal, pilihan ganda A, B, C, D, E termuat dengan format rapi.
   - Pilihan opsi tersimpan via AJAX ke tabel `jawabs`.
   - Pemulihan ujian saat browser di-refresh berhasil tanpa keluar dari sesi.
   - Evaluasi skor akhir, perhitungan Benar/Salah/Kosong, serta pembahasan cepat & konseptual berhasil di-render di halaman Finish.
2. **Katalog & Paywall Siswa**:
   - Paket berbayar (ID #6) terkunci dengan benar untuk akun siswa gratisan dan mengarahkan ke katalog kembali dengan peringatan lisensi.
3. **DataTables Admin & Master Siswa**:
   - Daftar 176 siswa, filter, dan toggling status langganan bekerja dengan lancar.
   - Query sanitization Yajra DataTables terbukti aman dari SQL injection injection test (`'; DROP TABLE test; --`).

---

## 5. Rekomendasi Tindakan (Action Plan)

1. **Sprint 1 (P0 / Urgent Security Fixes)**:
   - Terapkan pengecekan status admin pada `/master/siswa/delete-all`, `/vouchers`, dan `/crud/*`.
   - Pisahkan `errors/404.blade.php` dari `layouts.app` agar tidak ada lagi 500 crash saat URL tidak ditemukan.
2. **Sprint 2 (P1 / Functional & Anti-Cheat Fixes)**:
   - Migrasikan ekspor Excel di `LaporanController.php` ke Maatwebsite Excel v3.
   - Validasi IDOR pada endpoint cetak PDF laporan.
   - Implementasikan timestamp server-side untuk durasi ujian.
3. **Sprint 3 (P2 / Architecture)**:
   - Hapus pemanggilan `header()` / `exit()` dari file Blade.
   - Tambahkan histori pengerjaan (attempt counter) agar riwayat nilai ujian tidak tertimpa saat retake.

---
*Laporan ini disusun secara objektif berdasarkan verifikasi kode sumber dan pengujian dinamis pada platform riil.*
