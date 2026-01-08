@extends('layouts.kaprodi') {{-- Menggunakan template utama --}}

@section('title', 'Laporan Kuesioner')

@section('head_extras')
<style>
    /* Styling Visualisasi Chart yang Responsif */
    .chart-container-wrapper {
        background-color: #fff;
        padding: 1rem;
        border-radius: 1rem;
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
        border: 1px solid #e5e7eb;
        display: flex;
        flex-direction: column;
        height: 100%;
    }

    @media (min-width: 768px) {
        .chart-container-wrapper { padding: 1.5rem; }
    }

    .chart-title-box {
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin-bottom: 1rem;
        padding-bottom: 0.5rem;
        border-bottom: 2px solid #f3f4f6;
    }

    .chart-loader {
        border: 3px solid #f3f3f3;
        border-top: 3px solid #059669;
        border-radius: 50%;
        width: 24px;
        height: 24px;
        animation: spin 1s linear infinite;
    }
    @keyframes spin { 0% { transform: rotate(0deg); } 100% { transform: rotate(360deg); } }

    /* Container Canvas yang fleksibel */
    .chart-canvas-area {
        position: relative;
        flex-grow: 1;
        width: 100%;
        min-height: 300px;
    }

    @media (min-width: 1024px) {
        .chart-canvas-area { min-height: 350px; }
    }
</style>
@endsection

@section('content')

    {{-- Header Laporan Responsif --}}
    <header class="mb-6 p-4 bg-white rounded-xl shadow-md flex flex-col md:flex-row items-center justify-between gap-4 animate-fade-in">
        <div class="flex items-center w-full md:w-auto">
            <button id="sidebarToggle" class="mr-3 text-green-700 md:hidden p-2 rounded hover:bg-green-100 transition duration-150">
                <i data-lucide="menu" class="w-5 h-5"></i>
            </button>
            <div class="flex-grow">
                <h1 class="text-xl lg:text-2xl font-extrabold text-green-800 tracking-tight font-['Poppins']">
                    Laporan Kuesioner
                </h1>
                <p class="text-green-700 text-xs md:text-sm mt-1">
                    Analisis Prodi: <span class="font-bold underline">{{ $kaprodiProdi ?? 'N/A' }}</span>
                </p>
            </div>
        </div>
        <div class="w-full md:w-auto flex gap-2">
            <a href="{{ route('kaprodi.kuisioner.exportCsv') ?? '#' }}" class="flex-1 md:flex-none inline-flex items-center justify-center gap-2 bg-yellow-600 hover:bg-yellow-700 text-white font-bold py-2.5 px-5 rounded-lg shadow-md transition duration-150 text-xs md:text-sm">
                <i data-lucide="file-down" class="w-4 h-4"></i> Export CSV
            </a>
        </div>
    </header>

    {{-- Metrik Ringkasan --}}
    <section class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4 md:gap-6 mb-8">
        @php
            $metrics = [
                ['label' => 'Total Responden', 'val' => $aggregateData['total_responden'] ?? 0, 'icon' => 'mdi:account-group', 'color' => 'text-green-600', 'bg' => 'border-green-100'],
                ['label' => 'Partisipasi', 'val' => number_format($aggregateData['persentase_partisipasi'] ?? 0, 1).'%', 'icon' => 'mdi:chart-donut', 'color' => 'text-yellow-600', 'bg' => 'border-yellow-100'],
            ];
        @endphp

        @foreach($metrics as $m)
        <div class="bg-white p-5 rounded-2xl shadow-sm border {{ $m['bg'] }} flex items-center justify-between transition hover:shadow-md">
            <div>
                <p class="text-[10px] uppercase font-bold text-gray-400 tracking-widest">{{ $m['label'] }}</p>
                <p class="text-3xl font-black text-gray-800 mt-1 leading-none">{{ $m['val'] }}</p>
            </div>
            <iconify-icon icon="{{ $m['icon'] }}" class="w-12 h-12 {{ $m['color'] }} opacity-20" style="font-size: 40px;"></iconify-icon>
        </div>
        @endforeach
    </section>

    {{-- Grafik Section --}}
    <section class="bg-white p-4 md:p-8 rounded-2xl shadow-xl border border-gray-100">
        <h2 class="text-lg font-bold text-gray-800 mb-6 flex items-center gap-2 border-l-4 border-indigo-500 pl-3">
            <i data-lucide="bar-chart-3" class="w-5 h-5 text-indigo-600"></i> Distribusi Jawaban
        </h2>

        <div id="chart-container" class="grid grid-cols-1 lg:grid-cols-2 gap-6">

            @if (empty($kuisionerData) || $kuisionerData->count() == 0)
                <div class="text-center py-20 text-gray-400 border-2 border-dashed rounded-3xl bg-gray-50 lg:col-span-2">
                    <i data-lucide="database-zap" class="w-12 h-12 mx-auto mb-4 opacity-10"></i>
                    <p class="font-bold">Data kuesioner belum tersedia.</p>
                </div>
            @else
                {{-- Removed Relevansi Pekerjaan and Skor Kepuasan charts per request --}}

                <div class="chart-container-wrapper lg:col-span-2">
                    <div class="chart-title-box">
                        <h3 class="text-xs md:text-sm font-bold text-gray-700 uppercase">Proses Pendidikan</h3>
                        <div class="chart-loader" id="loader-pendidikan"></div>
                    </div>
                    <div class="chart-canvas-area !min-h-[400px]">
                        <canvas id="chart-pendidikan" class="hidden"></canvas>
                    </div>
                </div>

                <div class="chart-container-wrapper lg:col-span-2">
                    <div class="chart-title-box">
                        <h3 class="text-xs md:text-sm font-bold text-gray-700 uppercase">Fasilitas Kampus</h3>
                        <div class="chart-loader" id="loader-fasilitas"></div>
                    </div>
                    <div class="chart-canvas-area !min-h-[600px]">
                        <canvas id="chart-fasilitas" class="hidden"></canvas>
                    </div>
                </div>
            @endif
        </div>
    </section>

    <footer class="text-center text-gray-400 text-[10px] mt-12 mb-8 uppercase tracking-widest">
        &copy; {{ date('Y') }} UIN Raden Mas Said Surakarta &bull; Tracer Study
    </footer>
@endsection

@section('scripts')
    <script>
        // Memperbaiki Error "Argument #1 ($array) must be of type array, Illuminate\Database\Eloquent\Collection given"
        // Kita konversi Collection menjadi Array terlebih dahulu di sisi PHP
        @php
            $dataArray = isset($kuisionerData) ? $kuisionerData->toArray() : [];
        @endphp

        const kuisionerArray = {!! json_encode(array_values($dataArray)) !!};

        const ANSWER_COLORS = {
            'Sangat Besar': '#059669', 'Besar': '#10B981', 'Cukup Besar': '#F59E0B',
            'Kurang': '#F97316', 'Tidak Sama Sekali': '#EF4444', 'N/A': '#94A3B8',
            'Ya, Relevan': '#3B82F6', 'Tidak Relevan': '#F43F5E'
        };

        function showChart(ctxId) {
            const ctx = document.getElementById(ctxId);
            const loaderId = 'loader-' + (ctxId.includes('p1') ? 'p1' : (ctxId.includes('p2') ? 'p2' : ctxId.split('-').pop()));
            const loader = document.getElementById(loaderId);
            if (loader) loader.classList.add('hidden');
            if (ctx) ctx.classList.remove('hidden');
        }

        function aggregate(data, field) {
            const res = {};
            data.forEach(i => { const v = i[field] ?? 'N/A'; res[v] = (res[v] || 0) + 1; });
            return res;
        }

        function aggregateJson(data, field) {
            const res = {};
            data.forEach(item => {
                let obj = item[field];
                if (typeof obj === 'string') try { obj = JSON.parse(obj); } catch(e) { return; }
                if (obj && typeof obj === 'object') {
                    for (let q in obj) {
                        const cleanQ = q.replace(/\\/g, '').trim();
                        const ans = String(obj[q]);
                        if (!res[cleanQ]) res[cleanQ] = {};
                        res[cleanQ][ans] = (res[cleanQ][ans] || 0) + 1;
                    }
                }
            });
            return res;
        }

        function createPie(ctxId, labels, data, colors, isDoughnut = false) {
            const canvas = document.getElementById(ctxId);
            if(!canvas) return;
            showChart(ctxId);
            new Chart(canvas, {
                type: isDoughnut ? 'doughnut' : 'pie',
                data: {
                    labels,
                    datasets: [{ data, backgroundColor: colors, borderWidth: 2, borderColor: '#fff' }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: { position: 'bottom', labels: { boxWidth: 10, font: { size: 10 }, padding: 15 } }
                    }
                }
            });
        }

        function createStacked(ctxId, aggData, isHorizontal = false) {
            const canvas = document.getElementById(ctxId);
            if(!canvas) return;
            showChart(ctxId);
            const qs = Object.keys(aggData);
            const options = ['Sangat Besar', 'Besar', 'Cukup Besar', 'Kurang', 'Tidak Sama Sekali'];
            const datasets = options.map(opt => ({
                label: opt,
                data: qs.map(q => aggData[q][opt] || 0),
                backgroundColor: ANSWER_COLORS[opt],
                barPercentage: 0.8
            }));

            new Chart(canvas, {
                type: 'bar',
                data: {
                    labels: qs.map(l => l.length > 25 ? l.substring(0, 25) + '...' : l),
                    datasets
                },
                options: {
                    indexAxis: isHorizontal ? 'y' : 'x',
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: { position: 'top', labels: { boxWidth: 8, font: { size: 9 }, padding: 10 } },
                        tooltip: { mode: 'index', callbacks: { title: (items) => qs[items[0].dataIndex] } }
                    },
                    scales: {
                        x: { stacked: true, grid: { display: false }, ticks: { font: { size: 9 } } },
                        y: { stacked: true, grid: { color: '#f3f4f6' }, ticks: { font: { size: 9 } } }
                    }
                }
            });
        }

        document.addEventListener('DOMContentLoaded', () => {
            if (kuisionerArray.length > 0) {
                // Render only stacked charts (pendidikan & fasilitas) — relevansi & skor removed
                createStacked('chart-pendidikan', aggregateJson(kuisionerArray, 'pendidikan'), false);
                createStacked('chart-fasilitas', aggregateJson(kuisionerArray, 'fasilitas'), true);
            }
            lucide.createIcons();
        });
    </script>
@endsection
