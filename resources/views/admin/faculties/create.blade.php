@extends('layouts.admin')

@section('title', 'Tambah Fakultas')

@section('content')
<div class="space-y-6">

    @include('admin.partials.form-header', ['icon' => 'building-2', 'title' => 'Tambah Fakultas', 'subtitle' => 'Buat fakultas baru agar muncul sebagai opsi pada formulir alumni.', 'backRoute' => route('admin.faculties.index')])

    <section class="bg-white p-6 rounded-2xl shadow-lg border border-slate-200 max-w-3xl">
        <div class="flex items-center justify-between mb-4">
            <div>
                <h2 class="text-lg font-black text-slate-800">Form Tambah Fakultas</h2>
                <p class="text-xs text-slate-400">Tambahkan nama fakultas yang akan muncul di pilihan formulir.</p>
            </div>
            <a href="{{ route('admin.faculties.index') }}" class="text-sm text-slate-600 bg-white border border-slate-100 px-3 py-2 rounded-lg shadow-sm hover:bg-slate-50">Kembali</a>
        </div>

        @include('admin.partials.flash')

        <form action="{{ route('admin.faculties.store') }}" method="POST">
            @csrf
            <div class="space-y-4">
                <label for="name" class="block text-sm font-black text-slate-700">Nama Fakultas</label>
                <input id="name" type="text" name="name" class="w-full p-3 border rounded-xl focus:ring-2 focus:ring-emerald-200 focus:border-emerald-500" value="{{ old('name') }}" placeholder="Contoh: Fakultas Adab dan Bahasa" autofocus>
                @error('name')<div class="text-red-500 text-sm">{{ $message }}</div>@enderror
                <p class="text-xs text-slate-400">Gunakan nama resmi untuk konsistensi data.</p>
            </div>

            <div class="mt-6 flex items-center justify-between">
                <a href="{{ route('admin.faculties.index') }}" class="px-4 py-2 text-sm font-bold text-slate-600 rounded-xl">Batal</a>
                <div class="flex items-center gap-3">
                    <button type="reset" class="px-4 py-2 text-sm bg-slate-100 text-slate-700 rounded-xl hover:bg-slate-200">Reset</button>
                    <button type="submit" class="px-6 py-3 bg-emerald-500 text-white rounded-2xl font-black text-sm uppercase tracking-widest shadow">Simpan Fakultas</button>
                </div>
            </div>
        </form>
    </section>

</div>
@endsection
