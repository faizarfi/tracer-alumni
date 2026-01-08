@extends('layouts.kaprodi')

@section('title', 'Detail Kuesioner Alumni')

@section('content')
<style>
    .glass-card-detail {
        background: rgba(255, 255, 255, 0.95);
        backdrop-filter: blur(10px);
        border: 1px solid rgba(226, 232, 240, 0.8);
        border-radius: 2rem;
        box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.05);
    }

    .info-label {
        font-size: 10px;
        font-weight: 900;
        text-transform: uppercase;
        letter-spacing: .12em;
        color: #94a3b8; /* slate-400 */
        margin-bottom: .25rem;
        display: block;
    }

    .info-value {
        font-size: .875rem; /* text-sm */
        font-weight: 700;
        color: #334155; /* slate-700 */
        line-height: 1.1;
    }

    .answer-pill {
        padding: 1rem;
        border-radius: 1rem;
        border: 1px solid rgba(241, 245, 249, 1);
        transition: all 0.25s ease;
    }

    .section-header {
        display: flex;
        align-items: center;
        gap: 0.75rem;
        padding: 1rem 2rem;
        border-bottom: 1px solid #f8fafc; /* slate-50 */
    }

    /* Animasi Entry */
    .fade-up {
        animation: fadeUp 0.5s ease-out forwards;
    }

    @keyframes fadeUp {
        from { opacity: 0; transform: translateY(20px); }
        to { opacity: 1; transform: translateY(0); }
    }
</style>

<div class="space-y-8 font-['Plus_Jakarta_Sans'] pb-12">

    {{-- HEADER & NAVIGATION --}}
    <header class="flex flex-col md:flex-row md:items-center justify-between gap-6 fade-up">
        <div class="flex items-center gap-4">
            <a href="{{ route('kaprodi.alumni') }}" class="w-12 h-12 bg-white border border-slate-200 rounded-2xl flex items-center justify-center shadow-sm hover:bg-slate-50 transition-all group active:scale-90">
                <i data-lucide="arrow-left" class="w-5 h-5 text-slate-600 group-hover:-translate-x-1 transition-transform"></i>
            </a>
            <div>
                <h1 class="text-3xl font-black text-slate-900 tracking-tight">Review <span class="text-emerald-600">Kuesioner</span></h1>
                <p class="text-slate-500 mt-1 font-medium italic text-[10px] tracking-widest uppercase">Detail Jawaban Responden Alumni</p>
            </div>
        </div>

        @if ($kuesioner)
        <div class="bg-emerald-50 px-6 py-3 rounded-2xl border border-emerald-100 flex items-center gap-4 shadow-sm">
            <div class="text-right">
                <p class="text-[9px] font-black text-emerald-400 uppercase tracking-widest leading-none mb-1">Tanggal Submit</p>
                <p class="text-xs font-black text-emerald-700 leading-none">
                    {{ $kuesioner->updated_at->translatedFormat('d F Y, H:i') }} WIB
                </p>
            </div>
            <i data-lucide="calendar-check" class="w-8 h-8 text-emerald-300"></i>
        </div>
        @endif
    </header>

    @if ($alumni && $kuesioner)
        {{-- 1. PROFIL SINGKAT RESPONDEN --}}
        <section class="glass-card-detail overflow-hidden fade-up" style="animation-delay: 0.1s">
            <div class="section-header bg-slate-50/50">
                <i data-lucide="user-circle" class="w-6 h-6 text-slate-400"></i>
                <h2 class="text-sm font-black text-slate-800 uppercase tracking-widest">Identitas Responden</h2>
            </div>
            <div class="p-8 grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">
                <div class="flex items-center gap-4 col-span-1 md:col-span-2">
                    <img src="{{ $alumni->foto_path ? asset('storage/' . $alumni->foto_path) : 'https://ui-avatars.com/api/?name='.urlencode($alumni->nama).'&background=4f46e5&color=fff' }}"
                         class="w-16 h-16 rounded-[1.5rem] object-cover border-4 border-white shadow-md">
                    <div>
                        <span class="info-label">Nama Lengkap</span>
                        <p class="text-lg font-black text-slate-900 uppercase tracking-tight leading-tight">{{ $alumni->nama ?? '-' }}</p>
                    </div>
                </div>
                <div>
                        <span class="info-label">NIM / ID</span>
                        <p class="info-value text-emerald-600 font-mono">{{ $alumni->nim ?? '-' }}</p>
                </div>
                <div>
                    <span class="info-label">Program Studi</span>
                    <p class="info-value">{{ $alumni->jurusan ?? '-' }}</p>
                </div>
            </div>
        </section>

        {{-- 2. INFORMASI PEKERJAAN --}}
        <section class="glass-card-detail overflow-hidden fade-up" style="animation-delay: 0.2s">
                <div class="section-header bg-emerald-50/30">
                <i data-lucide="briefcase" class="w-6 h-6 text-emerald-600"></i>
                <h2 class="text-sm font-black text-slate-800 uppercase tracking-widest">Karir & Profesional</h2>
            </div>
            <div class="p-8 space-y-8">
                {{-- Status Bar --}}
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                    <div class="p-5 rounded-3xl bg-emerald-50 border border-emerald-100">
                        <span class="info-label text-emerald-400">Status Pekerjaan</span>
                        <p class="text-lg font-black text-emerald-900 leading-tight">{{ $kuesioner->status_pekerjaan ?? '-' }}</p>
                    </div>
                    <div class="p-5 rounded-3xl bg-slate-50 border border-slate-100">
                        <span class="info-label">Waktu Tunggu</span>
                        <p class="text-lg font-black text-slate-700 leading-tight">
                            {{ $kuesioner->waktu_tunggu ?? '0' }} <span class="text-xs font-bold text-slate-400 uppercase ml-1">Bulan</span>
                        </p>
                    </div>
                    <div class="p-5 rounded-3xl bg-slate-50 border border-slate-100">
                        <span class="info-label">Sektor Industri</span>
                        <p class="text-lg font-black text-slate-700 leading-tight">{{ $kuesioner->jenis_perusahaan ?? '-' }}</p>
                    </div>
                </div>

                {{-- Detail Perusahaan --}}
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                    <div class="flex items-start gap-4 p-6 bg-white border border-slate-100 rounded-3xl shadow-sm">
                        <div class="w-10 h-10 bg-slate-100 rounded-xl flex items-center justify-center shrink-0">
                            <i data-lucide="building-2" class="w-5 h-5 text-slate-400"></i>
                        </div>
                        <div>
                            <span class="info-label">Nama Institusi / Perusahaan</span>
                            <p class="font-bold text-slate-800">{{ $kuesioner->nama_perusahaan ?? '-' }}</p>
                        </div>
                    </div>
                    <div class="flex items-start gap-4 p-6 bg-white border border-slate-100 rounded-3xl shadow-sm">
                        <div class="w-10 h-10 bg-slate-100 rounded-xl flex items-center justify-center shrink-0">
                            <i data-lucide="map-pin" class="w-5 h-5 text-slate-400"></i>
                        </div>
                        <div>
                            <span class="info-label">Alamat / Lokasi Kerja</span>
                            <p class="font-bold text-slate-800 leading-relaxed">{{ $kuesioner->alamat_perusahaan ?? '-' }}</p>
                        </div>
                    </div>
                </div>

                {{-- Recap Stats --}}
                    <div class="bg-slate-900 rounded-[2.5rem] p-10 text-white relative overflow-hidden group">
                    <div class="absolute right-0 top-0 w-64 h-64 bg-emerald-500/10 rounded-full blur-3xl group-hover:bg-emerald-500/20 transition-all duration-700"></div>
                    <div class="relative z-10 grid grid-cols-3 gap-4 text-center">
                        <div>
                            <p class="text-3xl font-black text-emerald-400">{{ $kuesioner->jumlah_lamaran ?? 0 }}</p>
                            <p class="text-[10px] font-black uppercase tracking-widest text-slate-400 mt-2">Lamaran</p>
                        </div>
                        <div class="border-x border-white/10">
                            <p class="text-3xl font-black text-emerald-300">{{ $kuesioner->jumlah_respon ?? 0 }}</p>
                            <p class="text-[10px] font-black uppercase tracking-widest text-slate-400 mt-2">Respon</p>
                        </div>
                        <div>
                            <p class="text-3xl font-black text-amber-400">{{ $kuesioner->jumlah_wawancara ?? 0 }}</p>
                            <p class="text-[10px] font-black uppercase tracking-widest text-slate-400 mt-2">Interview</p>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        {{-- 3. DISTRIBUSI PENILAIAN --}}
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 fade-up" style="animation-delay: 0.3s">
            @foreach(['pendidikan' => ['label' => 'Proses Pendidikan', 'icon' => 'graduation-cap', 'color' => 'emerald'],
                      'fasilitas' => ['label' => 'Sarana Prasarana', 'icon' => 'building', 'color' => 'emerald']] as $key => $meta)
            <section class="glass-card-detail overflow-hidden flex flex-col">
                <div class="section-header bg-{{ $meta['color'] }}-50/30">
                    <i data-lucide="{{ $meta['icon'] }}" class="w-6 h-6 text-{{ $meta['color'] }}-600"></i>
                    <h2 class="text-sm font-black text-slate-800 uppercase tracking-widest">{{ $meta['label'] }}</h2>
                </div>
                <div class="p-8 space-y-3 flex-grow">
                    @php $dataArray = $kuesioner->$key ?? []; @endphp
                    @forelse ($dataArray as $q => $ans)
                        @php
                            $colorClass = match($ans) {
                                'Sangat Besar', 'Besar' => 'bg-emerald-50 border-emerald-100 text-emerald-700',
                                'Cukup Besar' => 'bg-amber-50 border-amber-100 text-amber-700',
                                'Kurang', 'Tidak Sama Sekali' => 'bg-rose-50 border-rose-100 text-rose-700',
                                default => 'bg-slate-50 border-slate-100 text-slate-500',
                            };
                        @endphp
                        <div class="answer-pill {{ $colorClass }}">
                            <p class="text-[9px] font-black uppercase tracking-tighter opacity-60 mb-1">{{ str_replace('\\', '', $q) }}</p>
                            <p class="text-xs font-black uppercase tracking-wide">{{ $ans ?? 'N/A' }}</p>
                        </div>
                    @empty
                        <div class="py-12 text-center text-slate-400 italic text-sm">Data penilaian tidak tersedia.</div>
                    @endforelse
                </div>
            </section>
            @endforeach
        </div>

        {{-- 4. KRITIK & SARAN --}}
        <section class="glass-card-detail overflow-hidden border-t-4 border-t-rose-500 fade-up" style="animation-delay: 0.4s">
            <div class="section-header">
                <i data-lucide="message-square" class="w-6 h-6 text-rose-500"></i>
                <h2 class="text-sm font-black text-slate-800 uppercase tracking-widest">Aspirasi Alumni</h2>
            </div>
            <div class="p-10">
                <div class="relative bg-slate-50 p-8 rounded-[2.5rem] border border-slate-100">
                    <i data-lucide="quote" class="absolute -top-4 -left-4 w-12 h-12 text-rose-200 opacity-50"></i>
                    <p class="text-lg font-medium text-slate-600 leading-relaxed italic relative z-10">
                        "{{ $kuesioner->jawaban ?? 'Responden tidak memberikan kritik atau saran tambahan.' }}"
                    </p>
                </div>
            </div>
        </section>

    @else
        {{-- EMPTY STATE --}}
        <div class="glass-card-detail p-20 text-center fade-up">
            <div class="w-24 h-24 bg-rose-50 text-rose-500 rounded-[2rem] flex items-center justify-center mx-auto mb-6">
                <i data-lucide="alert-circle" class="w-12 h-12"></i>
            </div>
            <h2 class="text-2xl font-black text-slate-900 uppercase tracking-tight">Data Tidak Lengkap</h2>
            <p class="text-slate-500 mt-2 max-w-md mx-auto">Sistem tidak menemukan record kuesioner untuk alumni ini. Pastikan alumni yang bersangkutan telah menyelesaikan proses pengisian kuesioner.</p>
            <a href="{{ route('kaprodi.alumni') }}" class="mt-10 inline-flex items-center gap-2 bg-slate-900 text-white px-8 py-3 rounded-2xl font-black uppercase tracking-widest text-[10px] hover:bg-indigo-600 transition-all">
                <i data-lucide="arrow-left" class="w-4 h-4"></i> Kembali ke Database
            </a>
        </div>
    @endif
</div>
@endsection

@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        lucide.createIcons();
    });
</script>
@endsection
