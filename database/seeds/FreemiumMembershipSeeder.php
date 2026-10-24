<?php

use Illuminate\Database\Seeder;
use App\User;
use App\Models\Soal;
use App\Models\Materi;

class FreemiumMembershipSeeder extends Seeder
{
    public function run()
    {
        // 1. Soal seeding
        Soal::where('id', 8)->update(['tipe_akses' => 'gratis', 'harga' => 0, 'password' => null]);
        Soal::where('id', '!=', 8)->update(['tipe_akses' => 'berbayar', 'harga' => 49000]);

        // 2. Siswa Gratis test account
        $freeStudent = User::firstOrNew(['email' => 'siswa_gratis@abdipraja.id']);
        $freeStudent->nama = 'Siswa Publik / Trial';
        $freeStudent->status = 'S';
        $freeStudent->status_langganan = 'gratis';
        $freeStudent->tgl_berakhir_les = null;
        $freeStudent->voucher = null;
        $freeStudent->password = bcrypt('siswa123');
        $freeStudent->save();

        // 3. Siswa Les test account
        $lesStudent = User::where('email', 'chrisdamayantidesi012@gmail.com')->first();
        if ($lesStudent) {
            $lesStudent->status_langganan = 'les';
            $lesStudent->tgl_berakhir_les = '2026-12-31';
            $lesStudent->password = bcrypt('siswa123');
            $lesStudent->save();
        }

        // Also ensure an explicit siswa_les@abdipraja.id exists
        $lesStudent2 = User::firstOrNew(['email' => 'siswa_les@abdipraja.id']);
        $lesStudent2->nama = 'Siswa Bimbel Aktif';
        $lesStudent2->status = 'S';
        $lesStudent2->status_langganan = 'les';
        $lesStudent2->tgl_berakhir_les = '2026-12-31';
        $lesStudent2->password = bcrypt('siswa123');
        $lesStudent2->save();

        // 4. Materi seeding
        if (Materi::count() == 0) {
            Materi::create([
                'id_user' => 1,
                'judul' => 'Pengenalan Tes Potensi Akademik (Gratis)',
                'isi' => '<p>Materi dasar pengenalan TPA dan tips strategi pengerjaan soal untuk persiapan seleksi kedinasan dan CPNS.</p>',
                'gambar' => null,
                'status' => 'Y',
                'hits' => 0,
                'sesi' => 1,
                'tipe_akses' => 'gratis',
            ]);
            Materi::create([
                'id_user' => 1,
                'judul' => 'Modul Intensif Penalaran Logis & Silogisme (Khusus Siswa Les)',
                'isi' => '<p>Modul pembelajaran mendalam mengenai penalaran analitis, silogisme majemuk, dan strategi eliminasi jawaban cepat.</p>',
                'gambar' => null,
                'status' => 'Y',
                'hits' => 0,
                'sesi' => 1,
                'tipe_akses' => 'berbayar',
            ]);
        }

        $materis = Materi::all();
        if ($materis->count() > 0) {
            $first = true;
            foreach ($materis as $m) {
                if ($first) {
                    $m->tipe_akses = 'gratis';
                    $first = false;
                } else {
                    $m->tipe_akses = 'berbayar';
                }
                $m->save();
            }
        }
    }
}
