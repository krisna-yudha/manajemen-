<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Hapus semua user terlebih dahulu untuk menghindari konflik
        User::truncate();

        // Membuat user manager default
        User::create([
            'name' => 'Manager',
            'email' => 'manager@example.com',
            'password' => Hash::make('password'),
            'role' => 'manager',
            'email_verified_at' => now(),
        ]);

        // Membuat user gudang default
        User::create([
            'name' => 'Staff Gudang',
            'email' => 'gudang@example.com',
            'password' => Hash::make('password'),
            'role' => 'gudang',
            'email_verified_at' => now(),
        ]);

        // Membuat user member default
        User::create([
            'name' => 'Member',
            'email' => 'member@example.com',
            'password' => Hash::make('password'),
            'role' => 'member',
            'email_verified_at' => now(),
        ]);
    }
}
