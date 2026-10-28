<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PaketLangganan extends Model
{
    protected $table = 'paket_langganans';

    protected $fillable = [
        'nama_paket',
        'durasi_bulan',
        'durasi_hari',
        'harga',
        'harga_coret',
        'badge',
        'deskripsi',
        'fitur',
        'urutan',
        'is_aktif',
    ];

    protected $casts = [
        'durasi_bulan' => 'integer',
        'durasi_hari' => 'integer',
        'harga' => 'integer',
        'harga_coret' => 'integer',
        'urutan' => 'integer',
        'is_aktif' => 'boolean',
    ];

    /**
     * Dapatkan daftar fitur dalam bentuk array
     */
    public function getFiturArray()
    {
        if (empty($this->fitur)) {
            return [];
        }

        // Pisahkan per baris
        $lines = preg_split('/\r\n|\r|\n/', trim($this->fitur));
        $result = [];
        foreach ($lines as $line) {
            $line = trim($line);
            if (!empty($line)) {
                // Hilangkan bullet tanda "-" atau "•" jika ada
                $line = ltrim($line, "-•* \t");
                $result[] = trim($line);
            }
        }
        return $result;
    }

    /**
     * Format Rupiah Harga
     */
    public function getFormattedHargaAttribute()
    {
        return 'Rp ' . number_format($this->harga, 0, ',', '.');
    }

    /**
     * Format Rupiah Harga Coret
     */
    public function getFormattedHargaCoretAttribute()
    {
        return $this->harga_coret ? 'Rp ' . number_format($this->harga_coret, 0, ',', '.') : null;
    }

    /**
     * Nominal hemat jika ada harga coret
     */
    public function getHematNominal()
    {
        if ($this->harga_coret && $this->harga_coret > $this->harga) {
            return $this->harga_coret - $this->harga;
        }
        return 0;
    }

    /**
     * Persentase hemat jika ada harga coret
     */
    public function getHematPersen()
    {
        if ($this->harga_coret && $this->harga_coret > $this->harga) {
            return (int)round((($this->harga_coret - $this->harga) / $this->harga_coret) * 100);
        }
        return 0;
    }
}
