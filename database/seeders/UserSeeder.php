<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            'name' => 'Hassan',
            'email' => 'hassan@shawermakrakow.com',
            'type'=>'superAdmin',
            'password' => Hash::make('isAdminHassan@ShawermaKrakow2024'),
        ]);
    }
}
