<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        \App\Models\Role::create([
            'name' => 'Superadmin',
        ]);
        \App\Models\Role::create([
            'name' => 'Admin Create', 
        ]);
        \App\Models\Role::create([
            'name' => 'Admin View',
        ]);
        \App\Models\Role::create([
            'name' => 'Sales',
        ]);
    }
}
