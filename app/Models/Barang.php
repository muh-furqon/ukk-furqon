<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Barang extends Model
{
    use HasFactory;

    protected $table = 'barangs';

    protected $fillable = [
        'nama_barang',
        'kategori_id',
        'detail_barang',
        'berat',
        'harga',
        'foto',
        'stok',
    ];

    public function kategori() {
        return $this->belongsTo(Kategori::class);
    }
}
