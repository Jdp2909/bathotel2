<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kamar extends Model
{
    use HasFactory;

    protected $table = 'kamar';

    protected $fillable = [
        'jenis_kamar',
        'harga_per_malam',
        'maks_tamu',
        'deskripsi',
        'gambar',
    ];


    public function transaksis()
    {
        return $this->hasMany(Transaksi::class);
    }
}
