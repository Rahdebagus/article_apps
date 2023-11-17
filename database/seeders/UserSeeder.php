<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            'name'=>'wahde',
            'email'=>'wahde@gmail.com',
            'password'=>bcrypt('wahde123'),
        ]);
        User::create([
            'name'=>'bagus',
            'email'=>'bagus@gmail.com',
            'password'=>bcrypt('bagus123'),
        ]);

        User::create([
            'name'=>'admin',
            'email'=>'admin@gmail.com',
            'password'=>bcrypt('admin123'),
            'role'=>'admin',
        ]);
    }
}
