<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Setting extends Model
{
    protected $table = 'settings';
    protected $fillable = ['key', 'value'];

    /**
     * Dapatkan nilai pengaturan berdasarkan key
     */
    public static function get($key, $default = null)
    {
        $setting = DB::table('settings')->where('key', $key)->first();
        return $setting ? $setting->value : $default;
    }

    /**
     * Simpan atau perbarui nilai pengaturan
     */
    public static function set($key, $value)
    {
        return DB::table('settings')->updateOrInsert(
            ['key' => $key],
            ['value' => $value, 'updated_at' => date('Y-m-d H:i:s')]
        );
    }

    /**
     * Dapatkan nomor WhatsApp Admin untuk display (contoh: 0857-6762-9211)
     */
    public static function getAdminWa()
    {
        $raw = self::get('no_wa_admin', '085767629211');
        return self::formatPhoneDisplay($raw);
    }

    /**
     * Dapatkan nomor WhatsApp steril format internasional (contoh: 6285767629211)
     */
    public static function getAdminWaSanitized()
    {
        $raw = self::get('no_wa_admin', '085767629211');
        // Bersihkan seluruh karakter selain angka
        $digits = preg_replace('/[^0-9]/', '', $raw);

        // Jika diawali 08, ubah ke 628
        if (substr($digits, 0, 2) === '08') {
            return '62' . substr($digits, 1);
        }
        // Jika sudah 628, gunakan langsung
        if (substr($digits, 0, 2) === '62') {
            return $digits;
        }
        // Default fallback jika tidak ada prefix
        return '62' . ltrim($digits, '0');
    }

    /**
     * Generate URL langsung wa.me
     */
    public static function getAdminWaUrl($text = '')
    {
        $number = self::getAdminWaSanitized();
        $url = "https://wa.me/{$number}";
        if (!empty($text)) {
            $url .= "?text=" . urlencode($text);
        }
        return $url;
    }

    /**
     * Dapatkan informasi Rekening Bank Admin
     */
    public static function getBankInfo()
    {
        return [
            'bank' => self::get('nama_bank', 'Bank BCA'),
            'rekening' => self::get('no_rekening', '8280912345'),
            'atas_nama' => self::get('atas_nama_rekening', 'Abdi Praja Edukasi'),
        ];
    }

    /**
     * Dapatkan jam layanan admin
     */
    public static function getJamLayanan()
    {
        return self::get('jam_layanan', '09.00 - 21.00 WIB');
    }

    /**
     * Format tampilan nomor telepon dengan tanda strip
     */
    public static function formatPhoneDisplay($phone)
    {
        $digits = preg_replace('/[^0-9]/', '', $phone);
        if (substr($digits, 0, 2) === '62') {
            $digits = '0' . substr($digits, 2);
        }
        if (strlen($digits) >= 10 && strlen($digits) <= 13) {
            return substr($digits, 0, 4) . '-' . substr($digits, 4, 4) . '-' . substr($digits, 8);
        }
        return $phone;
    }
}
