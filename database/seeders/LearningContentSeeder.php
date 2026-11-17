<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\LearningLevel;
use App\Models\Module;
use App\Models\Question;
use App\Models\QuestionOption;
use App\Models\Quiz;
use App\Models\Subject;
use Illuminate\Database\Seeder;

class LearningContentSeeder extends Seeder
{
    public function run(): void
    {
        $snbt = Category::where('slug', 'snbt')->first();
        if (! $snbt) {
            return;
        }

        $penalaranUmum = Subject::where('category_id', $snbt->id)->where('slug', 'penalaran-umum')->first();
        if (! $penalaranUmum) {
            return;
        }

        // 1. Create Learning Levels for Penalaran Umum (Map Nodes)
        $levelsData = [
            [
                'level_number' => 1,
                'title' => 'Dasar Logika Deduktif',
                'description' => 'Pelajari pola silogisme kategorik, modus ponens, dan modus tollens.',
                'type' => 'material',
                'xp_reward' => 50,
                'min_score_to_unlock' => 70,
                'order' => 1,
            ],
            [
                'level_number' => 2,
                'title' => 'Latihan Silogisme & Logika',
                'description' => 'Latihan 10 soal logika penarikan kesimpulan dengan feedback langsung.',
                'type' => 'practice',
                'xp_reward' => 75,
                'min_score_to_unlock' => 70,
                'order' => 2,
            ],
            [
                'level_number' => 3,
                'title' => 'Kuis Penalaran Analitis',
                'description' => 'Simulasi kuis berwaktu 15 menit untuk menguji kecepatan penalaran urutan dan kombinatorika.',
                'type' => 'quiz',
                'xp_reward' => 100,
                'min_score_to_unlock' => 70,
                'order' => 3,
            ],
            [
                'level_number' => 4,
                'title' => 'Latihan Penalaran Induktif & Pola',
                'description' => 'Analisis data grafis, analogi fakta, dan prediksi pola sebab-akibat.',
                'type' => 'practice',
                'xp_reward' => 120,
                'min_score_to_unlock' => 75,
                'order' => 4,
            ],
            [
                'level_number' => 5,
                'title' => 'Tryout Subtes Penalaran Umum',
                'description' => 'Simulasi penuh dengan standar waktu SNBT (30 menit, 20 soal).',
                'type' => 'tryout',
                'xp_reward' => 200,
                'min_score_to_unlock' => 80,
                'order' => 5,
            ],
        ];

        $createdLevels = [];
        foreach ($levelsData as $lvl) {
            $createdLevels[$lvl['level_number']] = LearningLevel::updateOrCreate(
                [
                    'subject_id' => $penalaranUmum->id,
                    'level_number' => $lvl['level_number'],
                ],
                $lvl
            );
        }

        // 2. Create Modules for Level 1 using single quoted string
        $moduleContent = <<<'MARKDOWN'
## Pengantar Logika Silogisme

Penalaran deduktif adalah proses menarik kesimpulan khusus dari premis-premis umum yang dianggap benar. Dalam SNBT, soal penalaran umum sering menguji kemampuan ini melalui kaidah silogisme.

### 1. Modus Ponens
- **Premis 1**: Jika P, maka Q (P → Q)
- **Premis 2**: Terjadi P
- **Kesimpulan**: Pasti terjadi Q

*Contoh:*
- Premis 1: Jika hari hujan lebat, maka jalanan licin.
- Premis 2: Hari ini hujan lebat.
- Kesimpulan: Jalanan licin.

### 2. Modus Tollens
- **Premis 1**: Jika P, maka Q (P → Q)
- **Premis 2**: Tidak terjadi Q (~Q)
- **Kesimpulan**: Pasti tidak terjadi P (~P)

*Contoh:*
- Premis 1: Jika lulus SNBT, maka siswa terdaftar di PTN.
- Premis 2: Andi tidak terdaftar di PTN.
- Kesimpulan: Andi tidak lulus SNBT.

### 3. Silogisme Hipotetis
- **Premis 1**: P → Q
- **Premis 2**: Q → R
- **Kesimpulan**: P → R

Ingat kaidah kata kuantor:
- **Semua/Setiap** bernegasi dengan **Beberapa/Ada/Sebagian**.
- Jika ada premis berkuantor "Semua" dan satu premis "Beberapa", maka kesimpulan umumnya harus berkuantor "Beberapa".
MARKDOWN;

        Module::updateOrCreate(
            [
                'subject_id' => $penalaranUmum->id,
                'slug' => 'pengantar-logika-silogisme-snbt',
            ],
            [
                'learning_level_id' => $createdLevels[1]->id,
                'title' => 'Pengantar Logika Silogisme SNBT',
                'reading_time_minutes' => 7,
                'order' => 1,
                'content' => $moduleContent,
            ]
        );

        // 3. Create Sample High Quality Questions for Penalaran Umum
        $questionsData = [
            [
                'level' => 2,
                'text' => 'Semua mahasiswa yang mengikuti ujian akhir mengenakan almamater. Sebagian mahasiswa di gedung A tidak mengenakan almamater. Kesimpulan yang sah adalah...',
                'difficulty' => 'easy',
                'explanation' => 'Kaidah silogisme: Premis umum menyatakan semua yang ikut ujian mengenakan almamater. Fakta di lapangan menyebutkan sebagian mahasiswa di gedung A tidak mengenakan almamater. Berarti, sebagian mahasiswa di gedung A tersebut tidak sedang mengikuti ujian akhir.',
                'options' => [
                    ['key' => 'A', 'text' => 'Semua mahasiswa di gedung A tidak mengikuti ujian akhir.', 'is_correct' => false],
                    ['key' => 'B', 'text' => 'Sebagian mahasiswa di gedung A tidak mengikuti ujian akhir.', 'is_correct' => true],
                    ['key' => 'C', 'text' => 'Sebagian mahasiswa yang mengenakan almamater tidak di gedung A.', 'is_correct' => false],
                    ['key' => 'D', 'text' => 'Semua mahasiswa di gedung A mengikuti ujian akhir.', 'is_correct' => false],
                    ['key' => 'E', 'text' => 'Tidak ada mahasiswa di gedung A yang mengenakan almamater.', 'is_correct' => false],
                ],
            ],
            [
                'level' => 2,
                'text' => 'Jika fasilitas laboratorium lengkap, maka penelitian berjalan lancar. Jika penelitian berjalan lancar, maka publikasi jurnal meningkat. Saat ini publikasi jurnal tidak meningkat. Kesimpulan yang benar adalah...',
                'difficulty' => 'medium',
                'explanation' => 'Menggunakan silogisme hipotetis: Fasilitas lengkap (P) -> Penelitian lancar (Q), Penelitian lancar (Q) -> Publikasi meningkat (R). Maka P -> R. Diketahui publikasi tidak meningkat (~R). Berdasarkan Modus Tollens, jika ~R maka ~P (fasilitas laboratorium tidak lengkap).',
                'options' => [
                    ['key' => 'A', 'text' => 'Penelitian tetap berjalan lancar.', 'is_correct' => false],
                    ['key' => 'B', 'text' => 'Fasilitas laboratorium lengkap tetapi mahasiswa malas.', 'is_correct' => false],
                    ['key' => 'C', 'text' => 'Fasilitas laboratorium tidak lengkap.', 'is_correct' => true],
                    ['key' => 'D', 'text' => 'Publikasi jurnal tertunda karena kendala biaya.', 'is_correct' => false],
                    ['key' => 'E', 'text' => 'Penelitian tidak menghasilkan publikasi baru.', 'is_correct' => false],
                ],
            ],
            [
                'level' => 2,
                'text' => 'Tidak ada atlet renang yang takut air dingin. Semua perenang handal adalah atlet renang. Budi takut air dingin. Simpulan yang tepat adalah...',
                'difficulty' => 'easy',
                'explanation' => 'Tidak ada atlet renang yang takut air. Semua perenang handal adalah atlet renang (jadi perenang handal tidak takut air). Budi takut air dingin, maka Budi jelas bukan perenang handal maupun atlet renang.',
                'options' => [
                    ['key' => 'A', 'text' => 'Budi bukan atlet renang handal.', 'is_correct' => true],
                    ['key' => 'B', 'text' => 'Budi seorang perenang handal yang sedang sakit.', 'is_correct' => false],
                    ['key' => 'C', 'text' => 'Budi takut air tetapi tetap atlet renang.', 'is_correct' => false],
                    ['key' => 'D', 'text' => 'Sebagian atlet renang takut air seperti Budi.', 'is_correct' => false],
                    ['key' => 'E', 'text' => 'Air dingin hanya dihindari oleh atlet pemula.', 'is_correct' => false],
                ],
            ],
            [
                'level' => 3,
                'text' => 'Enam siswa: P, Q, R, S, T, dan U duduk berurutan dari kiri ke kanan. P berada tepat di sebelah kiri Q. R berada di antara S dan T. U berada di ujung paling kanan. Jika S berada tepat di sebelah kanan Q, siapakah yang duduk di urutan kedua dari kiri?',
                'difficulty' => 'hard',
                'explanation' => 'Mari urutkan: P di kiri Q (PQ). S di kanan Q (PQS). R di antara S dan T, maka susunannya (PQSRT). Ditambah U di ujung paling kanan: P - Q - S - R - T - U. Urutan kedua dari kiri adalah Q.',
                'options' => [
                    ['key' => 'A', 'text' => 'P', 'is_correct' => false],
                    ['key' => 'B', 'text' => 'Q', 'is_correct' => true],
                    ['key' => 'C', 'text' => 'S', 'is_correct' => false],
                    ['key' => 'D', 'text' => 'R', 'is_correct' => false],
                    ['key' => 'E', 'text' => 'T', 'is_correct' => false],
                ],
            ],
            [
                'level' => 3,
                'text' => 'Semua menu di restoran X halal. Masakan yang mengandung minyak babi tidak halal. Sup konro di restoran X lezat. Kesimpulan yang benar adalah...',
                'difficulty' => 'medium',
                'explanation' => 'Karena semua menu di restoran X halal, dan masakan mengandung minyak babi tidak halal, maka semua menu di restoran X (termasuk Sup konro) tidak mengandung minyak babi.',
                'options' => [
                    ['key' => 'A', 'text' => 'Sup konro di restoran X tidak mengandung minyak babi.', 'is_correct' => true],
                    ['key' => 'B', 'text' => 'Semua masakan lezat tidak mengandung minyak babi.', 'is_correct' => false],
                    ['key' => 'C', 'text' => 'Hanya sup konro yang halal di restoran X.', 'is_correct' => false],
                    ['key' => 'D', 'text' => 'Sebagian menu restoran X mengandung minyak babi.', 'is_correct' => false],
                    ['key' => 'E', 'text' => 'Sup konro lezat karena diolah secara khusus.', 'is_correct' => false],
                ],
            ],
        ];

        // Clean existing questions for clean seeding
        Question::where('subject_id', $penalaranUmum->id)->delete();

        foreach ($questionsData as $qData) {
            $question = Question::create([
                'subject_id' => $penalaranUmum->id,
                'learning_level_id' => $createdLevels[$qData['level']]->id,
                'question_text' => $qData['text'],
                'explanation' => $qData['explanation'],
                'explanation_source' => 'manual',
                'explanation_status' => 'published',
                'difficulty' => $qData['difficulty'],
                'is_active' => true,
            ]);

            foreach ($qData['options'] as $opt) {
                QuestionOption::create([
                    'question_id' => $question->id,
                    'option_key' => $opt['key'],
                    'option_text' => $opt['text'],
                    'is_correct' => $opt['is_correct'],
                ]);
            }
        }

        // 4. Create Quiz for Level 3
        $quiz = Quiz::updateOrCreate(
            ['slug' => 'kuis-penalaran-analitis-level-3'],
            [
                'category_id' => $snbt->id,
                'subject_id' => $penalaranUmum->id,
                'learning_level_id' => $createdLevels[3]->id,
                'title' => 'Kuis Penalaran Analitis',
                'description' => 'Kuis berwaktu 15 menit dengan 5 soal untuk menguji kecepatan logika urutan.',
                'type' => 'quiz',
                'duration_minutes' => 15,
                'pass_percentage' => 70,
                'difficulty' => 'medium',
                'is_active' => true,
            ]
        );

        $qIds = Question::where('subject_id', $penalaranUmum->id)->pluck('id');
        $quiz->questions()->sync($qIds);

        // 5. Create Standalone Tryout SNBT
        $tryout = Quiz::updateOrCreate(
            ['slug' => 'tryout-akbar-snbt-2026'],
            [
                'category_id' => $snbt->id,
                'subject_id' => null,
                'learning_level_id' => null,
                'title' => 'Tryout Akbar Simulasi SNBT 2026',
                'description' => 'Simulasi ujian komprehensif format UTBK-SNBT dengan analisis mendalam subtes.',
                'type' => 'tryout',
                'duration_minutes' => 45,
                'pass_percentage' => 75,
                'difficulty' => 'hard',
                'is_active' => true,
            ]
        );
        $tryout->questions()->sync($qIds);
    }
}
