<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class SettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('settings')->insert([
            'school_name' => 'MI TARBIYAH ISLAMIYAH',
            'latitude' => '-6.1438724',
            'longitude' => '106.6603895',
            'radius' => 100,
            'check_in_start' => '06:30:00',
            'check_in_end' => '07:30:00',
            'late_after' => '07:31:00',
            'check_out_start' => '13:00:00',
            'check_out_end' => '13:30:00',
            'selfie_enabled' => true,
            'gps_enabled' => true,
            'qr_token' => Str::random(32),
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}