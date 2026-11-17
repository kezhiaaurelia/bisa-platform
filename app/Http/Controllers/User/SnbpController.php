<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\SnbpAnalysis;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class SnbpController extends Controller
{
    /**
     * Show the SNBP report score analysis tool and history.
     */
    public function index(Request $request): View
    {
        $user = $request->user();
        $analyses = SnbpAnalysis::where('user_id', $user->id)->latest()->get();

        return view('user.snbp.index', compact('user', 'analyses'));
    }

    /**
     * Calculate SNBP passing chance and generate personalized recommendations.
     */
    public function calculate(Request $request): RedirectResponse
    {
        $request->validate([
            'target_ptn' => ['required', 'string', 'max:255'],
            'target_major' => ['required', 'string', 'max:255'],
            'avg_report_score' => ['required', 'numeric', 'min:70', 'max:100'],
            'school_accreditation' => ['required', 'in:A,B,C'],
            'rank_in_class' => ['nullable', 'integer', 'min:1'],
        ]);

        $score = (float) $request->avg_report_score;
        $accreditation = $request->school_accreditation;

        // Realistic statistical chance calculation algorithm
        $baseChance = ($score - 70) * 2.8; // 70 => 0%, 100 => 84%
        if ($accreditation === 'A') {
            $baseChance += 12;
        } elseif ($accreditation === 'B') {
            $baseChance += 5;
        }

        // Clamp between 15% and 95%
        $chance = max(15, min(95, (int) round($baseChance)));

        $recommendation = "Berdasarkan nilai rata-rata rapor {$score} dan akreditasi sekolah {$accreditation}, peluang rasionalisasi masuk prodi {$request->target_major} di {$request->target_ptn} diperkirakan sebesar {$chance}%.";

        if ($chance >= 75) {
            $recommendation .= ' Peluangmu sangat kuat! Pertahankan konsistensi nilai di semester akhir dan persiapkan berkas sertifikat prestasi penunjang.';
        } elseif ($chance >= 50) {
            $recommendation .= ' Peluangmu kompetitif. Disarankan memilih PTN ini di Pilihan 1, dan memilih prodi dengan tingkat keketatan lebih rendah di Pilihan 2 sebagai cadangan aman.';
        } else {
            $recommendation .= ' Keketatan prodi ini sangat tinggi. Sebaiknya pertimbangkan prodi alternatif serumpun atau maksimalkan persiapan jalur tes SNBT/UTBK di BISA!';
        }

        $recommendation .= ' Jika kamu pendaftar beasiswa KIP Kuliah, pastikan akun SIM KIP Kuliah sudah terverifikasi sebelum batas pendaftaran SNBP ditutup.';

        $analysis = SnbpAnalysis::create([
            'user_id' => $request->user()->id,
            'target_ptn' => $request->target_ptn,
            'target_major' => $request->target_major,
            'avg_report_score' => $score,
            'chance_percentage' => $chance,
            'recommendation_text' => $recommendation,
        ]);

        return back()->with('analysis_result', $analysis);
    }
}
