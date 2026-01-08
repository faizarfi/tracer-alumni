@extends('layouts.user')

@section('title', $announcement->title)

@section('content')
<div class="max-w-3xl mx-auto py-12 px-6">
    <nav class="mb-6 text-sm text-slate-600 flex items-center gap-3">
        <a href="{{ route('announcements.index') }}" class="hover:underline text-emerald-600">Pengumuman</a>
        <span class="text-slate-300">/</span>
        <span class="text-slate-800 font-semibold">Detail</span>
    </nav>

    <article class="bg-white rounded-2xl border p-8 shadow-lg">
        <header class="mb-4">
            <h1 class="text-2xl font-heading font-extrabold text-slate-900">{{ $announcement->title }}</h1>
            <div class="flex items-center gap-3 mt-2 text-xs text-slate-500">
                <span class="flex items-center gap-2"><i data-lucide="calendar" class="w-4 h-4"></i> {{ $announcement->published_at ? $announcement->published_at->format('d M Y H:i') : $announcement->created_at->format('d M Y H:i') }}</span>
                <span class="text-slate-300">•</span>
                <span class="text-xs text-slate-400">{{ $announcement->created_at->diffForHumans() }}</span>
            </div>
        </header>

        <div class="prose prose-slate max-w-none text-slate-700 leading-relaxed">{!! $announcement->body !!}</div>

        <div class="mt-8 flex items-center gap-3">
            <a href="{{ route('announcements.index') }}" class="inline-flex items-center gap-2 bg-gray-100 hover:bg-gray-200 text-gray-800 font-semibold py-2 px-3 rounded-lg transition">
                <i data-lucide="arrow-left" class="w-4 h-4"></i> Kembali
            </a>
            <a href="{{ route('user.dashboard') }}" class="inline-flex items-center gap-2 ml-auto bg-emerald-600 hover:bg-emerald-700 text-white font-semibold py-2 px-3 rounded-lg transition">
                <i data-lucide="home" class="w-4 h-4"></i> Beranda
            </a>
        </div>
    </article>
</div>
@endsection
