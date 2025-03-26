<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AdminUser extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        \App\Models\User::create([
            'username' => 'admin',
            'email' => 'admin@example.com',
            'password' => bcrypt('123456'),
            'is_admin' => true,
            'email_verified_at' => now(),
        ]);
    }
}
