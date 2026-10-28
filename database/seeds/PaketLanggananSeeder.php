<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PaketLanggananSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $packages = [
            [
                'nama_paket' => 'Pass 1 Bulan - Sprint SKD',
                'durasi_bulan' => 1,
                'durasi_hari' => 30,
                'harga' => 49000,
                'harga_coret' => 79000,
                'badge' => 'Sprint H-30',
                'deskripsi' => 'Cocok untuk persiapan kilat dan review soal-soal krusial menjelang hari ujian seleksi.',
                'fitur' => "Akses Semua 30+ Tryout SKD CAT Kedinasan\nKunci Jawaban & Pembahasan Lengkap\nSeluruh Modul Materi & Rangkuman E-Book\nAnalisis Skor & Waktu Pengerjaan Real-time",
                'urutan' => 1,
                'is_aktif' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama_paket' => 'Pass 3 Bulan - Intensif Kedinasan',
                'durasi_bulan' => 3,
                'durasi_hari' => 90,
                'harga' => 99000,
                'harga_coret' => 199000,
                'badge' => 'Paling Populer',
                'deskripsi' => 'Paket paling diminati untuk persiapan matang dari nol hingga menguasai seluruh materi tes.',
                'fitur' => "Akses Semua 30+ Tryout SKD CAT Kedinasan\nKunci Jawaban & Pembahasan Lengkap (Teks & Trik Cepat)\nSeluruh Modul Materi & Rangkuman E-Book Lengkap\nPerang Skor & Simulasi Ranking Nasional\nUpdate Bank Soal Otomatis Berkala",
                'urutan' => 2,
                'is_aktif' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama_paket' => 'Pass 6 Bulan - Platinum All Season',
                'durasi_bulan' => 6,
                'durasi_hari' => 180,
                'harga' => 169000,
                'harga_coret' => 349000,
                'badge' => 'Terhemat',
                'deskripsi' => 'Akses tanpa batas dari awal persiapan pendaftaran sampai seluruh tahapan tes selesai.',
                'fitur' => "Akses Semua Paket Soal SKD CAT Tanpa Batas\nKunci Jawaban, Pembahasan Lengkap & Trik Cepat\nAkses Semua Modul, Materi & Rangkuman E-Book\nSimulasi Tryout Akbar & Ranking Nasional\nPrioritas Update Soal Kisi-Kisi Terbaru",
                'urutan' => 3,
                'is_aktif' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ];

        foreach ($packages as $pkg) {
            $existing = DB::table('paket_langganans')->where('nama_paket', $pkg['nama_paket'])->first();
            if (!$existing) {
                DB::table('paket_langganans')->insert($pkg);
            }
        }
    }
}
