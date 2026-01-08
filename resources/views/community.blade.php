@extends('layouts.user')

@section('title', 'Komunitas Alumni')

@section('content')
<div class="max-w-4xl mx-auto py-12 px-6">
    <h1 class="text-2xl font-black mb-6">Komunitas Alumni</h1>
    <p class="mb-6 text-slate-600">Bergabunglah dengan grup dan forum alumni untuk berjejaring, berbagi lowongan kerja, dan berbagi pengalaman.</p>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <div class="p-6 bg-white rounded-xl border shadow-sm">
            <h3 class="font-bold mb-2">Grup Telegram</h3>
            <p class="text-xs text-slate-500 mb-3">Gabung untuk update cepat dan diskusi informal.</p>
            <a href="#" class="text-emerald-600 font-bold">Gabung Telegram →</a>
        </div>
        <div class="p-6 bg-white rounded-xl border shadow-sm">
            <h3 class="font-bold mb-2">Forum Diskusi</h3>
            <p class="text-xs text-slate-500 mb-3">Forum berbasis web untuk topik karir dan mentoring.</p>
            <a href="#" class="text-emerald-600 font-bold">Masuk Forum →</a>
        </div>
    </div>
</div>
@endsection
