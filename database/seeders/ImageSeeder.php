<?php

namespace Database\Seeders;

use App\Models\Image;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;

class ImageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Image::create([
            'title' => 'Banner 2',
            'label' => 'background',
            'url' => asset('storage/images/main/Banner_2.webp'),
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
        Image::create([
            'title' => 'Cards bg',
            'label' => 'background',
            'url' => asset('storage/images/main/Cards_bg.webp'),
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
        Image::create([
            'title' => 'Pack food',
            'label' => 'pack_food',
            'url' => asset('storage/images/main/Pack_food.webp'),
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
        Image::create([
            'title' => 'Sausage',
            'label' => 'sausage',
            'url' => asset('storage/images/main/Sausage.webp'),
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
        Image::create([
            'title' => 'About img 1',
            'label' => 'about',
            'url' => asset('storage/images/main/about/About_img_1.webp'),
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
        Image::create([
            'title' => 'About img 2',
            'label' => 'about',
            'url' => asset('storage/images/main/about/About_img_2.webp'),
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
        Image::create([
            'title' => 'About main img',
            'label' => 'about_main',
            'url' => asset('storage/images/main/about/About_main_img.webp'),
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
        Image::create([
            'title' => 'Team 1',
            'label' => 'team',
            'url' => asset('storage/images/main/team/Team_1.webp'),
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
        Image::create([
            'title' => 'Team 2',
            'label' => 'team',
            'url' => asset('storage/images/main/team/Team_2.webp'),
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
        Image::create([
            'title' => 'Team 3',
            'label' => 'team',
            'url' => asset('storage/images/main/team/Team_3.webp'),
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
        Image::create([
            'title' => 'Team bg',
            'label' => 'team_bg',
            'url' => asset('storage/images/main/team/Team_bg.webp'),
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
        Image::create([
            'title' => 'instagram 1',
            'label' => 'instagram',
            'url' => asset('storage/images/main/instagram/instagram_1.webp'),
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
        Image::create([
            'title' => 'instagram 2',
            'label' => 'instagram',
            'url' => asset('storage/images/main/instagram/instagram_2.webp'),
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
        Image::create([
            'title' => 'instagram 3',
            'label' => 'instagram',
            'url' => asset('storage/images/main/instagram/instagram_3.webp'),
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
        Image::create([
            'title' => 'instagram 4',
            'label' => 'instagram',
            'url' => asset('storage/images/main/instagram/instagram_4.webp'),
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
        Image::create([
            'title' => 'instagram 5',
            'label' => 'instagram',
            'url' => asset('storage/images/main/instagram/instagram_5.webp'),
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
        Image::create([
            'title' => 'instagram 6',
            'label' => 'instagram',
            'url' => asset('storage/images/main/instagram/instagram_6.webp'),
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
        Image::create([
            'title' => 'instagram 7',
            'label' => 'instagram',
            'url' => asset('storage/images/main/instagram/instagram_7.webp'),
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
        Image::create([
            'title' => 'instagram 8',
            'label' => 'instagram',
            'url' => asset('storage/images/main/instagram/instagram_8.webp'),
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
        Image::create([
            'title' => 'seo',
            'label' => 'seo',
            'url' => asset('storage/images/main/seo/seo.webp'),
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
    }
}
