<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
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
            'nama_user' => 'Admin',
            'email' => 'admin@gmail.com',
            'email_verified_at' => now(),
            'password' => password_hash("12345678", PASSWORD_DEFAULT),
            'role' => 'admin',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        User::create([
            'nama_user' => 'Pegawai',
            'email' => 'pegawai@gmail.com',
            'email_verified_at' => now(),
            'password' => password_hash("12345678", PASSWORD_DEFAULT),
            'role' => 'pegawai',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        User::create([
            'nama_user' => 'Front Office',
            'email' => 'fo@gmail.com',
            'email_verified_at' => now(),
            'password' => password_hash("12345678", PASSWORD_DEFAULT),
            'role' => 'fo',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}
