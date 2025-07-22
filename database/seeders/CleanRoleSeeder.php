<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class CleanRoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Hapus semua user
        DB::table('users')->truncate();

        // Membuat user dengan hash yang benar
        $users = [
            [
                'name' => 'Manager',
                'email' => 'manager@example.com',
                'password' => Hash::make('password'),
                'role' => 'manager',
                'email_verified_at' => now(),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Staff Gudang',
                'email' => 'gudang@example.com',
                'password' => Hash::make('password'),
                'role' => 'gudang',
                'email_verified_at' => now(),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Member',
                'email' => 'member@example.com',
                'password' => Hash::make('password'),
                'role' => 'member',
                'email_verified_at' => now(),
                'created_at' => now(),
                'updated_at' => now(),
            ]
        ];

        // Insert menggunakan DB query builder
        DB::table('users')->insert($users);

        $this->command->info('Users created successfully with proper bcrypt hashing!');
    }
}
