<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\LiveClass;
use App\Models\TryoutEvent;
use Illuminate\Database\Seeder;

class FlowFeaturesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $snbtCategory = Category::where('slug', 'snbt')->first();
        $tkaCategory = Category::where('slug', 'tka')->first();
        $utbkCategory = Category::where('slug', 'utbk')->first();

        // 1. Tryout Events
        $events = [
            [
                'title' => 'Tryout Akbar SNBT Nasional 2025 #1',
                'category_id' => $snbtCategory?->id,
                'event_type' => 'snbt',
                'start_date' => now()->subDays(2),
                'end_date' => now()->addDays(5),
                'duration_minutes' => 120,
                'is_premium' => false,
                'is_published' => true,
                'release_discussion' => true,
                'description' => 'Simulasi akbar SNBT 7 subtes resmi dengan sistem penilaian Item Response Theory (IRT) dan ranking nasional secara real-time.',
            ],
            [
                'title' => 'Simulasi UTBK CAT Full Package #2',
                'category_id' => $utbkCategory?->id,
                'event_type' => 'utbk',
                'start_date' => now()->addDays(1),
                'end_date' => now()->addDays(8),
                'duration_minutes' => 105,
                'is_premium' => true,
                'is_published' => true,
                'release_discussion' => false,
                'description' => 'Drill soal UTBK dengan antarmuka CAT mirip sistem asli, melatih ketahanan mental dan kecepatan berpikir.',
            ],
            [
                'title' => 'Tryout Mandiri TKA Saintek & Soshum (SIMAK/UTUL)',
                'category_id' => $tkaCategory?->id,
                'event_type' => 'mandiri',
                'start_date' => now()->addDays(3),
                'end_date' => now()->addDays(10),
                'duration_minutes' => 90,
                'is_premium' => false,
                'is_published' => true,
                'release_discussion' => false,
                'description' => 'Paket persiapan ujian mandiri universitas favorit (SIMAK UI, UTUL UGM, SMUP Unpad) tingkat kesulitan HOTS.',
            ],
        ];

        foreach ($events as $event) {
            TryoutEvent::firstOrCreate(
                ['title' => $event['title']],
                $event
            );
        }

        // 2. Live Classes
        $liveClasses = [
            [
                'title' => 'Bedah Kilat Trik Cepat Penalaran Matematika SNBT',
                'instructor_name' => 'Dr. Bambang S., M.Sc. (Master Tutor SNBT)',
                'category_slug' => 'snbt',
                'scheduled_at' => now()->addDays(2)->setHour(19)->setMinute(30),
                'duration_minutes' => 90,
                'meet_url' => 'https://meet.google.com/bisa-snbt-math',
                'recording_url' => null,
                'is_premium' => false,
                'description' => 'Strategi menjawab soal model logika angka dan aljabar dalam waktu kurang dari 60 detik per nomor.',
            ],
            [
                'title' => 'Kupas Tuntas Soal Jebakan Literasi Bahasa Indonesia & Inggris',
                'instructor_name' => 'Kak Sarah Wijaya, S.Pd. (Expert Literasi)',
                'category_slug' => 'snbt',
                'scheduled_at' => now()->addDays(4)->setHour(19)->setMinute(0),
                'duration_minutes' => 90,
                'meet_url' => 'https://meet.google.com/bisa-snbt-literasi',
                'recording_url' => null,
                'is_premium' => true,
                'description' => 'Membedah cara menemukan ide pokok dan simpulan tersirat pada teks panjang tanpa membaca keseluruhan kalimat.',
            ],
            [
                'title' => 'Mastering Silogisme & Logika Analitik TPS',
                'instructor_name' => 'Kak Farhan Pratama, S.Si.',
                'category_slug' => 'snbt',
                'scheduled_at' => now()->subDays(3)->setHour(20)->setMinute(0),
                'duration_minutes' => 90,
                'meet_url' => 'https://meet.google.com/bisa-snbt-tps',
                'recording_url' => 'https://youtube.com/watch?v=sample-bisa-rekaman',
                'is_premium' => false,
                'description' => 'Sesi live interaktif mengenai aturan silogisme kategorik, hipotetik, dan disjungtif beserta arsip rekaman video.',
            ],
        ];

        foreach ($liveClasses as $lc) {
            LiveClass::firstOrCreate(
                ['title' => $lc['title']],
                $lc
            );
        }
    }
}
