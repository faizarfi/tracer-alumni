@extends('layouts.kaprodi')

@section('title', 'Pusat Bantuan Kaprodi')

@section('head_extras')
<style>
    /* Premium FAQ Accordion Logic */
    .faq-answer {
        max-height: 0;
        overflow: hidden;
        transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
        opacity: 0;
    }

    .faq-item.active {
        border-color: #10b981;
        background: #ffffff;
        box-shadow: 0 15px 30px -10px rgba(16, 185, 129, 0.1);
    }

    .faq-item.active .faq-answer {
        max-height: 500px;
        opacity: 1;
        padding-top: 1rem;
        padding-bottom: 1.5rem;
    }

    .faq-item.active .faq-icon {
        transform: rotate(180deg);
        color: #10b981;
    }

    .glass-card-help {
        background: rgba(255, 255, 255, 0.9);
        backdrop-filter: blur(10px);
        border: 1px solid rgba(226, 232, 240, 0.8);
        border-radius: 2rem;
    }
</style>
@endsection

@section('content')
<div class="space-y-8 font-['Plus_Jakarta_Sans'] pb-12">

    {{-- HEADER SECTION --}}
    <header class="flex flex-col md:flex-row md:items-center justify-between gap-6 animate-fade-in">
        <div class="flex items-center gap-4">
            <div class="w-12 h-12 bg-emerald-100 text-emerald-600 rounded-2xl flex items-center justify-center shadow-sm">
                <i data-lucide="help-circle" class="w-6 h-6"></i>
            </div>
            <div>
                <h1 class="text-3xl font-black text-slate-900 tracking-tight">Pusat <span class="text-green-600">Bantuan</span></h1>
                <p class="text-slate-500 mt-1 font-medium italic uppercase text-[10px] tracking-widest">Dokumentasi & Dukungan Teknis UIN RMS</p>
            </div>
        </div>
        <div class="hidden lg:flex items-center gap-2 bg-white px-4 py-2 rounded-2xl border border-slate-200 shadow-sm">
            <span class="relative flex h-2 w-2">
                <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-green-400 opacity-75"></span>
                <span class="relative inline-flex rounded-full h-2 w-2 bg-green-500"></span>
            </span>
            <span class="text-[10px] font-black text-slate-600 uppercase tracking-tighter">Sistem Online & Stabil</span>
        </div>
    </header>

    {{-- NAVIGASI CEPAT --}}
    <section class="grid grid-cols-1 sm:grid-cols-3 gap-6">
        <a href="#faq-section" class="p-6 bg-white rounded-[2rem] border border-slate-100 shadow-sm hover:shadow-xl hover:border-indigo-200 transition-all group">
            <div class="w-10 h-10 bg-indigo-50 text-indigo-600 rounded-xl flex items-center justify-center mb-4 group-hover:scale-110 transition-transform">
                <i data-lucide="message-circle" class="w-5 h-5"></i>
            </div>
            <h3 class="font-black text-slate-800 text-sm uppercase tracking-tight">Tanya Jawab</h3>
            <p class="text-[10px] text-slate-400 font-bold uppercase mt-1">Solusi Cepat Masalah Umum</p>
        </a>

        <a href="#interpretasi-section" class="p-6 bg-white rounded-[2rem] border border-slate-100 shadow-sm hover:shadow-xl hover:border-yellow-200 transition-all group">
            <div class="w-10 h-10 bg-yellow-50 text-yellow-600 rounded-xl flex items-center justify-center mb-4 group-hover:scale-110 transition-transform">
                <i data-lucide="bar-chart-3" class="w-5 h-5"></i>
            </div>
            <h3 class="font-black text-slate-800 text-sm uppercase tracking-tight">Literasi Data</h3>
            <p class="text-[10px] text-slate-400 font-bold uppercase mt-1">Cara Membaca Grafik</p>
        </a>

        <a href="mailto:it-tracer@uinsaid.ac.id" class="p-6 bg-white rounded-[2rem] border border-slate-100 shadow-sm hover:shadow-xl hover:border-emerald-200 transition-all group">
            <div class="w-10 h-10 bg-emerald-50 text-emerald-600 rounded-xl flex items-center justify-center mb-4 group-hover:scale-110 transition-transform">
                <i data-lucide="headphones" class="w-5 h-5"></i>
            </div>
            <h3 class="font-black text-slate-800 text-sm uppercase tracking-tight">Hubungi Admin</h3>
            <p class="text-[10px] text-slate-400 font-bold uppercase mt-1">Dukungan Teknis Lanjutan</p>
        </a>
    </section>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        {{-- KOLOM UTAMA --}}
        <div class="lg:col-span-2 space-y-8">

            {{-- FAQ SECTION --}}
            <section id="faq-section" class="glass-card-help p-8 shadow-xl shadow-slate-200/50">
                <div class="flex items-center gap-3 mb-8">
                    <div class="w-1 h-8 bg-indigo-500 rounded-full"></div>
                    <h2 class="text-xl font-black text-slate-800 uppercase tracking-tight">Pertanyaan Umum (FAQ)</h2>
                </div>

                <div class="space-y-4">
                    @php
                        $faqs = [
                            [
                                'q' => "Apa perbedaan 'Total Alumni' dan 'Total Responden'?",
                                'a' => "<b class='text-green-600'>Total Alumni</b> adalah seluruh lulusan yang terdaftar di database prodi Anda. <b class='text-indigo-600'>Total Responden</b> adalah alumni yang secara aktif sudah menyelesaikan pengisian kuesioner tracer study."
                            ],
                            [
                                'q' => "Mengapa data pada grafik tidak muncul atau kosong?",
                                'a' => "Sistem memerlukan minimal <span class='font-bold underline'>satu responden aktif</span> untuk mulai menghasilkan visualisasi. Jika grafik kosong, berarti belum ada alumni prodi Anda yang mengisi kuesioner."
                            ],
                            [
                                'q' => "Bagaimana cara melakukan ekspor data kuesioner?",
                                'a' => "Masuk ke halaman <span class='font-bold italic'>Laporan Kuesioner</span>, lalu klik tombol <span class='px-2 py-1 bg-emerald-100 text-emerald-700 rounded text-[10px] font-bold'>EXPORT CSV</span> di pojok kanan atas untuk mengunduh data mentah."
                            ]
                        ];
                    @endphp

                    @foreach($faqs as $faq)
                    <div class="faq-item border border-slate-100 rounded-[1.5rem] bg-slate-50/50 transition-all duration-300">
                        <button class="faq-question w-full flex items-center justify-between p-6 text-left focus:outline-none">
                            <span class="text-sm font-black text-slate-700 leading-tight tracking-tight">{{ $faq['q'] }}</span>
                            <i data-lucide="chevron-down" class="faq-icon w-5 h-5 text-slate-400 transition-transform duration-300"></i>
                        </button>
                        <div class="faq-answer px-6">
                            <p class="text-sm text-slate-500 leading-relaxed font-medium">{!! $faq['a'] !!}</p>
                        </div>
                    </div>
                    @endforeach
                </div>
            </section>

            {{-- LITERASI DATA SECTION --}}
            <section id="interpretasi-section" class="glass-card-help p-8 shadow-xl shadow-slate-200/50 border-t-4 border-t-yellow-500">
                <div class="flex items-center gap-3 mb-8">
                    <div class="w-1 h-8 bg-yellow-500 rounded-full"></div>
                    <h2 class="text-xl font-black text-slate-800 uppercase tracking-tight">Cara Membaca Grafik</h2>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="p-6 bg-blue-50/50 border border-blue-100 rounded-3xl group hover:bg-white transition-all">
                        <h3 class="text-[10px] font-black text-blue-600 uppercase tracking-[0.2em] mb-3">Relevansi Kerja (P1)</h3>
                        <p class="text-xs text-slate-600 leading-relaxed font-medium">
                            Mengukur keselarasan bidang ilmu dengan pekerjaan.
                            <span class="block mt-3 p-2 bg-blue-100/50 rounded-lg font-bold text-blue-800 italic">Target: > 70% Keselarasan</span>
                        </p>
                    </div>

                    <div class="p-6 bg-emerald-50/50 border border-emerald-100 rounded-3xl group hover:bg-white transition-all text-center">
                        <h3 class="text-[10px] font-black text-emerald-600 uppercase tracking-[0.2em] mb-3">Employability Rate</h3>
                        <p class="text-xs text-slate-600 leading-relaxed font-medium">
                            Persentase alumni yang terserap dunia kerja atau lanjut studi dalam waktu < 6 bulan.
                        </p>
                    </div>
                </div>
            </section>
        </div>

        {{-- KOLOM SAMPING --}}
        <aside class="space-y-6">
            <div class="bg-slate-900 rounded-[2.5rem] p-8 text-white shadow-2xl relative overflow-hidden group">
                <div class="absolute -right-10 -top-10 w-32 h-32 bg-green-500/20 rounded-full blur-3xl group-hover:bg-green-500/40 transition-all duration-500"></div>

                <h2 class="text-lg font-black mb-4 flex items-center gap-3">
                    <i data-lucide="shield-check" class="w-5 h-5 text-green-400"></i> Bantuan Teknis
                </h2>
                <p class="text-[11px] text-slate-400 leading-relaxed font-medium mb-8">
                    Terdapat kendala akses atau data prodi tidak sesuai? Hubungi Administrator IT Tracer Study Pusat.
                </p>

                <div class="space-y-4">
                    <a href="mailto:it-tracer@uinsaid.ac.id" class="flex items-center gap-4 p-4 bg-white/5 rounded-2xl border border-white/10 hover:bg-white/10 transition-all group">
                        <div class="w-8 h-8 bg-green-500/20 text-green-400 rounded-lg flex items-center justify-center">
                            <i data-lucide="mail" class="w-4 h-4"></i>
                        </div>
                        <span class="text-xs font-bold tracking-tight">it-tracer@uinsaid.ac.id</span>
                    </a>

                    <div class="flex items-center gap-4 p-4 bg-white/5 rounded-2xl border border-white/10">
                        <div class="w-8 h-8 bg-blue-500/20 text-blue-400 rounded-lg flex items-center justify-center">
                            <i data-lucide="phone" class="w-4 h-4"></i>
                        </div>
                        <span class="text-xs font-bold tracking-tight">(0271) 781516</span>
                    </div>
                </div>
            </div>

            {{-- SISTEM INFO --}}
            <div class="bg-white p-6 rounded-[2rem] border border-slate-100 shadow-sm flex items-center justify-between">
                <div>
                    <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest leading-none mb-1">Versi Sistem</p>
                    <p class="text-sm font-black text-slate-800 uppercase leading-none">V2.4 Stable</p>
                </div>
                <div class="w-10 h-10 bg-slate-50 rounded-xl flex items-center justify-center">
                    <i data-lucide="cpu" class="w-5 h-5 text-slate-300"></i>
                </div>
            </div>
        </aside>
    </div>
</div>
@endsection

@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', () => {
        const faqItems = document.querySelectorAll('.faq-item');

        faqItems.forEach(item => {
            const question = item.querySelector('.faq-question');

            question.addEventListener('click', () => {
                const isActive = item.classList.contains('active');

                // Mode Accordion: Tutup yang lain saat satu dibuka
                faqItems.forEach(i => i.classList.remove('active'));

                if (!isActive) {
                    item.classList.add('active');
                }
            });
        });

        // Inisialisasi Ikon Lucide
        lucide.createIcons();
    });
</script>
@endsection
