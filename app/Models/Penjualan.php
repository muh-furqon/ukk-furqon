<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Penjualan extends Model
{
    protected $fillable = ['kode_transaksi','pembayaran_id', 'member_id', 'waktu', 'batas_waktu', 'total', 'status', 'no_resi'];

    public function member()
    {
        return $this->belongsTo(Member::class);
    }

    public function penjualan_details()
    {
        return $this->hasMany(PenjualanDetail::class);
    }

    public function pembayaran()
    {
        return $this->belongsTo(Pembayaran::class);
    }
}
