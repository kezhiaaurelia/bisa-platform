<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            [
                'name' => 'TKA',
                'slug' => 'tka',
                'description' => 'Tes Kemampuan Akademik untuk mengukur penguasaan materi pelajaran sekolah dan persiapan ujian mandiri PTN.',
                'icon' => 'academic-cap',
                'order' => 1,
                'is_active' => true,
            ],
            [
                'name' => 'SNBT',
                'slug' => 'snbt',
                'description' => 'Seleksi Nasional Berbasis Tes untuk mengukur potensi kognitif, penalaran matematika, dan literasi.',
                'icon' => 'sparkles',
                'order' => 2,
                'is_active' => true,
            ],
            [
                'name' => 'UTBK',
                'slug' => 'utbk',
                'description' => 'Ujian Tulis Berbasis Komputer sebagai standar seleksi masuk perguruan tinggi negeri di Indonesia.',
                'icon' => 'computer-desktop',
                'order' => 3,
                'is_active' => true,
            ],
        ];

        foreach ($categories as $cat) {
            Category::updateOrCreate(
                ['slug' => $cat['slug']],
                $cat
            );
        }
    }
}
