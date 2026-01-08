@extends('layouts.admin')

@section('title','Edit Pengumuman')

@section('header')
    <header class="mb-6 p-4 bg-white rounded-xl shadow-md flex items-center justify-between animate-fade-in">
        <div>
            <h1 class="text-xl lg:text-2xl font-extrabold text-emerald-800 tracking-tight font-['Poppins']">Edit Pengumuman</h1>
            <p class="text-emerald-600 text-sm mt-1">Perbarui isi dan tanggal publikasi pengumuman.</p>
        </div>
        <div class="text-sm text-gray-600">
            <p class="font-semibold">Admin Panel</p>
        </div>
    </header>
@endsection

@section('content')

    <div class="container mx-auto max-w-4xl bg-white rounded-2xl shadow-xl border border-gray-200 p-6 md:p-8 animate-fade-in">

        @if ($errors->any())
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4 animate-fade-in" role="alert">
                <p class="font-semibold">Mohon periksa kesalahan berikut:</p>
                <ul class="mt-1 list-disc list-inside text-sm">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <h2 class="text-xl font-bold text-gray-800 mb-6 flex items-center gap-2">
            <i data-lucide="edit-3" class="text-emerald-600"></i>
            Formulir Pembaruan
        </h2>

        <form action="{{ route('admin.announcements.update', $announcement->id) }}" method="POST" class="space-y-6">
            @csrf
            @method('PUT')

            @include('admin.announcements._form', ['announcement' => $announcement])

            <div class="flex flex-col-reverse md:flex-row justify-between items-center gap-4 pt-4 border-t border-gray-100">
                <a href="{{ route('admin.dashboard') }}" class="w-full md:w-auto inline-flex items-center justify-center gap-2 bg-gray-100 hover:bg-gray-200 text-gray-700 font-bold py-3 px-6 rounded-xl transition-all duration-200">
                    <i data-lucide="arrow-left" class="w-4 h-4"></i> Kembali
                </a>

                <div class="flex items-center gap-3">
                    <button type="submit" class="inline-flex items-center gap-2 bg-emerald-600 hover:bg-emerald-700 text-white font-bold py-3 px-6 rounded-xl shadow-lg transition-all duration-200">
                        <i data-lucide="save" class="w-4 h-4"></i> Simpan Perubahan
                    </button>
                    <form action="{{ route('admin.announcements.destroy', $announcement->id) }}" method="POST" class="inline-block" onsubmit="return confirm('Hapus pengumuman ini?');">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="inline-flex items-center gap-2 bg-red-600 hover:bg-red-700 text-white font-bold py-3 px-4 rounded-xl transition-all duration-200">
                            <i data-lucide="trash" class="w-4 h-4"></i> Hapus
                        </button>
                    </form>
                </div>
            </div>
        </form>

    </div>

@endsection
