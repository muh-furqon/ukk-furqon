<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        User::factory()->create([
            'name' => 'kasir',
            'email' => 'kasir@gmail.com',
            'role' => 'kasir',
            'password' => Hash::make('kasir'),
        ]);

        User::factory()->create([
            'name' => 'pimpinan',
            'email' => 'pimpinan@gmail.com',
            'role' => 'pimpinan',
            'password' => Hash::make('pimpinan'),
        ]);
    }
}
