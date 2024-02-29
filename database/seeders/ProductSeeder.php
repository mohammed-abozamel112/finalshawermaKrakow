<?php

namespace Database\Seeders;

use App\Models\Product;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Product::create([
            'name' => 'Bayonne Ham',
            'description' => 'description for product',
            'category' => 'bayonne',
            'quantity' => 100,
            'availability' => true,
            'top_product' => true,
            'weight' => 1,
            'price_before_discount' => 25,
            'image' => asset('storage/images/products/bayonne_ham.webp'),
            'shawermakrakows_id' => 1,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
        Product::create([
            'name' => 'Beef Meat',
            'description' => 'description for product',
            'category' => 'beef',
            'quantity' => 100,
            'availability' => true,
            'top_product' => true,
            'weight' => 1,
            'price_before_discount' => 20,
            'image' => asset('storage/images/products/beef_meat.webp'),
            'shawermakrakows_id' => 1,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
        Product::create([
            'name' => 'Beef Ribs',
            'description' => 'description for product',
            'category' => 'beef',
            'quantity' => 100,
            'availability' => true,
            'top_product' => true,
            'weight' => 1,
            'price_before_discount' => 10,
            'image' => asset('storage/images/products/beef_ribs.webp'),
            'shawermakrakows_id' => 1,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
        Product::create([
            'name' => 'Beef Steack',
            'description' => 'description for product',
            'category' => 'beef',
            'quantity' => 100,
            'availability' => true,
            'top_product' => false,
            'weight' => 1,
            'price_before_discount' => 15,
            'image' => asset('storage/images/products/beef_steack.webp'),
            'shawermakrakows_id' => 1,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
        Product::create([
            'name' => 'Chicken Chunks',
            'description' => 'description for product',
            'category' => 'chicken',
            'quantity' => 100,
            'availability' => true,
            'top_product' => false,
            'weight' => 1,
            'price_before_discount' => 11,
            'image' => asset('storage/images/products/chicken_chunks.webp'),
            'shawermakrakows_id' => 1,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
        Product::create([
            'name' => 'Fresh Prawns',
            'description' => 'description for product',
            'category' => 'prawns',
            'quantity' => 100,
            'availability' => true,
            'top_product' => false,
            'weight' => 1,
            'price_before_discount' => 12,
            'image' => asset('storage/images/products/fresh_prawns.webp'),
            'shawermakrakows_id' => 1,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
        Product::create([
            'name' => 'Meat Patties',
            'description' => 'description for product',
            'category' => 'meat',
            'quantity' => 100,
            'availability' => true,
            'top_product' => false,
            'weight' => 1,
            'price_before_discount' => 23,
            'image' => asset('storage/images/products/meat_patties.webp'),
            'shawermakrakows_id' => 1,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
        Product::create([
            'name' => 'Pork Steak',
            'description' => 'description for product',
            'category' => 'steak',
            'quantity' => 100,
            'availability' => true,
            'top_product' => false,
            'weight' => 1,
            'price_before_discount' => 33,
            'image' => asset('storage/images/products/pork_steak.webp'),
            'shawermakrakows_id' => 1,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
        Product::create([
            'name' => 'Salmon Fish Steaks',
            'description' => 'description for product',
            'category' => 'fish',
            'quantity' => 100,
            'availability' => true,
            'top_product' => false,
            'weight' => 1,
            'price_before_discount' => 44,
            'image' => asset('storage/images/products/salmon_fish_steaks.webp'),
            'shawermakrakows_id' => 1,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
        Product::create([
            'name' => 'Smoked Pork',
            'description' => 'description for product',
            'category' => 'pork',
            'quantity' => 100,
            'availability' => true,
            'top_product' => false,
            'weight' => 1,
            'price_before_discount' => 22,
            'image' => asset('storage/images/products/smoked_pork.webp'),
            'shawermakrakows_id' => 1,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
        Product::create([
            'name' => 'Tuna Fish',
            'description' => 'description for product',
            'category' => 'tuna',
            'quantity' => 100,
            'availability' => true,
            'top_product' => false,
            'weight' => 1,
            'price_before_discount' => 43,
            'image' => asset('storage/images/products/tuna_fish.webp'),
            'shawermakrakows_id' => 1,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
        Product::create([
            'name' => 'Wild Caught Salmon',
            'description' => 'description for product',
            'category' => 'salmon',
            'quantity' => 100,
            'availability' => true,
            'top_product' => false,
            'weight' => 1,
            'price_before_discount' => 36,
            'image' => asset('storage/images/products/wild_caught_salmon.webp'),
            'shawermakrakows_id' => 1,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
    }
}
