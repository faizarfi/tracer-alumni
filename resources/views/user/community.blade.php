@extends('layouts.user')

@section('title', 'Komunitas Alumni')

@section('content')
<div class="max-w-4xl mx-auto py-12 px-6">
    <h1 class="text-2xl font-black mb-6">Komunitas Alumni</h1>
    <p class="mb-6 text-slate-600">Bergabunglah dengan grup dan forum alumni untuk berjejaring, berbagi lowongan kerja, dan berbagi pengalaman.</p>
    <div class="mb-6">
        <a href="{{ route('user.dashboard') }}" class="inline-flex items-center gap-2 px-4 py-2 bg-slate-100 text-slate-700 rounded-lg text-sm hover:bg-slate-200">
            &larr; Kembali ke Dashboard
        </a>
    </div>

    @if(!isset($communities) || $communities->isEmpty())
        <div class="p-6 bg-white rounded border">Belum ada komunitas yang dikonfigurasi. Silakan hubungi admin.</div>
    @else
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        @foreach($communities as $c)
        <div class="p-6 bg-white rounded-xl border shadow-sm">
            <h3 class="font-bold mb-2">{{ $c->name }}</h3>
            @if($c->type)
                <p class="text-xs text-slate-500 mb-3">{{ $c->type }}</p>
            @endif
            @if($c->url && trim($c->url) !== '')
                <a href="{{ $c->url }}" target="_blank" rel="noopener noreferrer" class="text-emerald-600 font-bold">Gabung →</a>
            @else
                <span class="text-slate-500">Tautan belum diatur</span>
            @endif
        </div>
        @endforeach
    </div>
    @endif
</div>
@endsection

@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const links = document.querySelectorAll('.community-link');
        links.forEach(a => {
            a.addEventListener('click', function (e) {
                const url = a.getAttribute('data-url') || '';
                if (url && url.trim() !== '') {
                    window.open(url, '_blank');
                } else {
                    if (typeof Swal !== 'undefined') {
                        Swal.fire({
                            icon: 'info',
                            title: 'Tautan belum diatur',
                            text: 'Tautan untuk fitur ini belum dikonfigurasi. Silakan hubungi admin untuk informasi lebih lanjut.'
                        });
                    } else {
                        alert('Tautan belum dikonfigurasi. Hubungi admin.');
                    }
                }
            });
        });
    });
</script>
@endsection
