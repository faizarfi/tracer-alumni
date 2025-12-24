@extends('layouts.admin')

@section('title', 'Dashboard')

@push('chart-libs')
    {{-- Only load chart libraries when needed --}}
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-datalabels@2.0.0"></script>
@endpush

@section('content')

    {{-- New: Dynamic Header with Greeting & Time --}}
    <header class="mb-8 p-4 bg-white rounded-xl shadow-md flex items-center justify-between animate-slide-in-left">
        <div>
            <h1 class="text-3xl lg:text-4xl font-extrabold text-green-800 tracking-tight font-['Poppins']">
                Halo, <span id="adminName">{{ Auth::user()->name ?? 'Admin' }}</span>!
            </h1>
            <p class="text-green-700 text-lg mt-1" id="currentDateTime"></p>
        </div>
    </header>

    {{-- Statistik Cards --}}
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mb-10">
        @php
            // Pastikan variabel dari Controller sudah didefinisikan di sini jika Anda tidak menggunakan view composer atau passing data
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
                class="bg-gradient-to-br {{ $stat['color_from'] }} {{ $stat['color_to'] }} text-white rounded-2xl shadow-xl p-6 hover:shadow-2xl transition-all duration-300 ease-in-out flex justify-between items-center cursor-pointer transform hover:scale-105 select-none animate-fade-in-up"
                style="animation-delay: {{ $loop->index * 0.15 }}s;"
                title="{{ $stat['label'] }}">
                <div>
                    <p class="text-sm font-semibold tracking-wide uppercase drop-shadow-md">{{ $stat['label'] }}</p>
                    <p class="text-4xl font-extrabold mt-1 drop-shadow-md font-['Poppins']">{{ $stat['value'] }}</p>
                </div>
                <iconify-icon icon="{{ $stat['icon'] }}" width="48" height="48" class="opacity-90 drop-shadow-md"></iconify-icon>
            </div>
        @endforeach
    </div>

    {{-- Data Visualization Grid (Chart & New Info Card) --}}
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-10">
        <section
            class="bg-white rounded-2xl shadow-xl p-6 lg:p-8 w-full animate-fade-in-down border border-green-200">
            <h2 class="text-2xl font-semibold text-green-800 mb-6 text-center select-none drop-shadow-md font-['Poppins']">Statistik Utama Alumni</h2>
            <div class="w-full flex justify-center items-center" style="height: 320px;">
                <canvas id="statusChart" class="!w-full !h-full rounded-lg"></canvas>
            </div>
        </section>

        {{-- NEW FEATURE: Kuesioner and Employment Rate Summary --}}
        <section class="bg-white rounded-2xl shadow-xl p-6 lg:p-8 w-full animate-fade-in-up border border-indigo-200">
            <h2 class="text-2xl font-semibold text-indigo-800 mb-6 font-['Poppins'] text-center">Ringkasan Persentase Data</h2>
            <div class="space-y-6">
                @php
                    $employmentRate = ($totalAlumni > 0) ? round(($bekerja / $totalAlumni) * 100, 1) : 0;
                    $unemploymentRate = ($totalAlumni > 0) ? round(($belumBekerja / $totalAlumni) * 100, 1) : 0;
                    $questionnaireCompletionRate = ($totalAlumni > 0) ? round(($isiKuisioner / $totalAlumni) * 100, 1) : 0;
                @endphp

                <div class="flex items-center gap-4 p-4 bg-indigo-50 rounded-xl border border-indigo-100 transition-all duration-300 hover:bg-indigo-100 cursor-pointer">
                    <div class="bg-indigo-200 p-3 rounded-full flex-shrink-0">
                        <i data-lucide="award" class="w-7 h-7 text-indigo-700"></i>
                    </div>
                    <div class="flex-1">
                        <p class="font-semibold text-indigo-800 text-lg">Persentase Alumni Bekerja</p>
                        <div class="w-full bg-gray-200 rounded-full h-2.5 mt-2">
                            <div class="bg-indigo-600 h-2.5 rounded-full" style="width: {{ $employmentRate }}%"></div>
                        </div>
                        <p class="text-sm text-gray-700 mt-1"><span class="font-bold text-indigo-700">{{ $bekerja }}</span> dari <span class="font-bold text-indigo-700">{{ $totalAlumni }}</span> alumni ({{ $employmentRate }}%)</p>
                    </div>
                </div>

                <div class="flex items-center gap-4 p-4 bg-red-50 rounded-xl border border-red-100 transition-all duration-300 hover:bg-red-100 cursor-pointer">
                    <div class="bg-red-200 p-3 rounded-full flex-shrink-0">
                        <i data-lucide="frown" class="w-7 h-7 text-red-700"></i>
                    </div>
                    <div class="flex-1">
                        <p class="font-semibold text-red-800 text-lg">Persentase Alumni Belum Bekerja</p>
                        <div class="w-full bg-gray-200 rounded-full h-2.5 mt-2">
                            <div class="bg-red-600 h-2.5 rounded-full" style="width: {{ $unemploymentRate }}%"></div>
                        </div>
                        <p class="text-sm text-gray-700 mt-1"><span class="font-bold text-red-700">{{ $belumBekerja }}</span> dari <span class="font-bold text-red-700">{{ $totalAlumni }}</span> alumni ({{ $unemploymentRate }}%)</p>
                    </div>
                </div>

                <div class="flex items-center gap-4 p-4 bg-emerald-50 rounded-xl border border-emerald-100 transition-all duration-300 hover:bg-emerald-100 cursor-pointer">
                    <div class="bg-emerald-200 p-3 rounded-full flex-shrink-0">
                        <i data-lucide="check-square" class="w-7 h-7 text-emerald-700"></i>
                    </div>
                    <div class="flex-1">
                        <p class="font-semibold text-emerald-800 text-lg">Tingkat Pengisian Kuesioner</p>
                        <div class="w-full bg-gray-200 rounded-full h-2.5 mt-2">
                            <div class="bg-emerald-600 h-2.5 rounded-full" style="width: {{ $questionnaireCompletionRate }}%"></div>
                        </div>
                        <p class="text-sm text-gray-700 mt-1"><span class="font-bold text-emerald-700">{{ $isiKuisioner }}</span> dari <span class="font-bold text-emerald-700">{{ $totalAlumni }}</span> alumni ({{ $questionnaireCompletionRate }}%)</p>
                    </div>
                </div>
            </div>
        </section>
    </div>


    {{-- Alumni Terbaru Table (Using Laravel Collection methods safely) --}}
    <section
        class="bg-white shadow-xl rounded-2xl p-6 lg:p-8 overflow-x-auto w-full animate-fade-in-up border border-green-200">
        <h2 class="text-2xl font-semibold text-green-800 mb-6 text-center select-none drop-shadow-md font-['Poppins']">Alumni Terbaru</h2>
        {{-- Pastikan $latestAlumni di pass dari Controller dan merupakan Collection --}}
        @if(isset($latestAlumni) && $latestAlumni->isNotEmpty())
            <div class="rounded-lg overflow-hidden border border-gray-200">
                <table class="w-full text-sm">
                    <thead class="bg-green-100 text-green-800 uppercase tracking-wide text-left select-none border-b border-green-200">
                        <tr>
                            <th class="py-3 px-5">Nama</th>
                            <th class="py-3 px-5 text-center">NIM</th>
                            <th class="py-3 px-5 text-center">Jurusan</th>
                            <th class="py-3 px-5 text-center">Fakultas</th>
                        </tr>
                    </thead>
                    <tbody class="text-gray-900 divide-y divide-gray-100">
                        @foreach($latestAlumni as $alumni)
                            <tr
                                class="hover:bg-green-50 transition-colors duration-200 cursor-pointer select-text">
                                <td class="py-3 px-5 font-medium">{{ $alumni->nama }}</td>
                                <td class="py-3 px-5 text-center">{{ $alumni->nim }}</td>
                                <td class="py-3 px-5 text-center">{{ $alumni->jurusan }}</td>
                                <td class="py-3 px-5 text-center">{{ $alumni->fakultas }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @else
            <div class="text-center py-8 bg-gray-50 rounded-lg">
                <img src="https://www.svgrepo.com/show/472628/no-data.svg" alt="No Data" class="w-32 h-32 mx-auto mb-4 opacity-60">
                <p class="text-lg text-gray-500 italic">Belum ada data alumni terbaru yang tersedia.</p>
            </div>
                        <section
                class="bg-gradient-to-r from-green-100 via-green-50 to-green-100 shadow-xl rounded-2xl overflow-hidden w-full flex flex-col md:flex-row items-center select-none border border-green-200 mt-10">
                <img src="https://fokuskampus.com/wp-content/uploads/2023/04/se.410-Foto-kampus-dan-Biaya-Kuliah-2023-di-Universitas-Islam-Negeri-Raden-Mas-Said-Surakarta.jpg"
                    alt="UIN Raden Mas Said Surakarta"
                    class="w-full md:w-1/2 h-56 md:h-auto object-cover rounded-t-2xl md:rounded-l-2xl md:rounded-tr-none shadow-lg">
                <div class="p-6 lg:p-8 text-green-900 max-w-xl">
                    <h2 class="text-2xl lg:text-3xl font-extrabold mb-3 drop-shadow-md font-['Poppins']">UIN Raden Mas Said Surakarta</h2>
                    <p class="text-sm leading-relaxed font-medium tracking-wide">
                        UIN Raden Mas Said Surakarta adalah kampus Islam unggulan yang terakreditasi nasional. Memadukan ilmu pengetahuan dan nilai-nilai spiritual, UIN membekali mahasiswa untuk siap berdaya saing secara global dengan tetap menjunjung tinggi nilai keislaman dan integritas.
                    </p>
                </div>
            </section>
        @endif
    </section>

    {{-- Optional: Additional Insights/CTA Card --}}
    <section class="bg-gradient-to-br from-blue-100 to-blue-200 text-blue-900 rounded-2xl shadow-xl p-8 mt-10 flex flex-col md:flex-row items-center gap-6 animate-fade-in border border-blue-300">
        <div class="md:w-2/3">
            <h2 class="text-3xl font-extrabold mb-3 font-['Poppins']">Perlu Data Lebih Detail?</h2>
            <p class="text-lg leading-relaxed">
                Jelajahi halaman Manajemen Alumni untuk melihat daftar lengkap, filter, dan unduh data secara spesifik.
            </p>
            <a href="{{ route('admin.alumni') }}" class="mt-5 inline-flex items-center px-6 py-3 bg-blue-600 text-white font-semibold rounded-lg shadow-md hover:bg-blue-700 transition transform hover:-translate-y-1">
                <i data-lucide="external-link" class="w-5 h-5 mr-2"></i> Kunjungi Manajemen Alumni
            </a>
        </div>
        <div class="md:w-1/3 flex justify-center items-center">
            <iconify-icon icon="mdi:database-search" class="text-blue-700 opacity-70" width="120" height="120"></iconify-icon>
        </div>
    </section>

@endsection

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // --- PHP/Blade Variables to JS ---
            // Pastikan variabel ini tersedia dari Controller/View Composer
            const totalAlumni = parseInt("{{ $totalAlumni ?? 0 }}") || 0;
            const bekerja = parseInt("{{ $bekerja ?? 0 }}") || 0;
            const belumBekerja = parseInt("{{ $belumBekerja ?? 0 }}") || 0;
            const isiKuisioner = parseInt("{{ $isiKuisioner ?? 0 }}") || 0;

            // --- Chart.js Configuration ---
            Chart.register(ChartDataLabels); // Register plugin

            const ctx = document.getElementById('statusChart');
            if (ctx) {
                new Chart(ctx, {
                    type: 'doughnut',
                    data: {
                        labels: ['Total Alumni', 'Sudah Bekerja', 'Belum Bekerja', 'Kuesioner Terisi'],
                        datasets: [{
                            data: [totalAlumni, bekerja, belumBekerja, isiKuisioner],
                            backgroundColor: [
                                '#10B981', // green-500 for Total Alumni
                                '#3B82F6', // blue-500 for Sudah Bekerja
                                '#EF4444', // red-500 for Belum Bekerja
                                '#F59E0B' // amber-500 for Kuesioner Terisi
                            ],
                            borderColor: '#ffffff',
                            borderWidth: 2,
                            hoverOffset: 12
                        }]
                    },
                    options: {
                        plugins: {
                            legend: {
                                position: 'bottom',
                                labels: {
                                    color: '#065f46',
                                    font: {
                                        size: 13,
                                        weight: '600',
                                        family: 'Inter'
                                    },
                                    padding: 20,
                                }
                            },
                            tooltip: {
                                bodyFont: {
                                    family: 'Inter',
                                    size: 13
                                },
                                titleFont: {
                                    family: 'Inter',
                                    weight: 'bold',
                                    size: 14
                                },
                                callbacks: {
                                    label: function(context) {
                                        let label = context.label || '';
                                        const rawValue = context.raw;
                                        const totalAlumniValue = context.dataset.data[0];

                                        if (label) {
                                            label += ': ';
                                        }

                                        if (label === 'Total Alumni: ') {
                                            return label + rawValue + ' alumni';
                                        }

                                        // Calculate percentage relative to Total Alumni
                                        if (totalAlumniValue > 0) {
                                            const percentage = ((rawValue / totalAlumniValue) * 100).toFixed(1) + '%';
                                            return label + rawValue + ' alumni (' + percentage + ')';
                                        }
                                        return label + rawValue + ' alumni';
                                    }
                                }
                            },
                            datalabels: { // Configure the datalabels plugin
                                color: '#fff',
                                font: {
                                    weight: 'bold',
                                    size: 14,
                                    family: 'Inter'
                                },
                                formatter: (value, context) => {
                                    if (value === 0) return '';

                                    const label = context.label;
                                    const totalAlumniValue = context.dataset.data[0];

                                    // Only show percentage for Bekerja/Belum Bekerja/Kuesioner
                                    if (label === 'Sudah Bekerja' || label === 'Belum Bekerja' || label === 'Kuesioner Terisi') {
                                        if (totalAlumniValue > 0) {
                                            const percentage = ((value / totalAlumniValue) * 100).toFixed(0);
                                            return percentage + '%';
                                        }
                                    }
                                    // For Total Alumni, just show the count
                                    return value;
                                },
                                textShadowColor: 'rgba(0, 0, 0, 0.5)',
                                textShadowBlur: 6
                            }
                        },
                        responsive: true,
                        maintainAspectRatio: false,
                        animation: {
                            duration: 900
                        }
                    }
                });
            } else {
                console.error("Chart canvas element not found!");
            }
        });
    </script>
@endpush
