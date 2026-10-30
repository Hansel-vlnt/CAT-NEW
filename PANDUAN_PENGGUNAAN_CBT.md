# BUKU PANDUAN PENGGUNAAN PLATFORM CBT
## Computer-Based Testing (CBT) & E-Learning — Abdi Praja Edukasi

Dokumen ini merupakan panduan operasional resmi platform CBT Abdi Praja Edukasi, mencakup alur kerja bagi Administrator/Guru dan panduan teknis pelaksanaan ujian bagi Siswa.

---

## DAFTAR ISI
1. [Akses Sistem & Kredensial Default](#1-akses-sistem--kredensial-default)
2. [Panduan Administrator & Guru](#2-panduan-administrator--guru)
   - [A. Manajemen Paket Soal & Alur Penerbitan](#a-manajemen-paket-soal--alur-penerbitan)
   - [B. Penulisan Butir Soal (Single Key, Multi Key, & TKP)](#b-penulisan-butir-soal-single-key-multi-key--tkp)
   - [C. Import Butir Soal Massal via Excel](#c-import-butir-soal-massal-via-excel)
   - [D. Manajemen Data Siswa & Proteksi Keamanan](#d-manajemen-data-siswa--proteksi-keamanan)
   - [E. Manajemen Voucher & Akses Berlangganan](#e-manajemen-voucher--akses-berlangganan)
   - [F. Rekapitulasi & Ekspor Laporan Nilai (Excel & PDF)](#f-rekapitulasi--ekspor-laporan-nilai-excel--pdf)
3. [Panduan Siswa (Peserta Ujian)](#3-panduan-siswa-peserta-ujian)
   - [A. Login & Pemilihan Paket Latihan](#a-login--pemilihan-paket-latihan)
   - [B. Antarmuka Ujian & Navigasi Pengerjaan](#b-antarmuka-ujian--navigasi-pengerjaan)
   - [C. Penyelesaian Ujian & Evaluasi Pembahasan](#c-penyelesaian-ujian--evaluasi-pembahasan)
4. [Format Baku Template Excel Import Soal](#4-format-baku-template-excel-import-soal)
5. [Tanya Jawab & Pemecahan Masalah (FAQ)](#5-tanya-jawab--pemecahan-masalah-faq)

---

## 1. Akses Sistem & Kredensial Default

Platform CBT dapat diakses melalui peramban web modern (Google Chrome, Mozilla Firefox, Microsoft Edge, atau Safari).

- **URL Aplikasi Lokal**: `http://localhost:8000` atau `http://127.0.0.1:8000`
- **Halaman Login**: `http://localhost:8000/login`

### Kredensial Akun Bawaan (Default):

| Peran (Role) | Email / Username | Kata Sandi | Hak Akses Utama |
| :--- | :--- | :--- | :--- |
| **Administrator** | `admin@abdipraja.co.id` | `admin123` | Akses penuh manajemen paket soal, penerbitan paket, kelola siswa, voucher langganan, dan ekspor laporan rekapitulasi nilai. |
| **Siswa (Akun Uji Coba)** | `siswa_les@abdipraja.id` | `siswa123` | Mengikuti simulasi latihan soal, melihat rekap skor, pembahasan konseptual, dan cetak rapor hasil mandiri. |

---

## 2. Panduan Administrator & Guru

### A. Manajemen Paket Soal & Alur Penerbitan

Untuk mencegah paket kosong terbit ke dashboard siswa secara tidak sengaja, sistem menerapkan mekanisme **3-Langkah Penerbitan**:

```
[ Langkah 1: Buat Paket (Draft) ] ➔ [ Langkah 2: Isi Butir Soal ] ➔ [ Langkah 3: Terbitkan ke Siswa ]
```

1. **Membuat Paket Soal**:
   - Masuk ke menu **E-Learning** > **Data Paket Soal**.
   - Klik tombol **"+ Tambah Paket Soal"**.
   - Lengkapi formulir informasi paket:
     - **Nama Paket**: contoh *Simulasi SKD Kedinasan 2026 - Paket 01*.
     - **Deskripsi Singkat**: penjelasan tujuan atau cakupan materi paket.
     - **Kategori Utama**: pilih klasifikasi soal (misal *Kedinasan & Polri*).
     - **Sub Kategori**: ketik sub-kategori spesifik (misal *TIU*, *TWK*, *TKP*, atau *Paket Lengkap*).
     - **Tipe Akses**:
       - 🟢 **Gratis / Public Trial**: dapat diakses langsung oleh seluruh siswa tanpa status langganan.
       - 🔒 **Khusus Les / Langganan**: hanya dapat diakses oleh siswa yang memiliki status keanggotaan aktif / voucher les.
     - **Durasi Waktu**: lama waktu pengerjaan dalam satuan **menit** (contoh `90`).
     - **KKM (Kriteria Ketuntasan Minimal)**: skala nilai 0–100 (contoh `70`).
     - **Waktu Ujian**: pilihan hitungan timer (*Total Waktu Paket* atau *Per Soal*).
     - **Password Token**: token opsional jika ujian memerlukan kode masuk dari pengawas.
   - Klik **"Simpan & Lanjut ke Pengisian Soal"**.
   - Paket akan disimpan dengan status **Draft** (belum tampil di akun siswa).

2. **Menerbitkan Paket**:
   - Setelah butir-butir soal selesai ditambahkan (baik via manual maupun import Excel), klik tombol hijau **"Terbitkan Paket ke Siswa"** di bagian atas halaman detail paket.
   - Status paket akan berubah menjadi **Published / Aktif** dan otomatis tersedia di dashboard siswa.

---

### B. Penulisan Butir Soal (Single Key, Multi Key, & TKP)

Editor soal CBT dilengkapi dengan editor kaya (*rich-text editor*) dengan dukungan pemilihan jenis huruf (**Plus Jakarta Sans**, **Arial**, **Times New Roman**, dll.) dan ukuran teks fleksibel.

1. Buka halaman detail paket soal yang ingin diisi.
2. Pada bagian formulir pembuatan butir soal:
   - **Tipe Soal**:
     - 🔘 **Single Key (1 Opsi)**: Soal pilihan ganda klasik dengan tepat satu jawaban benar (bobot nilai standar).
     - 🔘 **Multi Key (Pilih > 1)**: Soal yang memperbolehkan lebih dari satu jawaban benar (ditandai dengan checkbox pilihan majemuk).
     - 🔘 **TKP Berbobot (1–5 Poin)**: Soal bertipe Tes Karakteristik Pribadi di mana setiap opsi (A sampai E) memiliki bobot skor antara 1 hingga 5.
   - **Pertanyaan Soal**: Tulis pertanyaan pada editor Summernote. Anda dapat memasukkan gambar, format tebal, miring, daftar poin, maupun tabel.
   - **Opsi Jawaban**: Isi teks untuk Pilihan A, B, C, D, dan E.
   - **Kunci Jawaban**:
     - Untuk *Single Key*: Pilih huruf kunci tunggal (A, B, C, D, atau E).
     - Untuk *Multi Key*: Centang opsi-opsi yang bernilai benar.
     - Untuk *TKP*: Masukkan nilai bobot (1–5) pada masing-masing opsi.
   - **Pembahasan Konseptual**: Masukkan penjelasan materi atau langkah penyelesaian soal yang akan ditampilkan kepada siswa setelah ujian selesai.
3. Klik **"Simpan Soal"**.

---

### C. Import Butir Soal Massal via Excel

Import Excel adalah metode tercepat untuk memasukkan puluhan hingga ratusan butir soal sekaligus.

1. Pada halaman detail paket soal, klik tombol **"Import Excel"** di atas tabel soal.
2. Pada modal yang muncul, klik **"Unduh Format Template Excel (.xlsx)"** untuk memastikan struktur kolom sesuai.
3. Buka file template yang diunduh pada Microsoft Excel / Google Sheets:
   - **Baris 1**: Judul kolom header (jangan diubah atau dihapus).
   - **Baris 2 dst**: Isi data butir soal.
4. **Aturan Penulisan Kunci Jawaban di Excel**:
   - Soal *Single Key*: Tulis satu huruf kapital, misal: `A`
   - Soal *Multi Key*: Tulis kombinasi huruf dipisahkan koma, misal: `A,C` atau `B,D,E`
   - Soal *TKP*: Tulis bobot tiap opsi dipisahkan titik dua atau koma sesuai template panduan.
   - Kolom *Pembahasan*: Tulis teks pembahasan materi konseptual.
5. Simpan file sebagai format `.xlsx`.
6. Kembali ke sistem CBT, pilih file tersebut pada form import, lalu klik **"Unggah & Import"**.
7. Sistem akan memvalidasi data dan memetakan butir soal secara otomatis.

---

### D. Manajemen Data Siswa & Proteksi Keamanan

- **Daftar Akun Siswa**: Buka menu **Master Data** > **Data Siswa** untuk melihat seluruh pengguna terdaftar, menambahkan akun manual, atau import akun massal.
- **Pembersihan Data Siswa (Hapus Massal)**:
  - Menu **Hapus Data Siswa** dilengkapi proteksi keamanan tingkat tinggi.
  - Untuk mencegah penghapusan yang tidak disengaja atau serangan CSRF, aksi hapus massal **wajib mengonfirmasi password akun Administrator yang sedang aktif**.
  - Permintaan HTTP GET ke endpoint pembersihan diblokir otomatis dengan kode *405 Method Not Allowed*.

---

### E. Manajemen Voucher & Akses Berlangganan

Platform CBT menerapkan model freemium/keanggotaan:
- Paket *Gratis* dapat dikerjakan secara bebas.
- Paket *Khusus Les* memerlukan aktivasi status keanggotaan.

**Pengelolaan Voucher**:
1. Akses menu **Voucher** pada URL `/vouchers`.
2. Halaman ini diproteksi ketat hanya untuk akun Administrator (pengguna berstatus Siswa yang mencoba mengakses akan ditolak dengan error 403 / dialihkan ke beranda).
3. Admin dapat membuat kode voucher baru (misal kupon diskon atau aktivasi paket langganan) dan membagikannya kepada siswa yang telah menyelesaikan proses pembayaran (saat ini via konfirmasi WhatsApp Admin).

---

### F. Rekapitulasi & Ekspor Laporan Nilai (Excel & PDF)

1. Buka menu **Laporan** > **Laporan Nilai**.
2. Pilih paket ujian yang ingin dievaluasi, lalu klik **"Lihat Nilai"**.
3. Di dalam halaman rekapitulasi:
   - Tabel menampilkan daftar nama peserta, total nilai, status pengerjaan, dan tombol detail jawaban.
   - **Ekspor Excel**: Klik tombol hijau **"Ekspor Excel"** di bagian atas untuk mengunduh rekap nilai seluruh siswa dalam format spreadsheet resmi Microsoft Excel `.xlsx` (menggunakan engine Maatwebsite 3.1).
   - **Cetak Lembar Hasil / PDF**: Klik tombol detail pada salah satu siswa untuk meninjau rincian butir benar/salah, atau cetak rapor siswa ke dalam format PDF resmi.

---

## 3. Panduan Siswa (Peserta Ujian)

### A. Login & Pemilihan Paket Latihan

1. Buka halaman utama CBT dan klik **Login**.
2. Masukkan alamat email dan kata sandi yang telah didaftarkan.
3. Pada panel samping navigasi, pilih menu **Latihan Soal / Ujian Online**.
4. Anda akan melihat kartu-kartu paket latihan yang tersedia:
   - Label 🟢 **Gratis**: Dapat langsung dikerjakan kapan saja.
   - Label 🔒 **Khusus Les**: Memerlukan status akun les aktif. Jika belum aktif, hubungi Admin melalui tombol WhatsApp yang tersedia untuk proses aktivasi langganan.
5. Klik **"Mulai Ujian"** pada paket yang dipilih.
6. Jika paket memiliki kata sandi token, masukkan token ujian yang diberikan oleh pengawas/guru, lalu klik **"Lanjut"**.

---

### B. Antarmuka Ujian & Navigasi Pengerjaan

Halaman ujian dirancang fokus dan bersih untuk memaksimalkan kenyamanan belajar:

```
+-------------------------------------------------------------------+
|  [Nama Paket Soal]                      Sisa Waktu: [ 01:29:45 ]  |
+-------------------------------------------------------------------+
|                                        |                          |
|  Soal No. 1 dari 50                    |   NAVIGASI NOMOR SOAL    |
|  ------------------                    |   [ 1 ] [ 2 ] [ 3 ] ...  |
|  Isi teks pertanyaan soal...           |   [ 6 ] [ 7 ] [ 8 ] ...  |
|                                        |                          |
|  [ ] Opsi Jawaban A                    |   Keterangan Warna:      |
|  [ ] Opsi Jawaban B                    |   - Hijau  : Terjawab    |
|  [ ] Opsi Jawaban C                    |   - Kuning : Ragu-ragu   |
|  [ ] Opsi Jawaban D                    |   - Putih  : Belum dijawab|
|                                        |                          |
|  [<- Sebelumnya] [Ragu-ragu] [Selanjutnya ->]                     |
+-------------------------------------------------------------------+
```

- **Sinkronisasi Timer Server**:
  - Timer berjalan otomatis di pojok kanan atas.
  - Waktu pengerjaan diverifikasi oleh server, sehingga peserta tidak dapat memanipulasi waktu ujian dari peramban.
  - Apabila peramban tidak sengaja tertutup atau komputer mati, peserta cukup masuk kembali ke paket yang sama; jawaban yang telah dipilih tetap tersimpan dan timer melanjutkan sisa waktu yang tersisa di server.
- **Tipe Input Jawaban**:
  - *Soal Single Key*: Klik pada lingkaran opsi (A, B, C, D, atau E). Memilih opsi lain akan memindahkan tanda centang secara otomatis.
  - *Soal Multi Key*: Beri tanda centang pada kotak checkbox untuk semua opsi yang menurut Anda benar.
- **Tombol Ragu-ragu**:
  - Berfungsi menandai nomor soal dengan warna kuning pada peta nomor navigasi agar mudah diperiksa kembali sebelum menyelesaikan ujian.
- **Menyelesaikan Ujian**:
  - Setelah seluruh butir soal selesai dijawab, klik tombol **"Selesai Ujian"**.
  - Konfirmasi dialog akan muncul menanyakan kepastian pengiriman lembar jawaban.

---

### C. Penyelesaian Ujian & Evaluasi Pembahasan

1. Setelah lembar jawaban dikirimkan, sistem langsung menghitung perolehan nilai akhir berdasarkan kunci jawaban dan bobot masing-masing butir.
2. Halaman hasil menampilkan:
   - **Skor Akhir & Status Kelulusan (KKM)**.
   - **Jumlah Soal Terjawab Benar & Salah**.
   - **Review Lembar Jawaban**: Menampilkan jawaban yang Anda pilih bersanding dengan kunci jawaban yang benar.
   - **Pembahasan Konseptual**: Setiap butir soal dilengkapi ulasan materi agar siswa dapat memahami letak kesalahan dan konsep dasarnya.
3. **Cetak Hasil Ujian (PDF)**:
   - Siswa dapat mengklik tombol **"Cetak PDF Hasil Ujian"** untuk mengunduh bukti nilai latihan mandiri.
   - Sistem dilengkapi proteksi kepemilikan data (IDOR prevention): siswa hanya berhak mengakses dan mencetak dokumen hasil ujian milik akunnya sendiri.

---

## 4. Format Baku Template Excel Import Soal

Ketika menyiapkan berkas import bank soal massal via Microsoft Excel, pastikan struktur tabel memenuhi format baku berikut:

| Kolom | Nama Header | Tipe Data | Deskripsi & Contoh Nilai |
| :---: | :--- | :--- | :--- |
| **A** | `ID Soal` | Angka | Kosongkan atau isi urutan butir (`1`, `2`, `3`). |
| **B** | `Soal` | Teks / HTML | Isi kalimat pertanyaan butir soal. |
| **C** | `Pilihan A` | Teks | Teks isi pilihan jawaban A. |
| **D** | `Pilihan B` | Teks | Teks isi pilihan jawaban B. |
| **E** | `Pilihan C` | Teks | Teks isi pilihan jawaban C. |
| **F** | `Pilihan D` | Teks | Teks isi pilihan jawaban D. |
| **G** | `Pilihan E` | Teks | Teks isi pilihan jawaban E. |
| **H** | `Kunci Jawaban` | Huruf | **Single Key**: `A` atau `B`<br>**Multi Key**: `A,C` atau `B,D,E` |
| **I** | `Score` | Angka | Bobot nilai benar (default standar: `1` atau `5`). |
| **J** | `Pembahasan` | Teks | Ulasan konseptual penyelesaian soal. |

> **Catatan Penting**:
> - Jangan menghapus baris ke-1 (baris nama kolom/header).
> - Simpan berkas dengan ekstensi resmi `.xlsx` atau `.xls`.
> - Hindari penggunaan rumus (*formula Excel*) di dalam sel data; pastikan seluruh data berupa teks biasa.

---

## 5. Tanya Jawab & Pemecahan Masalah (FAQ)

### Q1: Mengapa paket soal yang baru saya buat tidak muncul di akun siswa?
> **Jawab**: Paket soal yang baru dibuat secara default berstatus **Draft** agar siswa tidak melihat paket yang butir soalnya belum lengkap. Setelah butir soal selesai diisi, buka detail paket tersebut lalu klik tombol **"Terbitkan Paket ke Siswa"**.

### Q2: Bagaimana cara mengaktifkan akun siswa agar bisa mengakses paket "Khusus Les"?
> **Jawab**: Administrator dapat memberikan kode voucher langganan dari menu `/vouchers` atau mengubah status langganan siswa secara langsung melalui menu **Master Data** > **Data Siswa**.

### Q3: Apa yang terjadi jika koneksi internet siswa terputus saat ujian berjalan?
> **Jawab**: Jawaban setiap butir soal disimpan secara berkala ke database saat tombol opsi diklik. Jika koneksi terputus, siswa cukup memuat ulang (*refresh*) halaman atau login kembali. Seluruh jawaban sebelumnya tetap aman dan pengerjaan dapat dilanjutkan.

### Q4: Mengapa muncul pesan error saat mengekspor laporan nilai ke Excel?
> **Jawab**: Pastikan paket soal tersebut memiliki data pengerjaan (peserta ujian). Engine ekspor telah dimutakhirkan ke library Maatwebsite Excel 3.1 yang stabil dan langsung menghasilkan berkas `.xlsx`.

### Q5: Apakah siswa dapat melihat hasil ujian teman lainnya?
> **Jawab**: Tidak. Sistem menerapkan mekanisme otorisasi berbasis hak kepemilikan. Setiap permintaan pencetakan PDF maupun peninjauan lembar jawaban siswa lain akan langsung diblokir oleh server dengan kode penolakan akses *403 Forbidden*.

---
*Dokumen ini disusun untuk Tim Akademik & Pengembang Platform CBT Abdi Praja Edukasi.*
