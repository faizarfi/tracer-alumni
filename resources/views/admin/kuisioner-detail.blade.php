@extends('layouts.admin')

@section('title', 'Detail Kuesioner Alumni')

@section('content')
<style>
    /* Premium Glass Detail Styling */
    .glass-card-detail {
        background: rgba(255, 255, 255, 0.95);
        backdrop-filter: blur(10px);
        border: 1px solid rgba(226, 232, 240, 0.8);
        border-radius: 2.5rem;
        box-shadow: 0 15px 35px -10px rgba(0, 0, 0, 0.05);
    }

    .info-label {
        font-size: 10px;
        font-weight: 900;
        text-transform: uppercase;
        letter-spacing: .12em;
        color: #475569;
        margin-bottom: .375rem;
        display: block;
    }

    .info-value {
        font-size: 0.95rem;
        font-weight: 800;
        color: #0f172a;
        line-height: 1.1;
    }

    .answer-pill {
        padding: 1rem;
        border-radius: 16px;
        border: 1px solid rgba(15,23,42,0.04);
        transition: all .28s ease;
        background: #ffffff;
        box-shadow: 0 6px 18px rgba(2,6,23,0.04);
        display: flex;
        justify-content: space-between;
        align-items: center;
        gap: .5rem;
    }

    .section-divider {
        display: flex;
        align-items: center;
        gap: .75rem;
        padding: 1.25rem 2rem;
        border-bottom: 1px solid rgba(148,163,184,0.06);
    }

    /* Logic Sentimen Warna */
    .sentimen-positif { border-left: 4px solid #10b981; }
    .sentimen-negatif { border-left: 4px solid #f43f5e; }
    .sentimen-netral { border-left: 4px solid #f59e0b; }
</style>

<div class="space-y-8 font-['Plus_Jakarta_Sans'] pb-12">

    {{-- HEADER SECTION --}}
    <header class="flex flex-col md:flex-row md:items-center justify-between gap-6 animate-fade-in">
        <div class="flex items-center gap-4">
            <a href="{{ route('admin.kuisioner') }}" class="w-12 h-12 bg-white border border-slate-200 rounded-2xl flex items-center justify-center shadow-sm hover:bg-slate-50 transition-all group active:scale-90">
                <i data-lucide="arrow-left" class="w-5 h-5 text-slate-600 group-hover:-translate-x-1 transition-transform"></i>
            </a>
            <div>
                <h1 class="text-3xl font-black text-slate-900 tracking-tight flex items-center gap-3">
                    Detail <span class="text-green-600">Responden</span>
                </h1>
                <p class="text-slate-500 mt-1 font-medium italic uppercase text-[10px] tracking-widest">Peninjauan Jawaban Alumni Secara Mendalam</p>
            </div>
        </div>

        @if ($kuisioner->created_at)
        <div class="bg-emerald-50 px-6 py-3 rounded-2xl border border-emerald-100 flex items-center gap-4 shadow-sm">
            <div class="text-right">
                <p class="text-[9px] font-black text-green-400 uppercase tracking-widest leading-none mb-1">Waktu Submit</p>
                <p class="text-xs font-black text-green-700 leading-none">
                    {{ $kuisioner->created_at->translatedFormat('d F Y, H:i') }} WIB
                </p>
            </div>
            <i data-lucide="check-circle-2" class="w-6 h-6 text-emerald-600"></i>
        </div>
        @endif
    </header>

    {{-- 1. IDENTITAS UTAMA --}}
    <section class="glass-card-detail overflow-hidden">
        <div class="section-divider bg-slate-50/50">
            <i data-lucide="user" class="w-5 h-5 text-slate-400"></i>
            <h2 class="text-[11px] font-black text-slate-800 uppercase tracking-widest">Metadata Responden</h2>
        </div>
        <div class="p-8 grid grid-cols-1 md:grid-cols-3 gap-8 text-center md:text-left">
            <div>
                <span class="info-label">User ID System</span>
                <p class="text-lg font-black text-emerald-700 font-mono tracking-tighter">#{{ $kuisioner->user_id }}</p>
            </div>
            <div class="md:border-x border-slate-100 md:px-8">
                <span class="info-label">Nama Alumni</span>
                <p class="text-lg font-black text-slate-800 uppercase tracking-tight">{{ $kuisioner->user->name ?? 'Tidak Ditemukan' }}</p>
            </div>
            <div>
                <span class="info-label">Status Kelengkapan</span>
                <span class="inline-flex items-center gap-2 bg-emerald-100 text-emerald-700 px-3 py-1 rounded-full text-[10px] font-black uppercase mt-1">
                    <i data-lucide="verified" class="w-3 h-3"></i> Terverifikasi
                </span>
            </div>
        </div>
    </section>

    {{-- 2. INFORMASI PEKERJAAN --}}
    <section class="glass-card-detail overflow-hidden">
        <div class="section-divider bg-emerald-50/30">
            <i data-lucide="briefcase" class="w-5 h-5 text-emerald-600"></i>
            <h2 class="text-[11px] font-black text-slate-800 uppercase tracking-widest">Informasi Karir & Institusi</h2>
        </div>
        <div class="p-8 space-y-8">
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                <div class="p-6 rounded-3xl bg-emerald-50 border border-emerald-100 shadow-sm group">
                    <span class="info-label text-emerald-600">Status Saat Ini</span>
                    <p class="text-base font-black text-emerald-800">{{ $kuisioner->status_pekerjaan ?? '-' }}</p>
                </div>
                <div class="p-6 rounded-3xl bg-slate-50 border border-slate-100 shadow-sm">
                    <span class="info-label">Waktu Tunggu Lulus</span>
                    <p class="text-base font-black text-slate-700 uppercase">
                        {{ $kuisioner->waktu_tunggu ?? '0' }} <span class="text-xs font-bold text-slate-400 ml-1">Bulan</span>
                    </p>
                </div>
                <div class="p-6 rounded-3xl bg-slate-50 border border-slate-100 shadow-sm">
                    <span class="info-label">Jenis Perusahaan</span>
                    <p class="text-base font-black text-slate-700">{{ $kuisioner->jenis_perusahaan ?? '-' }}</p>
                </div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                <div class="p-6 bg-slate-50 border border-slate-100 rounded-3xl shadow-sm flex items-start gap-4">
                    <div class="w-10 h-10 bg-slate-50 rounded-xl flex items-center justify-center shrink-0">
                        <i data-lucide="building" class="w-5 h-5 text-emerald-500"></i>
                    </div>
                    <div>
                        <span class="info-label">Nama Perusahaan</span>
                        <p class="font-bold text-slate-700">{{ $kuisioner->nama_perusahaan ?? '-' }}</p>
                    </div>
                </div>
                <div class="p-6 bg-slate-50 border border-slate-100 rounded-3xl shadow-sm flex items-start gap-4">
                    <div class="w-10 h-10 bg-slate-50 rounded-xl flex items-center justify-center shrink-0">
                        <i data-lucide="map-pin" class="w-5 h-5 text-emerald-500"></i>
                    </div>
                    <div>
                        <span class="info-label">Alamat Perusahaan</span>
                        <p class="font-bold text-slate-700 leading-relaxed">{{ $kuisioner->alamat_perusahaan ?? '-' }}</p>
                    </div>
                </div>
            </div>

            <div class="bg-slate-900 rounded-[2.5rem] p-10 text-white relative overflow-hidden group">
                <div class="absolute right-0 top-0 w-64 h-64 bg-emerald-500/10 rounded-full blur-3xl group-hover:bg-emerald-500/20 transition-all duration-700"></div>
                <div class="relative z-10 grid grid-cols-3 gap-4 text-center">
                    <div>
                        <p class="text-3xl font-black text-emerald-300">{{ $kuisioner->jumlah_lamaran ?? 0 }}</p>
                        <p class="text-[9px] font-black uppercase tracking-widest text-slate-400 mt-2">Total Lamaran</p>
                    </div>
                    <div class="border-x border-white/10">
                        <p class="text-3xl font-black text-emerald-400">{{ $kuisioner->jumlah_respon ?? 0 }}</p>
                        <p class="text-[9px] font-black uppercase tracking-widest text-slate-400 mt-2">Respon Balik</p>
                    </div>
                    <div>
                        <p class="text-3xl font-black text-emerald-200">{{ $kuisioner->jumlah_wawancara ?? 0 }}</p>
                        <p class="text-[9px] font-black uppercase tracking-widest text-slate-400 mt-2">Interview</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- 3. DETAIL JAWABAN (PENDIDIKAN & FASILITAS) --}}
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
        @foreach(['pendidikan' => ['label' => 'Proses Pendidikan', 'icon' => 'graduation-cap', 'color' => 'emerald'],
              'fasilitas' => ['label' => 'Fasilitas Kampus', 'icon' => 'server', 'color' => 'emerald']] as $key => $meta)
        <section class="glass-card-detail overflow-hidden flex flex-col">
            <div class="section-divider bg-{{ $meta['color'] }}-50/30">
                <i data-lucide="{{ $meta['icon'] }}" class="w-5 h-5 text-{{ $meta['color'] }}-600"></i>
                <h2 class="text-[11px] font-black text-slate-800 uppercase tracking-widest">{{ $meta['label'] }}</h2>
            </div>
            <div class="p-8 space-y-3">
                @php $dataArray = is_string($kuisioner->$key) ? json_decode($kuisioner->$key, true) : (array) $kuisioner->$key; @endphp
                @forelse ($dataArray as $label => $val)
                    @php
                        $sentimen = match($val) {
                            'Sangat Besar', 'Besar' => 'sentimen-positif',
                            'Cukup Besar' => 'sentimen-netral',
                            default => 'sentimen-negatif'
                        };
                    @endphp
                    <div class="answer-pill {{ $sentimen }} hover:bg-slate-50">
                        <span class="text-[10px] font-bold text-slate-500 uppercase leading-tight pr-4">{{ str_replace('_', ' ', $label) }}</span>
                        <span class="text-xs font-black text-slate-900 uppercase whitespace-nowrap">{{ $val ?? '-' }}</span>
                    </div>
                @empty
                    <div class="text-center py-10 text-slate-300 italic text-sm">Data tidak tersedia.</div>
                @endforelse {{-- DISINI PERBAIKANNYA: @endforelse bukan @endforeach --}}
            </div>
        </section>
        @endforeach
    </div>

    {{-- 4. KRITIK & SARAN --}}
    <section class="glass-card-detail overflow-hidden border-t-4 border-t-emerald-500">
        <div class="section-divider bg-emerald-50/20">
            <i data-lucide="message-square" class="w-5 h-5 text-emerald-500"></i>
            <h2 class="text-[11px] font-black text-slate-800 uppercase tracking-widest">Kritik & Saran Alumni</h2>
        </div>
        <div class="p-10">
            <div class="relative bg-slate-50 p-8 rounded-[2.5rem] border border-slate-100 shadow-inner">
                <i data-lucide="quote" class="absolute -top-4 -left-4 w-10 h-10 text-emerald-100 opacity-60"></i>
                <p class="text-lg font-medium text-slate-600 leading-relaxed italic relative z-10">
                    "{{ $kuisioner->jawaban ?? 'Responden tidak memberikan kritik atau saran tambahan.' }}"
                </p>
            </div>
        </div>
    </section>

</div>
@endsection

@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        lucide.createIcons();
    });
</script>
@endsection
