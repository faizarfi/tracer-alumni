@extends('layouts.admin')

@section('title', 'Edit Program Studi')

@section('content')
<div class="max-w-3xl">
    @include('admin.partials.form-header', ['icon' => 'book', 'title' => 'Edit Program Studi', 'subtitle' => 'Perbarui program dan tautkan ke fakultas yang sesuai.', 'backRoute' => route('admin.programs.index')])

    <div class="bg-white p-6 rounded-2xl shadow-lg border border-slate-200">
        <form action="{{ route('admin.programs.update', $program) }}" method="POST">
            @csrf @method('PUT')
            <div class="space-y-4">
                <div>
                    <label for="faculty_id" class="block text-sm font-black text-slate-700 mb-2">Fakultas</label>
                    <select id="faculty_id" name="faculty_id" class="w-full p-3 border rounded-xl focus:ring-2 focus:ring-emerald-200 focus:border-emerald-500">
                        <option value="">-- Pilih Fakultas --</option>
                        @foreach($faculties as $f)
                            <option value="{{ $f->id }}" {{ (old('faculty_id', $program->faculty_id) == $f->id) ? 'selected' : '' }}>{{ $f->name }}</option>
                        @endforeach
                    </select>
                    @error('faculty_id')<div class="text-red-500 text-sm">{{ $message }}</div>@enderror
                </div>

                <div>
                    <label for="name" class="block text-sm font-black text-slate-700 mb-2">Nama Program Studi</label>
                    <input id="name" type="text" name="name" class="w-full p-3 border rounded-xl focus:ring-2 focus:ring-emerald-200 focus:border-emerald-500" value="{{ old('name', $program->name) }}">
                    @error('name')<div class="text-red-500 text-sm">{{ $message }}</div>@enderror
                </div>
            </div>

            <div class="mt-6 flex items-center justify-between">
                <div class="flex items-center gap-3">
                    <form action="{{ route('admin.programs.destroy', $program) }}" method="POST" class="swal-confirm inline-block" data-confirm="Hapus program studi ini?">
                        @csrf @method('DELETE')
                        <button type="submit" class="inline-flex items-center gap-2 px-3 py-2 bg-rose-100 text-rose-700 rounded-lg hover:bg-rose-600 hover:text-white transition-all shadow-sm">
                            <i data-lucide="trash-2" class="w-4 h-4"></i>
                            <span class="text-xs font-bold">Hapus</span>
                        </button>
                    </form>
                </div>

                <div class="flex items-center gap-3">
                    <a href="{{ route('admin.programs.index') }}" class="px-4 py-2 text-sm font-bold text-slate-600 rounded-xl">Batal</a>
                    <button type="submit" class="px-6 py-3 bg-emerald-500 text-white rounded-2xl font-black text-sm uppercase tracking-widest shadow">Simpan Perubahan</button>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection
