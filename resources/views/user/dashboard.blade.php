@extends('layouts.user')

@section('title', 'Dashboard Alumni | UIN Raden Mas Said')

@section('content')
<style>
    /* Premium Glassmorphism & Effects */
    .glass-card-white {
        background: rgba(255, 255, 255, 0.9);
        backdrop-filter: blur(10px);
        border: 1px solid rgba(226, 232, 240, 0.8);
        transition: all 0.3s ease;
    }

    .glass-card-white:hover {
        transform: translateY(-5px);
        box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.05);
    }

    .hero-gradient {
        background: radial-gradient(circle at top right, #f0fdf4, #ffffff);
    }

    .text-gradient-emerald {
        background: linear-gradient(to right, #064e3b, #10b981);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
    }

    @keyframes float {
        0%, 100% { transform: translateY(0); }
        50% { transform: translateY(-10px); }
    }
    .animate-float { animation: float 5s ease-in-out infinite; }

    /* Custom Warning Animation */
    @keyframes pulse-soft {
        0%, 100% { opacity: 1; }
        50% { opacity: 0.8; }
    }
    .animate-pulse-soft { animation: pulse-soft 3s infinite; }
</style>

<div class="flex-1 bg-slate-50 font-['Inter']">

    {{-- 1. HERO SECTION --}}
    <section id="beranda" class="relative min-h-[50vh] flex items-center justify-center overflow-hidden py-16 hero-gradient">
        <div class="absolute inset-0 z-0 opacity-5">
            <img src="https://uinsaid.ac.id/files/post/cover/profil-universitas-1708058171.jpeg" class="w-full h-full object-cover">
        </div>

        <div class="relative z-10 max-w-5xl mx-auto px-6 text-center">
            <div class="inline-flex items-center gap-2 px-4 py-1.5 bg-green-100 text-green-700 rounded-full text-[11px] font-bold uppercase tracking-widest mb-6 border border-green-200">
                <i data-lucide="award" class="w-4 h-4"></i> Official Alumni Portal
            </div>
            <h1 class="text-4xl md:text-5xl font-black text-slate-900 leading-tight mb-4 tracking-tight">
                Selamat Datang, <br>
                <span class="text-gradient-emerald">{{ auth()->user()->name }}</span>
            </h1>
            <p class="text-sm md:text-base text-slate-500 max-w-xl mx-auto leading-relaxed mb-8">
                Portal resmi Tracer Study UIN Raden Mas Said Surakarta. Mari berbagi informasi karir untuk kemajuan almamater.
            </p>
            <a href="{{ route('user.profil') }}"
                class="inline-flex items-center gap-3 px-8 py-3 bg-green-700 text-white font-bold rounded-xl shadow-lg shadow-green-900/20 hover:bg-green-800 transition-all active:scale-95 text-xs uppercase tracking-widest">
                <i data-lucide="user-plus" class="w-4 h-4"></i> Lengkapi Profil
            </a>
        </div>
    </section>

    {{-- 2. ALERT WARNING (Lengkapi Profil Sebelum Kuisioner) --}}
    <div class="max-w-7xl mx-auto px-6 -mt-8 relative z-30">
        <div class="bg-amber-50 border border-amber-200 rounded-2xl p-5 flex flex-col md:flex-row items-center justify-between gap-4 shadow-xl shadow-amber-900/5 animate-pulse-soft">
            <div class="flex items-center gap-4 text-center md:text-left">
                <div class="w-12 h-12 bg-amber-100 text-amber-600 rounded-full flex items-center justify-center shrink-0">
                    <i data-lucide="alert-triangle" class="w-6 h-6"></i>
                </div>
                <div>
                    <h4 class="text-amber-900 font-bold text-sm uppercase tracking-tight">Penting Sebelum Mengisi Kuesioner!</h4>
                    <p class="text-amber-700 text-xs font-medium">Mohon pastikan data diri dan pekerjaan di <span class="font-bold">Profil Alumni</span> sudah terisi dengan benar sebelum memulai kuesioner.</p>
                </div>
            </div>
            <a href="{{ route('user.profil') }}" class="px-5 py-2 bg-amber-600 text-white text-[10px] font-black uppercase tracking-widest rounded-lg hover:bg-amber-700 transition-colors whitespace-nowrap">
                Cek Profil Sekarang
            </a>
        </div>
    </div>

    {{-- 3. QUICK ACCESS --}}
    <section class="py-12 px-6 relative z-20">
        <div class="max-w-7xl mx-auto">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-12">
                <a href="{{ route('user.profil') }}" class="glass-card-white p-8 rounded-3xl flex items-center gap-5 group">
                    <div class="w-12 h-12 bg-green-100 text-green-700 rounded-xl flex items-center justify-center shrink-0 group-hover:bg-green-700 group-hover:text-white transition-colors shadow-sm">
                        <i data-lucide="user-cog" class="w-6 h-6"></i>
                    </div>
                    <div>
                        <h3 class="text-base font-bold text-slate-900 mb-0.5 tracking-tight uppercase">Profil Alumni</h3>
                        <p class="text-slate-400 text-[10px] uppercase font-bold tracking-widest leading-none">Kelola Data Anda</p>
                    </div>
                </a>

                <a href="{{ route('user.kuisioner') }}" class="glass-card-white p-8 rounded-3xl flex items-center gap-5 group border-t-4 border-t-emerald-500">
                    <div class="w-12 h-12 bg-emerald-100 text-emerald-700 rounded-xl flex items-center justify-center shrink-0 group-hover:bg-emerald-700 group-hover:text-white transition-colors shadow-sm">
                        <i data-lucide="clipboard-check" class="w-6 h-6"></i>
                    </div>
                    <div>
                        <h3 class="text-base font-bold text-slate-900 mb-0.5 tracking-tight uppercase">Isi Kuesioner</h3>
                        <p class="text-slate-400 text-[10px] uppercase font-bold tracking-widest leading-none">Survey Tracer Study</p>
                    </div>
                </a>

                <a href="{{ route('user.cari-alumni') }}" class="glass-card-white p-8 rounded-3xl flex items-center gap-5 group">
                    <div class="w-12 h-12 bg-blue-100 text-blue-700 rounded-xl flex items-center justify-center shrink-0 group-hover:bg-blue-700 group-hover:text-white transition-colors shadow-sm">
                        <i data-lucide="users" class="w-6 h-6"></i>
                    </div>
                    <div>
                        <h3 class="text-base font-bold text-slate-900 mb-0.5 tracking-tight uppercase">Cari Alumni</h3>
                        <p class="text-slate-400 text-[10px] uppercase font-bold tracking-widest leading-none">Temukan Teman</p>
                    </div>
                </a>
            </div>

            {{-- 4. STATISTICS (SINKRON DENGAN HEADER EMERALD) --}}
            <div class="max-w-5xl mx-auto">
                <div class="relative overflow-hidden bg-emerald-950 rounded-[2rem] p-8 md:p-12 shadow-2xl border border-white/5">
                    <div class="absolute -top-10 -right-10 w-40 h-40 bg-emerald-500/20 rounded-full blur-3xl"></div>
                    <div class="relative z-10">
                        <div class="flex justify-center mb-10 text-center">
                            <span class="px-4 py-1.5 rounded-full bg-white/5 border border-white/10 text-[10px] font-black uppercase tracking-[0.3em] text-emerald-400">
                                Statistik Alumni UIN RMS
                            </span>
                        </div>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-8 md:gap-0">
                            <div class="flex flex-col items-center md:border-r border-white/10 px-6 group">
                                <div class="mb-5 p-3 bg-emerald-500/10 rounded-2xl group-hover:bg-emerald-500/20 transition-colors">
                                    <i data-lucide="briefcase" class="w-7 h-7 text-emerald-400"></i>
                                </div>
                                <span class="text-5xl md:text-6xl font-black text-white leading-none animate-float">{{ $bekerja ?? 0 }}</span>
                                <p class="mt-4 text-[10px] font-bold uppercase tracking-[0.2em] text-emerald-200/60">Alumni Telah Bekerja</p>
                            </div>
                            <div class="flex flex-col items-center px-6 group text-center">
                                <div class="mb-5 p-3 bg-emerald-500/10 rounded-2xl group-hover:bg-emerald-500/20 transition-colors">
                                    <i data-lucide="file-check-2" class="w-7 h-7 text-emerald-400"></i>
                                </div>
                                <span class="text-5xl md:text-6xl font-black text-white leading-none animate-float" style="animation-delay: 1s">{{ $isiKuisioner ?? 0 }}</span>
                                <p class="mt-4 text-[10px] font-bold uppercase tracking-[0.2em] text-emerald-200/60">Responden Kuesioner</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- 5. FEATURES --}}
    <section id="tentang" class="py-16 px-6 bg-white rounded-t-[3rem]">
        <div class="max-w-7xl mx-auto">
            <div class="text-center mb-12">
                <h2 class="text-2xl font-black text-slate-900 mb-2 uppercase tracking-tight">Keunggulan Kampus</h2>
                <div class="w-12 h-1 bg-green-500 mx-auto rounded-full"></div>
            </div>

            @php
                $features = [
                    ['icon' => 'school', 'title' => 'Fasilitas Lengkap'],
                    ['icon' => 'book-marked', 'title' => 'Kurikulum Terkini'],
                    ['icon' => 'users-2', 'title' => 'Jaringan Alumni'],
                    ['icon' => 'award', 'title' => 'Prestasi Unggul'],
                    ['icon' => 'rocket', 'title' => 'Technopreneur'],
                    ['icon' => 'shield-check', 'title' => 'Keamanan Terjamin'],
                ];
            @endphp

            <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-6 gap-4">
                @foreach ($features as $f)
                <div class="p-6 bg-slate-50 rounded-2xl border border-slate-100 text-center group hover:bg-green-50 transition-colors">
                    <i data-lucide="{{ $f['icon'] }}" class="w-6 h-6 mx-auto mb-3 text-green-600 transition-transform group-hover:scale-110"></i>
                    <div class="text-[10px] font-bold text-slate-800 uppercase tracking-widest leading-tight">{{ $f['title'] }}</div>
                </div>
                @endforeach
            </div>
        </div>
    </section>

    {{-- 6. GALERI --}}
    <section id="galeri" class="py-16 px-6 bg-slate-50">
        <div class="max-w-7xl mx-auto text-center mb-10">
            <h2 class="text-2xl font-black text-slate-900 tracking-tight uppercase">Momen Kampus</h2>
        </div>
        <div class="max-w-7xl mx-auto grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 px-4">
            @forelse($galleries as $gallery)
            <div class="relative h-64 overflow-hidden rounded-3xl shadow-md group">
                <img src="{{ Storage::url($gallery->image_path) }}" class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-110">
                <div class="absolute inset-0 bg-gradient-to-t from-black/80 to-transparent opacity-0 group-hover:opacity-100 transition-opacity flex flex-col justify-end p-6">
                    <h4 class="text-white font-bold text-[10px] uppercase">{{ $gallery->title }}</h4>
                    <p class="text-green-400 text-[9px] mt-1">{{ $gallery->created_at->format('d M Y') }}</p>
                </div>
            </div>
            @empty
            <div class="col-span-full py-16 text-center bg-white rounded-3xl border-2 border-dashed border-slate-200">
                <i data-lucide="image-off" class="w-10 h-10 text-slate-300 mx-auto mb-3"></i>
                <p class="text-slate-400 text-xs font-bold uppercase tracking-widest">Belum ada foto.</p>
            </div>
            @endforelse
        </div>
    </section>

    {{-- 7. TESTIMONIALS (FIXED INFINITE SLIDER) --}}
 {{-- 5. KISAH ALUMNI (PAGINATION VERSION) --}}
    <section class="py-20 px-6">
        <div class="max-w-6xl mx-auto">
            <div class="text-center mb-12">
                <h2 class="text-xl font-black text-slate-900 tracking-tight uppercase">Kisah Sukses Alumni</h2>
                <p class="text-slate-500 text-xs mt-2 font-medium uppercase tracking-widest">Inspirasi dari para lulusan UIN Raden Mas Said</p>
            </div>

            <div id="testimonial-page-container" class="grid grid-cols-1 md:grid-cols-1 gap-6">
                @php
                    // Menampilkan max 5 per halaman secara statis di frontend
                    $approvedTestimonials = $testimonials ?? collect();
                @endphp

                @forelse($approvedTestimonials as $index => $testimonial)
                <div class="testimonial-page-item {{ $index >= 5 ? 'hidden' : '' }}" data-index="{{ $index }}">
                    <div class="bg-white p-8 rounded-[2.5rem] border border-emerald-50 relative shadow-sm flex flex-col md:flex-row gap-8 items-center">
                        <div class="shrink-0 relative">
                            <i data-lucide="quote" class="absolute -top-4 -left-4 w-12 h-12 text-emerald-50"></i>
                            <img src="{{ $testimonial->foto_path ? Storage::url($testimonial->foto_path) : 'https://ui-avatars.com/api/?name='.urlencode($testimonial->nama).'&background=065f46&color=fff' }}"
                                 class="w-24 h-24 rounded-[2rem] object-cover shadow-md border-4 border-white relative z-10">
                        </div>
                        <div class="flex-1 text-center md:text-left">
                            <p class="text-sm md:text-base text-slate-600 font-medium italic leading-relaxed mb-4">"{{ $testimonial->testimonial_quote }}"</p>
                            <h4 class="font-black text-emerald-800 text-[11px] uppercase tracking-[0.2em]">{{ $testimonial->nama }}</h4>
                            <p class="text-[9px] font-bold text-slate-400 uppercase mt-1">Lulusan {{ $testimonial->tahun_keluar }} • {{ $testimonial->tempat_bekerja }}</p>
                        </div>
                    </div>
                </div>
                @empty
                <div class="w-full text-slate-300 italic text-xs font-bold uppercase tracking-widest text-center py-10">Belum ada kisah sukses yang dibagikan.</div>
                @endforelse
            </div>

            {{-- Navigasi Pagination Manual --}}
            @if($approvedTestimonials->count() > 5)
            <div class="mt-12 flex justify-center items-center gap-3" id="testimonial-pagination">
                {{-- Tombol angka akan dihasilkan oleh JavaScript di bawah --}}
            </div>
            @endif
        </div>
    </section>
    {{-- 8. FAQ SECTION (STATIC CARDS) --}}
    <section id="faq" class="py-16 px-6 bg-slate-50 rounded-b-[4rem]">
        <div class="max-w-6xl mx-auto">
            <div class="text-center mb-12">
                <h2 class="text-2xl font-black text-slate-900 tracking-tight uppercase mb-2">Pusat Bantuan</h2>
                <div class="w-12 h-1 bg-green-500 mx-auto rounded-full"></div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 px-4">
                @php
                    $faqs = [
                        ['icon' => 'help-circle', 'q' => 'Apa itu Tracer Study?', 'a' => 'Survey resmi penelusuran lulusan untuk peningkatan kualitas kurikulum kampus.'],
                        ['icon' => 'shield-check', 'q' => 'Apakah Data Aman?', 'a' => 'Kerahasiaan data dijamin sepenuhnya. Hanya digunakan untuk statistik akreditasi.'],
                        ['icon' => 'user-edit', 'q' => 'Cara Ubah Profil?', 'a' => 'Klik tombol Lengkapi Profil, unggah foto atau edit data, lalu klik simpan perubahan.'],
                    ];
                @endphp

                @foreach($faqs as $faq)
                <div class="bg-white p-8 rounded-[2rem] shadow-sm border border-slate-200 group hover:border-green-500 transition-colors">
                    <div class="w-10 h-10 bg-green-50 text-green-600 rounded-xl flex items-center justify-center mb-5 group-hover:bg-green-600 group-hover:text-white transition-all">
                        <i data-lucide="{{ $faq['icon'] }}" class="w-5 h-5"></i>
                    </div>
                    <h3 class="text-xs font-black text-slate-900 mb-3 uppercase tracking-widest leading-tight">{{ $faq['q'] }}</h3>
                    <p class="text-[11px] text-slate-500 leading-relaxed font-medium">{{ $faq['a'] }}</p>
                </div>
                @endforeach
            </div>
        </div>
    </section>

</div>
@endsection

@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        lucide.createIcons();

        // Fix Slider Testimonial
        const actualItems = {{ $actualItems ?? 0 }};
        const container = document.getElementById('testimonial-container');

        if (actualItems > 0 && container) {
            const prevBtn = document.getElementById('prevTestimonial');
            const nextBtn = document.getElementById('nextTestimonial');
            let index = actualItems;

            const updateCarousel = (smooth = true) => {
                const width = container.parentElement.clientWidth;
                container.style.transition = smooth ? 'transform 0.8s cubic-bezier(0.4, 0, 0.2, 1)' : 'none';
                container.style.transform = `translateX(-${index * width}px)`;
            };

            updateCarousel(false);

            nextBtn.addEventListener('click', () => {
                index++;
                updateCarousel();
                if (index >= actualItems * 2) {
                    setTimeout(() => { index = actualItems; updateCarousel(false); }, 800);
                }
            });

            prevBtn.addEventListener('click', () => {
                index--;
                updateCarousel();
                if (index < actualItems) {
                    setTimeout(() => { index = (actualItems * 2) - 1; updateCarousel(false); }, 800);
                }
            });

            window.addEventListener('resize', () => updateCarousel(false));
        }
    });
</script>
@endsection
