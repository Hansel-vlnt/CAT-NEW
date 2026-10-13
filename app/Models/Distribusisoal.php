<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Auth;

class Distribusisoal extends Model
{
  public function soal()
  {
  	return $this->belongsTo('App\Models\Soal', 'id_soal');
  }
  public function jawabUser()
  {
  	return $this->belongsTo('App\Models\Jawab', 'id_soal', 'id_soal'); //->where('id_user', Auth::user()->id);
  }
}
