@extends('layouts.admin')

@section('title','Buat Pengumuman')

@section('header')
    <header class="mb-6 p-4 bg-white rounded-xl shadow-md flex items-center justify-between animate-fade-in">
        <div>
            <h1 class="text-xl lg:text-2xl font-extrabold text-emerald-800 tracking-tight font-['Poppins']">Buat Pengumuman Baru</h1>
            <p class="text-emerald-600 text-sm mt-1">Gunakan formulir di bawah untuk menambahkan pengumuman.</p>
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
            <i data-lucide="plus-circle" class="text-emerald-600"></i>
            Formulir Pembuatan
        </h2>

        <form action="{{ route('admin.announcements.store') }}" method="POST" class="space-y-6">
            @csrf

            @include('admin.announcements._form')

            <div class="flex flex-col-reverse md:flex-row justify-between items-center gap-4 pt-4 border-t border-gray-100">
                <a href="{{ route('admin.dashboard') }}" class="w-full md:w-auto inline-flex items-center justify-center gap-2 bg-gray-100 hover:bg-gray-200 text-gray-700 font-bold py-3 px-6 rounded-xl transition-all duration-200">
                    <i data-lucide="arrow-left" class="w-4 h-4"></i> Kembali
                </a>

                <button type="submit" class="w-full md:w-auto inline-flex items-center justify-center gap-2 bg-emerald-600 hover:bg-emerald-700 text-white font-bold py-3 px-8 rounded-xl shadow-lg transition-all duration-200">
                    <i data-lucide="save" class="w-4 h-4"></i> Simpan Pengumuman
                </button>
            </div>
        </form>
    </div>

@endsection
