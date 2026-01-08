@extends('layouts.kaprodi')

@section('title', 'Database Alumni')

@section('content')
<style>
    /* Card shell with subtle glass and stronger border for separation */
    .glass-card-alumni {
        background: rgba(255, 255, 255, 0.96);
        backdrop-filter: blur(6px);
        border: 1px solid rgba(226, 232, 240, 1);
        border-radius: 1.5rem;
        color: #0f172a;
    }

    .table-container {
        border-radius: 1.25rem;
        overflow: hidden;
        border: 1px solid #eef2ff;
    }

    /* Status badge explicit styles (replaces Tailwind @apply) */
    .status-badge {
        display: inline-block;
        padding: 0.25rem 0.75rem;
        border-radius: 9999px;
        font-size: 0.625rem;
        font-weight: 800;
        text-transform: uppercase;
        letter-spacing: 0.06em;
        border: 1px solid transparent;
    }

    /* Input filter explicit styles */
    .input-filter {
        width: 100%;
        background: #fff;
        border: 1px solid #e6edf6;
        border-radius: 0.75rem;
        padding: 0.625rem 1rem;
        outline: none;
        transition: box-shadow .15s ease, border-color .15s ease, transform .06s ease;
        font-size: 0.875rem;
        font-weight: 600;
        color: #0f172a;
    }
    .input-filter:focus {
        border-color: #2563eb;
        box-shadow: 0 8px 20px rgba(37,99,235,0.08);
    }

    /* Animasi Hover Baris Tabel */
    .tr-hover {
        transition: background-color 0.18s ease, transform 0.12s ease;
    }
    .tr-hover:hover {
        background-color: #fbfdff;
        transform: translateY(-1px);
    }

    /* Improve small icon contrast in header */
    .header-stat-icon { color: #1e40af; }

    /* Make disabled action clearer */
    .btn-disabled {
        background: #f8fafc;
        color: #94a3b8;
        border: 1px solid #e6edf6;
        opacity: 1;
    }
</style>

<div class="space-y-6 font-['Plus_Jakarta_Sans']">

    {{-- HEADER SECTION --}}
    <header class="flex flex-col md:flex-row md:items-center justify-between gap-4 animate-fade-in">
        <div class="flex items-center gap-4">
            <div class="w-12 h-12 bg-blue-100 text-blue-600 rounded-2xl flex items-center justify-center shadow-sm">
                <i data-lucide="users" class="w-6 h-6"></i>
            </div>
            <div>
                <h1 class="text-2xl font-black text-slate-900 tracking-tight">Database <span class="text-blue-600">Alumni</span></h1>
                @php $prodiName = $prodi ?? (Auth::user()->prodi ?? 'Program Studi'); @endphp
                <p class="text-slate-500 text-xs font-medium uppercase tracking-widest">Unit: {{ $prodiName }}</p>
            </div>
        </div>
        <div class="bg-white px-6 py-3 rounded-2xl border border-slate-200 shadow-sm flex items-center gap-4">
            <div class="text-right">
                <p class="text-[10px] font-black text-slate-400 uppercase tracking-[0.2em]">Total Terdata</p>
                <p class="text-xl font-black text-blue-800 leading-none">{{ $alumniData->total() ?? 0 }} <span class="text-xs font-medium text-slate-400">Orang</span></p>
            </div>
            <i data-lucide="database" class="w-8 h-8 header-stat-icon"></i>
        </div>
    </header>

    {{-- FILTER SECTION --}}
    <section class="glass-card-alumni p-6 shadow-xl shadow-slate-200/50">
        <form action="{{ route('kaprodi.alumni') }}" method="GET" class="grid grid-cols-1 md:grid-cols-4 gap-4">
            <div class="md:col-span-2 relative group">
                <i data-lucide="search" class="absolute left-4 top-3 w-4 h-4 text-slate-400 group-focus-within:text-blue-500 transition-colors"></i>
                <input type="search" name="cari" value="{{ request('cari') }}" placeholder="Cari Nama atau NIM Alumni..." class="input-filter pl-11">
            </div>

            <div class="relative">
                <select name="tahun" class="input-filter appearance-none cursor-pointer pr-10">
                    <option value="">Semua Tahun Lulus</option>
                    @if(isset($availableYears))
                        @foreach ($availableYears as $year)
                            <option value="{{ $year }}" {{ request('tahun') == $year ? 'selected' : '' }}>Angkatan {{ $year }}</option>
                        @endforeach
                    @endif
                </select>
                <i data-lucide="chevron-down" class="absolute right-4 top-3 w-4 h-4 text-slate-400 pointer-events-none"></i>
            </div>

            <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white rounded-xl font-bold text-sm transition-all shadow-lg shadow-blue-900/20 active:scale-95 flex items-center justify-center gap-2">
                <i data-lucide="filter" class="w-4 h-4"></i> TERAPKAN FILTER
            </button>
        </form>
    </section>

    {{-- MAIN TABLE SECTION --}}
    <section class="glass-card-alumni overflow-hidden shadow-xl shadow-slate-200/50">
        {{-- Status Info --}}
        <div class="px-8 py-4 bg-slate-50 border-b border-slate-100 flex justify-between items-center text-[11px] font-bold text-slate-500 uppercase tracking-widest">
            <span>Daftar Record Alumni</span>
            <span>
                @if(isset($alumniData) && $alumniData->total() > 0)
                    Menampilkan {{ $alumniData->firstItem() }} - {{ $alumniData->lastItem() }} Dari {{ $alumniData->total() }} Data
                @endif
            </span>
        </div>

        {{-- DESKTOP TABLE --}}
        <div class="hidden md:block">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-white border-b border-slate-100 text-[11px] font-black text-slate-400 uppercase tracking-widest">
                        <th class="px-8 py-5">Identitas Alumni</th>
                        <th class="px-8 py-5 text-center">Periode</th>
                        <th class="px-8 py-5 text-center">Status Karir</th>
                        <th class="px-8 py-5 text-center">Kuesioner</th>
                        <th class="px-8 py-5 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-50">
                    @forelse ($alumniData as $alumni)
                    <tr class="tr-hover">
                        <td class="px-8 py-4">
                            <div class="flex items-center gap-4">
                                <img src="{{ $alumni->foto_path ? asset('storage/' . $alumni->foto_path) : 'https://ui-avatars.com/api/?name='.urlencode($alumni->nama).'&background=0ea5e9&color=fff' }}"
                                     class="w-11 h-11 rounded-2xl object-cover border-2 border-white shadow-sm" alt="">
                                <div>
                                    <p class="font-bold text-slate-900 text-sm leading-tight uppercase">{{ $alumni->nama }}</p>
                                    <p class="text-xs font-medium text-slate-400 mt-0.5 tracking-tighter">{{ $alumni->nim }}</p>
                                </div>
                            </div>
                        </td>
                        <td class="px-8 py-4 text-center">
                            <div class="inline-flex items-center gap-2 bg-slate-100 px-3 py-1 rounded-lg">
                                <span class="text-[10px] font-bold text-slate-500">{{ $alumni->tahun_masuk ?? '?' }}</span>
                                <i data-lucide="arrow-right" class="w-3 h-3 text-slate-400"></i>
                                <span class="text-xs font-black text-green-600">{{ $alumni->tahun_keluar }}</span>
                            </div>
                        </td>
                        <td class="px-8 py-4 text-center">
                            @if(($alumni->sudah_bekerja ?? 0) == 1)
                                <span class="status-badge bg-emerald-50 text-emerald-600 border-emerald-100">Bekerja</span>
                            @else
                                <span class="status-badge bg-rose-50 text-rose-600 border-rose-100">Belum</span>
                            @endif
                        </td>
                        <td class="px-8 py-4 text-center">
                            @if($alumni->has_filled_questionnaire ?? false)
                                <div class="flex items-center justify-center text-emerald-600 gap-1 font-bold text-[10px] uppercase">
                                    <i data-lucide="check-circle-2" class="w-4 h-4"></i> Lengkap
                                </div>
                            @else
                                <span class="text-slate-500 text-[10px] font-bold uppercase italic tracking-tighter">Belum Isi</span>
                            @endif
                        </td>
                        <td class="px-8 py-4 text-right">
                            @if($alumni->has_filled_questionnaire ?? false)
                                <a href="{{ route('kaprodi.alumni.detail', ['alumni_id' => $alumni->user_id]) }}"
                                   class="inline-flex items-center gap-2 bg-slate-900 text-white px-4 py-2 rounded-xl text-[10px] font-black uppercase tracking-widest hover:bg-blue-600 transition-all shadow-md">
                                    Detail <i data-lucide="chevron-right" class="w-3 h-3 text-white"></i>
                                </a>
                            @else
                                <button disabled class="btn-disabled cursor-not-allowed inline-flex items-center gap-2 px-4 py-2 rounded-xl text-[10px] font-black uppercase">
                                    No Data
                                </button>
                            @endif
                        </td>
                    </tr>
                    @empty
                        {{-- Handled by table logic --}}
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- MOBILE CARD VIEW --}}
        <div class="md:hidden divide-y divide-slate-100">
            @forelse ($alumniData as $alumni)
                <div class="p-6 bg-white space-y-4">
                    <div class="flex justify-between items-start">
                        <div class="flex gap-4">
                            <img src="{{ $alumni->foto_path ? asset('storage/' . $alumni->foto_path) : 'https://ui-avatars.com/api/?name='.urlencode($alumni->nama).'&background=0ea5e9&color=fff' }}"
                                 class="w-12 h-12 rounded-2xl object-cover shadow-sm" alt="">
                            <div>
                                <h4 class="font-black text-slate-900 text-sm uppercase leading-tight">{{ $alumni->nama }}</h4>
                                <p class="text-xs font-bold text-slate-400 mt-1 uppercase">{{ $alumni->nim }}</p>
                            </div>
                        </div>
                        <div class="text-right">
                            <p class="text-[9px] font-black text-slate-500 uppercase tracking-widest leading-none">Lulus</p>
                            <p class="text-sm font-black text-green-600 mt-1">{{ $alumni->tahun_keluar }}</p>
                        </div>
                    </div>
                    <div class="flex items-center justify-between pt-2 border-t border-slate-50">
                        @if(($alumni->sudah_bekerja ?? 0) == 1)
                            <span class="status-badge bg-emerald-50 text-emerald-600 border-emerald-100">Bekerja</span>
                        @else
                            <span class="status-badge bg-rose-50 text-rose-600 border-rose-100">Belum Bekerja</span>
                        @endif

                        @if($alumni->has_filled_questionnaire ?? false)
                            <a href="{{ route('kaprodi.alumni.detail', ['alumni_id' => $alumni->user_id]) }}"
                               class="bg-blue-600 text-white px-4 py-2 rounded-xl text-[10px] font-black uppercase tracking-widest flex items-center gap-2">
                                Detail <i data-lucide="arrow-right" class="w-3 h-3"></i>
                            </a>
                        @else
                            <span class="text-[10px] font-bold text-slate-500 uppercase italic tracking-tighter">Kuesioner Kosong</span>
                        @endif
                    </div>
                </div>
            @empty
                <div class="py-20 text-center">
                    <div class="w-20 h-20 bg-slate-50 rounded-[2rem] flex items-center justify-center mx-auto mb-4">
                        <i data-lucide="search-x" class="w-10 h-10 text-slate-400"></i>
                    </div>
                    <p class="text-slate-400 font-bold uppercase tracking-widest text-xs">Data alumni tidak ditemukan</p>
                </div>
            @endforelse
        </div>
    </section>

    {{-- PAGINATION --}}
    <div class="mt-8 flex justify-center">
        @if(isset($alumniData) && method_exists($alumniData, 'links'))
            <div class="px-2 py-4 bg-white rounded-2xl shadow-sm border border-slate-200">
                {{ $alumniData->links() }}
            </div>
        @endif
    </div>

</div>
@endsection

@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        lucide.createIcons();
    });
</script>
@endsection
