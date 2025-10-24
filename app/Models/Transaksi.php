<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaksi extends Model
{
    use HasFactory;
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function kamar()
    {
        return $this->belongsTo(Kamar::class);
    }

    protected $table = 'transaksi'; // <---   biar Laravel tahu nama tabelnya. soalnya laravel bodoh dan otomatis tambahin s tiap table

    protected $fillable = [
        'user_id',
        'kamar_id',
        'tanggal_checkin',
        'tanggal_checkout',
        'jumlah_tamu',
        'metode_pembayaran',
        'bukti_pembayaran',
        'status',
    ];

}
