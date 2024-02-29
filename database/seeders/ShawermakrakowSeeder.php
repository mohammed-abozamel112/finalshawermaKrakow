<?php

namespace Database\Seeders;

use App\Models\Shawermakrakow;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ShawermakrakowSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Shawermakrakow::create([
            "name" => "Shawerma Krakow",
            "owner" => "Hassan",
            "mobile" => "545455660",
            "address" => "poland",
        ]);
    }
}
