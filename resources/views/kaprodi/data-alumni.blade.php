@extends('layouts.kaprodi') {{-- Menggunakan template utama --}}

@section('title', 'Data Alumni')

@section('content')

    {{-- Header/Title Section Responsif --}}
    <header class="mb-6 p-4 bg-white rounded-xl shadow-md flex flex-col md:flex-row md:items-center justify-between gap-4 animate-fade-in">
        <div class="flex items-center flex-grow">
            {{-- TOMBOL TOGGLE SIDEBAR (Hanya muncul di Mobile) --}}
            <button id="sidebarToggle" class="mr-3 text-green-700 md:hidden p-2 rounded-lg hover:bg-green-100 transition duration-150" aria-label="Toggle Menu">
                <i data-lucide="menu" class="w-5 h-5"></i>
            </button>
            <div>
                <h1 class="text-xl lg:text-2xl font-extrabold text-blue-800 tracking-tight font-['Poppins'] flex items-center">
                    <i data-lucide="users-round" class="hidden sm:inline-block w-6 h-6 mr-2 text-blue-600"></i> Data Alumni
                </h1>
                @php
                    $prodiName = $prodi ?? (Auth::user()->prodi ?? 'Program Studi');
                @endphp
                <p class="text-gray-600 text-xs md:text-sm mt-1">Status kuesioner Prodi: <span class="font-bold text-blue-700">{{ $prodiName }}</span></p>
            </div>
        </div>
        {{-- Metadata Ringkas di Header --}}
        <div class="hidden sm:flex flex-col items-end text-right">
            <p class="text-[10px] font-bold text-gray-400 uppercase tracking-widest">Total Terfilter</p>
            <p class="text-lg font-bold text-blue-800">{{ $alumniData->total() ?? 0 }} Alumni</p>
        </div>
    </header>

    <section class="bg-white p-4 md:p-6 rounded-2xl shadow-xl border border-gray-200">

        {{-- Filter dan Pencarian Responsif --}}
        <form action="{{ route('kaprodi.alumni') ?? '#' }}" method="GET" class="mb-6 grid grid-cols-1 md:grid-cols-3 gap-3 bg-gray-50 p-4 rounded-xl border border-gray-200">
            <div class="md:col-span-2 relative">
                <input type="search" name="cari" id="cari" placeholder="Cari Nama, NIM..."
                    value="{{ request('cari') }}"
                    class="w-full pl-10 pr-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 outline-none transition text-sm">
                <i data-lucide="search" class="w-4 h-4 absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400"></i>
            </div>

            <div class="flex gap-2">
                <select name="tahun" id="tahun"
                    class="flex-1 px-3 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 text-sm bg-white outline-none">
                    <option value="">Semua Tahun Lulus</option>
                    @if(isset($availableYears))
                        @foreach ($availableYears as $year)
                            <option value="{{ $year }}" {{ request('tahun') == $year ? 'selected' : '' }}>
                                Thn {{ $year }}
                            </option>
                        @endforeach
                    @endif
                </select>

                <button type="submit" class="px-5 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition shadow-md flex items-center justify-center font-bold text-sm">
                    Filter
                </button>
            </div>
        </form>

        {{-- Info Hasil Pencarian --}}
        <div class="mb-4 px-1 flex justify-between items-center">
            <div class="text-xs md:text-sm text-gray-500 italic">
                @if(isset($alumniData) && $alumniData->total() > 0)
                    Menampilkan {{ $alumniData->firstItem() }}-{{ $alumniData->lastItem() }} dari {{ $alumniData->total() }} data.
                @else
                    Tidak ada alumni ditemukan.
                @endif
            </div>
        </div>

        {{-- Container Tabel/Card --}}
        <div class="border border-gray-200 rounded-xl overflow-hidden shadow-sm">

            {{-- DESKTOP VIEW (Laptop/PC) --}}
            <div class="hidden md:block overflow-x-auto">
                <table class="min-w-full text-sm divide-y divide-gray-200">
                    <thead class="bg-gray-800 text-white uppercase text-[11px] font-bold tracking-wider">
                        <tr>
                            <th class="py-4 px-5 text-center">Profil</th>
                            <th class="py-4 px-5">NIM / Nama</th>
                            <th class="py-4 px-5 text-center">Masuk / Lulus</th>
                            <th class="py-4 px-5 text-center">Status Kerja</th>
                            <th class="py-4 px-5 text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-100">
                        @forelse ($alumniData as $alumni)
                            <tr class="hover:bg-blue-50/50 transition">
                                <td class="py-3 px-5 text-center">
                                    <img src="{{ $alumni->foto_path ? asset('storage/' . $alumni->foto_path) : 'https://placehold.co/40x40/065f46/ffffff?text=U' }}"
                                        class="w-10 h-10 object-cover rounded-full mx-auto border border-gray-200 shadow-sm" alt="Foto">
                                </td>
                                <td class="py-3 px-5">
                                    <div class="font-bold text-gray-900">{{ $alumni->nama }}</div>
                                    <div class="text-xs text-gray-500">{{ $alumni->nim }}</div>
                                </td>
                                <td class="py-3 px-5 text-center">
                                    <span class="text-gray-500">{{ $alumni->tahun_masuk ?? '-' }}</span>
                                    <i data-lucide="arrow-right" class="inline w-3 h-3 mx-1 text-gray-300"></i>
                                    <span class="font-bold text-green-700">{{ $alumni->tahun_keluar }}</span>
                                </td>
                                <td class="py-3 px-5 text-center">
                                    @if(($alumni->sudah_bekerja ?? 0) == 1)
                                        <span class="px-2 py-1 rounded-md text-[10px] font-bold bg-green-100 text-green-700 border border-green-200 uppercase">Bekerja</span>
                                    @else
                                        <span class="px-2 py-1 rounded-md text-[10px] font-bold bg-red-100 text-red-700 border border-red-200 uppercase">Belum</span>
                                    @endif
                                </td>
                                <td class="py-3 px-5 text-center">
                                    @if($alumni->has_filled_questionnaire ?? false)
                                        <a href="{{ route('kaprodi.alumni.detail', ['alumni_id' => $alumni->user_id]) ?? '#' }}"
                                           class="inline-flex items-center text-blue-600 hover:text-blue-800 font-bold group">
                                            Detail <i data-lucide="chevron-right" class="w-4 h-4 ml-0.5 group-hover:translate-x-0.5 transition-transform"></i>
                                        </a>
                                    @else
                                        <span class="text-gray-400 italic text-xs italic">Kosong</span>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            {{-- State ditangani di bagian bawah --}}
                        @endforelse
                    </tbody>
                </table>
            </div>

            {{-- MOBILE VIEW (Smartphone) --}}
            <div class="md:hidden divide-y divide-gray-100">
                @forelse ($alumniData as $alumni)
                    <div class="p-4 bg-white space-y-3">
                        <div class="flex items-center gap-3">
                            <img src="{{ $alumni->foto_path ? asset('storage/' . $alumni->foto_path) : 'https://placehold.co/40x40/065f46/ffffff?text=U' }}"
                                 class="w-12 h-12 rounded-xl object-cover border border-gray-100" alt="Foto">
                            <div class="flex-1 min-w-0">
                                <h4 class="font-bold text-gray-900 truncate text-sm leading-tight">{{ $alumni->nama }}</h4>
                                <p class="text-xs text-gray-500 font-medium">{{ $alumni->nim }}</p>
                            </div>
                            <div class="text-right">
                                <p class="text-[10px] font-bold text-gray-400 uppercase">Lulus</p>
                                <p class="text-sm font-bold text-green-700">{{ $alumni->tahun_keluar }}</p>
                            </div>
                        </div>
                        <div class="flex items-center justify-between bg-gray-50 p-2 rounded-lg">
                            <div class="text-[10px] font-bold uppercase {{ ($alumni->sudah_bekerja ?? 0) == 1 ? 'text-green-600' : 'text-red-500' }}">
                                {{ ($alumni->sudah_bekerja ?? 0) == 1 ? 'Bekerja / Studi' : 'Belum Bekerja' }}
                            </div>
                            @if($alumni->has_filled_questionnaire ?? false)
                                <a href="{{ route('kaprodi.alumni.detail', ['alumni_id' => $alumni->user_id]) ?? '#' }}"
                                   class="bg-blue-600 text-white px-3 py-1 rounded-md text-[10px] font-bold flex items-center gap-1 shadow-sm">
                                   Buka Detail <i data-lucide="arrow-right" class="w-3 h-3"></i>
                                </a>
                            @else
                                <span class="text-[10px] text-gray-400 italic">Kuesioner Belum Diisi</span>
                            @endif
                        </div>
                    </div>
                @empty
                    <div class="p-10 text-center bg-gray-50">
                        <i data-lucide="search-x" class="w-10 h-10 mx-auto mb-3 text-gray-300"></i>
                        <p class="text-sm text-gray-500">Data alumni tidak ditemukan.</p>
                    </div>
                @endforelse
            </div>
        </div>

        {{-- Pagination --}}
        <div class="mt-6">
            @if(isset($alumniData) && method_exists($alumniData, 'links'))
                <div class="px-2">
                    {{ $alumniData->links() }}
                </div>
            @endif
        </div>

    </section>
@endsection
