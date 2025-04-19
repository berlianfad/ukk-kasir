<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class UserSeeder extends Seeder
{
    /**
      * Run the database seeds.
     */
    public function run(): void
    {
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
