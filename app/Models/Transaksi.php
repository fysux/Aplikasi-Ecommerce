<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaksi extends Model
{
    use HasFactory;

    protected $table = 'transaksi';

    protected $primaryKey = 'transaksi_id';

    protected $fillable = [
        'user_id',
        'barang_id',
        'qty',
        'total_harga',
    ];

    public function saldo ()
    {
        return $this->belongsTo(Saldo::class, 'user_id');
    }

    public function barang ()
    {
        return $this->belongsTo(Barang::class, 'barang_id');
    }
}
