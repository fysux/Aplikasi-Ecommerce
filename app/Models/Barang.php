<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Barang extends Model
{
    use HasFactory;

    protected $table = 'barang';

    protected $primaryKey = 'barang_id';

    protected $fillable = [
        'user_id',
        'nama',
        'gambar',
        'stok',
        'harga',
    ];

    public function transaksi()
    {
        return $this->hasMany(Transaksi::class, 'barang_id');
    }

    public function riwayat()
    {
        return $this->hasMany(Riwayat::class, 'barang_id');
    }

    public function saldo()
    {
        return $this->hasMany(Saldo::class, 'barang_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
