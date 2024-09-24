<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LaporanPenjualan extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public function user()
    {
        return $this->belongsTo(User::class, 'sales_id', 'id');
    }

    public function produk(){
        return $this->belongsTo(Produk::class, 'produk_id', 'id');
    }
}
