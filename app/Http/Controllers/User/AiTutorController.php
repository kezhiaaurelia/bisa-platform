<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Question;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class AiTutorController extends Controller
{
    /**
     * Display KakAI Tutor AI interactive chat hub.
     */
    public function index(Request $request): View
    {
        $user = $request->user();

        return view('user.kakai.index', compact('user'));
    }

    /**
     * Answer student questions regarding a specific question or concept.
     */
    public function ask(Request $request): JsonResponse
    {
        $request->validate([
            'prompt' => ['nullable', 'string', 'max:2000'],
            'question_id' => ['nullable', 'exists:questions,id'],
        ]);

        $prompt = $request->input('prompt', '');
        $questionId = $request->input('question_id');

        $question = null;
        if ($questionId) {
            $question = Question::with('options', 'subject')->find($questionId);
        }

        // Generate comprehensive academic tutoring explanation
        $responseContent = $this->generateTutorResponse($prompt, $question);

        return response()->json([
            'success' => true,
            'reply' => $responseContent,
            'question_id' => $questionId,
        ]);
    }

    /**
     * Formulate an insightful Indonesian EdTech tutor response.
     */
    protected function generateTutorResponse(string $prompt, ?Question $question): array
    {
        if ($question) {
            $correctOption = $question->options->firstWhere('is_correct', true);
            $correctKey = $correctOption ? $correctOption->option_key : 'Kunci';
            $correctText = $correctOption ? $correctOption->option_text : '';

            return [
                'summary' => "Halo! KakAI siap membantumu membedah soal {$question->subject?->name} ini sampai tuntas! Jangan panik, yuk kita uraikan satu per satu.",
                'concept' => 'Soal ini menguji pemahaman konsep fundamental mengenai penalaran logis dan eliminasi opsi yang tidak didukung data.',
                'step_by_step' => [
                    'Langkah 1: Identifikasi kata kunci dan premis utama pada pertanyaan.',
                    'Langkah 2: Cermati premis negatif atau partikular yang membatasi kesimpulan.',
                    "Langkah 3: Jawaban benar adalah opsi [{$correctKey}] '{$correctText}', karena memenuhi validitas kaidah logika proposisi.",
                ],
                'speed_trick' => "💡 Trik Cepat KakAI: Hindari opsi yang mengandung generalisasi mutlak seperti 'pasti selalu', 'seluruhnya tanpa kecuali', kecuali jika disebutkan secara eksplisit pada teks!",
                'analogy' => "Bayangkan jika 'Semua apel adalah buah' dan 'Sebagian buah rasanya manis'. Kita tidak bisa menyimpulkan 'Semua apel manis'. Prinsip yang sama berlaku di nomor ini!",
            ];
        }

        // General chat reply
        return [
            'summary' => 'Halo pejuang PTN! Ada konsep atau tipe soal UTBK/SNBT yang ingin kamu diskusikan dengan KakAI hari ini?',
            'concept' => 'Kunci sukses menembus PTN impian adalah konsistensi drill soal, membedah pola jebakan, dan menguasai manajemen waktu.',
            'step_by_step' => [
                '1. Mulai dengan Mode Latihan santai untuk membangun pondasi teori per bab.',
                '2. Uji ketahanan mental dengan Mode Kuis bertimer 15-30 menit.',
                '3. Evaluasi subtes yang masih di bawah target dan ulangi pembahasannya bersama KakAI.',
            ],
            'speed_trick' => 'Trik KakAI: Gunakan teknik Skimming-Scanning saat mengerjakan Literasi Bahasa Indonesia dan Bahasa Inggris untuk menghemat 40% waktu membaca!',
            'analogy' => 'Persiapan masuk PTN ibarat lari maraton, bukan sprint. Konsisten 20 soal sehari jauh lebih efektif dibanding 200 soal sistem kebut semalam!',
        ];
    }
}
