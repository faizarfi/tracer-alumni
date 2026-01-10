@extends('layouts.admin')

@section('title', 'Ikhtisar Admin')

@push('chart-libs')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-datalabels@2.0.0"></script>
@endpush

@section('content')
<style>
    /* Efek Glassmorphism Khusus Admin */
    .glass-card-admin {
        background: rgba(255, 255, 255, 0.95);
        backdrop-filter: blur(10px);
        border: 1px solid rgba(226, 232, 240, 0.8);
        transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
    }

    .glass-card-admin:hover {
        transform: translateY(-5px);
        box-shadow: 0 20px 40px -15px rgba(16, 185, 129, 0.15);
        border-color: #10b981;
    }

    .metric-icon-gradient {
        width: 48px;
        height: 48px;
        border-radius: 12px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        color: #ffffff;
        box-shadow: 0 8px 22px rgba(2,6,23,0.08);
        transition: transform .36s cubic-bezier(.2,.9,.2,1), box-shadow .36s;
    }
    .metric-icon-gradient i { transform: translateY(0); transition: transform .36s; }
    .glass-card-admin:hover .metric-icon-gradient { transform: translateY(-6px) rotate(-6deg); box-shadow: 0 18px 40px rgba(2,6,23,0.12); }

    /* Animasi Entry */
    .fade-up {
        animation: fadeUp 0.6s ease-out forwards;
    }

    @keyframes fadeUp {
        from { opacity: 0; transform: translateY(20px); }
        to { opacity: 1; transform: translateY(0); }
    }
</style>

<div class="space-y-8 font-['Plus_Jakarta_Sans'] pb-12">

    {{-- 1. HEADER SECTION --}}
    <header class="flex flex-col md:flex-row md:items-center justify-between gap-6 fade-up">
        <div>
            <h1 class="text-3xl font-black text-slate-900 tracking-tight">Gambaran <span class="text-green-600">Sistem</span></h1>
            <p class="text-slate-500 mt-1 font-medium uppercase text-[10px] tracking-widest">Selamat datang, {{ Auth::user()->name ?? 'Administrator' }}</p>
        </div>

        <div class="bg-white px-6 py-3 rounded-2xl border border-slate-200 shadow-sm flex items-center gap-4">
            <div class="text-right">
                <p class="text-[9px] font-black text-slate-400 uppercase tracking-widest leading-none mb-1">Waktu Server</p>
                <p id="currentDateTime" class="text-xs font-black text-green-700 leading-none"></p>
            </div>
            <div class="w-10 h-10 bg-green-50 text-green-600 rounded-xl flex items-center justify-center">
                <i data-lucide="clock" class="w-5 h-5"></i>
            </div>
        </div>
    </header>

    {{-- 2. STATISTIC CARDS --}}
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 fade-up" style="animation-delay: 0.1s">
        @php
            $stats = [
                ['label' => 'Total Alumni', 'value' => $totalAlumni ?? 0, 'icon' => 'users', 'color' => 'bg-gradient-to-br from-emerald-500 to-green-700', 'desc' => 'Seluruh Database'],
                ['label' => 'Sudah Bekerja', 'value' => $bekerja ?? 0, 'icon' => 'briefcase', 'color' => 'bg-gradient-to-br from-blue-500 to-indigo-700', 'desc' => 'Terserap Industri'],
                ['label' => 'Belum Bekerja', 'value' => $belumBekerja ?? 0, 'icon' => 'user-minus', 'color' => 'bg-gradient-to-br from-rose-500 to-red-700', 'desc' => 'Available / Studi'],
                ['label' => 'Kuesioner', 'value' => $isiKuisioner ?? 0, 'icon' => 'file-text', 'color' => 'bg-gradient-to-br from-amber-400 to-orange-600', 'desc' => 'Responden Aktif'],
            ];
        @endphp

        @foreach($stats as $stat)
            <div class="glass-card-admin p-8 rounded-[2.5rem] group relative overflow-hidden">
                <div class="absolute -top-6 -right-6 w-24 h-24 bg-slate-50 rounded-full transition-transform group-hover:scale-150"></div>

                <div class="relative z-10 flex flex-col items-center text-center">
                    <div class="metric-icon-gradient {{ $stat['color'] }} mb-5 group-hover:rotate-12 transition-transform">
                        <i data-lucide="{{ $stat['icon'] }}" class="w-6 h-6"></i>
                    </div>
                    <p class="text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] mb-1">{{ $stat['label'] }}</p>
                    <h3 class="text-4xl font-black text-slate-900 tracking-tighter">{{ $stat['value'] }}</h3>
                    <p class="text-[9px] font-bold text-slate-400 mt-2 uppercase tracking-wider">{{ $stat['desc'] }}</p>
                </div>
            </div>
        @endforeach
    </div>

    {{-- 3. VISUALIZATION GRID --}}
    <div class="grid grid-cols-1 lg:grid-cols-5 gap-8 fade-up" style="animation-delay: 0.2s">
        {{-- Chart Section --}}
        <section class="glass-card-admin p-8 lg:col-span-3 rounded-[2.5rem]">
            <div class="flex items-center justify-between mb-8 border-b border-slate-50 pb-5">
                <h2 class="text-sm font-black text-slate-800 uppercase tracking-widest flex items-center gap-2">
                    <span class="w-2 h-2 bg-green-500 rounded-full animate-pulse"></span> Statistik Distribusi Alumni
                </h2>
            </div>
            <div class="h-80 w-full">
                <canvas id="statusChart"></canvas>
            </div>
        </section>

        {{-- Percentage Breakdown --}}
        <section class="glass-card-admin p-8 lg:col-span-2 rounded-[2.5rem]">
            <div class="mb-10">
                <h2 class="text-sm font-black text-slate-800 uppercase tracking-widest">Analisis Persentase</h2>
                <p class="text-[10px] text-slate-400 font-bold mt-1 uppercase tracking-tighter">Berdasarkan data kuesioner terkini</p>
            </div>

            @php
                $total = $totalAlumni ?? 1;
                $rates = [
                    ['label' => 'Tingkat Bekerja', 'rate' => round((($bekerja ?? 0) / $total) * 100, 1), 'icon' => 'award', 'color' => 'bg-blue-600', 'text' => 'text-blue-600', 'bg' => 'bg-blue-50'],
                    ['label' => 'Tingkat Pengangguran', 'rate' => round((($belumBekerja ?? 0) / $total) * 100, 1), 'icon' => 'alert-circle', 'color' => 'bg-rose-600', 'text' => 'text-rose-600', 'bg' => 'bg-rose-50'],
                    ['label' => 'Partisipasi Kuesioner', 'rate' => round((($isiKuisioner ?? 0) / $total) * 100, 1), 'icon' => 'check-square', 'color' => 'bg-emerald-600', 'text' => 'text-emerald-600', 'bg' => 'bg-emerald-50']
                ];
            @endphp

            <div class="space-y-8">
                @foreach($rates as $r)
                <div class="group">
                    <div class="flex items-center justify-between mb-2">
                        <div class="flex items-center gap-3">
                            <div class="w-8 h-8 {{ $r['bg'] }} {{ $r['text'] }} rounded-lg flex items-center justify-center group-hover:scale-110 transition-transform">
                                <i data-lucide="{{ $r['icon'] }}" class="w-4 h-4"></i>
                            </div>
                            <span class="text-xs font-black text-slate-700 uppercase tracking-tight">{{ $r['label'] }}</span>
                        </div>
                        <span class="text-sm font-black text-slate-900">{{ $r['rate'] }}%</span>
                    </div>
                    <div class="w-full h-2 bg-slate-100 rounded-full overflow-hidden">
                        <div class="{{ $r['color'] }} h-full transition-all duration-1000" style="width: {{ $r['rate'] }}%"></div>
                    </div>
                </div>
                @endforeach
            </div>
        </section>
    </div>

    {{-- 4. LATEST ALUMNI TABLE --}}
    <section class="glass-card-admin overflow-hidden rounded-[2.5rem] shadow-xl fade-up" style="animation-delay: 0.3s">
            <div class="px-8 py-6 bg-slate-50 border-b border-slate-100 flex items-center justify-between">
            <h2 class="text-sm font-black text-slate-800 uppercase tracking-widest">Rekor Alumni Terbaru</h2>
            <a href="{{ route('admin.alumni') }}" class="text-[10px] font-black text-green-600 hover:text-green-700 uppercase tracking-[0.2em] transition-all">Lihat Semua &rarr;</a>
        </div>

        <div class="overflow-x-auto">
            @if(isset($latestAlumni) && $latestAlumni->isNotEmpty())
            <table class="w-full text-left">
                <thead>
                    <tr class="bg-white text-[10px] font-black text-slate-400 uppercase tracking-[0.2em]">
                        <th class="px-8 py-5">Nama Lengkap</th>
                        <th class="px-8 py-5 text-center">NIM</th>
                        <th class="px-8 py-5 text-center">Program Studi</th>
                        <th class="px-8 py-5 text-right">Fakultas</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-50">
                    @foreach($latestAlumni as $alumni)
                    <tr class="hover:bg-slate-50/50 transition-colors">
                        <td class="px-8 py-4">
                            <div class="flex items-center gap-3">
                                <div class="w-8 h-8 bg-green-100 text-green-600 rounded-lg flex items-center justify-center font-bold text-xs uppercase">
                                    {{ substr($alumni->nama, 0, 1) }}
                                </div>
                                <span class="text-sm font-bold text-slate-700 uppercase tracking-tight">{{ $alumni->nama }}</span>
                            </div>
                        </td>
                        <td class="px-8 py-4 text-center">
                            <span class="px-3 py-1 bg-slate-100 rounded-lg font-mono text-xs text-slate-500 font-bold">{{ $alumni->nim }}</span>
                        </td>
                        <td class="px-8 py-4 text-center">
                            <span class="text-xs font-bold text-slate-500 uppercase tracking-tighter">{{ $alumni->jurusan }}</span>
                        </td>
                        <td class="px-8 py-4 text-right">
                            <span class="text-[10px] font-black text-slate-400 uppercase">{{ $alumni->fakultas }}</span>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            @else
            <div class="p-20 text-center">
                <i data-lucide="database-zap" class="w-12 h-12 text-slate-200 mx-auto mb-4"></i>
                <p class="text-xs font-bold text-slate-400 uppercase tracking-[0.2em]">Belum ada data terbaru</p>
            </div>
            @endif
        </div>
    </section>

    {{-- 5. PENGUMUMAN (Admin Quick Manage) --}}
    <section class="glass-card-admin overflow-hidden rounded-[2.5rem] shadow-xl fade-up" style="animation-delay: 0.35s">
        <div class="px-8 py-6 bg-slate-50 border-b border-slate-100 flex items-center justify-between">
            <h2 class="text-sm font-black text-slate-800 uppercase tracking-widest">Pengumuman Terbaru</h2>
            <div class="flex items-center gap-3">
                <a href="{{ route('admin.announcements.create') }}" class="text-[10px] font-black bg-emerald-600 text-white px-3 py-2 rounded-lg hover:bg-emerald-700">Buat Pengumuman</a>
                <a href="{{ route('admin.community.index') }}" class="text-[10px] font-black bg-sky-600 text-white px-3 py-2 rounded-lg hover:bg-sky-700">Kelola Komunitas</a>
                <a href="{{ route('announcements.index') }}" class="text-[10px] font-black text-slate-600 px-3 py-2 rounded-lg border">Lihat Publik</a>
            </div>
        </div>

        <div class="p-6">
            @if(isset($announcements) && $announcements->isNotEmpty())
                <ul class="space-y-4">
                    @foreach($announcements as $a)
                    <li class="flex flex-col md:flex-row md:items-center md:justify-between bg-white rounded-lg p-4 border gap-3 md:gap-0">
                        <div class="flex-1">
                            <a href="{{ route('announcements.show', $a->id) }}" class="font-bold text-slate-800 block md:inline">{{ Str::limit($a->title, 80) }}</a>
                            <div class="text-[11px] text-slate-500 mt-2 md:mt-0">{{ $a->published_at ? \Illuminate\Support\Carbon::parse($a->published_at)->format('d M Y') : \Illuminate\Support\Carbon::parse($a->created_at)->format('d M Y') }}</div>
                        </div>
                        <div class="flex items-center gap-2 mt-3 md:mt-0">
                            <a href="{{ route('admin.announcements.edit', $a->id) }}" class="text-xs font-bold text-amber-600 px-3 py-1 rounded border">Edit</a>
                            <form action="{{ route('admin.announcements.destroy', $a->id) }}" method="POST" onsubmit="return confirm('Hapus pengumuman ini?');">
                                @csrf
                                @method('DELETE')
                                <button class="text-xs font-bold text-red-600 px-3 py-1 rounded border">Hapus</button>
                            </form>
                        </div>
                    </li>
                    @endforeach
                </ul>
            @else
                <div class="p-8 text-center text-slate-500">Belum ada pengumuman. Buat pengumuman pertama untuk dilihat publik.</div>
            @endif
        </div>
    </section>

</div>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        lucide.createIcons();

        // 1. Clock Implementation
        function updateDateTime() {
            const now = new Date();
            const options = { weekday: 'long', day: 'numeric', month: 'short', hour: '2-digit', minute: '2-digit' };
            document.getElementById('currentDateTime').textContent = now.toLocaleDateString('id-ID', options).toUpperCase() + ' WIB';
        }
        updateDateTime();
        setInterval(updateDateTime, 60000);

        // 2. Chart Implementation
        const statsData = {
            bekerja: parseInt("{{ $bekerja ?? 0 }}"),
            belum: parseInt("{{ $belumBekerja ?? 0 }}"),
            kuesioner: parseInt("{{ $isiKuisioner ?? 0 }}")
        };

        const ctx = document.getElementById('statusChart');
        if (ctx) {
            new Chart(ctx, {
                type: 'doughnut',
                data: {
                    labels: ['Bekerja', 'Belum Bekerja', 'Isi Kuesioner'],
                    datasets: [{
                                data: [statsData.bekerja, statsData.belum, statsData.kuesioner],
                                /* Modern, cool palette: cyan / emerald / violet */
                                backgroundColor: ['#06b6d4', '#10b981', '#7c3aed'],
                                borderWidth: 6,
                                borderColor: '#ffffff',
                                hoverOffset: 18
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                            cutout: '70%',
                    plugins: {
                        legend: {
                                    position: 'bottom',
                                    labels: {
                                        padding: 24,
                                        usePointStyle: true,
                                        pointStyle: 'circle',
                                        boxWidth: 10,
                                        font: { size: 12, weight: '800' },
                                        color: '#0f172a'
                                    }
                        },
                                tooltip: {
                                    backgroundColor: '#064e3b',
                                    padding: 12,
                                    titleFont: { size: 13, weight: '800' },
                                    bodyFont: { size: 12 },
                                    cornerRadius: 8
                                }
                    }
                }
            });
        }
    });
</script>
@endpush
