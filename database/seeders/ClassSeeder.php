<?php

namespace Database\Seeders;

use App\Models\LMSClass;
use App\Models\User;
use Illuminate\Database\Seeder;

class ClassSeeder extends Seeder
{
    public function run(): void
    {
        $dosen = User::role('dosen')->first();
        $mahasiswa = User::role('mahasiswa')->get();

        $kelasData = [
            [
                'name' => 'Pemrograman Web Lanjutan',
                'description' => 'Mata kuliah ini membahas pengembangan web modern menggunakan framework Laravel, REST API, dan teknik deployment. Cocok untuk mahasiswa yang sudah memahami dasar-dasar pemrograman web.',
                'category' => 'Teknik Informatika',
                'level' => 'Semester 4',
                'dosen_id' => $dosen->id,
            ],
            [
                'name' => 'Basis Data Terdistribusi',
                'description' => 'Studi tentang sistem basis data terdistribusi, replikasi, sharding, dan optimasi query pada lingkungan multi-server.',
                'category' => 'Teknik Informatika',
                'level' => 'Semester 6',
                'dosen_id' => $dosen->id,
            ],
            [
                'name' => 'Kecerdasan Buatan',
                'description' => 'Pengenalan konsep kecerdasan buatan, machine learning, neural network, dan penerapannya dalam berbagai studi kasus.',
                'category' => 'Teknik Informatika',
                'level' => 'Semester 5',
                'dosen_id' => $dosen->id,
            ],
        ];

        foreach ($kelasData as $data) {
            $kelas = LMSClass::create($data);
            $kelas->students()->attach($mahasiswa->pluck('id'), [
                'progress' => fake()->randomFloat(2, 0, 100),
                'is_active' => true,
            ]);
        }
    }
}
