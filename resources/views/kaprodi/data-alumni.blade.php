@extends('layouts.kaprodi') {{-- Menggunakan template utama --}}

@section('title', 'Data Alumni')

@section('content')

    {{-- Header/Title Section --}}
    <header class="mb-6 p-4 bg-white rounded-xl shadow-md flex items-center justify-between">
        {{-- TOMBOL TOGGLE SIDEBAR (Mobile) --}}
        <button id="sidebarToggle" class="mr-3 text-green-700 md:hidden p-2 rounded hover:bg-green-100 transition duration-150" aria-label="Toggle Menu">
            <i data-lucide="menu" class="w-5 h-5"></i>
        </button>
        <div class="flex-grow">
            <h1 class="text-xl lg:text-2xl font-extrabold text-blue-800 tracking-tight font-['Poppins']">
                <i data-lucide="users-round" class="inline-block w-6 h-6 mr-2 text-blue-600"></i> Data Alumni Program Studi
            </h1>
            @php
                // Prodiname diambil dari $prodi yang di-pass dari controller
                $prodiName = $prodi ?? (Auth::user()->prodi ?? 'Program Studi Tidak Ditemukan');
            @endphp
            <p class="text-gray-600 text-sm mt-1">Mengelola data mentah dan status kuesioner untuk Prodi: {{ $prodiName }}</p>
        </div>
    </header>

    <section class="bg-white p-6 rounded-2xl shadow-xl border border-gray-200">

        {{-- Filter dan Pencarian --}}
        <form action="{{ route('kaprodi.alumni') ?? '#' }}" method="GET" class="mb-6 grid grid-cols-1 md:grid-cols-3 gap-4 bg-gray-50 p-4 rounded-xl border">

            <div class="md:col-span-2">
                <label for="cari" class="sr-only">Cari Alumni</label>
                <div class="relative">
                    <input type="search" name="cari" id="cari" placeholder="Cari Nama, NIM, atau Prodi..."
                        value="{{ request('cari') }}"
                        class="w-full pl-10 pr-4 py-2.5 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500 transition duration-150 shadow-sm">
                    <i data-lucide="search" class="w-5 h-5 absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400"></i>
                </div>
            </div>

            <div>
                <label for="tahun" class="sr-only">Filter Tahun Lulus</label>
                <div class="flex gap-2">
                    <select name="tahun" id="tahun"
                        class="flex-1 px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-green-500 focus:border-green-500 shadow-sm">
                        <option value="">Semua Tahun Lulus</option>
                        @if(isset($availableYears))
                            @foreach ($availableYears as $year)
                                <option value="{{ $year }}" {{ request('tahun') == $year ? 'selected' : '' }}>
                                    Tahun {{ $year }}
                                </option>
                            @endforeach
                        @endif
                    </select>

                    <button type="submit"
                        class="px-4 py-2.5 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition shadow-md flex items-center gap-1">
                        <i data-lucide="filter" class="w-5 h-5"></i> Filter
                    </button>
                </div>
            </div>
        </form>

        {{-- Info Hasil Pencarian --}}
        <div class="mb-4 text-sm text-gray-600">
            @if(isset($alumniData) && method_exists($alumniData, 'total'))
                @php
                    $total = $alumniData->total();
                    $first = $alumniData->firstItem() ?? 0;
                    $last = $alumniData->lastItem() ?? 0;
                @endphp

                @if ($total > 1)
                    Menampilkan {{ $first }} hingga {{ $last }} dari total {{ $total }} alumni.
                @elseif ($total === 1)
                    Menampilkan 1 dari total 1 alumni.
                @else
                    Tidak ada alumni yang ditemukan.
                @endif

                @if(request('cari') && $total > 0)
                    <span class="font-semibold ml-2 text-green-700">({{ $total }} hasil untuk "{{ request('cari') }}")</span>
                @endif
            @else
                <span class="text-red-500 font-semibold">Error: Data alumni tidak terinisialisasi dengan benar.</span>
            @endif
        </div>

        {{-- Tabel Data Alumni --}}
        <div class="overflow-x-auto rounded-lg border border-gray-200 shadow-lg">
            <table class="min-w-full text-sm divide-y divide-gray-200">
                <thead class="bg-gray-800 text-white uppercase tracking-wider text-left">
                    <tr>
                        <th class="py-3 px-5 text-center">Foto</th>
                        <th class="py-3 px-5">NIM</th>
                        <th class="py-3 px-5">Nama Alumni</th>
                        <th class="py-3 px-5 text-center">Tahun Masuk</th>
                        <th class="py-3 px-5 text-center">Tahun Lulus</th>
                        <th class="py-3 px-5 text-center">Status Kerja</th>
                        <th class="py-3 px-5 text-center">Detail Kuesioner</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-100 text-gray-700">

                    @if(isset($alumniData) && $alumniData->count())
                        @foreach ($alumniData as $alumni)
                            <tr class="table-row-hover">
                                {{-- Kolom Foto --}}
                                <td class="py-3 px-5 text-center">
                                    @php
                                        // Asumsi asset helper sudah menangani path storage
                                        $path = $alumni->foto_path ? asset('storage/' . $alumni->foto_path) : null;
                                        $photoUrl = $path ?? 'https://placehold.co/40x40/065f46/ffffff?text=U';
                                    @endphp
                                    <img src="{{ $photoUrl }}"
                                        onerror="this.onerror=null; this.src='https://placehold.co/40x40/065f46/ffffff?text=U';"
                                        alt="Foto Alumni"
                                        class="w-10 h-10 object-cover rounded-full mx-auto shadow-sm border border-gray-200">
                                </td>
                                <td class="py-3 px-5 font-medium text-gray-900">{{ $alumni->nim }}</td>
                                <td class="py-3 px-5">{{ $alumni->nama }}</td>
                                <td class="py-3 px-5 text-center">{{ $alumni->tahun_masuk ?? '-' }}</td>

                                {{-- TAHUN LULUS: Menggunakan properti tahun_keluar --}}
                                <td class="py-3 px-5 text-center text-green-700 font-medium">
                                    {{ $alumni->tahun_keluar }}
                                </td>

                                <td class="py-3 px-5 text-center">
                                    {{-- Status Kerja Badge --}}
                                    @if(($alumni->sudah_bekerja ?? 0) == 1)
                                        <span class="inline-flex items-center gap-1.5 py-1 px-3 rounded-full text-xs font-medium bg-green-100 text-green-800 border border-green-300">
                                            Bekerja/Studi
                                        </span>
                                    @else
                                        <span class="inline-flex items-center gap-1.5 py-1 px-3 rounded-full text-xs font-medium bg-red-100 text-red-800 border border-red-300">
                                            Belum Bekerja
                                        </span>
                                    @endif
                                </td>
                                <td class="py-3 px-5 text-center">
                                    {{-- Detail Kuesioner Link --}}
                                    @if($alumni->has_filled_questionnaire ?? false)
                                        <a href="{{ route('kaprodi.alumni.detail', ['alumni_id' => $alumni->user_id]) ?? '#' }}"
                                            class="text-indigo-600 hover:text-indigo-800 font-semibold transition duration-150 flex items-center justify-center group">
                                            Lihat Detail
                                            <i data-lucide="arrow-right" class="w-4 h-4 ml-1 transition group-hover:translate-x-0.5"></i>
                                        </a>
                                    @else
                                        <span class="text-gray-400 italic">Belum Mengisi</span>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    @else
                        <tr>
                            <td colspan="7" class="py-10 text-center text-lg text-gray-500">
                                <i data-lucide="inbox" class="w-10 h-10 mx-auto mb-3"></i>
                                Data alumni Program Studi {{ $prodiName }} tidak ditemukan.
                            </td>
                        </tr>
                    @endif
                </tbody>
            </table>
        </div>

        {{-- Pagination --}}
        <div class="mt-6">
            @if(isset($alumniData) && method_exists($alumniData, 'links'))
                {{ $alumniData->links() }}
            @endif
        </div>

    </section>
@endsection

@section('scripts')
{{-- Tidak ada script spesifik selain yang ada di template utama --}}
@endsection
