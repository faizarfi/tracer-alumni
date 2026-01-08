@extends('layouts.user')

@section('title', 'Pengumuman')

@section('content')
<div class="max-w-5xl mx-auto py-12 px-6">
    <header class="mb-8 flex items-start justify-between gap-4">
        <div class="flex-1">
            <h1 class="text-3xl font-heading font-extrabold text-slate-900">Pengumuman Terbaru</h1>
            <p class="text-slate-600 mt-2">Informasi penting dan pengumuman resmi dari kampus. Cek detail untuk informasi lebih lanjut.</p>
        </div>

        <div class="flex-shrink-0 flex flex-col items-end gap-2">
            @auth
                @php $role = auth()->user()->role ?? 'user'; @endphp
                @if($role === 'admin')
                    <a href="{{ route('admin.dashboard') }}" class="inline-flex items-center gap-2 bg-emerald-600 hover:bg-emerald-700 text-white font-semibold py-2 px-4 rounded-lg">Dashboard Admin</a>
                @elseif($role === 'kaprodi')
                    <a href="{{ route('kaprodi.dashboard') }}" class="inline-flex items-center gap-2 bg-emerald-600 hover:bg-emerald-700 text-white font-semibold py-2 px-4 rounded-lg">Dashboard Kaprodi</a>
                @else
                    <a href="{{ route('user.dashboard') }}" class="inline-flex items-center gap-2 bg-emerald-600 hover:bg-emerald-700 text-white font-semibold py-2 px-4 rounded-lg">Dashboard Saya</a>
                @endif
            @else
                <a href="{{ route('login') }}" class="inline-flex items-center gap-2 bg-white border border-emerald-600 text-emerald-600 font-semibold py-2 px-4 rounded-lg">Masuk</a>
            @endauth
        </div>
    </header>

    @if($announcements->isEmpty())
        <div class="bg-white rounded-2xl shadow-lg p-8 flex flex-col md:flex-row items-center gap-6 border border-gray-200">
            <div class="flex-shrink-0">
                <i data-lucide="bell" class="w-16 h-16 text-emerald-500"></i>
            </div>
            <div class="flex-1">
                <h2 class="text-xl font-semibold text-slate-900">Belum ada pengumuman</h2>
                <p class="text-slate-600 mt-1">Saat ini belum ada pengumuman. Silakan kembali nanti untuk pembaruan terbaru.</p>
            </div>
            <div class="ml-auto">
                <a href="{{ route('user.dashboard') }}" class="inline-flex items-center gap-2 bg-emerald-600 hover:bg-emerald-700 text-white font-semibold py-2 px-4 rounded-lg">Kembali ke Beranda</a>
            </div>
        </div>
    @else
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            @foreach($announcements as $a)
                <article class="bg-white rounded-2xl border p-6 shadow-sm hover:shadow-md transition">
                    <div class="flex items-start gap-4">
                        <div class="flex-shrink-0">
                            <i data-lucide="megaphone" class="w-6 h-6 text-emerald-500"></i>
                        </div>
                        <div class="flex-1">
                            <h3 class="text-lg font-semibold text-slate-900">{{ $a->title }}</h3>
                            <p class="text-xs text-slate-500 mt-1">{{ $a->published_at ? $a->published_at->format('d M Y') : $a->created_at->format('d M Y') }}</p>
                            <p class="text-sm text-slate-700 mt-3">{{ Str::limit(strip_tags($a->body), 180) }}</p>
                            <div class="mt-4 flex items-center justify-between">
                                <a href="{{ route('announcements.show', $a->id) }}" class="text-emerald-600 font-semibold hover:underline">Baca selengkapnya →</a>
                                <span class="text-xs text-slate-400">{{ $a->created_at->diffForHumans() }}</span>
                            </div>
                        </div>
                    </div>
                </article>
            @endforeach
        </div>

        <div class="mt-8 flex justify-center">
            @if(method_exists($announcements, 'links'))
                {{ $announcements->links() }}
            @endif
        </div>
    @endif
</div>
@endsection
