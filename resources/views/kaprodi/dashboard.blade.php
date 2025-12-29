@extends('layouts.kaprodi')

@section('title', 'Dashboard')

@section('content')

    {{-- Header/Title Section Responsif --}}
    <header class="mb-6 p-4 bg-white rounded-xl shadow-md flex flex-col md:flex-row md:items-center justify-between animate-fade-in gap-4">
        <div class="flex items-center">
            {{-- TOMBOL TOGGLE SIDEBAR (Hanya muncul di Mobile) --}}
            <button id="sidebarToggle" class="mr-3 text-green-700 md:hidden p-2 rounded-lg hover:bg-green-100 transition duration-150" aria-label="Toggle Menu">
                <i data-lucide="menu" class="w-6 h-6"></i>
            </button>
            <div>
                <h1 class="text-xl lg:text-2xl font-extrabold text-green-800 tracking-tight font-['Poppins']">
                    Dashboard Kaprodi
                </h1>
                @php
                    $userName = Auth::user()->name ?? 'Kaprodi';
                    $prodiName = $kaprodiData['prodi_name'] ?? (Auth::user()->prodi ?? 'Program Studi');
                @endphp
                <p class="text-green-700 text-xs md:text-sm mt-0.5">Halo, {{ $userName }}! Unit: <span class="font-bold">{{ $prodiName }}</span></p>
            </div>
        </div>
        <div class="flex flex-col items-center md:items-end flex-shrink-0 bg-green-50 md:bg-transparent p-2 md:p-0 rounded-lg">
            <p class="text-xs md:text-sm font-semibold text-gray-700" id="currentDate"></p>
            <p class="text-[10px] md:text-xs text-gray-500" id="currentTime"></p>
        </div>
    </header>

    {{-- Notifikasi --}}
    @if (session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded-xl relative mb-6 animate-fade-in flex justify-between items-center" role="alert">
            <span class="text-sm font-medium">{{ session('success') }}</span>
            <button onclick="this.parentElement.remove()"><i data-lucide="x" class="w-4 h-4"></i></button>
        </div>
    @endif

    {{-- Card Metrik Utama --}}
    <section class="grid grid-cols-1 sm:grid-cols-2 gap-4 md:gap-6 mb-8">
        {{-- Total Alumni --}}
        <div class="bg-white p-6 rounded-2xl shadow-lg border border-green-100 transform transition duration-300 hover:scale-[1.02] flex items-center justify-between">
            <div>
                <p class="text-xs font-bold text-gray-400 uppercase tracking-widest">Total Alumni</p>
                <p class="text-3xl md:text-4xl font-extrabold text-green-900 mt-1 font-['Poppins']">{{ $kaprodiData['total_alumni'] ?? '0' }}</p>
                <p class="text-[10px] text-gray-400 mt-1 italic">Tercatat di prodi Anda</p>
            </div>
            <div class="bg-green-100 p-3 rounded-2xl">
                <i data-lucide="graduation-cap" class="w-8 h-8 text-green-600"></i>
            </div>
        </div>

        {{-- Responden --}}
        <div class="bg-white p-6 rounded-2xl shadow-lg border border-yellow-100 transform transition duration-300 hover:scale-[1.02] flex items-center justify-between">
            <div>
                <p class="text-xs font-bold text-gray-400 uppercase tracking-widest">Responden Tracer</p>
                <p class="text-3xl md:text-4xl font-extrabold text-yellow-700 mt-1 font-['Poppins']">{{ $kaprodiData['total_responden'] ?? '0' }}</p>
                <p class="text-[10px] text-gray-400 mt-1 italic">Sudah mengisi kuesioner</p>
            </div>
            <div class="bg-yellow-100 p-3 rounded-2xl">
                <i data-lucide="clipboard-check" class="w-8 h-8 text-yellow-600"></i>
            </div>
        </div>
    </section>

    {{-- Akses Cepat Responsif --}}
    <section class="bg-white p-5 md:p-8 rounded-2xl shadow-xl border border-gray-200 mb-8">
        <h2 class="text-lg font-bold text-gray-800 mb-5 flex items-center gap-2">
            <i data-lucide="zap" class="w-5 h-5 text-green-600"></i> Akses Data & Laporan
        </h2>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            {{-- Aksi 1: Laporan --}}
            <a href="{{ route('kaprodi.kuisioner.report') }}" class="group flex items-center justify-between p-4 bg-green-50 border border-green-200 rounded-2xl transition hover:bg-green-100 hover:shadow-md">
                <div class="flex items-center gap-4">
                    <div class="p-2 bg-white rounded-xl shadow-sm">
                        <iconify-icon icon="mdi:file-chart-outline" class="w-7 h-7 text-green-700"></iconify-icon>
                    </div>
                    <div>
                        <h3 class="font-bold text-green-800 text-sm md:text-base">Laporan Analisis</h3>
                        <p class="text-[10px] md:text-xs text-gray-500">Statistik kuesioner prodi</p>
                    </div>
                </div>
                <i data-lucide="chevron-right" class="w-4 h-4 text-green-400 group-hover:translate-x-1 transition-transform"></i>
            </a>

            {{-- Aksi 2: Alumni --}}
            <a href="{{ route('kaprodi.alumni') }}" class="group flex items-center justify-between p-4 bg-blue-50 border border-blue-200 rounded-2xl transition hover:bg-blue-100 hover:shadow-md">
                <div class="flex items-center gap-4">
                    <div class="p-2 bg-white rounded-xl shadow-sm">
                        <iconify-icon icon="mdi:database-outline" class="w-7 h-7 text-blue-700"></iconify-icon>
                    </div>
                    <div>
                        <h3 class="font-bold text-blue-800 text-sm md:text-base">Data Alumni</h3>
                        <p class="text-[10px] md:text-xs text-gray-500">Daftar lulusan prodi</p>
                    </div>
                </div>
                <i data-lucide="chevron-right" class="w-4 h-4 text-blue-400 group-hover:translate-x-1 transition-transform"></i>
            </a>

            {{-- Aksi 3: Export --}}
            <a href="{{ route('kaprodi.kuisioner.exportCsv') }}" class="group flex items-center justify-between p-4 bg-yellow-50 border border-yellow-200 rounded-2xl transition hover:bg-yellow-100 hover:shadow-md">
                <div class="flex items-center gap-4">
                    <div class="p-2 bg-white rounded-xl shadow-sm">
                        <iconify-icon icon="mdi:file-download-outline" class="w-7 h-7 text-yellow-700"></iconify-icon>
                    </div>
                    <div>
                        <h3 class="font-bold text-yellow-800 text-sm md:text-base">Export CSV</h3>
                        <p class="text-[10px] md:text-xs text-gray-500">Unduh data kuesioner</p>
                    </div>
                </div>
                <i data-lucide="download" class="w-4 h-4 text-yellow-400 group-hover:translate-y-0.5 transition-transform"></i>
            </a>

            {{-- Aksi 4: Help --}}
            <a href="{{ route('kaprodi.help') }}" class="group flex items-center justify-between p-4 bg-gray-50 border border-gray-200 rounded-2xl transition hover:bg-gray-100 hover:shadow-md">
                <div class="flex items-center gap-4">
                    <div class="p-2 bg-white rounded-xl shadow-sm">
                        <i data-lucide="help-circle" class="w-7 h-7 text-gray-600"></i>
                    </div>
                    <div>
                        <h3 class="font-bold text-gray-800 text-sm md:text-base">Panduan</h3>
                        <p class="text-[10px] md:text-xs text-gray-500">Bantuan navigasi</p>
                    </div>
                </div>
                <i data-lucide="external-link" class="w-4 h-4 text-gray-400"></i>
            </a>
        </div>
    </section>

    {{-- Grafik Responsif --}}
    <section class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-10">
        {{-- Bar Chart --}}
        <div class="bg-white p-5 md:p-6 rounded-2xl shadow-xl border border-gray-200">
            <h2 class="text-base md:text-lg font-bold text-gray-800 mb-6 flex items-center gap-2">
                <i data-lucide="bar-chart-2" class="w-5 h-5 text-indigo-600"></i> Alumni per Tahun Lulus
            </h2>
            <div class="relative w-full h-64 md:h-80">
                <canvas id="alumniByYearChart"></canvas>
            </div>
        </div>

        {{-- Doughnut Chart --}}
        <div class="bg-white p-5 md:p-6 rounded-2xl shadow-xl border border-gray-200">
            <h2 class="text-base md:text-lg font-bold text-gray-800 mb-6 flex items-center gap-2">
                <i data-lucide="pie-chart" class="w-5 h-5 text-pink-600"></i> Status Serapan Kerja
            </h2>
            <div class="relative w-full h-64 md:h-80 flex justify-center items-center">
                <canvas id="statusKerjaChart"></canvas>
            </div>
        </div>
    </section>

@endsection

@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    const kaprodiData = {
        alumni_by_year: @json($kaprodiData['alumni_by_year'] ?? []),
        status_kerja: @json($kaprodiData['status_kerja'] ?? []),
    };

    function updateDateTime() {
        const now = new Date();
        const optionsDate = { weekday: 'long', year: 'numeric', month: 'long', day: 'numeric' };
        const optionsTime = { hour: '2-digit', minute: '2-digit', second: '2-digit' };

        document.getElementById('currentDate').innerText = now.toLocaleDateString('id-ID', optionsDate);
        document.getElementById('currentTime').innerText = now.toLocaleTimeString('id-ID', optionsTime) + ' WIB';
    }

    function initCharts(data) {
        Chart.defaults.font.family = 'Inter, sans-serif';
        Chart.defaults.color = '#718096';

        // 1. Alumni per Tahun
        const yearCtx = document.getElementById('alumniByYearChart');
        if (yearCtx && Object.keys(data.alumni_by_year).length > 0) {
            new Chart(yearCtx, {
                type: 'bar',
                data: {
                    labels: Object.keys(data.alumni_by_year),
                    datasets: [{
                        label: 'Jumlah Alumni',
                        data: Object.values(data.alumni_by_year),
                        backgroundColor: '#059669',
                        borderRadius: 8,
                        barThickness: 25,
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: { legend: { display: false } },
                    scales: {
                        y: { beginAtZero: true, grid: { borderDash: [5, 5] }, ticks: { stepSize: 1 } },
                        x: { grid: { display: false } }
                    }
                }
            });
        }

        // 2. Status Kerja (Sinkron Database)
        const statusCtx = document.getElementById('statusKerjaChart');
        if (statusCtx && Object.keys(data.status_kerja).length > 0) {
            // Ambil data asli dari database
            const rawKeys = Object.keys(data.status_kerja); // ['1', '0']
            const rawValues = Object.values(data.status_kerja);

            // Mapping dinamis agar warna tidak tertukar
            const mappedLabels = rawKeys.map(key => key == '1' ? 'Bekerja' : 'Belum Bekerja');
            const mappedColors = rawKeys.map(key => key == '1' ? '#10B981' : '#F43F5E');

            new Chart(statusCtx, {
                type: 'doughnut',
                data: {
                    labels: mappedLabels,
                    datasets: [{
                        data: rawValues,
                        backgroundColor: mappedColors,
                        borderWidth: 0,
                        hoverOffset: 15
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    cutout: '70%',
                    plugins: {
                        legend: {
                            position: 'bottom',
                            labels: { padding: 25, usePointStyle: true, font: { size: 12, weight: '600' } }
                        },
                        tooltip: {
                            callbacks: {
                                label: function(context) {
                                    let label = context.label || '';
                                    let value = context.raw || 0;
                                    let total = context.dataset.data.reduce((a, b) => a + b, 0);
                                    let percentage = ((value / total) * 100).toFixed(1);
                                    return ` ${label}: ${value} Orang (${percentage}%)`;
                                }
                            }
                        }
                    }
                }
            });
        }
    }

    document.addEventListener('DOMContentLoaded', () => {
        initCharts(kaprodiData);
        updateDateTime();
        setInterval(updateDateTime, 1000);
        lucide.createIcons();
    });
</script>
@endsection
