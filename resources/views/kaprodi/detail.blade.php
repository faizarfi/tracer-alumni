@extends('layouts.kaprodi') {{-- Menggunakan template utama --}}

@section('title', 'Detail Kuesioner Alumni')

@section('content')

    {{-- Header/Title Section --}}
    <header class="mb-6 p-4 bg-white rounded-xl shadow-md flex items-center justify-between">
        {{-- TOMBOL TOGGLE SIDEBAR (Mobile) --}}
        <button id="sidebarToggle" class="mr-3 text-green-700 md:hidden p-2 rounded hover:bg-green-100 transition duration-150" aria-label="Toggle Menu">
            <i data-lucide="menu" class="w-5 h-5"></i>
        </button>
        <div class="flex-grow">
            <h1 class="text-xl lg:text-2xl font-extrabold text-indigo-800 tracking-tight font-['Poppins']">
                Detail Kuesioner Alumni
            </h1>
            <p class="text-gray-600 text-sm mt-1">Review detail jawaban kuesioner dari alumni.</p>
        </div>
    </header>

    {{-- Konten Utama Detail --}}
    <div class="max-w-7xl mx-auto w-full">

        {{-- Tombol Kembali --}}
        <div class="mb-6">
            <a href="{{ route('kaprodi.alumni') ?? '#' }}" class="inline-flex items-center px-4 py-2 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300 transition duration-150 text-sm font-semibold shadow-sm">
                <i data-lucide="arrow-left" class="w-4 h-4 mr-1.5"></i> Kembali ke Daftar Alumni
            </a>
        </div>

        @php
            // Memastikan variabel tersedia dan memformat tanggal
            $alumni = $alumni ?? null;
            $kuesioner = $kuesioner ?? null;
            $tanggalMengisi = $kuesioner->updated_at ?? ($alumni->updated_at ?? 'Data tidak tersedia');

            if ($tanggalMengisi instanceof \Carbon\Carbon) {
                $tanggalMengisiFormatted = $tanggalMengisi->translatedFormat('d F Y, H:i') . ' WIB';
            } else {
                $tanggalMengisiFormatted = 'Tanggal tidak tersedia';
            }

            // CSS class untuk detail card, dipindahkan dari <style> asli
            $detailCardStyle = 'margin-bottom: 1.5rem; padding: 1.5rem; background-color: white; border-radius: 1rem; box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -2px rgba(0, 0, 0, 0.1);';
            $basicDetailItemStyle = 'display: flex; justify-content: space-between; padding: 0.5rem 0; border-bottom: 1px dashed #e2e8f0;';
            $infoBlockStyle = 'padding: 1rem; border-radius: 0.75rem; background-color: #f0fdfa; border: 1px solid #ccfbf1; transition: all 0.2s; box-shadow: 0 1px 3px 0 rgba(0, 0, 0, 0.05);';
        @endphp


        @if ($alumni && $kuesioner)
            {{-- Bagian 1: Informasi Dasar Alumni --}}
            <section style="{{ $detailCardStyle }}" class="border-t-4 border-green-500">
                <h2 class="text-xl font-bold text-gray-800 mb-4 flex items-center gap-2">
                    <i data-lucide="user-check" class="w-5 h-5 text-green-600"></i> Data Dasar Responden
                </h2>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div style="{{ $basicDetailItemStyle }}">
                        <span class="text-gray-500">Nama Alumni</span>
                        <span class="font-extrabold text-gray-900">{{ $alumni->nama ?? '-' }}</span>
                    </div>
                    <div style="{{ $basicDetailItemStyle }}">
                        <span class="text-gray-500">NIM</span>
                        <span class="font-extrabold text-gray-900">{{ $alumni->nim ?? '-' }}</span>
                    </div>
                    <div style="{{ $basicDetailItemStyle }}">
                        <span class="text-gray-500">Program Studi</span>
                        <span class="font-semibold text-gray-700">{{ $alumni->jurusan ?? '-' }}</span>
                    </div>
                    <div style="{{ $basicDetailItemStyle }}" class="md:col-span-1">
                        <span class="text-gray-500">Tanggal Mengisi Kuesioner</span>
                        <span class="font-semibold text-green-600">{{ $tanggalMengisiFormatted }}</span>
                    </div>
                </div>
            </section>

            {{-- Bagian 2: Informasi Pekerjaan --}}
            <section style="{{ $detailCardStyle }}" class="border-t-4 border-blue-500">
                <h2 class="text-xl font-bold text-gray-800 mb-4 flex items-center gap-2">
                    <i data-lucide="briefcase" class="w-5 h-5 text-blue-600"></i> Informasi Pekerjaan
                </h2>

                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">

                    {{-- Status Pekerjaan Saat Ini --}}
                    <div class="border-blue-300 bg-blue-50" style="{{ $infoBlockStyle }}">
                        <p class="text-xs font-medium text-blue-700 uppercase mb-1 flex items-center gap-1">
                            <i data-lucide="check-circle" class="w-3 h-3"></i> Status Pekerjaan
                        </p>
                        <p class="text-lg font-extrabold text-gray-900">{{ $kuesioner->status_pekerjaan ?? 'Belum Ada Data' }}</p>
                    </div>

                    {{-- Waktu Tunggu (Bulan) --}}
                    <div style="{{ $infoBlockStyle }}">
                        <p class="text-xs font-medium text-gray-500 uppercase mb-1 flex items-center gap-1">
                            <i data-lucide="clock" class="w-3 h-3"></i> Waktu Tunggu (Bulan)
                        </p>
                        <p class="text-lg font-bold text-gray-800">{{ $kuesioner->waktu_tunggu ?? '-' }}</p>
                    </div>

                    {{-- Jenis Tempat Kerja --}}
                    <div style="{{ $infoBlockStyle }}">
                        <p class="text-xs font-medium text-gray-500 uppercase mb-1">Jenis Tempat Kerja</p>
                        <p class="text-lg font-bold text-gray-800">{{ $kuesioner->jenis_perusahaan ?? '-' }}</p>
                    </div>

                    {{-- Nama Perusahaan --}}
                    <div class="sm:col-span-3" style="{{ $infoBlockStyle }}">
                        <p class="text-xs font-medium text-gray-500 uppercase mb-1">Nama Perusahaan</p>
                        <p class="text-lg font-bold text-gray-800">{{ $kuesioner->nama_perusahaan ?? '-' }}</p>
                    </div>

                    {{-- Jenis Pekerjaan --}}
                    <div style="{{ $infoBlockStyle }}">
                        <p class="text-xs font-medium text-gray-500 uppercase mb-1">Jenis Pekerjaan</p>
                        <p class="text-lg font-bold text-gray-800">{{ $kuesioner->jenis_pekerjaan ?? '-' }}</p>
                    </div>

                    {{-- Alamat Perusahaan --}}
                    <div class="lg:col-span-2" style="{{ $infoBlockStyle }}">
                        <p class="text-xs font-medium text-gray-500 uppercase mb-1">Alamat Perusahaan</p>
                        <p class="text-lg font-bold text-gray-800">{{ $kuesioner->alamat_perusahaan ?? '-' }}</p>
                    </div>

                    {{-- Statistik Pencarian Kerja --}}
                    <div class="sm:col-span-3 bg-gray-50 border-gray-200" style="padding: 1rem; border-radius: 0.75rem; border: 1px solid #e5e7eb; box-shadow: 0 1px 3px 0 rgba(0, 0, 0, 0.05);">
                        <p class="text-sm font-semibold text-gray-600 mb-3 border-b pb-2">Statistik Pencarian Kerja (Total)</p>
                        <div class="grid grid-cols-3 text-center">
                            <div>
                                <p class="text-2xl font-extrabold text-blue-700">{{ $kuesioner->jumlah_lamaran ?? 0 }}</p>
                                <p class="text-xs text-gray-500">Lamaran Dikirim</p>
                            </div>
                            <div>
                                <p class="text-2xl font-extrabold text-blue-700">{{ $kuesioner->jumlah_respon ?? 0 }}</p>
                                <p class="text-xs text-gray-500">Tanggapan Perusahaan</p>
                            </div>
                            <div>
                                <p class="text-2xl font-extrabold text-blue-700">{{ $kuesioner->jumlah_wawancara ?? 0 }}</p>
                                <p class="text-xs text-gray-500">Wawancara</p>
                            </div>
                        </div>
                    </div>
                </div>
            </section>

            {{-- Bagian 3: Relevansi Pendidikan & Fasilitas --}}
            <section style="{{ $detailCardStyle }}" class="border-t-4 border-yellow-500">
                <h2 class="text-xl font-bold text-gray-800 mb-4 flex items-center gap-2">
                    <i data-lucide="book-open-check" class="w-5 h-5 text-yellow-600"></i> Relevansi Pendidikan & Fasilitas
                </h2>

                <h3 class="text-lg font-semibold text-gray-700 mt-4 mb-3 border-b pb-2">Pengalaman Pendidikan:</h3>
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4 mt-2">
                    @php
                        $pendidikanData = $kuesioner->pendidikan ?? [];
                    @endphp

                    {{-- Loop melalui array pendidikan --}}
                    @forelse ($pendidikanData as $label => $value)
                        @php
                            $valueDisplay = $value ?? 'Tidak Jawab';
                            $cleanLabel = str_replace('\\', '', $label);
                            $colorClass = '';
                            if (in_array($valueDisplay, ['Besar', 'Sangat Besar'])) {
                                $colorClass = 'text-green-600 bg-green-50 border-green-300';
                            } elseif (in_array($valueDisplay, ['Kurang', 'Tidak Sama Sekali'])) {
                                $colorClass = 'text-red-600 bg-red-50 border-red-300';
                            } else {
                                $colorClass = 'text-gray-500 bg-gray-50 border-gray-300';
                            }
                        @endphp
                        <div class="p-3 rounded-lg border shadow-sm {{ $colorClass }}">
                            <p class="text-xs text-gray-500 font-medium uppercase truncate">{{ $cleanLabel }}</p>
                            <p class="text-lg font-bold">{{ $valueDisplay }}</p>
                        </div>
                    @empty
                        <p class="text-gray-500 italic col-span-full p-4 bg-gray-50 rounded-lg">Data pengalaman pendidikan belum diisi.</p>
                    @endforelse
                </div>

                <h3 class="text-lg font-semibold text-gray-700 mt-6 mb-3 border-b pb-2">Fasilitas Kampus:</h3>
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4 mt-2">
                    @php
                        $fasilitasData = $kuesioner->fasilitas ?? [];
                    @endphp

                    {{-- Loop melalui array fasilitas --}}
                    @forelse ($fasilitasData as $label => $value)
                        @php
                            $valueDisplay = $value ?? 'Tidak Jawab';
                            $cleanLabel = str_replace('\\', '', $label);
                            $colorClass = '';
                            if (in_array($valueDisplay, ['Besar', 'Sangat Besar'])) {
                                $colorClass = 'text-green-600 bg-green-50 border-green-300';
                            } elseif (in_array($valueDisplay, ['Kurang', 'Tidak Sama Sekali'])) {
                                $colorClass = 'text-red-600 bg-red-50 border-red-300';
                            } else {
                                $colorClass = 'text-gray-500 bg-gray-50 border-gray-300';
                            }
                        @endphp
                        <div class="p-3 rounded-lg border shadow-sm {{ $colorClass }}">
                            <p class="text-xs text-gray-500 font-medium uppercase truncate">{{ $cleanLabel }}</p>
                            <p class="text-lg font-bold">{{ $valueDisplay }}</p>
                        </div>
                    @empty
                        <p class="text-gray-500 italic col-span-full p-4 bg-gray-50 rounded-lg">Data fasilitas kampus belum diisi.</p>
                    @endforelse
                </div>
            </section>

            {{-- Bagian 4: Kritik & Saran --}}
            <section style="{{ $detailCardStyle }}" class="border-t-4 border-red-500">
                <h2 class="text-xl font-bold text-gray-800 mb-4 flex items-center gap-2">
                    <i data-lucide="message-square" class="w-5 h-5 text-red-600"></i> Kritik & Saran
                </h2>
                {{-- Menggunakan kolom 'jawaban' untuk kritik/saran --}}
                <blockquote class="p-4 bg-red-50 border-l-4 border-red-500 rounded-r-lg shadow-inner text-gray-700 italic text-base">
                    "{{ $kuesioner->jawaban ?? 'Tidak ada kritik atau saran yang diberikan.' }}"
                </blockquote>
            </section>

        @else
            {{-- Error Handling jika data tidak ditemukan --}}
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded-lg relative mt-6" role="alert">
                <p class="font-bold">Data Tidak Ditemukan</p>
                <p class="text-sm">Detail alumni atau kuesioner tidak dapat dimuat. Pastikan ID alumni ({{ request()->route('alumni_id') }}) valid dan data kuesioner tersedia.</p>
            </div>
        @endif

    </div>
@endsection

@section('scripts')
{{-- Tidak ada script Chart.js atau script tambahan yang diperlukan di sini --}}
@endsection
