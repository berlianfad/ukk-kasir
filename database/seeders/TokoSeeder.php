<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TokoSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('tokos')->insert([
            [
                'nama_toko' => 'Toko Sukses Makmur',
                'alamat' => 'Jl. Merdeka No. 123, Jakarta',
                'no_hp' => '081234567890',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama_toko' => 'Toko Jaya Sentosa',
                'alamat' => 'Jl. Sudirman No. 45, Bandung',
                'no_hp' => '082198765432',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama_toko' => 'Toko Amanah',
                'alamat' => 'Jl. Diponegoro No. 67, Surabaya',
                'no_hp' => '083112233445',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
