<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Question;
use App\Models\QuestionOption;
use App\Models\Subject;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\View\View;
use Symfony\Component\HttpFoundation\StreamedResponse;

class ImportController extends Controller
{
    public function index(): View
    {
        return view('admin.import.index');
    }

    /**
     * Download Excel/CSV format template.
     */
    public function downloadTemplate(): StreamedResponse
    {
        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="template_import_soal_bisa.csv"',
        ];

        return response()->stream(function () {
            $handle = fopen('php://output', 'w');

            // Header row
            fputcsv($handle, [
                'category',
                'subject',
                'question',
                'option_a',
                'option_b',
                'option_c',
                'option_d',
                'option_e',
                'correct_answer',
                'explanation',
                'difficulty',
            ]);

            // Sample row
            fputcsv($handle, [
                'SNBT',
                'Penalaran Umum',
                'Semua bunga di taman harum. Sebagian tanaman di taman berduri. Simpulan yang benar adalah...',
                'Sebagian tanaman berduri harum.',
                'Semua tanaman berduri harum.',
                'Tidak ada tanaman berduri yang harum.',
                'Semua tanaman di taman adalah bunga.',
                'Semua bunga berduri.',
                'A',
                'Premis pertama mencakup semua bunga, premis kedua sebagian tanaman berduri. Simpulannya sebagian tanaman berduri harum.',
                'medium',
            ]);

            fclose($handle);
        }, 200, $headers);
    }

    /**
     * Process and validate the Excel/CSV import.
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'file' => ['required', 'file', 'mimes:csv,txt,xlsx'],
        ]);

        $file = $request->file('file');
        $path = $file->getRealPath();

        $rows = [];
        if (($handle = fopen($path, 'r')) !== false) {
            // Read header
            $header = fgetcsv($handle, 4000, ',');

            $lineNumber = 1;
            while (($data = fgetcsv($handle, 4000, ',')) !== false) {
                $lineNumber++;
                if (count($data) < 9) {
                    continue; // Skip empty/malformed rows
                }

                $rows[] = [
                    'line' => $lineNumber,
                    'category' => trim($data[0] ?? ''),
                    'subject' => trim($data[1] ?? ''),
                    'question' => trim($data[2] ?? ''),
                    'option_a' => trim($data[3] ?? ''),
                    'option_b' => trim($data[4] ?? ''),
                    'option_c' => trim($data[5] ?? ''),
                    'option_d' => trim($data[6] ?? ''),
                    'option_e' => trim($data[7] ?? ''),
                    'correct_answer' => strtoupper(trim($data[8] ?? '')),
                    'explanation' => trim($data[9] ?? ''),
                    'difficulty' => strtolower(trim($data[10] ?? 'medium')),
                ];
            }
            fclose($handle);
        }

        if (empty($rows)) {
            return back()->with('error', 'File kosong atau format tidak sesuai template.');
        }

        // VALIDATION PHASE: Validate ALL rows before inserting any into database!
        $errors = [];
        $validDifficulties = ['easy', 'medium', 'hard'];
        $validKeys = ['A', 'B', 'C', 'D', 'E'];

        foreach ($rows as $r) {
            $line = $r['line'];

            if (empty($r['question'])) {
                $errors[] = "Baris {$line} — Kolom 'question' (pertanyaan) tidak boleh kosong.";
            }

            if (empty($r['option_a']) || empty($r['option_b'])) {
                $errors[] = "Baris {$line} — Opsi A dan B wajib diisi.";
            }

            if (! in_array($r['correct_answer'], $validKeys, true)) {
                $errors[] = "Baris {$line} — correct_answer tidak valid (harus salah satu dari: A, B, C, D, E). Nilai yang ditemukan: '{$r['correct_answer']}'.";
            }

            if (! in_array($r['difficulty'], $validDifficulties, true)) {
                $errors[] = "Baris {$line} — difficulty tidak valid (harus salah satu dari: easy, medium, hard). Nilai yang ditemukan: '{$r['difficulty']}'.";
            }
        }

        // If any error exists, ABORT and show line-by-line errors!
        if (! empty($errors)) {
            return back()->with('import_errors', $errors)->with('error', 'Ditemukan '.count($errors).' kesalahan dalam file. Import dibatalkan untuk menjaga kebersihan data.');
        }

        // INSERTION PHASE: All rows are valid!
        $importedCount = 0;
        foreach ($rows as $r) {
            // Find or create category
            $category = Category::firstOrCreate(
                ['name' => $r['category']],
                ['slug' => Str::slug($r['category']), 'order' => 1, 'is_active' => true]
            );

            // Find or create subject
            $subject = Subject::firstOrCreate(
                ['category_id' => $category->id, 'name' => $r['subject']],
                ['slug' => Str::slug($r['subject']), 'order' => 1, 'is_active' => true]
            );

            // Create question
            $q = Question::create([
                'subject_id' => $subject->id,
                'question_text' => $r['question'],
                'explanation' => $r['explanation'] ?: null,
                'explanation_source' => 'manual',
                'explanation_status' => 'published',
                'difficulty' => $r['difficulty'],
                'is_active' => true,
            ]);

            // Create options
            $optionsMap = [
                'A' => $r['option_a'],
                'B' => $r['option_b'],
                'C' => $r['option_c'],
                'D' => $r['option_d'],
                'E' => $r['option_e'],
            ];

            foreach ($optionsMap as $key => $text) {
                if (! empty($text)) {
                    QuestionOption::create([
                        'question_id' => $q->id,
                        'option_key' => $key,
                        'option_text' => $text,
                        'is_correct' => $r['correct_answer'] === $key,
                    ]);
                }
            }

            $importedCount++;
        }

        return redirect()->route('admin.questions.index')->with('success', "Import berhasil! {$importedCount} soal telah berhasil dimasukkan ke sistem.");
    }
}
