<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pembayaran extends Model
{
    protected $fillable = ['metode', 'status', 'total_bayar', 'kembalian']; // Add total_bayar and kembalian

    public function penjualan()
    {
        return $this->hasOne(Penjualan::class);
    }
}