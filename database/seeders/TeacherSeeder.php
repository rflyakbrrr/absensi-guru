<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TeacherSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $teachers = [
            ['name' => 'Siti Cholidah S.Hum', 'position' => 'Kepala'],
            ['name' => 'Siti Mudrikah, S.Pd', 'position' => 'Guru Kelas'],
            ['name' => 'Silmi Lisani, S.Pd', 'position' => 'Guru Kelas'],
            ['name' => 'Hj. Jariah, S.Pd.I', 'position' => 'Guru Kelas'],
            ['name' => 'Siti Umayah Sari, S.Pd.I', 'position' => 'Guru Kelas'],
            ['name' => 'Susilawati, S.Pd.I', 'position' => 'Guru Kelas'],
            ['name' => 'Dede Muflihah, S.Pd', 'position' => 'Guru Kelas'],
            ['name' => 'Hilma Mamduhah, S.Pd', 'position' => 'Guru Kelas'],
            ['name' => 'Qonita Rahmi, M.Pd', 'position' => 'Guru Kelas'],
            ['name' => 'Maya Amelia, S.Pd', 'position' => 'Guru Kelas'],
            ['name' => 'Ayu Dwi Syahnovi, S.Sy', 'position' => 'Guru Kelas'],
            ['name' => 'Siti Rahmawati, S.Pd', 'position' => 'Guru Kelas'],
            ['name' => 'Siti Sofwatul Kamalia, S.Pd', 'position' => 'Guru B.inggris'],
            ['name' => 'Adi Jafar Sidik, S.Ak', 'position' => 'Guru Pjok'],
            ['name' => 'Muhammad Rafly Akbar', 'position' => 'Tata Usaha/Guru Tik'],
            ['name' => 'Genta aditya Parsha', 'position' => 'Guru Tahfidz'],
            ['name' => 'Nanang Kurniawan', 'position' => 'Guru Tahfidz'],
        ];

        foreach ($teachers as $teacher) {
            DB::table('teachers')->insert([
                'name' => $teacher['name'],
                'position' => $teacher['position'],
                'status' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}