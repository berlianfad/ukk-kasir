<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Product;
use Carbon\Carbon;

class ProductSeeder extends Seeder
{
    /**
      * Run the database seeds.
     */
    public function run(): void
    {
        Product::insert([
            [
                'name' => 'Beras',
                'price' => 10000,
                'stock' => 5,
                'image' => 'beras.png',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'name' => 'Cabai',
                'price' => 30000,
                'stock' => 5,
                'image' => 'cabai.png',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'name' => 'Daging',
                'price' => 100000,
                'stock' => 5,
                'image' => 'daging.png',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'name' => 'Jagung',
                'price' => 10000,
                'stock' => 5,
                'image' => 'jagung.png',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'name' => 'Kedelai',
                'price' => 10000,
                'stock' => 5,
                'image' => 'kedelai.png',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'name' => 'Telur',
                'price' => 30000,
                'stock' => 5,
                'image' => 'telur.png',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
        ]);
    }
}
