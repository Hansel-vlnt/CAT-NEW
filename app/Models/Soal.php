<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Soal extends Model
{
  public function dataDateri()
  {
    return $this->belongsTo('App\Models\Materi', 'materi');
  }
  public function user()
  {
    return $this->belongsTo('App\User', 'id_user');
  }
  public function jawab()
  {
    return $this->belongsTo('App\Models\Jawab', 'id_soal');
  }
  public function detailSoal()
  {
    return $this->hasMany('App\Models\Detailsoal', 'id_soal');
  }

  public function detail_soal_essays()
  {
    return $this->hasMany(DetailSoalEssay::class, 'id_soal', 'id');
  }

  public function isGratis()
  {
    return empty($this->tipe_akses) || $this->tipe_akses === 'gratis';
  }

  public function isPublished()
  {
    return $this->tampil == 1 || ($this->tampil === null && $this->detailSoal()->count() > 0);
  }

  public function getJumlahSoalAttribute()
  {
    return $this->detailSoal()->count();
  }
}
