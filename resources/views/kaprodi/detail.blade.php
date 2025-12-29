@extends('layouts.kaprodi') {{-- Menggunakan template utama --}}

@section('title', 'Detail Kuesioner Alumni')

@section('content')

    {{-- Header/Title Section Responsif --}}
    <header class="mb-6 p-4 bg-white rounded-xl shadow-md flex flex-col md:flex-row md:items-center justify-between gap-4 animate-fade-in">
        <div class="flex items-center flex-grow">
            {{-- TOMBOL TOGGLE SIDEBAR (Mobile) --}}
            <button id="sidebarToggle" class="mr-3 text-green-700 md:hidden p-2 rounded-lg hover:bg-green-100 transition duration-150" aria-label="Toggle Menu">
                <i data-lucide="menu" class="w-5 h-5"></i>
            </button>
            <div>
                <h1 class="text-xl lg:text-2xl font-extrabold text-indigo-800 tracking-tight font-['Poppins']">
                    Detail Kuesioner Alumni
                </h1>
                <p class="text-gray-600 text-xs md:text-sm mt-1">Review detail jawaban kuesioner dari alumni secara mendalam.</p>
            </div>
        </div>
    </header>

    <div class="max-w-7xl mx-auto w-full space-y-6">

        {{-- Tombol Kembali Responsif --}}
        <div class="flex">
            <a href="{{ route('kaprodi.alumni') ?? '#' }}" class="w-full md:w-auto inline-flex items-center justify-center px-4 py-2.5 bg-white border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 transition duration-150 text-sm font-bold shadow-sm">
                <i data-lucide="arrow-left" class="w-4 h-4 mr-2"></i> Kembali ke Daftar Alumni
            </a>
        </div>

        @php
            $alumni = $alumni ?? null;
            $kuesioner = $kuesioner ?? null;
            $tanggalMengisi = $kuesioner->updated_at ?? ($alumni->updated_at ?? null);
            $tanggalMengisiFormatted = ($tanggalMengisi instanceof \Carbon\Carbon)
                ? $tanggalMengisi->translatedFormat('d F Y, H:i') . ' WIB'
                : 'Tanggal tidak tersedia';

            // Utility Tailwind Classes
            $cardBase = "bg-white rounded-2xl shadow-lg border border-gray-200 overflow-hidden animate-fade-in";
            $cardHeader = "px-6 py-4 border-b border-gray-100 flex items-center gap-3";
        @endphp

        @if ($alumni && $kuesioner)
            {{-- Bagian 1: Informasi Dasar Alumni --}}
            <section class="{{ $cardBase }}">
                <div class="{{ $cardHeader }} bg-green-50/50">
                    <i data-lucide="user-check" class="w-5 h-5 text-green-600"></i>
                    <h2 class="text-lg font-bold text-gray-800">Data Dasar Responden</h2>
                </div>
                <div class="p-6 grid grid-cols-1 md:grid-cols-2 gap-y-4 gap-x-8">
                    <div class="flex flex-col sm:flex-row sm:justify-between border-b border-dashed border-gray-200 pb-2">
                        <span class="text-xs font-bold text-gray-400 uppercase tracking-wider">Nama Alumni</span>
                        <span class="font-bold text-gray-900">{{ $alumni->nama ?? '-' }}</span>
                    </div>
                    <div class="flex flex-col sm:flex-row sm:justify-between border-b border-dashed border-gray-200 pb-2">
                        <span class="text-xs font-bold text-gray-400 uppercase tracking-wider">NIM</span>
                        <span class="font-mono font-bold text-indigo-600">{{ $alumni->nim ?? '-' }}</span>
                    </div>
                    <div class="flex flex-col sm:flex-row sm:justify-between border-b border-dashed border-gray-200 pb-2">
                        <span class="text-xs font-bold text-gray-400 uppercase tracking-wider">Program Studi</span>
                        <span class="font-semibold text-gray-700 text-right">{{ $alumni->jurusan ?? '-' }}</span>
                    </div>
                    <div class="flex flex-col sm:flex-row sm:justify-between border-b border-dashed border-gray-200 pb-2">
                        <span class="text-xs font-bold text-gray-400 uppercase tracking-wider">Waktu Submit</span>
                        <span class="font-semibold text-green-600">{{ $tanggalMengisiFormatted }}</span>
                    </div>
                </div>
            </section>

            {{-- Bagian 2: Informasi Pekerjaan --}}
            <section class="{{ $cardBase }}">
                <div class="{{ $cardHeader }} bg-blue-50/50">
                    <i data-lucide="briefcase" class="w-5 h-5 text-blue-600"></i>
                    <h2 class="text-lg font-bold text-gray-800">Informasi Pekerjaan</h2>
                </div>
                <div class="p-6 space-y-6">
                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
                        {{-- Status Pekerjaan --}}
                        <div class="p-4 rounded-xl bg-blue-50 border border-blue-100 shadow-sm">
                            <p class="text-[10px] font-bold text-blue-500 uppercase mb-1">Status Pekerjaan</p>
                            <p class="text-base font-extrabold text-gray-900 leading-tight">{{ $kuesioner->status_pekerjaan ?? '-' }}</p>
                        </div>
                        {{-- Waktu Tunggu --}}
                        <div class="p-4 rounded-xl bg-gray-50 border border-gray-100 shadow-sm">
                            <p class="text-[10px] font-bold text-gray-400 uppercase mb-1">Waktu Tunggu</p>
                            <p class="text-base font-bold text-gray-800">{{ $kuesioner->waktu_tunggu ?? '-' }} <span class="text-xs font-normal">Bulan</span></p>
                        </div>
                        {{-- Jenis Tempat Kerja --}}
                        <div class="p-4 rounded-xl bg-gray-50 border border-gray-100 shadow-sm">
                            <p class="text-[10px] font-bold text-gray-400 uppercase mb-1">Jenis Tempat Kerja</p>
                            <p class="text-base font-bold text-gray-800">{{ $kuesioner->jenis_perusahaan ?? '-' }}</p>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 lg:grid-cols-3 gap-4">
                        <div class="lg:col-span-1 p-4 rounded-xl bg-gray-50 border border-gray-100 shadow-sm">
                            <p class="text-[10px] font-bold text-gray-400 uppercase mb-1">Nama Perusahaan</p>
                            <p class="text-base font-bold text-gray-800">{{ $kuesioner->nama_perusahaan ?? '-' }}</p>
                        </div>
                        <div class="lg:col-span-2 p-4 rounded-xl bg-gray-50 border border-gray-100 shadow-sm">
                            <p class="text-[10px] font-bold text-gray-400 uppercase mb-1">Alamat Perusahaan</p>
                            <p class="text-base font-bold text-gray-800">{{ $kuesioner->alamat_perusahaan ?? '-' }}</p>
                        </div>
                    </div>

                    {{-- Statistik Grid --}}
                    <div class="bg-gray-800 rounded-2xl p-6 text-white shadow-inner">
                        <p class="text-xs font-bold text-gray-400 uppercase mb-4 tracking-widest text-center">Rekapitulasi Pencarian Kerja</p>
                        <div class="grid grid-cols-3 gap-2">
                            <div class="text-center">
                                <p class="text-2xl md:text-3xl font-black text-blue-400">{{ $kuesioner->jumlah_lamaran ?? 0 }}</p>
                                <p class="text-[9px] md:text-xs text-gray-400 uppercase mt-1">Lamaran</p>
                            </div>
                            <div class="text-center border-x border-gray-700">
                                <p class="text-2xl md:text-3xl font-black text-green-400">{{ $kuesioner->jumlah_respon ?? 0 }}</p>
                                <p class="text-[9px] md:text-xs text-gray-400 uppercase mt-1">Respon</p>
                            </div>
                            <div class="text-center">
                                <p class="text-2xl md:text-3xl font-black text-yellow-400">{{ $kuesioner->jumlah_wawancara ?? 0 }}</p>
                                <p class="text-[9px] md:text-xs text-gray-400 uppercase mt-1">Wawancara</p>
                            </div>
                        </div>
                    </div>
                </div>
            </section>

            {{-- Bagian 3: Relevansi Pendidikan & Fasilitas --}}
            <section class="{{ $cardBase }}">
                <div class="{{ $cardHeader }} bg-yellow-50/50">
                    <i data-lucide="book-open-check" class="w-5 h-5 text-yellow-600"></i>
                    <h2 class="text-lg font-bold text-gray-800">Relevansi Pendidikan & Fasilitas</h2>
                </div>
                <div class="p-6 space-y-8">
                    {{-- Loop untuk Pendidikan dan Fasilitas --}}
                    @foreach(['pendidikan' => 'Pengalaman Pendidikan', 'fasilitas' => 'Fasilitas Kampus'] as $key => $title)
                    <div>
                        <h3 class="text-sm font-black text-gray-400 uppercase tracking-widest mb-4 border-l-4 border-yellow-400 pl-3">{{ $title }}</h3>
                        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-3">
                            @php $dataArray = $kuesioner->$key ?? []; @endphp
                            @forelse ($dataArray as $label => $value)
                                @php
                                    $valueDisplay = $value ?? 'Tidak Jawab';
                                    $colorClass = match($valueDisplay) {
                                        'Sangat Besar', 'Besar' => 'bg-green-50 border-green-200 text-green-700',
                                        'Kurang', 'Tidak Sama Sekali' => 'bg-red-50 border-red-200 text-red-700',
                                        default => 'bg-gray-50 border-gray-200 text-gray-600',
                                    };
                                @endphp
                                <div class="p-3 rounded-xl border {{ $colorClass }} transition hover:shadow-md">
                                    <p class="text-[10px] opacity-70 font-bold uppercase truncate">{{ str_replace('\\', '', $label) }}</p>
                                    <p class="text-sm font-black mt-1">{{ $valueDisplay }}</p>
                                </div>
                            @empty
                                <div class="col-span-full p-4 bg-gray-50 rounded-xl text-center text-xs italic text-gray-400">Data tidak tersedia.</div>
                            @endforelse
                        </div>
                    </div>
                    @endforeach
                </div>
            </section>

            {{-- Bagian 4: Kritik & Saran --}}
            <section class="{{ $cardBase }} border-t-4 border-red-500">
                <div class="{{ $cardHeader }}">
                    <i data-lucide="message-square" class="w-5 h-5 text-red-600"></i>
                    <h2 class="text-lg font-bold text-gray-800">Kritik & Saran Alumni</h2>
                </div>
                <div class="p-6">
                    <div class="relative p-5 bg-red-50 rounded-2xl border-l-8 border-red-500 shadow-inner">
                        <i data-lucide="quote" class="absolute top-2 right-4 w-10 h-10 text-red-200/50"></i>
                        <p class="text-gray-700 italic leading-relaxed text-sm md:text-base relative z-10">
                            "{{ $kuesioner->jawaban ?? 'Tidak ada kritik atau saran yang diberikan.' }}"
                        </p>
                    </div>
                </div>
            </section>

        @else
            {{-- Error Handling Responsif --}}
            <div class="bg-red-50 border-2 border-red-200 p-8 rounded-3xl text-center animate-fade-in">
                <i data-lucide="alert-triangle" class="w-16 h-16 text-red-400 mx-auto mb-4"></i>
                <h2 class="text-xl font-black text-red-700 uppercase">Data Tidak Ditemukan</h2>
                <p class="text-gray-500 mt-2 text-sm">Maaf, detail kuesioner untuk ID alumni ini tidak dapat dimuat atau belum diisi.</p>
                <a href="{{ route('kaprodi.alumni') }}" class="mt-6 inline-block bg-red-600 text-white px-6 py-2 rounded-full font-bold shadow-lg shadow-red-200">Kembali Sekarang</a>
            </div>
        @endif

    </div>
@endsection
