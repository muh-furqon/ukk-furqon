<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kategori extends Model
{
    use HasFactory;

    protected $table = 'kategoris'; // Define the table name

    protected $fillable = [
        'nama_kategori',
    ];

    public function barangs(){
        return $this->hasMany(Barang::class);
    }
}
