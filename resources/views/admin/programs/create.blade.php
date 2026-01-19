@extends('layouts.admin')

@section('title', 'Tambah Program Studi')

@section('content')
<div class="space-y-6">

    @include('admin.partials.form-header', ['icon' => 'book', 'title' => 'Tambah Program Studi', 'subtitle' => 'Tambah program studi baru dan kaitkan dengan fakultas terkait.', 'backRoute' => route('admin.programs.index')])

    <section class="bg-white p-6 rounded-2xl shadow-lg border border-slate-200 max-w-3xl">
        <div class="flex items-center justify-between mb-4">
            <div>
                <h2 class="text-lg font-black text-slate-800">Form Tambah Program Studi</h2>
                <p class="text-xs text-slate-400">Tambahkan program studi dan kaitkan dengan fakultas.</p>
            </div>
            <a href="{{ route('admin.programs.index') }}" class="text-sm text-slate-600 bg-white border border-slate-100 px-3 py-2 rounded-lg shadow-sm hover:bg-slate-50">Kembali</a>
        </div>

        @include('admin.partials.flash')

        <form action="{{ route('admin.programs.store') }}" method="POST">
            @csrf
            <div class="space-y-4">
                <div>
                    <label for="faculty_id" class="block text-sm font-black text-slate-700 mb-2">Fakultas</label>
                    <select id="faculty_id" name="faculty_id" class="w-full p-3 border rounded-xl focus:ring-2 focus:ring-emerald-200 focus:border-emerald-500">
                        <option value="">-- Pilih Fakultas --</option>
                        @foreach($faculties as $f)
                            <option value="{{ $f->id }}" {{ old('faculty_id') == $f->id ? 'selected' : '' }}>{{ $f->name }}</option>
                        @endforeach
                    </select>
                    @error('faculty_id')<div class="text-red-500 text-sm">{{ $message }}</div>@enderror
                </div>

                <div>
                    <label for="name" class="block text-sm font-black text-slate-700 mb-2">Nama Program Studi</label>
                    <input id="name" type="text" name="name" class="w-full p-3 border rounded-xl focus:ring-2 focus:ring-emerald-200 focus:border-emerald-500" value="{{ old('name') }}" placeholder="Contoh: Teknik Informatika" autofocus>
                    @error('name')<div class="text-red-500 text-sm">{{ $message }}</div>@enderror
                    <p class="text-xs text-slate-400">Gunakan nama resmi untuk konsistensi data.</p>
                </div>
            </div>

            <div class="mt-6 flex items-center justify-between">
                <a href="{{ route('admin.programs.index') }}" class="px-4 py-2 text-sm font-bold text-slate-600 rounded-xl">Batal</a>
                <div class="flex items-center gap-3">
                    <button type="reset" class="px-4 py-2 text-sm bg-slate-100 text-slate-700 rounded-xl hover:bg-slate-200">Reset</button>
                    <button type="submit" class="px-6 py-3 bg-emerald-500 text-white rounded-2xl font-black text-sm uppercase tracking-widest shadow">Simpan Program</button>
                </div>
            </div>
        </form>
    </section>

</div>
@endsection
