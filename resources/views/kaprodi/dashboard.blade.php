@extends('layouts.kaprodi') {{-- Sesuaikan dengan lokasi template utama Anda --}}

@section('title', 'Dashboard')

@section('content')

    {{-- Header/Title Section --}}
    <header class="mb-6 p-4 bg-white rounded-xl shadow-md flex items-center justify-between animate-fade-in">
        {{-- TOMBOL TOGGLE SIDEBAR (Mobile) --}}
        <button id="sidebarToggle" class="mr-3 text-green-700 md:hidden p-2 rounded hover:bg-green-100 transition duration-150" aria-label="Toggle Menu">
            <i data-lucide="menu" class="w-5 h-5"></i>
        </button>
        <div class="flex-grow">
            <h1 class="text-xl lg:text-2xl font-extrabold text-green-800 tracking-tight font-['Poppins']">
                Dashboard Kaprodi
            </h1>
            {{-- Menggunakan data dari $kaprodiData atau fallback ke Auth::user() --}}
            @php
                $userName = Auth::user()->name ?? 'Kaprodi';
                $prodiName = $kaprodiData['prodi_name'] ?? (Auth::user()->prodi ?? 'Program Studi Tidak Ditemukan');
            @endphp
            <p class="text-green-700 text-sm mt-1">Selamat datang, {{ $userName }}! Anda mengelola Prodi: {{ $prodiName }}</p>
        </div>
        <div class="flex flex-col items-end flex-shrink-0 ml-4">
            <p class="text-sm font-semibold text-gray-700" id="currentDate"></p>
            <p class="text-sm text-gray-600" id="currentTime"></p>
        </div>
    </header>

    {{-- Notifikasi Umum --}}
    @if (session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded-lg relative mb-4 animate-fade-in" role="alert">
            <span class="block sm:inline">{{ session('success') }}</span>
        </div>
    @endif

    {{-- Card Metrik Utama (Hanya 2) --}}
    <section class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">

        {{-- Card 1: Total Alumni Prodi --}}
        <div class="bg-white p-6 rounded-xl shadow-lg border border-green-100 transform transition duration-300 hover:scale-[1.02] hover:shadow-xl">
            <div class="flex items-center justify-between">
                <p class="text-sm font-medium text-gray-500">Total Alumni Prodi</p>
                <i data-lucide="graduation-cap" class="w-7 h-7 text-green-600"></i>
            </div>
            <p class="text-4xl font-extrabold text-green-900 mt-2">{{ $kaprodiData['total_alumni'] ?? '0' }}</p>
            <p class="text-xs text-gray-400 mt-1">Total Lulusan {{ $prodiName }}</p>
        </div>

        {{-- Card 2: Responden Tracer Study --}}
        <div class="bg-white p-6 rounded-xl shadow-lg border border-yellow-100 transform transition duration-300 hover:scale-[1.02] hover:shadow-xl">
            <div class="flex items-center justify-between">
                <p class="text-sm font-medium text-gray-500">Responden Kuesioner</p>
                <i data-lucide="clipboard-check" class="w-7 h-7 text-yellow-600"></i>
            </div>
            <p class="text-4xl font-extrabold text-green-900 mt-2">{{ $kaprodiData['total_responden'] ?? '0' }}</p>
            <p class="text-xs text-gray-400 mt-1">Alumni yang telah mengisi kuesioner</p>
        </div>

    </section>

    {{-- Bagian Aksi Cepat --}}
    <section class="bg-white p-6 rounded-2xl shadow-xl border border-gray-200 mb-8">
        <h2 class="text-xl font-bold text-gray-800 mb-4 flex items-center gap-2">
            <i data-lucide="clipboard-list" class="w-5 h-5 text-green-600"></i> Akses Data Cepat
        </h2>
        <p class="text-gray-600 mb-5">Gunakan tautan di bawah ini untuk mengakses laporan detail dan data mentah Program Studi Anda.</p>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">

            {{-- Aksi 1: Laporan Kuesioner --}}
            <a href="{{ route('kaprodi.kuisioner.report') ?? '#' }}" class="flex items-center justify-between p-4 bg-green-50 border border-green-200 rounded-xl shadow-sm transition duration-200 hover:bg-green-100 hover:shadow-lg">
                <div class="flex items-center gap-4">
                    <iconify-icon icon="mdi:file-chart-outline" class="w-8 h-8 text-green-700"></iconify-icon>
                    <div>
                        <h3 class="font-semibold text-green-800">Lihat Laporan Kuesioner</h3>
                        <p class="text-sm text-gray-500">Analisis data kuesioner Tracer Study per pertanyaan.</p>
                    </div>
                </div>
                <i data-lucide="chevron-right" class="w-5 h-5 text-green-600"></i>
            </a>

            {{-- Aksi 2: Data Alumni Mentah --}}
            <a href="{{ route('kaprodi.alumni') ?? '#' }}" class="flex items-center justify-between p-4 bg-blue-50 border border-blue-200 rounded-xl shadow-sm transition duration-200 hover:bg-blue-100 hover:shadow-lg">
                <div class="flex items-center gap-4">
                    <iconify-icon icon="mdi:database-outline" class="w-8 h-8 text-blue-700"></iconify-icon>
                    <div>
                        <h3 class="font-semibold text-blue-800">Data Mentah Alumni</h3>
                        <p class="text-sm text-gray-500">Tampilkan dan saring daftar lengkap alumni Prodi Anda.</p>
                    </div>
                </div>
                <i data-lucide="chevron-right" class="w-5 h-5 text-blue-600"></i>
            </a>

            {{-- Aksi 3: Export Data CSV --}}
            <a href="{{ route('kaprodi.kuisioner.exportCsv') ?? '#' }}" class="flex items-center justify-between p-4 bg-yellow-50 border border-yellow-200 rounded-xl shadow-sm transition duration-200 hover:bg-yellow-100 hover:shadow-lg">
                <div class="flex items-center gap-4">
                    <iconify-icon icon="mdi:file-download-outline" class="w-8 h-8 text-yellow-700"></iconify-icon>
                    <div>
                        <h3 class="font-semibold text-yellow-800">Export Data Kuesioner (CSV)</h3>
                        <p class="text-sm text-gray-500">Unduh data kuesioner lengkap dalam format CSV.</p>
                    </div>
                </div>
                <i data-lucide="download" class="w-5 h-5 text-yellow-600"></i>
            </a>

            {{-- Aksi 4: Lihat FAQ/Panduan --}}
            <a href="{{ route('kaprodi.help') ?? '#' }}" class="flex items-center justify-between p-4 bg-gray-50 border border-gray-200 rounded-xl shadow-sm transition duration-200 hover:bg-gray-100 hover:shadow-lg">
                <div class="flex items-center gap-4">
                    <i data-lucide="help-circle" class="w-8 h-8 text-gray-700"></i>
                    <div>
                        <h3 class="font-semibold text-gray-800">Panduan Penggunaan Dashboard</h3>
                        <p class="text-sm text-gray-500">Pelajari cara menafsirkan metrik dan menggunakan filter data.</p>
                    </div>
                </div>
                <i data-lucide="external-link" class="w-5 h-5 text-gray-600"></i>
            </a>
        </div>
    </section>

    {{-- Bagian Grafik dan Statistik --}}
    <section class="grid grid-cols-1 lg:grid-cols-2 gap-6">

        {{-- Grafik 1: Distribusi Alumni Berdasarkan Tahun Keluar (Bar Chart) --}}
        <div class="bg-white p-6 rounded-2xl shadow-2xl border border-gray-200">
            <h2 class="text-xl font-bold text-gray-800 mb-4 flex items-center gap-2">
                <i data-lucide="bar-chart-2" class="w-5 h-5 text-indigo-600"></i> Alumni Berdasarkan Tahun Keluar
            </h2>
            <div class="h-64">
                <canvas id="alumniByYearChart"></canvas>
            </div>
        </div>

        {{-- Grafik 2: Distribusi Status Kerja (Doughnut Chart) --}}
        <div class="bg-white p-6 rounded-2xl shadow-2xl border border-gray-200">
            <h2 class="text-xl font-bold text-gray-800 mb-4 flex items-center gap-2">
                <i data-lucide="pie-chart" class="w-5 h-5 text-pink-600"></i> Status Serapan Kerja
            </h2>
            <div class="h-64 flex justify-center items-center">
                <div class="max-w-xs w-full">
                    <canvas id="statusKerjaChart"></canvas>
                </div>
            </div>
        </div>

    </section>
@endsection

@section('scripts')
<script>
    const kaprodiData = {
        // Pastikan data yang disematkan adalah array/object yang valid
        alumni_by_year: @json($kaprodiData['alumni_by_year'] ?? []),
        status_kerja: @json($kaprodiData['status_kerja'] ?? []),
    };

    function initCharts(data) {
        // --- Chart 1: Alumni Berdasarkan Tahun Keluar ---
        const alumniByYearCtx = document.getElementById('alumniByYearChart');
        if (alumniByYearCtx && Object.keys(data.alumni_by_year).length > 0) {
            const yearLabels = Object.keys(data.alumni_by_year);
            const yearCounts = Object.values(data.alumni_by_year);

            new Chart(alumniByYearCtx, {
                type: 'bar',
                data: {
                    labels: yearLabels,
                    datasets: [{
                        label: 'Jumlah Alumni',
                        data: yearCounts,
                        backgroundColor: 'rgba(5, 150, 105, 0.7)', // emerald-600
                        borderColor: 'rgba(5, 150, 105, 1)',
                        borderWidth: 1,
                        borderRadius: 4,
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            display: false
                        },
                        title: {
                            display: false
                        }
                    },
                    scales: {
                        y: {
                            beginAtZero: true,
                            ticks: {
                                precision: 0
                            }
                        },
                        x: {
                            grid: {
                                display: false
                            }
                        }
                    }
                }
            });
        } else if (alumniByYearCtx) {
            alumniByYearCtx.parentNode.innerHTML = '<p class="text-center text-gray-500 pt-10">Data Alumni per Tahun belum tersedia.</p>';
        }


        // --- Chart 2: Status Serapan Kerja ---
        const statusKerjaCtx = document.getElementById('statusKerjaChart');
        if (statusKerjaCtx && Object.keys(data.status_kerja).length > 0) {
            const statusLabels = {
                '1': 'Bekerja/Studi',
                '0': 'Belum Bekerja'
            };
            const rawKeys = Object.keys(data.status_kerja);
            const counts = Object.values(data.status_kerja);
            const labels = rawKeys.map(key => statusLabels[key] || 'Lain-lain');

            new Chart(statusKerjaCtx, {
                type: 'doughnut',
                data: {
                    labels: labels,
                    datasets: [{
                        data: counts,
                        backgroundColor: [
                            'rgba(16, 185, 129, 0.8)', // green-500 (Bekerja)
                            'rgba(244, 63, 94, 0.8)', // red-500 (Belum Bekerja)
                        ],
                        borderColor: '#fff',
                        hoverOffset: 4
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            position: 'right',
                            align: 'center',
                            labels: {
                                usePointStyle: true,
                            }
                        },
                        title: {
                            display: false
                        }
                    },
                    layout: {
                        padding: 10
                    }
                }
            });
        } else if (statusKerjaCtx) {
            statusKerjaCtx.parentNode.innerHTML = '<p class="text-center text-gray-500 pt-10">Data Status Serapan Kerja belum tersedia.</p>';
        }
    }

    // Panggil inisialisasi chart setelah DOMContentLoaded untuk memastikan canvas ada
    document.addEventListener('DOMContentLoaded', function() {
        initCharts(kaprodiData);
    });
</script>
@endsection
