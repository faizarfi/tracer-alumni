@extends('layouts.admin')

@section('title', 'Edit Fakultas')

@section('content')
<div class="max-w-3xl">
    @include('admin.partials.form-header', ['icon' => 'building-2', 'title' => 'Edit Fakultas', 'subtitle' => 'Perbarui nama fakultas yang akan muncul pada formulir.', 'backRoute' => route('admin.faculties.index')])

    <div class="bg-white p-6 rounded-2xl shadow-lg border border-slate-200">
        <form action="{{ route('admin.faculties.update', $faculty) }}" method="POST">
            @csrf @method('PUT')
            <div class="space-y-4">
                <label for="name" class="block text-sm font-black text-slate-700">Nama Fakultas</label>
                <input id="name" type="text" name="name" class="w-full p-3 border rounded-xl focus:ring-2 focus:ring-emerald-200 focus:border-emerald-500" value="{{ old('name', $faculty->name) }}">
                @error('name')<div class="text-red-500 text-sm">{{ $message }}</div>@enderror
                <p class="text-xs text-slate-400">Gunakan nama resmi fakultas. Contoh: Fakultas Teknik.</p>
            </div>

            <div class="mt-6 flex items-center justify-between">
                <div class="flex items-center gap-3">
                    <form action="{{ route('admin.faculties.destroy', $faculty) }}" method="POST" class="swal-confirm inline-block" data-confirm="Hapus fakultas ini?"><!-- delete -->
                        @csrf @method('DELETE')
                        <button type="submit" class="inline-flex items-center gap-2 px-3 py-2 bg-rose-100 text-rose-700 rounded-lg hover:bg-rose-600 hover:text-white transition-all shadow-sm">
                            <i data-lucide="trash-2" class="w-4 h-4"></i>
                            <span class="text-xs font-bold">Hapus</span>
                        </button>
                    </form>
                </div>

                <div class="flex items-center gap-3">
                    <a href="{{ route('admin.faculties.index') }}" class="px-4 py-2 text-sm font-bold text-slate-600 rounded-xl">Batal</a>
                    <button type="submit" class="px-6 py-3 bg-emerald-500 text-white rounded-2xl font-black text-sm uppercase tracking-widest shadow">Simpan Perubahan</button>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection
