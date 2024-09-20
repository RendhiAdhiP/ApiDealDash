<?php

namespace Database\Factories;

use App\Models\Kota;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Faker\Factory as FakerFactory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\User>
 */
class UserFactory extends Factory
{
    protected $model = User::class;

    /**
     * The current password being used by the factory.
     */
    protected static ?string $password;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $faker = FakerFactory::create('id_ID'); 

        $kota_ids = Kota::pluck('id')->toArray();
        $role_ids = \App\Models\Role::whereIn('id', [2, 3, 4])->pluck('id')->toArray();


        return [
            'name' => $faker->name,
            'foto' => $faker->imageUrl(640, 480, 'people', true, 'Faker'), 
            'email' => $faker->unique()->safeEmail,
            'email_verified_at' => now(),
            'password' => Hash::make('password'), 
            'tanggal_lahir' => $faker->date(),
            'kota_asal' => $faker->randomElement($kota_ids), 
            'role_id' => $faker->randomElement($role_ids), 
            'remember_token' => $faker->sha256,
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }

    /**
     * Indicate that the model's email address should be unverified.
     */
    public function unverified(): static
    {
        return $this->state(fn (array $attributes) => [
            'email_verified_at' => null,
        ]);
    }
}
