@extends('layouts.admin')

@section('title', 'Testimoni Ditolak - Admin UIN Raden Mas Said')

@section('content')
<style>
    /* Premium Rejected Card Styling */
    .glass-rejected-card {
        background: rgba(255, 255, 255, 0.9);
        backdrop-filter: blur(10px);
        border: 1px solid rgba(226, 232, 240, 0.8);
        border-radius: 2rem;
        transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
        display: flex;
        flex-direction: column;
    }

    .glass-rejected-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 20px 40px -15px rgba(0, 0, 0, 0.05);
        border-color: #eab308; /* Yellow tint for rejected state */
    }

    .archive-badge-bg {
        background: linear-gradient(135deg, #fef9c3 0%, #fef08a 100%);
    }

    .rejected-quote {
        @apply text-slate-500 italic;
        position: relative;
    }
</style>

<div class="space-y-8 font-['Plus_Jakarta_Sans'] pb-12">

    {{-- HEADER SECTION --}}
    <header class="flex flex-col md:flex-row md:items-center justify-between gap-6 animate-fade-in">
        <div class="flex items-center gap-4">
            <div class="w-12 h-12 bg-yellow-100 text-yellow-600 rounded-2xl flex items-center justify-center shadow-sm">
                <i data-lucide="archive" class="w-6 h-6"></i>
            </div>
            <div>
                <h1 class="text-3xl font-black text-slate-900 tracking-tight">Arsip <span class="text-yellow-600">Penolakan</span></h1>
                <p class="text-slate-500 mt-1 font-medium italic uppercase text-[10px] tracking-widest">Testimoni Tidak Terbit: {{ $testimonialsRejected->total() ?? 0 }} Data</p>
            </div>
        </div>
    </header>

    {{-- NOTIFIKASI --}}
    @if(session('success') || session('error'))
        <div class="flex items-center gap-3 {{ session('success') ? 'bg-emerald-50 border-emerald-100 text-emerald-800' : 'bg-rose-50 border-rose-100 text-rose-800' }} px-6 py-4 rounded-2xl animate-fade-in shadow-sm border">
            <i data-lucide="{{ session('success') ? 'check-circle' : 'alert-circle' }}" class="w-5 h-5"></i>
            <span class="text-sm font-bold uppercase tracking-tight">{{ session('success') ?? session('error') }}</span>
        </div>
    @endif

    {{-- REJECTED LIST GRID --}}
    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
        @forelse ($testimonialsRejected as $alumni)
            <div class="glass-rejected-card p-8">
                <div class="flex justify-between items-start mb-6">
                    <div class="w-12 h-12 archive-badge-bg text-yellow-700 rounded-2xl flex items-center justify-center shadow-inner">
                        <i data-lucide="ban" class="w-6 h-6"></i>
                    </div>
                    <div class="flex flex-col items-end">
                        <span class="px-3 py-1 bg-slate-100 text-slate-500 rounded-full text-[9px] font-black uppercase tracking-widest border border-slate-200">Hidden from Public</span>
                        <p class="text-[9px] text-slate-300 font-bold uppercase mt-2 italic">Ditolak: {{ $alumni->updated_at->format('d M Y') }}</p>
                    </div>
                </div>

                <blockquote class="rejected-quote text-base font-medium leading-relaxed mb-8 flex-grow">
                    "{{ $alumni->testimonial_quote }}"
                </blockquote>

                <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-6 pt-6 border-t border-slate-50">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 rounded-full bg-slate-100 border-2 border-white shadow-sm flex items-center justify-center overflow-hidden opacity-60 grayscale">
                            <img src="https://ui-avatars.com/api/?name={{ urlencode($alumni->nama) }}&background=64748b&color=fff" alt="Avatar">
                        </div>
                        <div>
                            <p class="font-bold text-slate-700 text-sm uppercase tracking-tight">{{ $alumni->nama }}</p>
                            <p class="text-[10px] text-slate-400 font-medium italic">ID: #{{ $alumni->user_id }}</p>
                        </div>
                    </div>

                    {{-- ACTION BUTTON: RESTORE TO REVIEW --}}
                    <form action="{{ route('admin.testimonials.pending', $alumni->user_id) }}" method="POST" onsubmit="return confirm('Kembalikan testimoni ini ke daftar Review (Pending)?');">
                        @csrf
                        @method('PUT')
                        <button type="submit" class="flex items-center gap-2 px-4 py-2.5 bg-indigo-600 text-white hover:bg-indigo-700 rounded-xl font-black text-[10px] uppercase tracking-widest transition-all active:scale-95 shadow-lg shadow-indigo-100">
                            <i data-lucide="refresh-ccw" class="w-4 h-4"></i> Restore to Review
                        </button>
                    </form>
                </div>
            </div>
        @empty
            <div class="col-span-full py-32 text-center bg-white rounded-[3rem] border-2 border-dashed border-slate-100">
                <div class="w-20 h-20 bg-slate-50 rounded-[2rem] flex items-center justify-center mx-auto mb-6 border border-slate-50 shadow-inner">
                    <i data-lucide="check-square" class="w-10 h-10 text-slate-200"></i>
                </div>
                <h3 class="text-slate-400 font-black uppercase tracking-widest text-xs">Arsip Kosong</h3>
                <p class="text-slate-300 text-[10px] mt-2 italic uppercase">Tidak ada testimoni yang ditolak dalam sistem.</p>
            </div>
        @endforelse
    </div>

    {{-- PAGINATION --}}
    @if ($testimonialsRejected->hasPages())
        <div class="mt-12 flex justify-center">
            <div class="bg-white px-6 py-3 rounded-2xl shadow-sm border border-slate-200">
                {{ $testimonialsRejected->links('pagination::tailwind') }}
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
