<?php

namespace Database\Seeders;

use App\Models\Admin;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    public function run(): void
    {
        Admin::create([
            'name' => 'CME Coordinator',
            'username' => 'admin',
            'password' => 'Kijabe2026!', // Change this to a secure password
        ]);
    }
}