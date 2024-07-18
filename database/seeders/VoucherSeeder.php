<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class VoucherSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('vouchers')->insert([
            [
                'kode' => 'FA111',
                'nominal' => 10,
                'type' => '%',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'kode' => 'FA222',
                'nominal' => 50000,
                'type' => 'idr',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'kode' => 'FA333',
                'nominal' => 6,
                'type' => '%',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'kode' => 'FA444',
                'nominal' => 5,
                'type' => '%',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
