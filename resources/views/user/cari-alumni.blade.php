@extends('layouts.user')

@section('title', 'Cari Alumni - UIN Raden Mas Said')

@section('content')
<div class="py-10 px-4 sm:px-6 lg:px-8">
    <div class="max-w-7xl mx-auto bg-white p-6 md:p-10 rounded-2xl shadow-2xl border border-gray-200">

        <div class="mb-8 text-center md:text-left">
            <a href="{{ route('user.dashboard') }}"
                class="inline-flex items-center px-6 py-2 rounded-full bg-gray-200 text-gray-700 font-semibold hover:bg-gray-300 transition duration-300">
                <span class="iconify mr-2" data-icon="mdi:arrow-left" style="font-size: 20px;"></span>
                Kembali ke Dashboard
            </a>
        </div>

        <h2 class="text-3xl sm:text-4xl font-extrabold text-green-800 mb-10 text-center font-['Poppins'] flex items-center justify-center gap-3">
            <span class="iconify w-9 h-9 text-green-600" data-icon="mdi:magnify"></span>
            Pencarian Alumni
        </h2>

        {{-- Filter and Search Form --}}
        <form method="GET" action="{{ route('user.cari-alumni') }}" class="space-y-6 mb-12 p-6 bg-green-50 rounded-xl shadow-inner border border-green-200">

            {{-- Bar Pencarian Utama --}}
            <div class="relative">
                <input type="text" name="query" value="{{ request('query') }}"
                    placeholder="Cari nama, NIM, jurusan, atau fakultas..."
                    class="w-full pl-5 pr-16 py-3 rounded-xl border-2 border-green-300 shadow-lg focus:ring-green-500 focus:border-green-500 text-gray-800 placeholder-gray-400 text-lg transition duration-300">
                <button type="submit"
                    class="absolute top-1/2 right-4 -translate-y-1/2 text-green-600 hover:text-green-800 transition duration-300 p-1">
                    <span class="iconify w-7 h-7" data-icon="mdi:magnify"></span>
                </button>
            </div>

            {{-- Filter Lanjutan (Dropdowns) --}}
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">

                {{-- Filter Fakultas --}}
                <select name="fakultas" onchange="this.form.submit()"
                    class="border border-gray-300 rounded-lg px-4 py-3 text-gray-700 shadow-sm hover:shadow-md focus:ring-2 focus:ring-emerald-400 transition-all duration-300">
                    <option value="" {{ request('fakultas') == '' ? 'selected' : '' }}>Semua Fakultas</option>
                    <option value="Fakultas Syariah" {{ request('fakultas') == 'Fakultas Syariah' ? 'selected' : '' }}>Fakultas Syariah</option>
                    <option value="Fakultas Ilmu Tarbiyah" {{ request('fakultas') == 'Fakultas Ilmu Tarbiyah' ? 'selected' : '' }}>Fakultas Ilmu Tarbiyah</option>
                    <option value="Fakultas Ekonomi dan Bisnis Islam" {{ request('fakultas') == 'Fakultas Ekonomi dan Bisnis Islam' ? 'selected' : '' }}>Fakultas Ekonomi dan Bisnis Islam</option>
                    <option value="Fakultas Ushuluddin dan Dakwah" {{ request('fakultas') == 'Fakultas Ushuluddin dan Dakwah' ? 'selected' : '' }}>Fakultas Ushuluddin dan Dakwah</option>
                </select>

                {{-- Filter Status Kerja --}}
                <select name="status" onchange="this.form.submit()"
                    class="border border-gray-300 rounded-lg px-4 py-3 text-gray-700 shadow-sm hover:shadow-md focus:ring-2 focus:ring-emerald-400 transition-all duration-300">
                    <option value="" {{ request('status') === null || request('status') === '' ? 'selected' : '' }}>Semua Status Kerja</option>
                    <option value="1" {{ request('status') === '1' ? 'selected' : '' }}>Sudah Bekerja</option>
                    <option value="0" {{ request('status') === '0' ? 'selected' : '' }}>Belum Bekerja</option>
                </select>

                {{-- Filter Tahun Masuk --}}
                <input type="number" name="tahun_masuk"
                        value="{{ request('tahun_masuk') }}"
                        placeholder="Filter Tahun Masuk"
                        onchange="this.form.submit()"
                        min="1950" max="{{ date('Y') }}"
                        class="border border-gray-300 rounded-lg px-4 py-3 text-gray-700 shadow-sm hover:shadow-md focus:ring-2 focus:ring-emerald-400 transition-all duration-300">

                {{-- Filter Tahun Lulus --}}
                <input type="number" name="tahun_keluar"
                        value="{{ request('tahun_keluar') }}"
                        placeholder="Filter Tahun Lulus"
                        onchange="this.form.submit()"
                        min="1950" max="{{ date('Y') + 5 }}"
                        class="border border-gray-300 rounded-lg px-4 py-3 text-gray-700 shadow-sm hover:shadow-md focus:ring-2 focus:ring-emerald-400 transition-all duration-300">

                <noscript>
                    <button type="submit" class="bg-green-600 text-white p-3 rounded-lg w-full">Terapkan Filter</button>
                </noscript>
            </div>
        </form>

        {{-- Result Count Display --}}
        @if(isset($alumni) && $alumni->count() > 0)
        <div class="mb-10 flex justify-center">
            <div class="flex items-center gap-4 bg-emerald-50 border border-emerald-300 px-8 py-4 rounded-xl shadow-lg">
                <span class="iconify text-emerald-600 w-8 h-8" data-icon="mdi:account-multiple"></span>
                <p class="text-xl text-emerald-700 font-semibold">Alumni Ditemukan: <span class="font-bold">{{ $alumni->count() }} orang</span></p>
            </div>
        </div>

        {{-- Alumni Cards Grid --}}
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6 md:gap-8">
            @foreach($alumni as $a)
            <div class="relative group bg-white border border-gray-200 rounded-3xl shadow-lg hover:shadow-2xl transform hover:-translate-y-1 transition-all duration-300 overflow-hidden">

                <div class="absolute top-0 right-0 bg-emerald-600 text-white px-4 py-1.5 text-sm font-semibold rounded-bl-2xl shadow-md z-10">
                    {{ $a->sudah_bekerja ? 'Sudah Bekerja' : 'Belum Bekerja' }}
                </div>

                {{-- Profile Image Placeholder/Container --}}
                <div class="w-full h-24 bg-green-50 flex items-center justify-center p-2">
                     @if($a->foto_path)
                         {{-- Menggunakan Storage::url untuk memanggil gambar yang diupload --}}
                         <img src="{{ \Illuminate\Support\Facades\Storage::url($a->foto_path) }}"
                            alt="Foto {{ $a->nama }}"
                            onerror="this.onerror=null;this.src='https://placehold.co/80x80/d1d5db/6b7280?text=P';"
                            class="w-20 h-20 rounded-full object-cover border-4 border-white shadow-md transition-transform group-hover:scale-105">
                     @else
                         <span class="w-20 h-20 rounded-full bg-gray-300 flex items-center justify-center text-xl font-bold text-gray-700 border-4 border-white shadow-md">
                            {{ substr($a->nama, 0, 1) }}
                         </span>
                     @endif
                </div>

                {{-- Card Content --}}
                <div class="p-6 pt-2 space-y-2 text-center">
                    <h3 class="text-xl font-bold text-green-800 truncate leading-snug">{{ $a->nama }}</h3>

                    <p class="text-gray-600 text-sm">
                        <span class="font-bold text-gray-700">NIM:</span> {{ $a->nim }}
                    </p>

                    <p class="text-gray-600 text-sm border-t border-gray-100 pt-2">
                         <span class="font-bold text-green-700">Masuk:</span> {{ $a->tahun_masuk ?? '-' }} |
                         <span class="font-bold text-green-700">Lulus:</span> {{ $a->tahun_keluar ?? '-' }}
                    </p>

                    <p class="text-gray-600 text-sm">
                        <span class="font-bold">Jurusan:</span> {{ $a->jurusan }}
                    </p>
                    <p class="text-gray-600 text-xs">
                        <span class="font-bold">Fakultas:</span> {{ $a->fakultas }}
                    </p>

                    @if($a->sudah_bekerja && $a->tempat_bekerja)
                    <div class="text-sm mt-3 pt-3 border-t border-gray-100">
                         <p class="font-bold text-blue-600">Bekerja di:</p>
                         <p class="text-gray-700 truncate" title="{{ $a->tempat_bekerja }}">{{ $a->tempat_bekerja }}</p>
                    </div>
                    @endif

                </div>
            </div>
            @endforeach
        </div>
        @else
        {{-- No Results --}}
        <div class="text-center mt-20 p-8 bg-gray-50 rounded-xl shadow-lg border border-gray-200">
            <img src="https://www.svgrepo.com/show/508699/search-not-found.svg" alt="Not Found" class="w-64 mx-auto mb-8 opacity-80">
            <p class="text-2xl text-gray-700 font-semibold leading-relaxed">
                Maaf, alumni tidak ditemukan.
            </p>
            <p class="text-gray-500 mt-4 text-lg">Coba gunakan kata kunci lain atau sesuaikan filter Anda.</p>
        </div>
        @endif
    </div>
</div>
@endsection
