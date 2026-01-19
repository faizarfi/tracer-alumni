@extends('layouts.admin')

@section('title', 'Manajemen Fakultas')

@section('content')
<div class="space-y-6">

    <header class="flex flex-col md:flex-row md:items-center justify-between gap-4">
        <div class="flex items-center gap-4">
            <div class="w-14 h-14 bg-emerald-500 text-white rounded-2xl flex items-center justify-center shadow-lg">
                <i data-lucide="building-2" class="w-7 h-7"></i>
            </div>
            <div>
                <h1 class="text-2xl font-black text-slate-900">Manajemen <span class="text-emerald-500">Fakultas</span></h1>
                <p class="text-sm text-slate-500 font-bold">Kelola entitas fakultas untuk dropdown pada formulir.</p>
            </div>
        </div>

        <div class="flex flex-col sm:flex-row sm:items-center gap-3 w-full sm:w-auto">
            <form method="GET" action="" class="flex items-center gap-2 w-full sm:w-auto">
                <label for="q" class="sr-only">Cari</label>
                <input id="q" name="q" value="{{ request('q') }}" placeholder="Cari nama fakultas..." class="w-full sm:w-64 px-4 py-2 rounded-2xl border border-slate-200 shadow-sm focus:outline-none focus:ring-2 focus:ring-emerald-200" />
                <button type="submit" class="px-3 py-2 bg-slate-100 text-slate-700 rounded-2xl hover:bg-slate-200 transition">Cari</button>
            </form>

            <a href="{{ route('admin.faculties.create') }}" class="flex items-center gap-2 px-4 py-2 bg-emerald-500 text-white rounded-2xl font-black text-xs uppercase tracking-widest shadow hover:bg-emerald-600 transition-all">
                <i data-lucide="plus" class="w-4 h-4"></i>
                <span>Tambah</span>
            </a>

            <div class="hidden sm:flex items-center ml-2 px-3 py-2 bg-white rounded-2xl border border-slate-100 shadow-sm text-sm text-slate-600">
                <i data-lucide="layers" class="w-4 h-4 mr-2 text-slate-400"></i>
                <span class="font-bold">{{ $faculties->total() ?? $faculties->count() }}</span>
                <span class="ml-2">Fakultas</span>
            </div>
        </div>
    </header>

    @include('admin.partials.flash')

    <section class="glass-card-table overflow-hidden bg-white rounded-2xl border border-slate-100 shadow-sm">
        <div class="px-6 py-4 border-b border-slate-100 flex items-center justify-between">
            <div>
                <div class="text-sm text-slate-500">Daftar fakultas</div>
                <div class="text-xs text-slate-400">Kelola pilihan yang muncul pada formulir pendaftaran.</div>
            </div>
            <div class="text-sm text-slate-500">Menampilkan <span class="font-bold text-slate-700">{{ $faculties->count() }}</span> dari <span class="font-bold text-slate-700">{{ $faculties->total() ?? $faculties->count() }}</span></div>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-slate-50">
                        <th class="px-6 py-3 text-sm font-semibold text-slate-600">Nama Fakultas</th>
                        <th class="px-6 py-3 text-sm font-semibold text-slate-600 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="bg-white">
                    @forelse($faculties as $f)
                    <tr class="odd:bg-white even:bg-slate-50 hover:bg-emerald-50">
                        <td class="px-6 py-4 font-semibold text-slate-800">
                            @php
                                $q = request('q');
                                $display = e($f->name);
                                if($q) {
                                    $escapedQ = preg_quote(e($q), '/');
                                    $display = preg_replace("/($escapedQ)/i", '<mark class="bg-emerald-200 text-slate-800 rounded px-1">$1</mark>', $display);
                                }
                            @endphp
                            {!! $display !!}
                        </td>
                        <td class="px-6 py-4 text-right">
                            <div class="inline-flex items-center gap-2 justify-end">
                                <a href="{{ route('admin.faculties.edit', $f) }}" title="Edit" aria-label="Edit" class="inline-flex items-center gap-2 px-3 py-2 bg-yellow-100 text-yellow-700 rounded-lg hover:bg-yellow-500 hover:text-white transition-all shadow-sm">
                                    <i data-lucide="edit-3" class="w-4 h-4"></i>
                                    <span class="hidden sm:inline text-xs font-bold">Edit</span>
                                </a>
                                <form action="{{ route('admin.faculties.destroy', $f) }}" method="POST" class="swal-confirm inline-block" data-confirm="Hapus fakultas ini?">
                                    @csrf @method('DELETE')
                                    <button type="submit" title="Hapus" aria-label="Hapus" class="inline-flex items-center gap-2 px-3 py-2 bg-rose-100 text-rose-700 rounded-lg hover:bg-rose-600 hover:text-white transition-all shadow-sm">
                                        <i data-lucide="trash-2" class="w-4 h-4"></i>
                                        <span class="hidden sm:inline text-xs font-bold">Hapus</span>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="2" class="py-12 text-center text-slate-500">
                            <i data-lucide="inbox" class="w-12 h-12 mx-auto mb-4 text-slate-300"></i>
                            <div class="font-black uppercase tracking-widest">Belum ada fakultas terdaftar</div>
                            <div class="mt-3 text-sm">Tambahkan fakultas untuk menampilkan pilihan pada formulir pendaftaran.</div>
                            <div class="mt-4">
                                <a href="{{ route('admin.faculties.create') }}" class="inline-flex items-center gap-2 px-4 py-2 bg-emerald-500 text-white rounded-2xl font-bold shadow hover:bg-emerald-600 transition">Tambah Fakultas</a>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </section>

    <div class="flex justify-center mt-6">
        <div class="bg-white px-4 py-3 rounded-2xl shadow-lg border border-slate-200">
            {{ $faculties->links() }}
        </div>
    </div>

</div>
@endsection
