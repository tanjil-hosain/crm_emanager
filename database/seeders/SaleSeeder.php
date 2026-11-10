<?php

namespace Database\Seeders;

use App\Models\Sale;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SaleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Sale::insert([
             [
                'total_amount' => 5000,
                'total_cost' => 3500,
                'sold_at' => now(),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'total_amount' => 3000,
                'total_cost' => 2000,
                'sold_at' => now(),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'total_amount' => 2000,
                'total_cost' => 1200,
                'sold_at' => now()->subDay(),
                'created_at' => now()->subDay(),
                'updated_at' => now()->subDay(),
            ],
            [
                'total_amount' => 4000,
                'total_cost' => 2800,
                'sold_at' => now()->subDays(2),
                'created_at' => now()->subDays(2),
                'updated_at' => now()->subDays(2),
            ],

        ]);
    }
}
