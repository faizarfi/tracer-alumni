@extends('layouts.admin')

@section('title', 'Manajemen Kuesioner')

@section('content')
<style>
    /* Premium Table / Card Styling */
    .glass-card-table {
        background: linear-gradient(180deg, rgba(240,253,244,0.85), rgba(255,255,255,0.95));
        border: 1px solid rgba(226, 232, 240, 0.8);
        border-radius: 1.75rem;
        box-shadow: 0 12px 40px -18px rgba(2,6,23,0.08);
        padding: 0.75rem;
    }

    .tr-hover {
        transition: all 0.18s ease;
    }

    .tr-hover:hover {
        transform: translateY(-3px);
    }

    /* Make table rows render as modern cards while preserving semantics */
    .glass-card-table table { width: 100%; border-collapse: separate; border-spacing: 0; }
    .glass-card-table thead { display: grid; grid-template-columns: 1fr 140px 220px 180px; gap: 12px; padding: 1rem; }
    .glass-card-table thead tr { display: contents; }
    .glass-card-table thead th { background: transparent; padding: 0.75rem 1rem; color: #94a3b8; }
    .glass-card-table tbody { display: grid; gap: 1rem; padding: 1rem; }
    .glass-card-table tbody tr { display: grid; grid-template-columns: 1fr 140px 220px 180px; gap: 12px; background: #ffffff; border-radius: 1rem; padding: 1rem; align-items: center; box-shadow: 0 8px 24px -16px rgba(2,6,23,0.06); border-left: 4px solid rgba(16,185,129,0.08); }
    .glass-card-table td { padding: 0; }

    .record-accent { border-left-color: #10b981 !important; }

    .input-premium {
        width: 100%;
        background: #ffffff;
        border: 1px solid #e6edf0;
        border-radius: 0.75rem;
        padding: 0.65rem 1rem;
        outline: none;
        font-size: 0.9375rem;
        font-weight: 600;
        color: #0f172a;
        transition: border-color 0.12s ease, box-shadow 0.12s ease;
    }
    .input-premium:focus { border-color: #10b981; box-shadow: 0 0 0 6px rgba(16,185,129,0.06); }
</style>

<div class="space-y-8 font-['Plus_Jakarta_Sans']">

    {{-- HEADER SECTION --}}
    <header class="flex flex-col md:flex-row md:items-center justify-between gap-6 animate-fade-in">
        <div class="flex items-center gap-4">
            <div class="w-12 h-12 bg-emerald-100 text-emerald-600 rounded-2xl flex items-center justify-center shadow-sm">
                <i data-lucide="file-text" class="w-6 h-6"></i>
            </div>
            <div>
                <h1 class="text-3xl font-black text-slate-900 tracking-tight">Manajemen <span class="text-green-600">Kuesioner</span></h1>
                <p class="text-slate-500 mt-1 font-medium italic uppercase text-[10px] tracking-widest">Data Responden Tracer Study Alumni</p>
            </div>
        </div>

        <div class="flex gap-3">
            <div class="hidden lg:flex flex-col items-end border-r pr-4 border-slate-200">
                <p id="currentDate" class="text-[10px] font-black text-slate-400 uppercase tracking-widest leading-none mb-1"></p>
                <p id="currentTime" class="text-xs font-black text-green-700 leading-none"></p>
            </div>
        </div>
    </header>

    {{-- Pesan flash ditangani oleh layout (SweetAlert) --}}

    {{-- SEARCH & FILTER SECTION --}}
    <section class="glass-card-table p-6 shadow-xl shadow-slate-200/50">
        <form action="{{ route('admin.kuisioner') }}" method="GET" class="grid grid-cols-1 md:grid-cols-4 gap-4">
            {{-- Search Input --}}
            <div class="md:col-span-2 relative group">
                <i data-lucide="search" class="absolute left-4 top-3 w-4 h-4 text-slate-400 group-focus-within:text-green-500 transition-colors"></i>
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari Nama Alumni..." class="input-premium pl-11">
            </div>

            {{-- Sort Select --}}
            <div class="relative">
                <select name="sort" onchange="this.form.submit()" class="input-premium appearance-none cursor-pointer pr-10">
                    <option value="asc" {{ request('sort') == 'asc' ? 'selected' : '' }}>Urutan Nama (A-Z)</option>
                    <option value="desc" {{ request('sort') == 'desc' ? 'selected' : '' }}>Urutan Nama (Z-A)</option>
                </select>
                <i data-lucide="chevron-down" class="absolute right-4 top-3 w-4 h-4 text-slate-400 pointer-events-none"></i>
            </div>

            {{-- Submit --}}
            <button type="submit" class="bg-green-700 hover:bg-green-800 text-white rounded-xl font-bold text-xs uppercase tracking-widest transition-all shadow-lg shadow-green-900/20 active:scale-95 flex items-center justify-center gap-2">
                <i data-lucide="filter" class="w-4 h-4"></i> Terapkan
            </button>
        </form>
    </section>

    {{-- MAIN TABLE SECTION --}}
    <section class="glass-card-table overflow-hidden shadow-xl shadow-slate-200/50">
        {{-- Status Bar --}}
        <div class="px-6 py-4 bg-transparent border-b border-slate-100 flex justify-between items-center">
            <div>
                <span class="text-[10px] font-black text-slate-400 uppercase tracking-[0.2em]">Record Kuesioner Terdata</span>
                <p class="text-xs text-slate-500 mt-1">Daftar responden lengkap dengan tanggal pengisian dan tindakan manajemen.</p>
            </div>
            <div>
                <span class="px-3 py-1 bg-emerald-50 text-emerald-700 rounded-full text-[10px] font-black uppercase tracking-tighter">
                    Total: {{ $kuisioners->total() }} Responden
                </span>
            </div>
        </div>

        {{-- Desktop View --}}
        <div class="hidden md:block">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-white text-[10px] font-black text-slate-400 uppercase tracking-[0.2em]">
                        <th class="px-8 py-5">Informasi Responden</th>
                        <th class="px-8 py-5 text-center">User ID</th>
                        <th class="px-8 py-5 text-center">Tanggal Mengisi</th>
                        <th class="px-8 py-5 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-50">
                    @forelse ($kuisioners as $kuisioner)
                    <tr class="tr-hover">
                        <td class="px-8 py-4">
                                        <div class="flex items-center gap-4">
                                            <div class="w-12 h-12 bg-emerald-50 text-emerald-600 rounded-xl flex items-center justify-center font-black text-base uppercase border border-emerald-100">
                                                {{ substr($kuisioner->user->name ?? '?', 0, 1) }}
                                            </div>
                                            <div>
                                                <p class="font-black text-slate-900 text-sm leading-tight uppercase">{{ $kuisioner->user->name ?? 'User Tidak Ditemukan' }}</p>
                                                <p class="text-[11px] font-medium text-slate-500 mt-0.5 tracking-tight">Alumni UIN Raden Mas Said</p>
                                            </div>
                                        </div>
                        </td>
                        <td class="px-8 py-4 text-center">
                            <span class="px-3 py-1 bg-emerald-50 border border-emerald-100 rounded-lg font-mono text-xs text-emerald-600 font-bold">#{{ $kuisioner->user_id }}</span>
                        </td>
                        <td class="px-8 py-4 text-center">
                            <div class="inline-flex items-center gap-2 text-slate-600">
                                <i data-lucide="calendar" class="w-4 h-4 text-emerald-300"></i>
                                <span class="text-xs font-bold">{{ $kuisioner->created_at->format('d M Y') }}</span>
                                <span class="text-[10px] text-slate-400 font-medium tracking-tighter">/ {{ $kuisioner->created_at->format('H:i') }}</span>
                            </div>
                        </td>
                        <td class="px-8 py-4 text-right">
                            <div class="flex justify-end items-center gap-2">
                                <a href="{{ route('admin.kuisioner.detail', $kuisioner->id) }}"
                                   class="inline-flex items-center gap-2 bg-emerald-50 text-emerald-600 px-4 py-2 rounded-xl text-[10px] font-black uppercase tracking-widest hover:bg-emerald-600 hover:text-white transition-all shadow-sm">
                                    <i data-lucide="eye" class="w-3.5 h-3.5"></i> Detail
                                </a>
                                <form action="{{ route('admin.kuisioner.destroy', $kuisioner->id) }}" method="POST" class="swal-confirm" data-confirm="Hapus data kuesioner ini?">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="p-2 text-red-500 hover:text-red-700 hover:bg-red-50 rounded-xl transition-all">
                                        <i data-lucide="trash-2" class="w-4 h-4"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4" class="py-20 text-center">
                            <i data-lucide="database-zap" class="w-12 h-12 text-slate-200 mx-auto mb-4"></i>
                            <p class="text-xs font-bold text-slate-400 uppercase tracking-widest">Belum ada data kuesioner</p>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- Mobile View --}}
        <div class="md:hidden divide-y divide-slate-100">
            @foreach ($kuisioners as $kuisioner)
            <div class="p-6 space-y-4">
                <div class="flex items-center justify-between">
                    <span class="text-[9px] font-black text-green-600 bg-green-50 px-2 py-1 rounded uppercase">ID: {{ $kuisioner->user_id }}</span>
                    <span class="text-[9px] font-bold text-slate-400 italic">{{ $kuisioner->created_at->format('d M Y, H:i') }}</span>
                </div>
                <h4 class="font-black text-slate-900 text-sm uppercase leading-tight">{{ $kuisioner->user->name ?? 'Tanpa Nama' }}</h4>
                <div class="flex gap-2">
                    <a href="{{ route('admin.kuisioner.detail', $kuisioner->id) }}" class="flex-1 bg-blue-600 text-white py-2.5 rounded-xl text-[10px] font-black uppercase tracking-widest text-center">Detail</a>
                    <form action="{{ route('admin.kuisioner.destroy', $kuisioner->id) }}" method="POST" class="flex-shrink-0 swal-confirm" data-confirm="Hapus data kuesioner ini?">
                        @csrf @method('DELETE')
                        <button type="submit" class="bg-rose-50 text-rose-600 p-2.5 rounded-xl border border-rose-100"><i data-lucide="trash-2" class="w-4 h-4"></i></button>
                    </form>
                </div>
            </div>
            @endforeach
        </div>
    </section>

    {{-- PAGINATION --}}
    <div class="mt-8 flex justify-center">
        <div class="bg-white px-4 py-2 rounded-2xl shadow-sm border border-slate-200">
            {{ $kuisioners->links() }}
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        lucide.createIcons();

        function updateClock() {
            const now = new Date();
            const dOpt = { weekday: 'long', day: 'numeric', month: 'short', year: 'numeric' };
            const tOpt = { hour: '2-digit', minute: '2-digit', second: '2-digit' };
            document.getElementById('currentDate').textContent = now.toLocaleDateString('id-ID', dOpt).toUpperCase();
            document.getElementById('currentTime').textContent = now.toLocaleTimeString('id-ID', tOpt) + ' WIB';
        }
        updateClock();
        setInterval(updateClock, 1000);
    });
</script>
@endpush
