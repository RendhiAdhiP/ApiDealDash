<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Produk extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected $primaryKey = 'produk_id';
    
    public function stokProduk(){
        return $this->hasMany(StokProduk::class, 'produk_id', 'produk_id');
    }

    protected function foto(): Attribute
    {
        return Attribute::make(
            get: function ($image) {
                return filter_var($image, FILTER_VALIDATE_URL) ? $image : url('/images/produks/' . $image);
            },
        );
    }

}
