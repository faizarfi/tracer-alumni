@extends('layouts.admin')

@section('title', 'Katalog Testimoni - Admin UIN Raden Mas Said')

@section('content')
<style>
    /* Desain Bento Card Premium */
    .bento-card {
        background: rgba(255, 255, 255, 0.9);
        backdrop-filter: blur(15px);
        border: 1px solid rgba(226, 232, 240, 0.8);
        border-radius: 2.5rem;
        transition: all 0.5s cubic-bezier(0.4, 0, 0.2, 1);
        position: relative;
        overflow: hidden;
    }

    .bento-card:hover {
        transform: translateY(-10px) scale(1.02);
        box-shadow: 0 30px 60px -12px rgba(0, 0, 0, 0.08);
        border-color: #10b981;
    }

    /* Aksen Dekoratif di background card */
    .card-accent {
        position: absolute;
        top: -20px;
        right: -20px;
        width: 100px;
        height: 100px;
        background: radial-gradient(circle, rgba(16, 185, 129, 0.1) 0%, transparent 70%);
        border-radius: 50%;
    }

    .quote-mark {
        font-family: 'Georgia', serif;
        font-size: 8rem;
        line-height: 1;
        position: absolute;
        top: -10px;
        left: 20px;
        opacity: 0.05;
        color: #10b981;
        pointer-events: none;
    }
</style>

<div class="space-y-10 font-['Plus_Jakarta_Sans'] pb-20">

    {{-- HEADER DENGAN STATISTIK RINGKAS --}}
    <header class="flex flex-col lg:flex-row lg:items-end justify-between gap-6 animate-fade-in">
        <div class="space-y-2">
            <div class="flex items-center gap-3 mb-2">
                <span class="px-4 py-1.5 bg-emerald-500 text-white text-[10px] font-black uppercase tracking-[0.2em] rounded-full shadow-lg shadow-emerald-200">Live Content</span>
            </div>
            <h1 class="text-4xl lg:text-5xl font-black text-slate-900 tracking-tight">Katalog <span class="text-emerald-600 font-outline">Testimoni</span></h1>
            <p class="text-slate-500 font-medium text-lg">Inspirasi dari alumni yang telah dipublikasikan ke publik.</p>
        </div>

        {{-- Mini Stat Card agar tidak kosong --}}
        <div class="flex gap-4 bg-white p-4 rounded-[2rem] border border-slate-100 shadow-sm">
            <div class="px-6 py-2 border-r border-slate-100 text-center">
                <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest">Total Live</p>
                <p class="text-2xl font-black text-slate-900">{{ $testimonialsApproved->total() }}</p>
            </div>
            <div class="px-6 py-2 text-center">
                <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest">Update Terakhir</p>
                <p class="text-xs font-bold text-emerald-600 mt-2 uppercase">{{ now()->format('d M Y') }}</p>
            </div>
        </div>
    </header>

    <hr class="border-slate-200/60">

    {{-- TESTIMONIAL GRID --}}
    <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-8">
        @forelse ($testimonialsApproved as $alumni)
            <div class="bento-card p-10 flex flex-col justify-between group">
                <div class="quote-mark">“</div>
                <div class="card-accent"></div>

                <div class="relative z-10">
                    {{-- Status Badge --}}
                    <div class="flex justify-between items-center mb-8">
                        <div class="flex gap-1">
                            @for($i = 0; $i < 5; $i++)
                                <i data-lucide="star" class="w-3 h-3 fill-emerald-500 text-emerald-500"></i>
                            @endfor
                        </div>
                        <span class="text-[9px] font-black text-slate-300 uppercase tracking-widest italic">Approved System</span>
                    </div>

                    <blockquote class="text-xl font-bold text-slate-800 leading-relaxed mb-10 relative">
                        <span class="relative z-10">{{ $alumni->testimonial_quote }}</span>
                    </blockquote>
                </div>

                <div class="relative z-10 flex items-center justify-between gap-4 pt-8 border-t border-slate-100">
                    <div class="flex items-center gap-4">
                        <div class="relative">
                            <img src="https://ui-avatars.com/api/?name={{ urlencode($alumni->nama) }}&background=10b981&color=fff&bold=true"
                                 class="w-14 h-14 rounded-2xl object-cover shadow-md border-2 border-white" alt="Alumni">
                            <div class="absolute -bottom-1 -right-1 w-5 h-5 bg-emerald-500 border-2 border-white rounded-full flex items-center justify-center">
                                <i data-lucide="check" class="w-3 h-3 text-white"></i>
                            </div>
                        </div>
                        <div>
                            <p class="font-black text-slate-900 text-sm uppercase tracking-tight">{{ $alumni->nama }}</p>
                            <p class="text-[11px] text-emerald-600 font-bold uppercase tracking-wider mt-0.5">{{ $alumni->prodi ?? 'Alumni' }}</p>
                            <p class="text-[10px] text-slate-400 font-medium italic mt-1">{{ $alumni->tempat_bekerja ?? 'Sukses Berkarir' }}</p>
                        </div>
                    </div>

                    {{-- Tombol Tarik Publikasi yang lebih elegan --}}
                    <form action="{{ route('admin.testimonials.reject', $alumni->user_id) }}" method="POST" onsubmit="return confirm('Tarik publikasi testimoni ini?');">
                        @csrf @method('DELETE')
                        <button type="submit" class="w-10 h-10 bg-slate-50 text-slate-400 hover:bg-rose-50 hover:text-rose-600 rounded-xl flex items-center justify-center transition-all group-hover:shadow-inner" title="Tarik Publikasi">
                            <i data-lucide="eye-off" class="w-5 h-5"></i>
                        </button>
                    </form>
                </div>
            </div>
        @empty
            {{-- Tampilan jika kosong --}}
            <div class="col-span-full py-40 text-center">
                <div class="relative inline-block">
                    <div class="absolute inset-0 bg-emerald-200 blur-3xl opacity-20 rounded-full"></div>
                    <i data-lucide="inbox" class="w-24 h-24 text-slate-200 mx-auto mb-6 relative z-10"></i>
                </div>
                <h3 class="text-2xl font-black text-slate-400 uppercase tracking-widest">Belum Ada Inspirasi</h3>
                <p class="text-slate-300 mt-2 font-medium">Testimoni yang disetujui akan muncul di etalase ini.</p>
            </div>
        @endforelse
    </div>

    {{-- PAGINATION --}}
    @if ($testimonialsApproved->hasPages())
        <div class="mt-16 flex justify-center">
            <div class="bg-white p-2 rounded-3xl shadow-xl border border-slate-100 flex gap-2">
                {{ $testimonialsApproved->links('pagination::tailwind') }}
            </div>
        </div>
    @endif
</div>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        lucide.createIcons();
    });
</script>
@endpush
