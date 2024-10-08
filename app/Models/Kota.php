<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kota extends Model
{
    use HasFactory;


    protected $guarded = ['created_at', 'updated_at'];

    protected $hidden = ['created_at', 'updated_at'];

    public function user(){
        return $this->hasMany(User::class, 'kota_asal', 'id');
    }
}
