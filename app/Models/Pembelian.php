<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pembelian extends Model
{
    protected $table = 'pembelians';

    protected $fillable = [
        'supplier_id',
        'tgl_beli',
        'total'
    ];

    public function supplier()
    {
        return $this->belongsTo(Supplier::class);
    }

    public function pembelian_details()
    {
        return $this->hasMany(PembelianDetail::class);
    }
}
