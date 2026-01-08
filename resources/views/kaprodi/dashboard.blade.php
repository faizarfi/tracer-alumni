@extends('layouts.kaprodi')

@section('title', 'Dashboard Kaprodi')

@section('content')
<style>
    /* Improved contrast and softer card backgrounds for readability */
    .glass-card-premium {
        background: linear-gradient(180deg, #ffffff 0%, #f8fafc 100%);
        backdrop-filter: blur(6px);
        border: 1px solid rgba(15, 23, 42, 0.06);
        transition: all 0.28s cubic-bezier(0.4, 0, 0.2, 1);
        color: #0f172a;
    }

    .glass-card-premium:hover {
        transform: translateY(-6px);
        box-shadow: 0 18px 30px -12px rgba(2,6,23,0.12);
        border-color: rgba(16,185,129,0.18);
    }

    /* Metric icon box with clearer contrast */
    .metric-icon-box {
        padding: 1rem;
        border-radius: 0.75rem;
        display: flex;
        align-items: center;
        justify-content: center;
        transition: all .25s;
        box-shadow: 0 6px 18px rgba(2,6,23,0.04);
    }

    /* Quick access cards (override white bg to subtle tint for contrast) */
    a.p-6.bg-white {
        background: linear-gradient(180deg,#fbfdff 0%, #ffffff 100%);
        border: 1px solid rgba(15,23,42,0.04);
        color: #0f172a;
    }
    a.p-6.bg-white h4 { color: #0f172a; }
    a.p-6.bg-white p { color: #475569; }

    /* Activity panel tweaks */
    #activityList p.text-sm { color: #0f172a; }
    #activityList p.text-xs { color: #64748b; }

    /* Make muted labels slightly darker for legibility */
    .text-slate-400 { color: #64748b !important; }
    .text-slate-500 { color: #475569 !important; }

    /* Button adjustments inside cards */
    .glass-card-premium .text-xs { color: #475569; }

    /* Animasi Entry */
    .fade-up { animation: fadeUp 0.6s ease-out forwards; }
    @keyframes fadeUp { from { opacity: 0; transform: translateY(20px); } to { opacity: 1; transform: translateY(0); } }
</style>

<div class="space-y-8 font-['Plus_Jakarta_Sans']">

    {{-- 1. HEADER SECTION --}}
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-6 fade-up">
        <div>
            <h1 class="text-3xl font-black text-slate-900 tracking-tight">Monitoring <span class="text-green-600">Alumni</span></h1>
            @php
                $userName = Auth::user()->name ?? 'Kaprodi';
                $prodiName = $kaprodiData['prodi_name'] ?? (Auth::user()->prodi ?? 'Program Studi');
            @endphp
            <p class="text-slate-500 mt-1 font-medium italic">Program Studi: <span class="text-green-700 font-bold">{{ $prodiName }}</span></p>
        </div>

        {{-- Tombol Quick Action --}}
        <div class="flex gap-3">
            <a href="{{ route('kaprodi.kuisioner.exportCsv') }}" class="flex items-center gap-2 px-5 py-2.5 bg-emerald-600 text-white rounded-xl font-bold text-xs shadow-lg shadow-emerald-900/20 hover:bg-emerald-700 transition-all active:scale-95">
                <i data-lucide="download" class="w-4 h-4"></i> EXPORT CSV
            </a>
            <a href="{{ route('kaprodi.alumni.exportPdf') }}" class="flex items-center gap-2 px-5 py-2.5 bg-slate-900 text-white rounded-xl font-bold text-xs shadow-lg shadow-slate-900/20 hover:bg-slate-700 transition-all active:scale-95">
                <i data-lucide="file-text" class="w-4 h-4"></i> EXPORT PDF
            </a>
        </div>
    </div>

    {{-- 2. METRIC CARDS --}}
    <section class="grid grid-cols-1 md:grid-cols-2 gap-6 fade-up" style="animation-delay: 0.1s">
        {{-- Card Total Alumni --}}
        <div class="glass-card-premium p-8 rounded-[2.5rem] flex items-center justify-between group overflow-hidden relative">
            <div class="absolute top-0 right-0 w-32 h-32 bg-green-50 rounded-full -mr-16 -mt-16 transition-transform group-hover:scale-110"></div>
            <div class="relative z-10">
                <p class="text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] mb-1">Total Alumni</p>
                <h3 class="text-5xl font-black text-slate-900 leading-none">{{ $kaprodiData['total_alumni'] ?? '0' }}</h3>
                <p class="text-xs font-bold text-green-600 mt-3 flex items-center gap-1">
                    <i data-lucide="users" class="w-3 h-3"></i> Terdaftar di Database
                </p>
            </div>
            <div class="metric-icon-box bg-green-100 text-green-700 group-hover:bg-green-600 group-hover:text-white relative z-10">
                <i data-lucide="graduation-cap" class="w-10 h-10"></i>
            </div>
        </div>

        {{-- Card Responden --}}
        <div class="glass-card-premium p-8 rounded-[2.5rem] flex items-center justify-between group overflow-hidden relative border-t-4 border-t-yellow-500">
            <div class="absolute top-0 right-0 w-32 h-32 bg-yellow-50 rounded-full -mr-16 -mt-16 transition-transform group-hover:scale-110"></div>
            <div class="relative z-10">
                <p class="text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] mb-1">Responden Tracer</p>
                <h3 class="text-5xl font-black text-slate-900 leading-none">{{ $kaprodiData['total_responden'] ?? '0' }}</h3>
                <p class="text-xs font-bold text-yellow-600 mt-3 flex items-center gap-1">
                    <i data-lucide="check-circle" class="w-3 h-3"></i> Mengisi Kuesioner
                </p>
            </div>
            <div class="metric-icon-box bg-yellow-100 text-yellow-700 group-hover:bg-yellow-500 group-hover:text-white relative z-10">
                <i data-lucide="clipboard-list" class="w-10 h-10"></i>
            </div>
        </div>
    </section>

    {{-- 5. INSIGHTS & RECENT ACTIVITY --}}
    <section class="grid grid-cols-1 lg:grid-cols-3 gap-6 fade-up" style="animation-delay: 0.35s">
        <div class="lg:col-span-2 space-y-4">
            <h3 class="text-sm font-black text-slate-700 uppercase tracking-widest">Insights Cepat</h3>
            <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                <div class="glass-card-premium p-4 rounded-2xl flex flex-col gap-2">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-xs font-black text-slate-400 uppercase tracking-wider">Rata-rata Waktu Mendapat Kerja</p>
                            <p class="text-2xl font-extrabold text-slate-900">{{ $kaprodiData['avg_time_to_job'] ?? '-'}} <span class="text-sm font-bold text-slate-500">bln</span></p>
                        </div>
                        <div class="metric-icon-box bg-indigo-50 text-indigo-600">
                            <i data-lucide="clock" class="w-6 h-6"></i>
                        </div>
                    </div>
                    <p class="text-[12px] text-slate-500">Dihitung dari responden yang melaporkan waktu mendapatkan pekerjaan.</p>
                </div>

                <div class="glass-card-premium p-4 rounded-2xl flex flex-col gap-2">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-xs font-black text-slate-400 uppercase tracking-wider">Tingkat Serapan Kerja</p>
                            <p class="text-2xl font-extrabold text-slate-900">{{ $kaprodiData['employability_rate'] ?? '-'}}<span class="text-sm font-bold text-slate-500">%</span></p>
                        </div>
                        <div class="metric-icon-box bg-emerald-50 text-emerald-600">
                            <i data-lucide="briefcase" class="w-6 h-6"></i>
                        </div>
                    </div>
                    <p class="text-[12px] text-slate-500">Persentase lulusan yang sudah bekerja saat survei.</p>
                </div>

                <div class="glass-card-premium p-4 rounded-2xl flex flex-col gap-2">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-xs font-black text-slate-400 uppercase tracking-wider">Responden Baru (30 hari)</p>
                            <p class="text-2xl font-extrabold text-slate-900">{{ $kaprodiData['recent_respondents_30d'] ?? '0' }}</p>
                        </div>
                        <div class="metric-icon-box bg-yellow-50 text-yellow-600">
                            <i data-lucide="refresh-cw" class="w-6 h-6"></i>
                        </div>
                    </div>
                    <p class="text-[12px] text-slate-500">Jumlah responden yang mengisi dalam 30 hari terakhir.</p>
                </div>
            </div>
        </div>

        <div class="space-y-4">
            <h3 class="text-sm font-black text-slate-700 uppercase tracking-widest">Aktivitas Terbaru</h3>
            <div class="glass-card-premium p-4 rounded-2xl">
                <div class="flex items-center justify-between mb-3">
                    <div class="text-xs text-slate-500 font-bold">Daftar aksi & perubahan terbaru</div>
                    <div class="flex items-center gap-2">
                        <button id="refreshActivity" class="text-xs bg-slate-100 px-3 py-1 rounded-lg">Refresh</button>
                        <button id="copyActivity" class="text-xs bg-slate-100 px-3 py-1 rounded-lg">Copy</button>
                    </div>
                </div>

                <ul id="activityList" class="space-y-3 max-h-64 overflow-auto custom-scrollbar">
                    @if(!empty($kaprodiData['recent_activity']))
                        @foreach($kaprodiData['recent_activity'] as $act)
                            <li class="flex items-start gap-3">
                                <div class="w-9 h-9 bg-slate-50 rounded-lg flex items-center justify-center text-slate-600">
                                    <i data-lucide="user-check" class="w-5 h-5"></i>
                                </div>
                                <div class="flex-1">
                                    <p class="text-sm font-bold text-slate-800">{!! $act['text'] !!}</p>
                                    <p class="text-xs text-slate-400 mt-1">{{ $act['time'] ?? '' }}</p>
                                </div>
                            </li>
                        @endforeach
                    @else
                        <li class="text-slate-400 text-sm">Belum ada aktivitas terbaru.</li>
                    @endif
                </ul>
            </div>
        </div>
    </section>

    {{-- 3. QUICK ACCESS GRID --}}
    <section class="fade-up" style="animation-delay: 0.2s">
        <h2 class="text-xs font-black text-slate-400 uppercase tracking-[0.3em] mb-6 ml-2">Akses Cepat Data</h2>
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
            {{-- Laporan Analisis --}}
            <a href="{{ route('kaprodi.kuisioner.report') }}" class="p-6 bg-white border border-slate-100 rounded-3xl flex flex-col gap-4 hover:border-green-500 transition-all group">
                <div class="w-12 h-12 bg-slate-50 text-slate-400 rounded-2xl flex items-center justify-center group-hover:bg-green-100 group-hover:text-green-600 transition-colors">
                    <i data-lucide="bar-chart-3" class="w-6 h-6"></i>
                </div>
                <div>
                    <h4 class="font-bold text-slate-900 text-sm">Laporan Analisis</h4>
                    <p class="text-[10px] text-slate-400 font-medium">Statistik kuesioner prodi</p>
                </div>
            </a>

            {{-- Data Alumni --}}
            <a href="{{ route('kaprodi.alumni') }}" class="p-6 bg-white border border-slate-100 rounded-3xl flex flex-col gap-4 hover:border-blue-500 transition-all group">
                <div class="w-12 h-12 bg-slate-50 text-slate-400 rounded-2xl flex items-center justify-center group-hover:bg-blue-100 group-hover:text-blue-600 transition-colors">
                    <i data-lucide="database" class="w-6 h-6"></i>
                </div>
                <div>
                    <h4 class="font-bold text-slate-900 text-sm">Database Alumni</h4>
                    <p class="text-[10px] text-slate-400 font-medium">Daftar lengkap lulusan</p>
                </div>
            </a>

            {{-- Export CSV --}}
            <a href="{{ route('kaprodi.kuisioner.exportCsv') }}" class="p-6 bg-white border border-slate-100 rounded-3xl flex flex-col gap-4 hover:border-emerald-500 transition-all group">
                <div class="w-12 h-12 bg-slate-50 text-slate-400 rounded-2xl flex items-center justify-center group-hover:bg-emerald-100 group-hover:text-emerald-600 transition-colors">
                    <i data-lucide="file-spreadsheet" class="w-6 h-6"></i>
                </div>
                <div>
                    <h4 class="font-bold text-slate-900 text-sm">Export Data</h4>
                    <p class="text-[10px] text-slate-400 font-medium">Unduh data (.csv)</p>
                </div>
            </a>

            {{-- Pusat Bantuan --}}
            <a href="{{ route('kaprodi.help') }}" class="p-6 bg-white border border-slate-100 rounded-3xl flex flex-col gap-4 hover:border-orange-500 transition-all group">
                <div class="w-12 h-12 bg-slate-50 text-slate-400 rounded-2xl flex items-center justify-center group-hover:bg-orange-100 group-hover:text-orange-600 transition-colors">
                    <i data-lucide="help-circle" class="w-6 h-6"></i>
                </div>
                <div>
                    <h4 class="font-bold text-slate-900 text-sm">Pusat Bantuan</h4>
                    <p class="text-[10px] text-slate-400 font-medium">Panduan navigasi sistem</p>
                </div>
            </a>
        </div>
    </section>

    {{-- 4. CHARTS SECTION --}}
    <section class="grid grid-cols-1 lg:grid-cols-2 gap-8 fade-up" style="animation-delay: 0.3s">
        {{-- Bar Chart --}}
        <div class="glass-card-premium p-8 rounded-[2.5rem]">
            <div class="flex items-center justify-between mb-8">
                <h3 class="text-sm font-black text-slate-800 uppercase tracking-widest flex items-center gap-2">
                    <span class="w-2 h-2 bg-indigo-500 rounded-full"></span> Lulusan per Tahun
                </h3>
            </div>
            <div class="h-72">
                <canvas id="alumniByYearChart"></canvas>
            </div>
        </div>

        {{-- Doughnut Chart --}}
        <div class="glass-card-premium p-8 rounded-[2.5rem]">
            <div class="flex items-center justify-between mb-8">
                <h3 class="text-sm font-black text-slate-800 uppercase tracking-widest flex items-center gap-2">
                    <span class="w-2 h-2 bg-emerald-500 rounded-full"></span> Status Serapan Kerja
                </h3>
            </div>
            <div class="h-72 flex justify-center items-center">
                <canvas id="statusKerjaChart"></canvas>
            </div>
        </div>
    </section>

</div>
@endsection

@section('scripts')
<script>
    // Data Preparation
    const kaprodiData = {
        alumni_by_year: @json($kaprodiData['alumni_by_year'] ?? []),
        status_kerja: @json($kaprodiData['status_kerja'] ?? []),
    };

    function initCharts(data) {
        // Global Config
        Chart.defaults.font.family = "'Plus Jakarta Sans', sans-serif";
        Chart.defaults.color = '#94a3b8';

        // 1. Alumni per Tahun (Bar Chart)
        const yearCtx = document.getElementById('alumniByYearChart');
        if (yearCtx && Object.keys(data.alumni_by_year).length > 0) {
            new Chart(yearCtx, {
                type: 'bar',
                data: {
                    labels: Object.keys(data.alumni_by_year),
                    datasets: [{
                        label: 'Alumni',
                        data: Object.values(data.alumni_by_year),
                        backgroundColor: '#10b981',
                        borderRadius: 12,
                        barThickness: 30,
                        hoverBackgroundColor: '#059669'
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: { display: false },
                        tooltip: {
                            padding: 12,
                            backgroundColor: '#1e293b',
                            titleFont: { size: 14, weight: 'bold' }
                        }
                    },
                    scales: {
                        y: {
                            beginAtZero: true,
                            grid: { borderDash: [5, 5], color: '#f1f5f9' },
                            ticks: { font: { weight: 'bold' } }
                        },
                        x: { grid: { display: false } }
                    }
                }
            });
        }

        // 2. Status Kerja (Doughnut Chart)
        const statusCtx = document.getElementById('statusKerjaChart');
        if (statusCtx && Object.keys(data.status_kerja).length > 0) {
            const rawKeys = Object.keys(data.status_kerja);
            const mappedLabels = rawKeys.map(key => key == '1' ? 'Bekerja' : 'Belum Bekerja');
            const mappedColors = rawKeys.map(key => key == '1' ? '#10B981' : '#f59e0b');

            new Chart(statusCtx, {
                type: 'doughnut',
                data: {
                    labels: mappedLabels,
                    datasets: [{
                        data: Object.values(data.status_kerja),
                        backgroundColor: mappedColors,
                        borderWidth: 6,
                        borderColor: '#ffffff',
                        hoverOffset: 10
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    cutout: '75%',
                    plugins: {
                        legend: {
                            position: 'bottom',
                            labels: {
                                padding: 20,
                                usePointStyle: true,
                                font: { size: 11, weight: '800' },
                                color: '#1e293b'
                            }
                        }
                    }
                }
            });
        }
    }

    document.addEventListener('DOMContentLoaded', () => {
        lucide.createIcons();
        initCharts(kaprodiData);
        // Activity controls
        const refreshBtn = document.getElementById('refreshActivity');
        const copyBtn = document.getElementById('copyActivity');
        const activityList = document.getElementById('activityList');

        if (refreshBtn) refreshBtn.addEventListener('click', () => {
            // Small visual refresh: re-run chart init (data should be updated from server on real app)
            initCharts(kaprodiData);
            refreshBtn.textContent = 'Updated';
            setTimeout(()=> refreshBtn.textContent = 'Refresh', 1200);
        });

        if (copyBtn) copyBtn.addEventListener('click', () => {
            if (!activityList) return;
            const lines = Array.from(activityList.querySelectorAll('p.text-sm')).map(el => el.textContent.trim()).join('\n');
            navigator.clipboard?.writeText(lines).then(()=>{
                copyBtn.textContent = 'Copied';
                setTimeout(()=> copyBtn.textContent = 'Copy', 1200);
            }).catch(()=>{ copyBtn.textContent = 'Failed'; setTimeout(()=> copyBtn.textContent = 'Copy', 1200); });
        });
    });
</script>
@endsection
