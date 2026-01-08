@extends('layouts.admin')

@section('title', 'Manajemen Alumni')

@section('content')
<style>
    /* Premium Table & Filter Styling - Kontras Diperkuat */
    .glass-card-table {
        background: #ffffff; /* Putih Solid agar tidak transparan berlebih */
        border: 1px solid #cbd5e1; /* Border abu-abu tegas */
        border-radius: 1.5rem;
        box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.1);
    }

    /* Input dengan Border Tegas dan Teks Gelap */
    .input-premium {
        @apply w-full bg-slate-50 border border-slate-400 rounded-xl px-4 py-3 outline-none focus:border-blue-600 focus:ring-4 focus:ring-blue-500/10 transition-all text-sm font-bold text-slate-900 appearance-none;
        /* text-slate-900 memastikan teks sangat hitam/gelap */
    }

    /* Label yang lebih terlihat */
    .filter-label {
        @apply text-[11px] font-black uppercase tracking-widest text-slate-700 mb-2 block ml-1;
    }

    .tr-hover {
        transition: all 0.2s ease;
    }

    .tr-hover:hover {
        background-color: #f1f5f9;
        transform: scale(1.001);
    }

    /* Header Tabel Gelap agar kontras */
    .table-header-dark {
        @apply bg-slate-800 text-white text-[10px] font-black uppercase tracking-widest;
    }
</style>

<div class="space-y-8 font-['Plus_Jakarta_Sans']">

    {{-- HEADER SECTION --}}
    <header class="flex flex-col md:flex-row md:items-center justify-between gap-6 animate-fade-in">
        <div class="flex items-center gap-4">
            <div class="w-14 h-14 bg-blue-600 text-white rounded-2xl flex items-center justify-center shadow-lg">
                <i data-lucide="users-round" class="w-7 h-7"></i>
            </div>
            <div>
                <h1 class="text-3xl font-black text-slate-900 tracking-tight">Database <span class="text-blue-600">Alumni</span></h1>
                <p class="text-slate-600 mt-1 font-bold uppercase text-[11px] tracking-widest">Total Terdaftar: {{ $alumnis->total() ?? 0 }} Alumni</p>
            </div>
        </div>

        <div class="flex gap-3">
            <a href="{{ route('admin.alumni.exportCsv') }}" class="flex items-center gap-2 px-6 py-3 bg-indigo-600 text-white rounded-2xl font-black text-xs uppercase tracking-widest shadow-xl hover:bg-indigo-700 transition-all active:scale-95">
                <i data-lucide="file-spreadsheet" class="w-4 h-4"></i> Export CSV
            </a>
        </div>
    </header>

    {{-- FILTER SECTION - DIPERBAIKI KONTRASNYA --}}
    <section class="glass-card-table p-8 shadow-xl">
        <form action="{{ route('admin.alumni') }}" method="GET" class="space-y-6">
            <div class="grid grid-cols-1 md:grid-cols-12 gap-8">

                {{-- Search --}}
                <div class="md:col-span-6">
                    <label class="filter-label">Cari Alumni (Nama/NIM)</label>
                    <div class="relative group">
                        <i data-lucide="search" class="absolute left-4 top-1/2 -translate-y-1/2 w-5 h-5 text-slate-500 group-focus-within:text-blue-600 transition-colors"></i>
                        <input type="text" name="cari" value="{{ request('cari') }}" placeholder="Ketik nama atau nomor induk..." class="input-premium pl-12 border-slate-300">
                    </div>
                </div>

                {{-- Filter Status Kerja --}}
                <div class="md:col-span-3">
                    <label class="filter-label">Status Karir</label>
                    <div class="relative">
                        <select name="status_kerja" onchange="this.form.submit()" class="input-premium pr-10 border-slate-300">
                            <option value="">Semua Status</option>
                            <option value="1" {{ request('status_kerja') === '1' ? 'selected' : '' }}>Sudah Bekerja</option>
                            <option value="0" {{ request('status_kerja') === '0' ? 'selected' : '' }}>Belum Bekerja</option>
                        </select>
                        <i data-lucide="chevron-down" class="absolute right-4 top-1/2 -translate-y-1/2 w-5 h-5 text-slate-600 pointer-events-none"></i>
                    </div>
                </div>

                {{-- Sort --}}
                <div class="md:col-span-3">
                    <label class="filter-label">Urutkan Data</label>
                    <div class="relative">
                        <select name="sort" onchange="this.form.submit()" class="input-premium pr-10 border-slate-300">
                            <option value="nama" {{ request('sort') == 'nama' ? 'selected' : '' }}>Nama Alumni</option>
                            <option value="nim" {{ request('sort') == 'nim' ? 'selected' : '' }}>NIM</option>
                            <option value="tahun_keluar" {{ request('sort') == 'tahun_keluar' ? 'selected' : '' }}>Tahun Lulus</option>
                        </select>
                        <i data-lucide="chevron-down" class="absolute right-4 top-1/2 -translate-y-1/2 w-5 h-5 text-slate-600 pointer-events-none"></i>
                    </div>
                </div>

            </div>

            <div class="flex justify-end pt-4 border-t border-slate-200">
                <button type="submit" class="bg-slate-900 hover:bg-black text-white px-10 py-4 rounded-xl font-black text-xs uppercase tracking-[0.2em] transition-all shadow-lg active:scale-95 flex items-center gap-2">
                    <i data-lucide="filter" class="w-4 h-4 text-blue-400"></i> Terapkan Filter
                </button>
            </div>
        </form>
    </section>

    {{-- TABLE SECTION --}}
    <section class="glass-card-table overflow-hidden shadow-2xl">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="table-header-dark">
                        <th class="px-8 py-5">Biodata & Tanggal Lahir</th>
                        <th class="px-5 py-5 text-center">NIM</th>
                        <th class="px-5 py-5">Program Studi / Jurusan</th>
                        <th class="px-5 py-5 text-center">Lulus</th>
                        <th class="px-5 py-5 text-center">Status</th>
                        <th class="px-8 py-5 text-right">Opsi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-200">
                    @forelse ($alumnis as $alumni)
                    <tr class="tr-hover group bg-white">
                        <td class="px-8 py-4">
                            <div class="flex items-center gap-4">
                                <img src="{{ $alumni->foto_path ? Storage::url($alumni->foto_path) : 'https://ui-avatars.com/api/?name='.urlencode($alumni->nama).'&background=0284c7&color=fff' }}"
                                     class="w-12 h-12 rounded-2xl object-cover border-2 border-slate-200 shadow-sm transition-transform group-hover:scale-105">
                                <div class="min-w-0">
                                    <p class="font-black text-slate-900 text-sm uppercase tracking-tight truncate">{{ $alumni->nama }}</p>
                                    {{-- KOLOM TANGGAL LAHIR - KONTRAK BIRU TEGAS --}}
                                    <p class="text-[10px] font-black text-blue-700 uppercase tracking-widest mt-1 bg-blue-50 px-2 py-0.5 rounded w-fit">
                                        <i data-lucide="calendar" class="w-3 h-3 inline mr-1 -mt-0.5"></i>
                                        {{ \Carbon\Carbon::parse($alumni->tanggal_lahir)->translatedFormat('d M Y') }}
                                    </p>
                                </div>
                            </div>
                        </td>
                        <td class="px-5 py-4 text-center">
                            <span class="font-mono text-xs font-black text-slate-800 bg-slate-100 px-2 py-1 rounded border border-slate-300">
                                {{ $alumni->nim }}
                            </span>
                        </td>
                        <td class="px-5 py-4">
                            <div class="flex flex-col">
                                <span class="text-[11px] font-black text-slate-800 leading-tight uppercase">{{ $alumni->jurusan }}</span>
                                <span class="text-[10px] font-bold text-slate-500 uppercase tracking-tighter mt-1 italic">{{ $alumni->fakultas }}</span>
                            </div>
                        </td>
                        <td class="px-5 py-4 text-center">
                            <span class="text-xs font-black text-emerald-700 bg-emerald-50 px-3 py-1 rounded-lg border border-emerald-200">
                                {{ $alumni->tahun_keluar }}
                            </span>
                        </td>
                        <td class="px-5 py-4 text-center">
                            @if($alumni->sudah_bekerja)
                                <span class="px-4 py-1.5 bg-emerald-600 text-white rounded-full text-[9px] font-black uppercase shadow-md">Bekerja</span>
                            @else
                                <span class="px-4 py-1.5 bg-rose-100 text-rose-700 rounded-full text-[9px] font-black uppercase border border-rose-200">Mencari</span>
                            @endif
                        </td>
                        <td class="px-8 py-4 text-right">
                            <div class="flex justify-end items-center gap-2">
                                <a href="{{ route('admin.alumni.edit', $alumni->user_id) }}" class="p-2.5 bg-blue-100 text-blue-700 rounded-xl hover:bg-blue-600 hover:text-white transition-all shadow-sm">
                                    <i data-lucide="edit-3" class="w-4 h-4"></i>
                                </a>
                                <form action="{{ route('admin.alumni.destroy', $alumni->user_id) }}" method="POST" class="swal-confirm" data-confirm="Hapus data alumni ini?">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="p-2.5 bg-rose-100 text-rose-700 rounded-xl hover:bg-rose-600 hover:text-white transition-all shadow-sm">
                                        <i data-lucide="trash-2" class="w-4 h-4"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="py-24 text-center">
                            <i data-lucide="search-x" class="w-12 h-12 text-slate-300 mx-auto mb-4"></i>
                            <p class="text-sm font-black text-slate-500 uppercase tracking-widest">Data alumni tidak ditemukan</p>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </section>

    {{-- PAGINATION --}}
    <div class="mt-8 flex justify-center pb-20">
        <div class="bg-white px-6 py-3 rounded-2xl shadow-lg border border-slate-300">
            {{ $alumnis->appends(request()->all())->links() }}
        </div>
    </div>
</div>
@endsection
