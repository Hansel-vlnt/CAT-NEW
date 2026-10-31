<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\User;

class Transaksi extends Model
{
    protected $table = 'transaksis';
    protected $guarded = [];

    protected $casts = [
        'paid_at' => 'datetime',
        'expired_at' => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'id_user');
    }

    public function paket()
    {
        return $this->belongsTo(PaketLangganan::class, 'id_paket');
    }

    public function getFormattedTotalAttribute()
    {
        return 'Rp ' . number_format($this->total_bayar, 0, ',', '.');
    }

    public function getFormattedNominalAttribute()
    {
        return 'Rp ' . number_format($this->nominal, 0, ',', '.');
    }
}
