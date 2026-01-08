@extends('layouts.admin')

@section('title', 'Review Testimoni - Admin UIN Raden Mas Said')

@section('content')
<style>
    /* Premium Glassmorphism Card for Testimonials */
    .glass-testimonial-card {
        background: rgba(255, 255, 255, 0.9);
        backdrop-filter: blur(10px);
        border: 1px solid rgba(226, 232, 240, 0.8);
        border-radius: 2rem;
        transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
    }

    .glass-testimonial-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 20px 40px -15px rgba(0, 0, 0, 0.1);
        border-color: #ef4444; /* Red tint for review state */
    }

    .quote-icon-bg {
        background: linear-gradient(135deg, #fee2e2 0%, #fecaca 100%);
    }
</style>

<div class="space-y-8 font-['Plus_Jakarta_Sans'] pb-12">

    {{-- HEADER SECTION --}}
    <header class="flex flex-col md:flex-row md:items-center justify-between gap-6 animate-fade-in">
        <div class="flex items-center gap-4">
            <div class="w-12 h-12 bg-red-100 text-red-600 rounded-2xl flex items-center justify-center shadow-sm">
                <i data-lucide="bell-ring" class="w-6 h-6"></i>
            </div>
            <div>
                <h1 class="text-3xl font-black text-slate-900 tracking-tight">Review <span class="text-red-600">Testimoni</span></h1>
                <p class="text-slate-500 mt-1 font-medium italic uppercase text-[10px] tracking-widest">Menunggu Moderasi: {{ $testimonialsToReview->total() ?? 0 }} Data</p>
            </div>
        </div>
    </header>

    {{-- NOTIFIKASI --}}
    @if(session('success') || session('error'))
        <div class="flex items-center gap-3 {{ session('success') ? 'bg-emerald-50 border-emerald-200 text-emerald-800' : 'bg-rose-50 border-rose-200 text-rose-800' }} px-6 py-4 rounded-2xl animate-fade-in shadow-sm border">
            <i data-lucide="{{ session('success') ? 'check-circle' : 'alert-circle' }}" class="w-5 h-5"></i>
            <span class="text-sm font-bold">{{ session('success') ?? session('error') }}</span>
        </div>
    @endif

    {{-- TESTIMONIAL GRID --}}
    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
        @forelse ($testimonialsToReview as $alumni)
            <div class="glass-testimonial-card p-8 flex flex-col justify-between">
                <div>
                    <div class="flex justify-between items-start mb-6">
                        <div class="w-12 h-12 quote-icon-bg text-red-600 rounded-2xl flex items-center justify-center shadow-inner">
                            <i data-lucide="quote" class="w-6 h-6"></i>
                        </div>
                        <span class="px-4 py-1.5 bg-amber-100 text-amber-700 rounded-full text-[9px] font-black uppercase tracking-widest shadow-sm border border-amber-200">Pending Review</span>
                    </div>

                    <blockquote class="text-lg font-medium text-slate-700 leading-relaxed italic mb-6">
                        "{{ $alumni->testimonial_quote }}"
                    </blockquote>

                    <div class="flex items-center gap-4 pt-6 border-t border-slate-50">
                        <div class="w-10 h-10 rounded-full bg-slate-100 border-2 border-white shadow-sm flex items-center justify-center overflow-hidden">
                            <img src="https://ui-avatars.com/api/?name={{ urlencode($alumni->nama) }}&background=random" alt="Avatar">
                        </div>
                        <div>
                            <p class="font-bold text-slate-900 text-sm uppercase tracking-tight">{{ $alumni->nama }}</p>
                            <p class="text-[10px] text-slate-400 font-medium">Lulus {{ $alumni->tahun_keluar ?? '-' }} • {{ $alumni->prodi ?? 'Alumni' }}</p>
                        </div>
                    </div>
                </div>

                {{-- ACTION BUTTONS --}}
                <div class="mt-8 flex gap-3">
                    <form action="{{ route('admin.testimonials.approve', $alumni->user_id) }}" method="POST" class="flex-1" onsubmit="return confirm('Publikasikan testimoni ini ke halaman utama?');">
                        @csrf @method('PUT')
                        <button type="submit" class="w-full flex items-center justify-center gap-2 bg-emerald-600 hover:bg-emerald-700 text-white font-bold py-3 px-4 rounded-xl shadow-lg shadow-emerald-900/20 transition-all active:scale-95 text-xs uppercase tracking-widest">
                            <i data-lucide="check-circle" class="w-4 h-4"></i> Setujui
                        </button>
                    </form>

                    <form action="{{ route('admin.testimonials.reject', $alumni->user_id) }}" method="POST" class="flex-1" onsubmit="return confirm('Tolak testimoni ini? Data akan dipindahkan ke daftar ditolak.');">
                        @csrf @method('DELETE')
                        <button type="submit" class="w-full flex items-center justify-center gap-2 bg-white border border-rose-200 text-rose-600 hover:bg-rose-50 font-bold py-3 px-4 rounded-xl transition-all active:scale-95 text-xs uppercase tracking-widest">
                            <i data-lucide="x-circle" class="w-4 h-4"></i> Tolak
                        </button>
                    </form>
                </div>
            </div>
        @empty
            <div class="col-span-full py-24 text-center bg-white rounded-[3rem] border-2 border-dashed border-slate-200">
                <div class="w-20 h-20 bg-slate-50 rounded-[2rem] flex items-center justify-center mx-auto mb-4 border border-slate-100 shadow-inner">
                    <i data-lucide="thumbs-up" class="w-10 h-10 text-slate-300"></i>
                </div>
                <h3 class="text-slate-400 font-black uppercase tracking-widest text-xs">Semua Terkendali!</h3>
                <p class="text-slate-300 text-[10px] mt-2 italic uppercase">Tidak ada testimoni baru yang perlu direview saat ini.</p>
            </div>
        @endforelse
    </div>

    {{-- PAGINATION --}}
    @if ($testimonialsToReview->hasPages())
        <div class="mt-12 flex justify-center">
            <div class="bg-white px-4 py-2 rounded-2xl shadow-sm border border-slate-200">
                {{ $testimonialsToReview->links('pagination::tailwind') }}
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
