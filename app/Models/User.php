<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasFactory, Notifiable, HasApiTokens;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $guarded = ['created_at', 'updated_at','remember_token'];

    

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
        'created_at',
        'updated_at',
        'email_verified_at',
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

    public function isSuperadmin(){
        return $this->role_id == 1;
    }

    public function isAdminCreate(){
        return $this->role_id == 2;
    }

    public function isAdminView(){
        return $this->role_id == 3;
    }

    public function isSales(){
        return $this->role_id == 4;
    }

    protected function foto(): Attribute
    {
        return Attribute::make(
            get: function ($image) {
                return filter_var($image, FILTER_VALIDATE_URL) ? $image : url('/images/users/' . $image);
            },
        );
    }


    public function kota()
    {
        return $this->belongsTo(Kota::class, 'kota_asal', 'id');
    }


    public function role(){
        return $this->belongsTo(Role::class, 'role_id', 'id');
    }


    public function laporanPenjualan(){
        return $this->hasMany(LaporanPenjualan::class, 'sales_id', 'id');
    }


    
}
