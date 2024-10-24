<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User; // Pastikan model User diimport
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $user = User::create([
            'user_id' => (string) Str::uuid(), // Generate UUID
            'firstname' => 'Admin',
            'lastname' => 'User',
            'username' => 'adminuser',
            'email' => 'admin@example.com',
            'password' => Hash::make('adminpassword'), // Password hashed
            'role' => User::ROLE_ADMIN,
        ]);

        // Menampilkan informasi pengguna yang baru dibuat
        $user;
    }
}