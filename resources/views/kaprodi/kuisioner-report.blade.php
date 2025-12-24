@extends('layouts.kaprodi') {{-- Menggunakan template utama --}}

@section('title', 'Laporan Kuesioner')

@section('head_extras')
<style>
    /* Styling Tambahan untuk Visualisasi Chart */
    .chart-container-wrapper {
        background-color: #fff;
        padding: 1.5rem;
        border-radius: 0.75rem;
        box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.05), 0 4px 6px -2px rgba(0, 0, 0, 0.05);
        border: 1px solid #e5e7eb;
        transition: box-shadow 0.2s;
    }
    .chart-container-wrapper:hover {
        box-shadow: 0 15px 25px -5px rgba(0, 0, 0, 0.1);
    }
    .chart-title-box {
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin-bottom: 0.75rem;
        padding-bottom: 0.5rem;
        border-bottom: 2px solid #e5e7eb;
    }
    /* Loader Style */
    .chart-loader {
        border: 4px solid #f3f3f3;
        border-top: 4px solid #047857;
        border-radius: 50%;
        width: 30px;
        height: 30px;
        animation: spin 1s linear infinite;
        margin: 20px auto;
    }
    @keyframes spin {
        0% { transform: rotate(0deg); }
        100% { transform: rotate(360deg); }
    }

    /* PENTING: Memastikan chart Pie/Doughnut proporsional di tengah */
    .chart-pie-container {
        height: 100%;
        width: 100%;
        max-height: 250px; /* Batasan agar Pie Chart tidak terlalu besar */
        max-width: 350px;
        margin: 0 auto;
    }
</style>
@endsection

@section('content')

    {{-- Header Laporan --}}
    <header class="mb-6 p-4 bg-white rounded-xl shadow-md flex flex-col sm:flex-row items-start sm:items-center justify-between">
        <button id="sidebarToggle" class="mr-3 text-green-700 md:hidden p-2 rounded hover:bg-green-100 transition duration-150" aria-label="Toggle Menu">
            <i data-lucide="menu" class="w-5 h-5"></i>
        </button>
        <div class="flex-grow">
            <h1 class="text-xl lg:text-2xl font-extrabold text-green-800 tracking-tight font-['Poppins']">
                Laporan Detail Kuesioner
            </h1>
            <p class="text-green-700 text-sm mt-1">
                Analisis data kuesioner Tracer Study untuk Program Studi: <span class="font-semibold">{{ $kaprodiProdi ?? 'Tidak Ditemukan' }}</span>
            </p>
        </div>
        <div class="mt-4 sm:mt-0 flex items-center gap-3">
            <a href="{{ route('kaprodi.kuisioner.exportCsv') ?? '#' }}" class="inline-flex items-center gap-2 bg-yellow-600 hover:bg-yellow-700 text-white font-semibold py-2 px-4 rounded-lg shadow-md transition duration-150">
                <i data-lucide="file-text" class="w-5 h-5"></i> Export CSV
            </a>
        </div>
    </header>

    {{-- Card Metrik Ringkasan --}}
    <section class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">

        {{-- Card 1: Total Responden --}}
        <div class="bg-white p-6 rounded-xl shadow-xl border border-green-100 flex items-center justify-between transition duration-300 hover:scale-[1.02]">
            <div>
                <p class="text-sm font-medium text-gray-500">Total Responden</p>
                <p class="text-4xl font-extrabold text-green-900 mt-1">{{ $aggregateData['total_responden'] ?? 0 }}</p>
            </div>
            <iconify-icon icon="mdi:account-group" class="w-10 h-10 text-green-600 opacity-70"></iconify-icon>
        </div>

        {{-- Card 2: Indeks Kepuasan Rata-rata --}}
        <div class="bg-white p-6 rounded-xl shadow-xl border border-blue-100 flex items-center justify-between transition duration-300 hover:scale-[1.02]">
            <div>
                <p class="text-sm font-medium text-gray-500">Indeks Kepuasan Rata-rata</p>
                <p class="text-4xl font-extrabold text-green-900 mt-1">{{ number_format($aggregateData['rata_rata_kepuasan'] ?? 0, 2) }}</p>
            </div>
            <iconify-icon icon="mdi:star-four-points" class="w-10 h-10 text-blue-600 opacity-70"></iconify-icon>
        </div>

        {{-- Card 3: Persentase Partisipasi --}}
        <div class="bg-white p-6 rounded-xl shadow-xl border border-yellow-100 flex items-center justify-between transition duration-300 hover:scale-[1.02]">
            <div>
                <p class="text-sm font-medium text-gray-500">Persentase Partisipasi</p>
                <p class="text-4xl font-extrabold text-green-900 mt-1">{{ number_format($aggregateData['persentase_partisipasi'] ?? 0, 1) }}%</p>
            </div>
            <iconify-icon icon="mdi:percent" class="w-10 h-10 text-yellow-600 opacity-70"></iconify-icon>
        </div>
    </section>

    {{-- Visualisasi Kuesioner Per Pertanyaan --}}
    <section class="bg-white p-6 rounded-2xl shadow-2xl border border-gray-200">
        <h2 class="text-xl font-bold text-gray-800 mb-6 flex items-center gap-2 border-b pb-2">
            <i data-lucide="bar-chart-3" class="w-5 h-5 text-indigo-600"></i> Distribusi Jawaban Kuesioner
        </h2>

        <div id="chart-container" class="grid grid-cols-1 lg:grid-cols-2 gap-6">

            @if (count($kuisionerData ?? []) === 0)
                <div class="text-center py-10 text-gray-500 border border-dashed rounded-xl bg-gray-50 lg:col-span-2">
                    <i data-lucide="inbox" class="w-10 h-10 mx-auto mb-3 text-gray-400"></i>
                    <p class="font-semibold">Data Kuesioner Belum Tersedia.</p>
                    <p class="text-sm">Mohon tunggu hingga alumni Program Studi Anda mengisi kuesioner.</p>
                </div>
            @else

                {{-- Chart 1: Relevansi Pekerjaan (Pie Chart) --}}
                <div class="chart-container-wrapper h-96">
                    <div class="chart-title-box">
                        <h3 class="text-lg font-semibold text-gray-700">P1: Relevansi Pekerjaan dengan Pendidikan?</h3>
                        <i data-lucide="briefcase" class="w-5 h-5 text-green-600"></i>
                    </div>
                    <div class="h-64 relative flex justify-center items-center">
                        <div class="chart-loader" id="loader-p1"></div>
                        <div class="chart-pie-container">
                            <canvas id="chart-p1" class="hidden"></canvas>
                        </div>
                    </div>
                </div>

                {{-- Chart 2: Tingkat Kepuasan (Pie Chart) --}}
                <div class="chart-container-wrapper h-96">
                    <div class="chart-title-box">
                        <h3 class="text-lg font-semibold text-gray-700">P2: Tingkat Kepuasan Fasilitas Kampus (Skala 1-5)</h3>
                        <i data-lucide="award" class="w-5 h-5 text-blue-600"></i>
                    </div>
                    <div class="h-64 relative flex justify-center items-center">
                        <div class="chart-loader" id="loader-p2"></div>
                        <div class="chart-pie-container">
                            <canvas id="chart-p2" class="hidden"></canvas>
                        </div>
                    </div>
                </div>

                {{-- Chart 3: Proses Pendidikan (Stacked Bar Chart - Vertical) --}}
                <div class="chart-container-wrapper lg:col-span-2">
                    <div class="chart-title-box">
                        <h3 class="text-lg font-semibold text-gray-700">P3: Penilaian terhadap Proses Pendidikan (Stacked Vertical)</h3>
                        <i data-lucide="graduation-cap" class="w-5 h-5 text-indigo-600"></i>
                    </div>
                    <div class="h-96 relative flex justify-center items-center">
                        <div class="chart-loader" id="loader-p3"></div>
                        <canvas id="chart-pendidikan" class="hidden"></canvas>
                    </div>
                </div>

                {{-- Chart 4: Fasilitas Kampus (Stacked Bar Chart - Horizontal) --}}
                <div class="chart-container-wrapper lg:col-span-2">
                    <div class="chart-title-box">
                        <h3 class="text-lg font-semibold text-gray-700">P4: Penilaian terhadap Fasilitas Kampus (Stacked Horizontal)</h3>
                        <i data-lucide="building" class="w-5 h-5 text-yellow-600"></i>
                    </div>
                    {{-- Ditingkatkan tingginya agar label horizontal tidak terpotong --}}
                    <div class="h-[500px] relative flex justify-center items-center">
                        <div class="chart-loader" id="loader-p4"></div>
                        <canvas id="chart-fasilitas" class="hidden"></canvas>
                    </div>
                </div>

            @endif

        </div>
    </section>

    <footer class="text-center text-gray-500 text-sm mt-12 pt-6 border-t border-gray-300">
        &copy; 2025 UIN Raden Mas Said Surakarta.
    </footer>
@endsection

@section('scripts')
    {{-- Data Kuesioner dari Controller di-inject di sini --}}
    <script>
        // Data disematkan dari Controller.
        const kuisionerDataArray = {!! json_encode($kuisionerData ?? []) !!};
        const kuisionerArray = Array.isArray(kuisionerDataArray) ? kuisionerDataArray : Object.values(kuisionerDataArray);

        // --- DEFINISI WARNA STANDAR (Konsisten dengan tema) ---
        const ANSWER_COLORS = {
            'Sangat Besar': 'rgba(16, 185, 129, 0.9)', // Emerald/Strong Green
            'Besar': 'rgba(52, 211, 153, 0.8)', // Medium Green
            'Cukup Besar': 'rgba(251, 191, 36, 0.8)', // Amber/Yellow
            'Kurang': 'rgba(253, 164, 46, 0.8)', // Orange
            'Tidak Sama Sekali': 'rgba(244, 63, 94, 0.8)', // Red
            'N/A': 'rgba(156, 163, 175, 0.8)', // Gray
            // P1 specific
            'Ya, Relevan': 'rgba(59, 130, 246, 0.8)', // Blue
            'Tidak Relevan': 'rgba(244, 63, 94, 0.8)', // Red
        };

        // Logika Chart.js (Fungsi-fungsi Helper)
        function showChart(ctxId) {
            const ctx = document.getElementById(ctxId);
            // Dapatkan ID loader dari ctxId, misalnya 'chart-p1' -> 'loader-p1'
            const loaderId = `loader-${ctxId.split('-').pop()}`;
            const loader = document.getElementById(loaderId);

            if (loader) loader.classList.add('hidden');
            if (ctx) ctx.classList.remove('hidden');
        }

        function aggregate(data, field) {
            const results = {};
            data.forEach(item => {
                const value = item[field] !== null && item[field] !== undefined ? String(item[field]) : 'N/A';
                results[value] = (results[value] || 0) + 1;
            });
            return results;
        }

        function aggregateJson(data, field) {
            const aggregatedResults = {};

            data.forEach(item => {
                let jsonString = item[field];
                let jsonObject = null; // Gunakan objek null untuk menahan hasil parse

                // Cek apakah data valid untuk di-parse
                if (typeof jsonString === 'string' && jsonString.trim() !== '' && jsonString !== 'null') {
                    try {
                        // 1. Coba parse langsung
                        let parsedValue = JSON.parse(jsonString);

                        // 2. Cek double escaping (jika hasil parse pertama masih string)
                        if (typeof parsedValue === 'string') {
                            parsedValue = JSON.parse(parsedValue);
                        }

                        jsonObject = parsedValue;

                    } catch (e) {
                        // Jika parsing gagal, ini menunjukkan data bermasalah
                        console.error(`[CRITICAL JSON PARSE ERROR] Gagal memproses data untuk field ${field}:`, e, item[field]);
                        return; // Lewati item ini
                    }
                } else if (typeof jsonString === 'object' && jsonString !== null) {
                    // Jika data sudah di-cast oleh model (sudah jadi objek), gunakan langsung
                    jsonObject = jsonString;
                } else {
                    return; // Lewati field yang null, undefined, atau string "null"
                }

                // Agregasi hasil parse
                if (typeof jsonObject === 'object' && jsonObject !== null) {
                    for (const subQuestion in jsonObject) {
                        if (jsonObject.hasOwnProperty(subQuestion)) {
                            const answer = String(jsonObject[subQuestion]);
                            // Menghapus karakter escape (seperti '\/') dan trim spasi
                            const cleanSubQuestion = subQuestion.replace(/\\/g, '').trim();

                            if (!aggregatedResults[cleanSubQuestion]) {
                                aggregatedResults[cleanSubQuestion] = {};
                            }
                            aggregatedResults[cleanSubQuestion][answer] = (aggregatedResults[cleanSubQuestion][answer] || 0) + 1;
                        }
                    }
                }
            });
            return aggregatedResults;
        }

        /**
         * Fungsi untuk membuat chart dasar (Pie/Bar)
         * @param {string} ctxId - ID canvas
         * @param {string} type - 'pie' atau 'bar'
         * @param {string[]} labels - Label data
         * @param {number[]} data - Nilai data
         * @param {string[]} customColors - Warna kustom untuk slice/bar
         */
        function createChart(ctxId, type, labels, data, customColors) {
            showChart(ctxId);

            new Chart(document.getElementById(ctxId), {
                type: type,
                data: {
                    labels: labels,
                    datasets: [{
                        data: data,
                        backgroundColor: customColors,
                        borderColor: type === 'pie' ? '#ffffff' : 'rgba(0,0,0,0)',
                        borderWidth: type === 'pie' ? 2 : 1,
                        hoverOffset: type === 'pie' ? 4 : 0,
                        borderRadius: type === 'bar' ? 4 : 0,
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            display: true,
                            position: type === 'pie' ? 'right' : 'top',
                            labels: {
                                color: '#2D3748',
                                font: {
                                    weight: '600'
                                }
                            }
                        },
                        tooltip: {
                            callbacks: {
                                label: function(context) {
                                    const total = context.dataset.data.reduce((a, b) => a + b, 0);
                                    const currentValue = context.raw;
                                    const percentage = total > 0 ? ((currentValue / total) * 100).toFixed(1) + '%' : '0%';
                                    return `${context.label}: ${currentValue} responden (${percentage})`;
                                }
                            }
                        }
                    },
                    scales: type === 'bar' ? {
                        y: {
                            beginAtZero: true,
                            ticks: { precision: 0 }
                        },
                        x: { grid: { display: false } }
                    } : {}
                }
            });
        }

        /**
         * Fungsi untuk membuat Stacked Bar Chart (Vertikal atau Horizontal)
         * @param {string} ctxId - ID canvas
         * @param {object} aggregatedData - Data yang sudah diagregasi oleh sub-pertanyaan
         * @param {string} axis - 'x' untuk Vertikal (default), 'y' untuk Horizontal
         */
        function createGroupedBarChart(ctxId, aggregatedData, axis = 'x') {
            showChart(ctxId);

            const subQuestions = Object.keys(aggregatedData);
            if (subQuestions.length === 0) {
                document.getElementById(ctxId).parentNode.innerHTML = '<p class="text-center text-gray-500 pt-10">Data tidak tersedia.</p>';
                return;
            }

            const standardAnswers = ['Sangat Besar', 'Besar', 'Cukup Besar', 'Kurang', 'Tidak Sama Sekali', 'N/A'];

            const datasets = standardAnswers.filter(answer => {
                return subQuestions.some(q => aggregatedData[q][answer]);
            }).map((answer) => {
                return {
                    label: answer,
                    data: subQuestions.map(q => aggregatedData[q][answer] || 0),
                    backgroundColor: ANSWER_COLORS[answer],
                    borderColor: 'rgba(255, 255, 255, 0.5)',
                    borderWidth: 1,
                    borderRadius: 0,
                };
            });

            new Chart(document.getElementById(ctxId), {
                type: 'bar',
                data: {
                    labels: subQuestions.map(q => q.replace(/ /g, '\n')), // Label di sumbu
                    datasets: datasets,
                },
                options: {
                    indexAxis: axis === 'y' ? 'y' : 'x', // Mengatur orientasi chart
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: { position: 'top' },
                        // PENTING: Perbaikan Tooltip Interaction
                        tooltip: {
                            mode: 'nearest', // Mode nearest lebih baik untuk bar chart
                            intersect: true, // Memungkinkan intersect untuk mendapatkan bar yang tepat
                            axis: axis === 'y' ? 'y' : 'x' // Batasi interaksi pada sumbu data (Y pada Horizontal Bar Chart)
                        }
                    },
                    scales: {
                        x: {
                            stacked: true,
                            beginAtZero: true,
                            ticks: { precision: 0, autoSkip: false },
                            grid: { display: axis === 'y' }
                        },
                        y: {
                            stacked: true,
                            beginAtZero: true,
                            ticks: { precision: 0, autoSkip: axis !== 'y' },
                            grid: { display: axis === 'x' }
                        }
                    },
                }
            });
        }

        // Logika Inisialisasi Chart
        function initCharts(kuisionerArray) {
            // --- Chart 1: Relevansi Pekerjaan (PIE CHART) ---
            const p1_raw = aggregate(kuisionerArray, 'relevansi_pekerjaan');
            const p1_valid_data = [];
            const p1_valid_labels = [];
            const p1_colors = [];

            Object.keys(p1_raw).forEach(key => {
                if (key === '1' || key === '0') {
                    const label = key === '1' ? 'Ya, Relevan' : 'Tidak Relevan';
                    p1_valid_labels.push(label);
                    p1_valid_data.push(p1_raw[key]);
                    p1_colors.push(ANSWER_COLORS[label]);
                }
            });

            if (p1_valid_data.length > 0) {
                createChart('chart-p1', 'pie', p1_valid_labels, p1_valid_data, p1_colors);
            } else {
                document.getElementById('loader-p1').parentNode.innerHTML = '<p class="text-center text-gray-500 pt-10">Data Relevansi Pekerjaan belum mencukupi.</p>';
            }


            // --- Chart 2: Tingkat Kepuasan (PIE CHART) ---
            const p2_raw = aggregate(kuisionerArray, 'skor_kepuasan');
            const p2_sortedKeys = Object.keys(p2_raw).filter(key => key !== 'N/A').sort();
            const p2_data = p2_sortedKeys.map(key => p2_raw[key]);
            const p2_labels = p2_sortedKeys.map(key => `Skor ${key}`);
            const p2_colors = ['rgba(16, 185, 129, 0.9)', 'rgba(52, 211, 153, 0.8)', 'rgba(251, 191, 36, 0.8)', 'rgba(59, 130, 246, 0.8)', 'rgba(236, 72, 153, 0.8)'];

            if (p2_data.length > 0) {
                createChart('chart-p2', 'doughnut', p2_labels, p2_data, p2_colors);
            } else {
                document.getElementById('loader-p2').parentNode.innerHTML = '<p class="text-center text-gray-500 pt-10">Data Skor Kepuasan belum mencukupi.</p>';
            }

            // --- Chart 3: Proses Pendidikan (STACKED VERTICAL BAR CHART) ---
            const pendidikan_raw = aggregateJson(kuisionerArray, 'pendidikan');
            if (Object.keys(pendidikan_raw).length > 0) {
                createGroupedBarChart('chart-pendidikan', pendidikan_raw, 'x'); // 'x' for vertical
            } else {
                document.getElementById('loader-p3').parentNode.innerHTML = '<p class="text-center text-gray-500 pt-10">Data Penilaian Proses Pendidikan belum tersedia.</p>';
            }

            // --- Chart 4: Fasilitas Kampus (STACKED HORIZONTAL BAR CHART) ---
            const fasilitas_raw = aggregateJson(kuisionerArray, 'fasilitas');
            if (Object.keys(fasilitas_raw).length > 0) {
                createGroupedBarChart('chart-fasilitas', fasilitas_raw, 'y'); // 'y' for horizontal
            } else {
                document.getElementById('loader-p4').parentNode.innerHTML = '<p class="text-center text-gray-500 pt-10">Data Penilaian Fasilitas Kampus belum tersedia.</p>';
            }
        }

        document.addEventListener('DOMContentLoaded', function() {
            // Inisialisasi Lucide
            lucide.createIcons();

            // Inisialisasi Chart jika ada data
            if (kuisionerArray.length > 0) {
                initCharts(kuisionerArray);
            }
        });
    </script>
@endsection
