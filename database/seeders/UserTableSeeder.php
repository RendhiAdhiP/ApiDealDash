<?php

namespace Database\Seeders;

use App\Models\Kota;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Faker\Factory as FakerFactory;

class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {



        User::factory(70)->create();

        User::create([
            'name' => "Zakaria Ramadhan",
            'foto' => null, 
            'email' => 'zakaria@me.com',
            'email_verified_at' => now(),
            'password' => Hash::make('password'), 
            'tanggal_lahir' => '2000-01-01',
            'kota_asal' => 2, 
            'role_id' => 1, 
            'remember_token' => 'zakaria',
            'created_at' => now(),
            'updated_at' => now(),
        ]);


    }
}
