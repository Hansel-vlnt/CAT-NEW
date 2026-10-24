<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Materi extends Model
{
  protected $table = 'materis';

  public function getUser()
  {
  	return $this->belongsTo('App\User', 'id_user');
  }

  public function isGratis()
  {
    return empty($this->tipe_akses) || $this->tipe_akses === 'gratis';
  }
}
