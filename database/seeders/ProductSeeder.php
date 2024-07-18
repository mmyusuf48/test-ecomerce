<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('products')->insert([
            'name' => 'Sample Product',
            'price' => 10000,
            'stock' => 50,
            'image' => null,
            'code' => 'FA4532',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}
