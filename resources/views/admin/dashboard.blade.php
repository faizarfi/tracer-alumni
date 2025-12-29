@extends('layouts.admin')

@section('title', 'Dashboard')

@push('chart-libs')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-datalabels@2.0.0"></script>
@endpush

@section('content')

    {{-- Dynamic Header: Responsive font sizes and alignment --}}
    <header class="mb-6 md:mb-8 p-4 bg-white rounded-xl shadow-md flex flex-col md:flex-row items-center justify-between animate-slide-in-left gap-4 text-center md:text-left">
        <div>
            <h1 class="text-2xl md:text-3xl lg:text-4xl font-extrabold text-green-800 tracking-tight font-['Poppins']">
                Halo, <span id="adminName">{{ Auth::user()->name ?? 'Admin' }}</span>!
            </h1>
            <p class="text-green-700 text-sm md:text-lg mt-1" id="currentDateTime"></p>
        </div>
        {{-- Tombol aksi cepat bisa ditambahkan di sini jika perlu --}}
    </header>

    {{-- Statistik Cards: Responsive Grid --}}
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 md:gap-6 mb-10">
        @php
            $totalAlumni = $totalAlumni ?? 0;
            $bekerja = $bekerja ?? 0;
            $belumBekerja = $belumBekerja ?? 0;
            $isiKuisioner = $isiKuisioner ?? 0;

            $stats = [
                ['label' => 'Total Alumni', 'value' => $totalAlumni, 'color_from' => 'from-green-400', 'color_to' => 'to-green-600', 'icon' => 'mdi:account-group-outline'],
                ['label' => 'Sudah Bekerja', 'value' => $bekerja, 'color_from' => 'from-blue-400', 'color_to' => 'to-blue-600', 'icon' => 'mdi:briefcase-check-outline'],
                ['label' => 'Belum Bekerja', 'value' => $belumBekerja, 'color_from' => 'from-red-400', 'color_to' => 'to-red-600', 'icon' => 'mdi:account-off-outline'],
                ['label' => 'Kuesioner Terisi', 'value' => $isiKuisioner, 'color_from' => 'from-yellow-400', 'color_to' => 'to-yellow-600', 'icon' => 'mdi:clipboard-list-outline'],
            ];
        @endphp

        @foreach($stats as $stat)
            <div
                class="bg-gradient-to-br {{ $stat['color_from'] }} {{ $stat['color_to'] }} text-white rounded-2xl shadow-lg p-5 md:p-6 hover:shadow-2xl transition-all duration-300 ease-in-out flex justify-between items-center cursor-pointer transform hover:scale-[1.02] active:scale-95 select-none animate-fade-in-up"
                style="animation-delay: {{ $loop->index * 0.1 }}s;"
                title="{{ $stat['label'] }}">
                <div>
                    <p class="text-xs md:text-sm font-semibold tracking-wide uppercase drop-shadow-md opacity-90">{{ $stat['label'] }}</p>
                    <p class="text-3xl md:text-4xl font-extrabold mt-1 drop-shadow-md font-['Poppins']">{{ $stat['value'] }}</p>
                </div>
                <iconify-icon icon="{{ $stat['icon'] }}" width="40" height="40" class="md:w-12 md:h-12 opacity-80 drop-shadow-md"></iconify-icon>
            </div>
        @endforeach
    </div>

    {{-- Data Visualization Grid: Flexible columns --}}
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-10">
        {{-- Chart Section --}}
        <section class="bg-white rounded-2xl shadow-xl p-5 md:p-8 w-full animate-fade-in-down border border-green-200">
            <h2 class="text-xl md:text-2xl font-semibold text-green-800 mb-6 text-center select-none font-['Poppins']">Statistik Utama Alumni</h2>
            <div class="relative w-full" style="height: 300px; md:height: 350px;">
                <canvas id="statusChart"></canvas>
            </div>
        </section>

        {{-- Percentage Summary Section --}}
        <section class="bg-white rounded-2xl shadow-xl p-5 md:p-8 w-full animate-fade-in-up border border-indigo-200">
            <h2 class="text-xl md:text-2xl font-semibold text-indigo-800 mb-6 font-['Poppins'] text-center">Ringkasan Persentase Data</h2>
            <div class="space-y-4 md:space-y-6">
                @php
                    $employmentRate = ($totalAlumni > 0) ? round(($bekerja / $totalAlumni) * 100, 1) : 0;
                    $unemploymentRate = ($totalAlumni > 0) ? round(($belumBekerja / $totalAlumni) * 100, 1) : 0;
                    $questionnaireRate = ($totalAlumni > 0) ? round(($isiKuisioner / $totalAlumni) * 100, 1) : 0;
                @endphp

                {{-- Progress Bar Item --}}
                @foreach([
                    ['label' => 'Alumni Bekerja', 'rate' => $employmentRate, 'count' => $bekerja, 'color' => 'bg-indigo-600', 'bg' => 'bg-indigo-50', 'icon' => 'award', 'text' => 'text-indigo-700'],
                    ['label' => 'Alumni Belum Bekerja', 'rate' => $unemploymentRate, 'count' => $belumBekerja, 'color' => 'bg-red-600', 'bg' => 'bg-red-50', 'icon' => 'frown', 'text' => 'text-red-700'],
                    ['label' => 'Tingkat Kuesioner', 'rate' => $questionnaireRate, 'count' => $isiKuisioner, 'color' => 'bg-emerald-600', 'bg' => 'bg-emerald-50', 'icon' => 'check-square', 'text' => 'text-emerald-700']
                ] as $item)
                <div class="flex items-center gap-3 md:gap-4 p-4 {{ $item['bg'] }} rounded-xl border border-transparent hover:border-gray-200 transition-all duration-300">
                    <div class="hidden sm:block {{ $item['bg'] }} p-3 rounded-full flex-shrink-0 border border-white">
                        <i data-lucide="{{ $item['icon'] }}" class="w-6 h-6 {{ $item['text'] }}"></i>
                    </div>
                    <div class="flex-1 min-w-0">
                        <p class="font-bold {{ $item['text'] }} text-sm md:text-base truncate">{{ $item['label'] }}</p>
                        <div class="w-full bg-gray-200 rounded-full h-2 mt-2">
                            <div class="{{ $item['color'] }} h-2 rounded-full transition-all duration-1000" style="width: {{ $item['rate'] }}%"></div>
                        </div>
                        <p class="text-xs text-gray-600 mt-1">
                            <span class="font-bold">{{ $item['count'] }}</span> / {{ $totalAlumni }} alumni <span class="font-bold">({{ $item['rate'] }}%)</span>
                        </p>
                    </div>
                </div>
                @endforeach
            </div>
        </section>
    </div>

    {{-- Alumni Terbaru Table: Responsive wrapper --}}
    <div class="space-y-10">
        <section class="bg-white shadow-xl rounded-2xl p-5 md:p-8 border border-green-200 animate-fade-in-up">
            <h2 class="text-xl md:text-2xl font-semibold text-green-800 mb-6 text-center font-['Poppins']">Alumni Terbaru</h2>

            <div class="overflow-x-auto -mx-5 md:mx-0">
                <div class="inline-block min-w-full align-middle md:px-0">
                    @if(isset($latestAlumni) && $latestAlumni->isNotEmpty())
                        <table class="min-w-full divide-y divide-gray-200 text-sm">
                            <thead class="bg-green-100 text-green-800 uppercase tracking-wide border-b border-green-200 text-left">
                                <tr>
                                    <th class="py-3 px-4">Nama</th>
                                    <th class="py-3 px-4 text-center">NIM</th>
                                    <th class="py-3 px-4 text-center hidden sm:table-cell">Jurusan</th>
                                    <th class="py-3 px-4 text-center hidden md:table-cell">Fakultas</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-100">
                                @foreach($latestAlumni as $alumni)
                                    <tr class="hover:bg-green-50 transition-colors duration-150">
                                        <td class="py-4 px-4 font-medium text-gray-900">{{ $alumni->nama }}</td>
                                        <td class="py-4 px-4 text-center text-gray-600">{{ $alumni->nim }}</td>
                                        <td class="py-4 px-4 text-center text-gray-600 hidden sm:table-cell">{{ $alumni->jurusan }}</td>
                                        <td class="py-4 px-4 text-center text-gray-600 hidden md:table-cell">{{ $alumni->fakultas }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    @else
                        <div class="text-center py-10 px-4">
                            <img src="https://www.svgrepo.com/show/472628/no-data.svg" alt="No Data" class="w-24 h-24 mx-auto mb-4 opacity-40">
                            <p class="text-gray-500 italic">Belum ada data alumni terbaru.</p>
                        </div>
                    @endif
                </div>
            </div>
        </section>

        {{-- CTA Card: Responsive Flex --}}
        <section class="bg-gradient-to-br from-blue-600 to-indigo-700 text-white rounded-2xl shadow-xl p-6 md:p-10 flex flex-col md:flex-row items-center gap-8 animate-fade-in">
            <div class="md:w-2/3 text-center md:text-left">
                <h2 class="text-2xl md:text-3xl font-extrabold mb-4 font-['Poppins']">Kelola Data Lebih Lengkap?</h2>
                <p class="text-blue-100 text-base md:text-lg mb-6 leading-relaxed">
                    Akses menu Manajemen Alumni untuk melakukan filter data mendalam, mengunduh laporan CSV, atau memperbarui informasi profil secara spesifik.
                </p>
                <a href="{{ route('admin.alumni') }}" class="inline-flex items-center px-6 py-3 bg-white text-blue-700 font-bold rounded-xl shadow-lg hover:bg-blue-50 transition transform hover:-translate-y-1 active:scale-95">
                    <i data-lucide="users" class="w-5 h-5 mr-2"></i> Ke Manajemen Alumni
                </a>
            </div>
            <div class="md:w-1/3 flex justify-center">
                <iconify-icon icon="mdi:database-cog" class="text-white opacity-20" width="160" height="160"></iconify-icon>
            </div>
        </section>
    </div>

@endsection

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // JS Variables from Blade
            const statsData = {
                total: parseInt("{{ $totalAlumni }}") || 0,
                bekerja: parseInt("{{ $bekerja }}") || 0,
                belum: parseInt("{{ $belumBekerja }}") || 0,
                kuesioner: parseInt("{{ $isiKuisioner }}") || 0
            };

            // Initialize Chart.js
            Chart.register(ChartDataLabels);
            const ctx = document.getElementById('statusChart');

            if (ctx) {
                new Chart(ctx, {
                    type: 'doughnut',
                    data: {
                        labels: ['Bekerja', 'Belum Bekerja', 'Isi Kuesioner'],
                        datasets: [{
                            data: [statsData.bekerja, statsData.belum, statsData.kuesioner],
                            backgroundColor: ['#3B82F6', '#EF4444', '#F59E0B'],
                            borderColor: '#ffffff',
                            borderWidth: 3,
                            hoverOffset: 15
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        plugins: {
                            legend: {
                                position: window.innerWidth < 768 ? 'bottom' : 'right',
                                labels: { padding: 20, font: { family: 'Poppins', size: 12 } }
                            },
                            datalabels: {
                                color: '#fff',
                                font: { weight: 'bold', size: 12 },
                                formatter: (val) => {
                                    if (statsData.total === 0) return '';
                                    return ((val / statsData.total) * 100).toFixed(0) + '%';
                                }
                            },
                            tooltip: {
                                callbacks: {
                                    label: (item) => ` ${item.label}: ${item.raw} Alumni`
                                }
                            }
                        },
                        cutout: '65%'
                    }
                });
            }

            // Real-time Clock logic (if needed in layout but defined here)
            function updateClock() {
                const now = new Date();
                const options = { weekday: 'long', year: 'numeric', month: 'long', day: 'numeric', hour: '2-digit', minute: '2-digit' };
                const el = document.getElementById('currentDateTime');
                if (el) el.textContent = now.toLocaleDateString('id-ID', options) + ' WIB';
            }
            updateClock();
            setInterval(updateClock, 60000);

            // Re-init lucide icons for dynamic elements
            if (window.lucide) lucide.createIcons();
        });
    </script>
@endpush
