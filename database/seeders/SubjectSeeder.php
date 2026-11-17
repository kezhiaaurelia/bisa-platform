<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Subject;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class SubjectSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categoryData = [
            'tka' => [
                ['name' => 'Matematika', 'icon' => 'calculator', 'description' => 'Aljabar, kalkulus, trigonometri, geometri, dan statistika.'],
                ['name' => 'Fisika', 'icon' => 'bolt', 'description' => 'Mekanika, termodinamika, gelombang, optik, dan fisika modern.'],
                ['name' => 'Kimia', 'icon' => 'beaker', 'description' => 'Struktur atom, stoikiometri, larutan asam basa, dan kimia organik.'],
                ['name' => 'Biologi', 'icon' => 'dna', 'description' => 'Biologi sel, genetika, metabolisme, ekologi, dan evolusi.'],
                ['name' => 'Ekonomi', 'icon' => 'chart-bar', 'description' => 'Konsep dasar ekonomi, pasar, pendapatan nasional, dan moneter.'],
                ['name' => 'Sosiologi', 'icon' => 'user-group', 'description' => 'Interaksi sosial, struktur sosial, konflik, dan perubahan sosial.'],
                ['name' => 'Geografi', 'icon' => 'globe-alt', 'description' => 'Litosfer, hidrosfer, atmosfer, biosfer, dan SIG.'],
                ['name' => 'Sejarah', 'icon' => 'clock', 'description' => 'Sejarah Indonesia, peradaban kuno, dan sejarah dunia.'],
                ['name' => 'Bahasa Indonesia', 'icon' => 'book-open', 'description' => 'Kaidah bahasa, pemahaman teks, ejaan, dan paragraf.'],
                ['name' => 'Bahasa Inggris', 'icon' => 'language', 'description' => 'Reading comprehension, vocabulary, and grammar in context.'],
            ],
            'snbt' => [
                ['name' => 'Penalaran Umum', 'icon' => 'light-bulb', 'description' => 'Penalaran induktif, deduktif, dan pemahaman logika analitis.'],
                ['name' => 'Pengetahuan Kuantitatif', 'icon' => 'variable', 'description' => 'Logika angka, aritmetika dasar, aljabar, dan interpretasi data numerik.'],
                ['name' => 'Penalaran Matematika', 'icon' => 'chart-pie', 'description' => 'Pemecahan masalah matematika dalam konteks kehidupan nyata.'],
                ['name' => 'Literasi Bahasa Indonesia', 'icon' => 'document-text', 'description' => 'Kemampuan memahami, mengevaluasi, dan merefleksi teks bahasa Indonesia.'],
                ['name' => 'Literasi Bahasa Inggris', 'icon' => 'chat-bubble-bottom-center-text', 'description' => 'Reading skills, synthesizing ideas, and critical reasoning in English.'],
                ['name' => 'Pemahaman Bacaan dan Menulis', 'icon' => 'pencil-square', 'description' => 'Struktur wacana, kalimat efektif, kohesi, dan ketepatan diksi.'],
                ['name' => 'Pengetahuan dan Pemahaman Umum', 'icon' => 'academic-cap', 'description' => 'Wawasan umum, sinonim/antonim, bentukan kata, dan simpulan bacaan.'],
            ],
            'utbk' => [
                ['name' => 'Tes Potensi Skolastik (TPS)', 'icon' => 'cpu-chip', 'description' => 'Kemampuan kognitif dasar untuk keberhasilan di pendidikan tinggi.'],
                ['name' => 'TKA Saintek', 'icon' => 'atom', 'description' => 'Tes Kemampuan Akademik kelompok Sains dan Teknologi terpadu.'],
                ['name' => 'TKA Soshum', 'icon' => 'newspaper', 'description' => 'Tes Kemampuan Akademik kelompok Sosial dan Humaniora terpadu.'],
                ['name' => 'Literasi dalam Bahasa', 'icon' => 'bookmark-square', 'description' => 'Literasi menyeluruh dalam Bahasa Indonesia dan Bahasa Inggris.'],
                ['name' => 'Penalaran Matematika Lanjutan', 'icon' => 'squares-plus', 'description' => 'Penalaran matematika komprehensif tingkat perguruan tinggi.'],
            ],
        ];

        foreach ($categoryData as $catSlug => $subjects) {
            $category = Category::where('slug', $catSlug)->first();
            if (! $category) {
                continue;
            }

            foreach ($subjects as $order => $sub) {
                Subject::updateOrCreate(
                    [
                        'category_id' => $category->id,
                        'slug' => Str::slug($sub['name']),
                    ],
                    [
                        'name' => $sub['name'],
                        'description' => $sub['description'],
                        'icon' => $sub['icon'],
                        'order' => $order + 1,
                        'is_active' => true,
                    ]
                );
            }
        }
    }
}
