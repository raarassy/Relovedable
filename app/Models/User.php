<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    // Barang yang dijual user
    public function barangs()
    {
        return $this->hasMany(Barang::class, 'id_penjual');
    }
    // Chat dikirim
    public function chatDikirim()
    {
        return $this->hasMany(Chat::class, 'id_pengirim');
    }
    // Chat diterima
    public function chatDiterima()
    {
        return $this->hasMany(Chat::class, 'id_penerima');
    }
    // Transaksi sebagai pembeli
    public function transaksiPembeli()
    {
        return $this->hasMany(Transaksi::class, 'id_pembeli');
    }
    // Transaksi sebagai penjual
    public function transaksiPenjual()
    {
        return $this->hasMany(Transaksi::class, 'id_penjual');
    }
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }
}
