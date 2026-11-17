@extends('layouts.app')

@section('title', 'KakAI — Tutor AI Persiapan PTN & Ujian Mandiri')

@section('content')
<div class="min-h-screen py-8 bg-gradient-to-b from-bisa-50/50 via-white to-gray-50 dark:from-[#0E1017] dark:via-[#121520] dark:to-[#0B0D13] transition-colors duration-200">
    <div class="max-w-4xl mx-auto px-4 sm:px-6">

        {{-- Top Banner --}}
        <div class="bg-white dark:bg-[#161922] rounded-3xl p-6 border border-gray-100 dark:border-white/10 shadow-sm mb-6 flex flex-wrap items-center justify-between gap-4 animate-fade-in-down">
            <div class="flex items-center gap-4">
                <div class="w-14 h-14 rounded-2xl bg-gradient-to-br from-bisa to-amber-500 text-white flex items-center justify-center text-2xl shadow-lg shadow-bisa/30">
                    <i class="bi bi-robot"></i>
                </div>
                <div>
                    <div class="flex items-center gap-2">
                        <h1 class="text-xl font-black text-charcoal-dark dark:text-white">KakAI Tutor AI</h1>
                        <span class="px-2 py-0.5 rounded-full text-[10px] font-black bg-emerald-100 dark:bg-emerald-950/40 text-emerald-700 dark:text-emerald-300 uppercase tracking-wider">
                            ● Online 24/7
                        </span>
                    </div>
                    <p class="text-xs text-gray-500 dark:text-gray-400 mt-0.5">
                        Tutor AI cerdas khusus persiapan SNBT, UTBK, TKA, dan Ujian Mandiri PTN.
                    </p>
                </div>
            </div>

            <div class="text-right">
                <a href="{{ route('practice.index') }}" class="px-4 py-2 bg-bisa-50 dark:bg-bisa-950/40 text-bisa hover:bg-bisa hover:text-white rounded-xl text-xs font-bold transition inline-flex items-center gap-1.5">
                    <i class="bi bi-pencil-square"></i>
                    <span>Buka Mode Latihan</span>
                </a>
            </div>
        </div>

        {{-- Chat Box Area --}}
        <div x-data="kakaiChat()" class="bg-white dark:bg-[#161922] rounded-3xl border border-gray-100 dark:border-white/10 shadow-xl overflow-hidden flex flex-col h-[650px] animate-fade-in-up">

            {{-- Message History Container --}}
            <div class="flex-1 overflow-y-auto p-6 space-y-4" id="chatContainer">
                <template x-for="(msg, idx) in messages" :key="idx">
                    <div :class="msg.role === 'user' ? 'flex justify-end' : 'flex justify-start items-start gap-3'">
                        <template x-if="msg.role === 'assistant'">
                            <div class="w-8 h-8 rounded-xl bg-bisa text-white flex items-center justify-center font-bold text-xs shrink-0 shadow-sm">
                                <i class="bi bi-robot"></i>
                            </div>
                        </template>

                        <div :class="msg.role === 'user' ? 'bg-bisa text-white rounded-2xl rounded-tr-none px-4 py-3 max-w-lg text-sm shadow-md' : 'bg-gray-50 dark:bg-white/5 text-charcoal-dark dark:text-gray-100 rounded-2xl rounded-tl-none px-5 py-4 max-w-xl text-sm border border-gray-100 dark:border-white/5 space-y-2.5'">
                            <div class="font-medium leading-relaxed" x-text="msg.content"></div>

                            {{-- Detailed Structured Cards from KakAI --}}
                            <template x-if="msg.cards">
                                <div class="space-y-2 mt-3 pt-3 border-t border-gray-200/60 dark:border-white/10 text-xs">
                                    <template x-if="msg.cards.concept">
                                        <div class="p-2.5 bg-blue-50 dark:bg-blue-950/30 text-blue-900 dark:text-blue-200 rounded-xl">
                                            <span class="font-bold block mb-0.5">🎯 Konsep Kunci:</span>
                                            <span x-text="msg.cards.concept"></span>
                                        </div>
                                    </template>
                                    <template x-if="msg.cards.speed_trick">
                                        <div class="p-2.5 bg-amber-50 dark:bg-amber-950/30 text-amber-900 dark:text-amber-200 rounded-xl">
                                            <span class="font-bold block mb-0.5">⚡ Trik Cepat:</span>
                                            <span x-text="msg.cards.speed_trick"></span>
                                        </div>
                                    </template>
                                    <template x-if="msg.cards.analogy">
                                        <div class="p-2.5 bg-emerald-50 dark:bg-emerald-950/30 text-emerald-900 dark:text-emerald-200 rounded-xl">
                                            <span class="font-bold block mb-0.5">💡 Analogi Mudah:</span>
                                            <span x-text="msg.cards.analogy"></span>
                                        </div>
                                    </template>
                                </div>
                            </template>
                        </div>
                    </div>
                </template>

                {{-- Loading Indicator --}}
                <div x-show="loading" class="flex items-center gap-3">
                    <div class="w-8 h-8 rounded-xl bg-bisa text-white flex items-center justify-center text-xs animate-pulse">
                        <i class="bi bi-robot"></i>
                    </div>
                    <div class="px-4 py-3 bg-gray-100 dark:bg-white/5 rounded-2xl text-xs text-gray-500 flex items-center gap-2">
                        <span class="w-2 h-2 rounded-full bg-bisa animate-ping"></span>
                        <span>KakAI sedang menganalisis konsep dan merangkum pembahasan...</span>
                    </div>
                </div>
            </div>

            {{-- Quick Prompts Suggestions --}}
            <div class="px-6 py-2.5 bg-gray-50/70 dark:bg-white/5 border-t border-gray-100 dark:border-white/5 flex items-center gap-2 overflow-x-auto text-xs whitespace-nowrap">
                <span class="text-gray-400 font-bold text-[11px]">Ide Pertanyaan:</span>
                <button type="button" @click="sendPredefined('Bagaimana trik cepat menaklukkan soal Silogisme di TPS?')" class="px-3 py-1 rounded-full bg-white dark:bg-white/10 border border-gray-200 dark:border-white/10 hover:border-bisa text-gray-600 dark:text-gray-300 hover:text-bisa transition">
                    💡 Trik Silogisme TPS
                </button>
                <button type="button" @click="sendPredefined('Jelaskan strategi mengerjakan Penalaran Matematika dalam waktu terbatas')" class="px-3 py-1 rounded-full bg-white dark:bg-white/10 border border-gray-200 dark:border-white/10 hover:border-bisa text-gray-600 dark:text-gray-300 hover:text-bisa transition">
                    ⏱️ Strategi Waktu Pen. Mat
                </button>
                <button type="button" @click="sendPredefined('Bagaimana cara menghitung passing grade SNBT dengan sistem IRT?')" class="px-3 py-1 rounded-full bg-white dark:bg-white/10 border border-gray-200 dark:border-white/10 hover:border-bisa text-gray-600 dark:text-gray-300 hover:text-bisa transition">
                    📊 Cara Kerja Skor IRT
                </button>
            </div>

            {{-- Input Form Area --}}
            <div class="p-4 bg-white dark:bg-[#161922] border-t border-gray-100 dark:border-white/10">
                <form @submit.prevent="sendMessage()" class="flex items-center gap-3">
                    <input type="text"
                           x-model="inputPrompt"
                           placeholder="Tanya KakAI apa saja tentang soal, rumus, atau strategi masuk PTN..."
                           class="flex-1 px-4 py-3.5 rounded-2xl border border-gray-200 dark:border-white/10 bg-gray-50 dark:bg-white/5 text-sm text-charcoal-dark dark:text-white focus:outline-none focus:border-bisa focus:ring-2 focus:ring-bisa/20 transition">
                    <button type="submit"
                            :disabled="loading || !inputPrompt.trim()"
                            class="px-6 py-3.5 bg-bisa hover:bg-bisa-dark disabled:opacity-50 text-white font-extrabold text-sm rounded-2xl shadow-md transition flex items-center gap-2">
                        <span>Kirim</span>
                        <i class="bi bi-send-fill text-xs"></i>
                    </button>
                </form>
            </div>

        </div>

    </div>
</div>

@push('scripts')
<script>
function kakaiChat() {
    return {
        inputPrompt: '',
        loading: false,
        messages: [
            {
                role: 'assistant',
                content: 'Halo pejuang PTN! Aku KakAI, tutor AI pribadimu di BISA. Ada konsep materi, trik rumus cepat, atau soal sulit yang ingin kamu bedah bersamaku hari ini?',
                cards: null
            }
        ],
        async sendMessage() {
            if (!this.inputPrompt.trim() || this.loading) return;
            const prompt = this.inputPrompt;
            this.messages.push({ role: 'user', content: prompt, cards: null });
            this.inputPrompt = '';
            this.loading = true;
            this.scrollToBottom();

            try {
                const res = await fetch("{{ route('kakai.ask') }}", {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({ prompt: prompt })
                });
                const data = await res.json();
                if (data.success && data.reply) {
                    this.messages.push({
                        role: 'assistant',
                        content: data.reply.summary,
                        cards: data.reply
                    });
                }
            } catch (e) {
                this.messages.push({
                    role: 'assistant',
                    content: 'Maaf, terjadi gangguan koneksi sementara. KakAI siap menjawab pertanyaanmu lagi dalam beberapa saat.',
                    cards: null
                });
            } finally {
                this.loading = false;
                this.scrollToBottom();
            }
        },
        sendPredefined(text) {
            this.inputPrompt = text;
            this.sendMessage();
        },
        scrollToBottom() {
            this.$nextTick(() => {
                const el = document.getElementById('chatContainer');
                if (el) el.scrollTop = el.scrollHeight;
            });
        }
    }
}
</script>
@endpush
@endsection

