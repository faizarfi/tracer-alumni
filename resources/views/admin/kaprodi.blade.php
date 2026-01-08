@extends('layouts.admin')

@section('title', 'Manajemen Kaprodi')

@section('content')
<style>
    /* Premium Glassmorphism Table Styling */
    .glass-card-kaprodi {
        background: rgba(255, 255, 255, 0.95);
        backdrop-filter: blur(10px);
        border: 1px solid rgba(226, 232, 240, 0.8);
        border-radius: 2.5rem;
        box-shadow: 0 15px 35px -10px rgba(0, 0, 0, 0.05);
    }

    .tr-hover {
        transition: all 0.2s ease;
    }

    .tr-hover:hover {
        background-color: #fff1f2; /* Soft pink tint */
        transform: scale(1.001);
    }

    .input-premium {
        @apply w-full bg-white border border-slate-200 rounded-2xl px-4 py-3 outline-none focus:border-pink-500 focus:ring-4 focus:ring-pink-500/10 transition-all text-sm font-medium text-slate-700 appearance-none;
    }

    /* Action Button dengan Teks */
    .btn-action-text {
        @apply flex items-center gap-2 px-4 py-2 rounded-xl font-black text-[10px] uppercase tracking-widest transition-all duration-300 shadow-sm hover:shadow-md active:scale-90;
    }
</style>

<div class="space-y-8 font-['Plus_Jakarta_Sans'] pb-12">

    {{-- HEADER SECTION --}}
    <header class="flex flex-col md:flex-row md:items-center justify-between gap-6 animate-fade-in">
        <div class="flex items-center gap-4">
            <div class="w-14 h-14 bg-pink-100 text-pink-600 rounded-2xl flex items-center justify-center shadow-sm border border-pink-200">
                <i data-lucide="user-check" class="w-8 h-8"></i>
            </div>
            <div>
                <h1 class="text-3xl font-black text-slate-900 tracking-tight">Manajemen <span class="text-pink-600">Kaprodi</span></h1>
                <p class="text-slate-500 mt-1 font-medium italic uppercase text-[10px] tracking-widest">Otoritas Pengelola Data Program Studi</p>
            </div>
        </div>

        <a href="{{ route('admin.kaprodi.create') }}" class="flex items-center gap-2 px-8 py-4 bg-pink-600 text-white rounded-2xl font-black text-xs uppercase tracking-widest shadow-xl shadow-pink-900/20 hover:bg-pink-700 transition-all active:scale-95">
            <i data-lucide="plus-circle" class="w-5 h-5"></i> Tambah Kaprodi
        </a>
    </header>

    {{-- ALERTS --}}
    @if(session('success') || session('error'))
        <div class="flex items-center gap-3 {{ session('success') ? 'bg-emerald-50 border-emerald-100 text-emerald-800' : 'bg-rose-50 border-rose-100 text-rose-800' }} px-6 py-4 rounded-2xl animate-fade-in shadow-sm border">
            <i data-lucide="{{ session('success') ? 'check-circle' : 'alert-circle' }}" class="w-5 h-5"></i>
            <span class="text-sm font-bold uppercase tracking-tight">{{ session('success') ?? session('error') }}</span>
        </div>
    @endif

    {{-- SEARCH & FILTER --}}
<section class="p-8 bg-white rounded-[2rem] shadow-xl border border-slate-200 animate-fade-in">
    <form action="#" method="GET" class="space-y-6">
        <div class="grid grid-cols-1 md:grid-cols-12 gap-6">

            <div class="md:col-span-6">
                <label class="block text-[11px] font-black uppercase tracking-widest text-slate-400 mb-2 ml-1">Pencarian Cepat</label>
                <div class="relative group">
                    <i data-lucide="search" class="absolute left-4 top-1/2 -translate-y-1/2 w-5 h-5 text-slate-300 group-focus-within:text-blue-500 transition-colors"></i>
                    <input type="text" name="cari" placeholder="Cari Nama, NIM, atau Jurusan..."
                        class="w-full pl-12 pr-4 py-3.5 bg-slate-50 border border-slate-200 rounded-2xl outline-none focus:ring-4 focus:ring-blue-500/10 focus:border-blue-500 transition-all font-bold text-slate-700">
                </div>
            </div>

            <div class="md:col-span-3">
                <label class="block text-[11px] font-black uppercase tracking-widest text-slate-400 mb-2 ml-1">Status Karir</label>
                <div class="relative">
                    <select name="status" class="w-full px-4 py-3.5 bg-slate-50 border border-slate-200 rounded-2xl outline-none focus:border-blue-500 appearance-none font-bold text-slate-700 cursor-pointer">
                        <option value="">Semua Status</option>
                        <option value="1">Bekerja</option>
                        <option value="0">Mencari Kerja</option>
                    </select>
                    <i data-lucide="chevron-down" class="absolute right-4 top-1/2 -translate-y-1/2 w-4 h-4 text-slate-400 pointer-events-none"></i>
                </div>
            </div>

            <div class="md:col-span-3">
                <label class="block text-[11px] font-black uppercase tracking-widest text-slate-400 mb-2 ml-1">Urutkan</label>
                <div class="relative">
                    <select name="sort" class="w-full px-4 py-3.5 bg-slate-50 border border-slate-200 rounded-2xl outline-none focus:border-blue-500 appearance-none font-bold text-slate-700 cursor-pointer">
                        <option value="nama">Nama Alumni</option>
                        <option value="nim">NIM</option>
                        <option value="tahun">Tahun Lulus</option>
                    </select>
                    <i data-lucide="chevron-down" class="absolute right-4 top-1/2 -translate-y-1/2 w-4 h-4 text-slate-400 pointer-events-none"></i>
                </div>
            </div>
        </div>

        <div class="flex justify-end pt-2">
            <button type="submit" class="bg-slate-900 text-white px-10 py-4 rounded-2xl font-black text-xs uppercase tracking-widest shadow-lg hover:bg-black transition-all active:scale-95 flex items-center gap-2">
                <i data-lucide="sliders-horizontal" class="w-4 h-4"></i> Terapkan Filter Lanjutan
            </button>
        </div>
    </form>
</section>

    {{-- MAIN DATA TABLE --}}
    <section class="glass-card-kaprodi overflow-hidden shadow-xl shadow-slate-200/50">
        <div class="px-8 py-5 bg-slate-50/50 border-b border-slate-100 flex justify-between items-center text-[10px] font-black text-slate-400 uppercase tracking-[0.2em]">
            <span>Record Ketua Program Studi</span>
            <div class="flex items-center gap-2">
                <span class="w-2 h-2 bg-pink-500 rounded-full animate-pulse"></span>
                <span class="text-pink-600">Status Aktif</span>
            </div>
        </div>

        {{-- DESKTOP VIEW --}}
        <div class="hidden md:block">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-white text-[10px] font-black text-slate-400 uppercase tracking-[0.2em]">
                        <th class="px-8 py-6">Identitas Pengelola</th>
                        <th class="px-8 py-6">Kontak Resmi</th>
                        <th class="px-8 py-6">Penempatan Prodi</th>
                        <th class="px-8 py-6 text-right">Tindakan Manajemen</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-50">
                    @forelse($kaprodiList as $kaprodi)
                    <tr class="tr-hover group">
                        <td class="px-8 py-5">
                            <div class="flex items-center gap-4">
                                <div class="w-10 h-10 bg-pink-100 text-pink-600 rounded-xl flex items-center justify-center font-black text-sm uppercase border border-pink-200 shadow-sm">
                                    {{ substr($kaprodi->name, 0, 1) }}
                                </div>
                                <div>
                                    <p class="font-bold text-slate-900 text-sm uppercase tracking-tight">{{ $kaprodi->name }}</p>
                                    <p class="text-[10px] font-medium text-slate-400 mt-0.5 tracking-tighter">Ketua Program Studi</p>
                                </div>
                            </div>
                        </td>
                        <td class="px-8 py-5">
                            <div class="flex items-center gap-2 text-slate-600">
                                <i data-lucide="mail" class="w-3.5 h-3.5 text-slate-300"></i>
                                <span class="text-xs font-semibold">{{ $kaprodi->email }}</span>
                            </div>
                        </td>
                        <td class="px-8 py-5">
                            <p class="text-xs font-black text-pink-700 uppercase leading-tight">{{ $kaprodi->prodi ?? 'N/A' }}</p>
                            <p class="text-[9px] font-bold text-slate-400 uppercase tracking-tighter mt-1 italic leading-none">{{ $kaprodi->fakultas ?? '-' }}</p>
                        </td>
                        <td class="px-8 py-5">
                            <div class="flex justify-end gap-3">
                                {{-- Tombol Edit dengan Teks --}}
                                <a href="{{ route('admin.kaprodi.edit', $kaprodi->id) }}" class="btn-action-text bg-blue-50 text-blue-600 hover:bg-blue-600 hover:text-white border border-blue-100">
                                    <i data-lucide="edit-3" class="w-3.5 h-3.5"></i>
                                    <span>Edit</span>
                                </a>

                                {{-- Tombol Hapus dengan Teks --}}
                                <form action="{{ route('admin.kaprodi.destroy', $kaprodi->id) }}" method="POST" onsubmit="return confirm('Hapus akses Kaprodi ini secara permanen?')">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="btn-action-text bg-rose-50 text-rose-600 hover:bg-rose-600 hover:text-white border border-rose-100">
                                        <i data-lucide="trash-2" class="w-3.5 h-3.5"></i>
                                        <span>Hapus</span>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4" class="py-20 text-center">
                            <i data-lucide="database-zap" class="w-12 h-12 text-slate-200 mx-auto mb-4"></i>
                            <p class="text-xs font-black text-slate-400 uppercase tracking-[0.2em]">Data Kaprodi Kosong</p>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- MOBILE VIEW --}}
        <div class="md:hidden divide-y divide-slate-100">
            @foreach($kaprodiList as $kaprodi)
            <div class="p-6 space-y-4">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 bg-pink-100 text-pink-600 rounded-xl flex items-center justify-center font-black">
                        {{ substr($kaprodi->name, 0, 1) }}
                    </div>
                    <div>
                        <h4 class="font-black text-slate-900 text-sm uppercase leading-tight">{{ $kaprodi->name }}</h4>
                        <p class="text-[10px] text-slate-400 italic mt-0.5">{{ $kaprodi->email }}</p>
                    </div>
                </div>
                <div class="bg-slate-50 p-4 rounded-2xl border border-slate-100">
                    <p class="text-[9px] font-black text-slate-300 uppercase tracking-widest mb-1 leading-none">Penugasan Prodi</p>
                    <p class="text-xs font-black text-pink-700 uppercase leading-snug">{{ $kaprodi->prodi ?? '-' }}</p>
                </div>
                <div class="flex gap-3">
                    <a href="{{ route('admin.kaprodi.edit', $kaprodi->id) }}" class="flex-1 btn-action-text bg-blue-600 text-white justify-center py-3">
                        <i data-lucide="edit-3" class="w-3.5 h-3.5"></i> <span>Edit</span>
                    </a>
                    <form action="{{ route('admin.kaprodi.destroy', $kaprodi->id) }}" method="POST" class="flex-1">
                        @csrf @method('DELETE')
                        <button type="submit" class="w-full btn-action-text bg-rose-600 text-white justify-center py-3">
                            <i data-lucide="trash-2" class="w-3.5 h-3.5"></i> <span>Hapus</span>
                        </button>
                    </form>
                </div>
            </div>
            @endforeach
        </div>
    </section>

    {{-- PAGINATION --}}
    <div class="mt-8 flex justify-center">
        @if(isset($kaprodiList) && method_exists($kaprodiList, 'links'))
            <div class="bg-white px-4 py-2 rounded-2xl shadow-sm border border-slate-200">
                {{ $kaprodiList->links() }}
            </div>
        @endif
    </div>

</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        lucide.createIcons();
    });
</script>
@endsection
