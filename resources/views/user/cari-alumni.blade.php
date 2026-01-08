@extends('layouts.user')

@section('title', 'Cari Alumni | UIN Raden Mas Said')

@section('content')
<style>
    /* Desain kartu transparan untuk area filter */
    .glass-filter-card {
        background: rgba(255, 255, 255, 0.95);
        backdrop-filter: blur(10px);
        border: 1px solid rgba(226, 232, 240, 0.8);
        box-shadow: 0 20px 40px rgba(0, 0, 0, 0.05);
    }

    /* Efek hover pada kartu alumni */
    .alumni-card {
        transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
        border: 1px solid rgba(226, 232, 240, 0.8);
    }

    .alumni-card:hover {
        transform: translateY(-10px);
        box-shadow: 0 25px 50px -12px rgba(16, 185, 129, 0.15);
        border-color: #10b981;
    }

    /* Penyesuaian input agar teks terlihat kontras */
    .input-premium {
        width: 100%;
        background-color: #ffffff;
        border: 1px solid #e2e8f0;
        border-radius: 1rem;
        padding: 0.875rem 1.25rem;
        outline: none;
        transition: all 0.3s ease;
        color: #1e293b; /* Slate-800 agar teks jelas */
    }

    .input-premium:focus {
        border-color: #10b981;
        box-shadow: 0 0 0 4px rgba(16, 185, 129, 0.1);
    }

    /* Badge status mengambang */
    .badge-status {
        backdrop-filter: blur(4px);
        background: rgba(6, 78, 59, 0.85);
    }
</style>

<div class="py-16 px-4 sm:px-6 lg:px-8 bg-slate-50 min-h-screen">
    <div class="max-w-7xl mx-auto">

        {{-- Bagian Header --}}
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-6 mb-12">
            <div>
                <h1 class="text-4xl font-black text-slate-900 tracking-tight">Direktori <span class="text-green-600">Alumni</span></h1>
                <p class="text-slate-500 mt-2 font-medium">Temukan dan terhubung kembali dengan rekan almamater Anda.</p>
            </div>
            <a href="{{ route('user.dashboard') }}"
                class="inline-flex items-center gap-2 px-6 py-3 rounded-2xl bg-white text-slate-700 font-bold hover:bg-slate-50 shadow-sm border border-slate-200 transition-all active:scale-95">
                <i data-lucide="layout-dashboard" class="w-5 h-5"></i>
                Dashboard
            </a>
        </div>

        {{-- AREA FILTER & PENCARIAN (Sudah Diperbaiki Visibilitasnya) --}}
        <div class="glass-filter-card p-8 rounded-[2.5rem] mb-12 animate-fade-in relative z-20">
            <form method="GET" action="{{ route('user.cari-alumni') }}" class="space-y-8">

                {{-- Bar Pencarian Utama --}}
                <div class="relative group">
                    <div class="absolute left-6 top-1/2 -translate-y-1/2 text-slate-400 group-focus-within:text-green-600 transition-colors">
                        <i data-lucide="search" class="w-6 h-6"></i>
                    </div>
                    <input type="text" name="query" value="{{ request('query') }}"
                        placeholder="Cari nama, NIM, jurusan..."
                        class="w-full pl-16 pr-36 py-5 rounded-[2rem] bg-slate-50 border-2 border-transparent focus:border-green-500 focus:bg-white outline-none text-lg font-medium transition-all shadow-inner text-slate-800">
                    <button type="submit" class="absolute right-3 top-1/2 -translate-y-1/2 bg-green-700 text-white px-8 py-3 rounded-2xl font-bold hover:bg-green-800 transition-all shadow-lg active:scale-95">
                        Cari
                    </button>
                </div>

                {{-- Grid Filter Lanjutan --}}
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">

                    {{-- Filter Fakultas --}}
                    <div class="space-y-2">
                        <label class="text-[10px] font-black uppercase tracking-widest text-slate-500 ml-2 block">Fakultas</label>
                        <div class="relative">
                            <select name="fakultas" onchange="this.form.submit()" class="input-premium appearance-none cursor-pointer pr-10">
                                <option value="">Semua Fakultas</option>
                                @foreach(['Fakultas Syariah', 'Fakultas Ilmu Tarbiyah', 'Fakultas Ekonomi dan Bisnis Islam', 'Fakultas Ushuluddin dan Dakwah', 'Fakultas Adab dan Bahasa'] as $f)
                                    <option value="{{ $f }}" {{ request('fakultas') == $f ? 'selected' : '' }}>{{ $f }}</option>
                                @endforeach
                            </select>
                            <i data-lucide="chevron-down" class="absolute right-4 top-1/2 -translate-y-1/2 w-4 h-4 text-slate-400 pointer-events-none"></i>
                        </div>
                    </div>

                    {{-- Filter Status Karir --}}
                    <div class="space-y-2">
                        <label class="text-[10px] font-black uppercase tracking-widest text-slate-500 ml-2 block">Status Karir</label>
                        <div class="relative">
                            <select name="status" onchange="this.form.submit()" class="input-premium appearance-none cursor-pointer pr-10">
                                <option value="">Semua Status</option>
                                <option value="1" {{ request('status') === '1' ? 'selected' : '' }}>Sudah Bekerja</option>
                                <option value="0" {{ request('status') === '0' ? 'selected' : '' }}>Belum Bekerja</option>
                            </select>
                            <i data-lucide="chevron-down" class="absolute right-4 top-1/2 -translate-y-1/2 w-4 h-4 text-slate-400 pointer-events-none"></i>
                        </div>
                    </div>

                    {{-- Filter Angkatan --}}
                    <div class="space-y-2">
                        <label class="text-[10px] font-black uppercase tracking-widest text-slate-500 ml-2 block">Angkatan (Tahun Masuk)</label>
                        <input type="number" name="tahun_masuk" value="{{ request('tahun_masuk') }}" placeholder="Contoh: 2020" onchange="this.form.submit()"
                            class="input-premium">
                    </div>

                    {{-- Filter Tahun Lulus --}}
                    <div class="space-y-2">
                        <label class="text-[10px] font-black uppercase tracking-widest text-slate-500 ml-2 block">Tahun Lulus</label>
                        <input type="number" name="tahun_keluar" value="{{ request('tahun_keluar') }}" placeholder="Contoh: 2024" onchange="this.form.submit()"
                            class="input-premium">
                    </div>
                </div>
            </form>
        </div>

        {{-- Hasil Pencarian --}}
        @if(isset($alumni) && $alumni->count() > 0)
            <div class="flex items-center gap-3 mb-10 px-4">
                <div class="w-12 h-1 bg-green-600 rounded-full"></div>
                <p class="text-slate-500 font-bold uppercase tracking-widest text-sm">Ditemukan <span class="text-slate-900">{{ $alumni->count() }}</span> Profil Alumni</p>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-8">
                @foreach($alumni as $a)
                <div class="alumni-card bg-white rounded-[2.5rem] overflow-hidden flex flex-col">
                    <div class="relative h-24 bg-gradient-to-br from-green-800 to-emerald-600">
                        <div class="absolute -bottom-10 left-1/2 -translate-x-1/2">
                            <div class="p-1 bg-white rounded-[2rem] shadow-xl">
                                @if($a->foto_path)
                                    <img src="{{ \Illuminate\Support\Facades\Storage::url($a->foto_path) }}"
                                         class="w-20 h-20 rounded-[1.8rem] object-cover"
                                         onerror="this.src='https://placehold.co/150x150/e2e8f0/64748b?text={{ substr($a->nama, 0, 1) }}'">
                                @else
                                    <div class="w-20 h-20 rounded-[1.8rem] bg-slate-100 flex items-center justify-center text-2xl font-black text-green-700">
                                        {{ substr($a->nama, 0, 1) }}
                                    </div>
                                @endif
                            </div>
                        </div>
                        <div class="absolute top-3 right-3 badge-status text-[10px] font-black text-white px-3 py-1 rounded-full uppercase tracking-widest">
                            {{ $a->sudah_bekerja ? 'Working' : 'Available' }}
                        </div>
                    </div>

                    <div class="pt-12 p-8 text-center flex-grow flex flex-col">
                        <h3 class="text-lg font-black text-slate-900 leading-tight mb-1 uppercase tracking-tight">{{ $a->nama }}</h3>
                        <p class="text-xs font-bold text-slate-400 mb-6 uppercase tracking-wider">{{ $a->nim }}</p>

                        <div class="grid grid-cols-2 gap-2 mb-6 text-center">
                            <div class="bg-slate-50 p-3 rounded-2xl border border-slate-100">
                                <p class="text-[9px] font-black text-slate-400 uppercase tracking-tighter mb-0.5">Masuk</p>
                                <p class="text-xs font-bold text-slate-700">{{ $a->tahun_masuk ?? '-' }}</p>
                            </div>
                            <div class="bg-slate-50 p-3 rounded-2xl border border-slate-100">
                                <p class="text-[9px] font-black text-slate-400 uppercase tracking-tighter mb-0.5">Lulus</p>
                                <p class="text-xs font-bold text-slate-700">{{ $a->tahun_keluar ?? '-' }}</p>
                            </div>
                        </div>

                        <div class="space-y-1 mb-6">
                            <p class="text-[10px] font-black text-green-600 uppercase tracking-widest">Jurusan</p>
                            <p class="text-xs font-bold text-slate-600 leading-relaxed px-2">{{ $a->jurusan }}</p>
                        </div>

                        @if($a->sudah_bekerja && $a->tempat_bekerja)
                        <div class="mt-auto pt-6 border-t border-slate-50">
                            <div class="flex items-center justify-center gap-2 text-blue-600 mb-1">
                                <i data-lucide="building-2" class="w-3.5 h-3.5"></i>
                                <span class="text-[9px] font-black uppercase tracking-widest">Bekerja di</span>
                            </div>
                            <p class="text-xs font-bold text-slate-700 truncate px-4" title="{{ $a->tempat_bekerja }}">{{ $a->tempat_bekerja }}</p>
                        </div>
                        @else
                        <div class="mt-auto pt-6 border-t border-slate-50 italic text-slate-400 text-[10px] font-medium">
                            Status karir belum diperbarui
                        </div>
                        @endif
                    </div>
                </div>
                @endforeach
            </div>
        @else
            {{-- Tampilan Jika Data Kosong --}}
            <div class="glass-filter-card rounded-[3rem] p-20 text-center animate-fade-in border-dashed border-2">
                <div class="w-24 h-24 bg-slate-50 rounded-[2rem] flex items-center justify-center mx-auto mb-8 shadow-inner">
                    <i data-lucide="search-x" class="w-12 h-12 text-slate-300"></i>
                </div>
                <h3 class="text-2xl font-black text-slate-900 mb-4">Tidak Ada Hasil</h3>
                <p class="text-slate-500 max-w-sm mx-auto">Kami tidak dapat menemukan profil alumni yang sesuai dengan filter Anda. Silakan coba kriteria pencarian lain.</p>
                <div class="mt-10">
                    <a href="{{ route('user.cari-alumni') }}" class="px-8 py-3 bg-slate-900 text-white rounded-2xl text-xs font-black uppercase tracking-widest hover:bg-slate-800 transition-all">
                        Reset Filter
                    </a>
                </div>
            </div>
        @endif
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        // Menginisialisasi Ikon Lucide
        lucide.createIcons();
    });
</script>
@endsection
