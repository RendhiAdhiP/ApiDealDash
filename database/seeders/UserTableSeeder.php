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

        $faker = FakerFactory::create('id_ID');

        $kota_ids = Kota::pluck('id')->toArray();
        User::factory(10)->create();
        // User::insert([
        //     'name' => $faker->name,
        //     'foto' => $faker->imageUrl(640, 480, 'people', true, 'Faker'), 
        //     'email' => $faker->unique()->safeEmail,
        //     'email_verified_at' => now(),
        //     'password' => Hash::make('password'), 
        //     'tanggal_lahir' => $faker->date(),
        //     'kota_asal' => $faker->randomElement($kota_ids), 
        //     'remember_token' => $faker->sha256,
        //     'created_at' => now(),
        //     'updated_at' => now(),
        // ]);
    }
}
