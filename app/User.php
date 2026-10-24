<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
  use Notifiable;

  /**
   * The attributes that are mass assignable.
   *
   * @var array
   */
  protected $fillable = [
    'name', 'email', 'password', 'nama', 'jk', 'status', 'status_langganan', 'tgl_berakhir_les',
  ];

  /**
   * The attributes that should be hidden for arrays.
   *
   * @var array
   */
  protected $hidden = [
    'password', 'remember_token',
  ];

  public function getKelas()
  {
    return $this->belongsTo(\App\Models\Kelas::class, 'id_kelas', 'id');
  }

  protected $cachedIsLanggananLes = null;
  protected static $voucherMap = null;

  public function isLanggananLes()
  {
    if ($this->cachedIsLanggananLes !== null) {
      return $this->cachedIsLanggananLes;
    }

    // Admin dan Guru selalu memiliki akses penuh
    if ($this->status == 'A' || $this->status == 'G') {
      return $this->cachedIsLanggananLes = true;
    }

    // Jika status_langganan secara eksplisit diset 'gratis' atau 'reguler', maka siswa adalah reguler
    if ($this->status_langganan === 'gratis' || $this->status_langganan === 'reguler') {
      return $this->cachedIsLanggananLes = false;
    }

    // Cek apakah status 'les' dan tanggalnya masih berlaku
    if ($this->status_langganan === 'les') {
      if (empty($this->tgl_berakhir_les)) {
        return $this->cachedIsLanggananLes = true;
      }
      return $this->cachedIsLanggananLes = (date('Y-m-d') <= $this->tgl_berakhir_les);
    }

    // Fallback: hanya jika status_langganan belum diset (null/empty) untuk kompatibilitas data lama
    if (empty($this->status_langganan) && !empty($this->voucher)) {
      if (self::$voucherMap === null) {
        self::$voucherMap = \Illuminate\Support\Facades\DB::table('vouchers')->whereNotNull('used_by')->get()->keyBy('id_voucher');
      }
      $voucher = isset(self::$voucherMap[$this->voucher]) ? self::$voucherMap[$this->voucher] : null;
      if ($voucher && !empty($voucher->used_date)) {
        $expiry = date('Y-m-d', strtotime($voucher->used_date . ' + ' . $voucher->masa_berlaku . ' days'));
        return $this->cachedIsLanggananLes = (date('Y-m-d') <= $expiry);
      }
    }

    return $this->cachedIsLanggananLes = false;
  }
}
