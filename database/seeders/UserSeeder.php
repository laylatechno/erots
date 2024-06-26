<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            'name' => 'Muhammad Rafi Heryadi',
            'email' => 'muhammadrafiheryadi94@gmail.com',
            'password' => Hash::make('12345678'),
            'role' => 'admin',
            'address' => '123 Main Street',
            'phone_number' => '123456789',
            'picture' => 'default.jpg',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('users')->insert([
            'name' => 'Layla Klan',
            'email' => 'laylaklan@gmail.com',
            'password' => Hash::make('12345678'),
            'role' => 'customer',
            'address' => '456 Elm Street',
            'phone_number' => '987654321',
            'picture' => 'default.jpg',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}
