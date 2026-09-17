<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        User::create([
            'name' => 'Smith',
            'username' => 'smith',
            'email' => 'smithsy95@gmail.com',
            'password' => Hash::make('123456'),
            'state' => true,
            'image' => 'default.jpg',
        ]);
    }
}
