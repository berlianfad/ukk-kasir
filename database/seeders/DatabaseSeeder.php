<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        User::insert([
            [
                'name' => 'Admin User',
                'email' => 'admin@gmail.com',
                'password' => Hash::make('123'),
                'role' => 'Admin',
            ],
            [
                'name' => 'Petugas User',
                'email' => 'petugas@gmail.com',
                'password' => Hash::make('123'),
                'role' => 'Employee',
            ]
        ]);
    }
}
