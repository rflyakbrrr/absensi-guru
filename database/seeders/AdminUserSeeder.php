<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::updateOrCreate(
            ['email' => 'admin@mitarbiyah.sch.id'],
            [
                'name' => 'Administrator',
                'nip' => '1234567890',
                'email' => 'admin@mitarbiyah.sch.id',
                'role' => 'admin',
                'password' => Hash::make('tarbiyah2026'),
                'email_verified_at' => now(),
            ]
        );
    }
}
