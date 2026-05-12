<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Barang extends Model
{
    protected $primaryKey = 'id_barang';

    protected $fillable = [
        'id_penjual',
        'nama_barang',
        'deskripsi',
        'harga',
        'kategori',
        'status',
    ];

    public $timestamps = false;

    // Relasi ke User (penjual)
    public function penjual()
    {
        return $this->belongsTo(User::class, 'id_penjual');
    }

    // Relasi ke FotoBarang
    public function fotoBarangs()
    {
        return $this->hasMany(FotoBarang::class, 'id_barang');
    }

    // Relasi ke Chat
    public function chats()
    {
        return $this->hasMany(Chat::class, 'id_barang');
    }

    // Relasi ke Transaksi
    public function transaksis()
    {
        return $this->hasMany(Transaksi::class, 'id_barang');
    }
}