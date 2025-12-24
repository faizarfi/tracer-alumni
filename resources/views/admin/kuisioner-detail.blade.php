@extends('layouts.admin')

@section('title', 'Detail Kuesioner')

{{-- Menimpa default header dengan Hero Section yang lebih informatif --}}
@section('header')
    <div class="bg-gradient-to-r from-emerald-500 to-green-600 text-white p-6 rounded-xl shadow-lg mb-8 flex flex-col md:flex-row items-center justify-between animate-fade-in transform hover:scale-[1.005] transition-transform duration-300">
        <div class="text-center md:text-left mb-4 md:mb-0">
            <h3 class="text-2xl font-bold font-['Poppins']">Halo, Admin! 👋</h3>
            <p class="text-green-100 mt-1">Anda sedang melihat detail kuesioner alumni.</p>
        </div>
        <div class="text-right flex-shrink-0">
            <p class="text-sm font-semibold" id="currentDate"></p>
            <p class="text-sm" id="currentTime"></p>
        </div>
    </div>
@endsection

@section('content')

    {{-- Asumsi $kuisioner dilempar dari Controller --}}
    <div class="container mx-auto max-w-5xl px-0 py-0 bg-white shadow-xl border border-gray-200 rounded-2xl animate-fade-in">

        <div class="p-8 pb-4 border-b border-gray-200 flex flex-col sm:flex-row items-start sm:items-center justify-between">
            <h2 class="text-3xl font-extrabold text-green-800 mb-4 sm:mb-0 font-['Poppins'] flex items-center gap-3">
                <iconify-icon icon="mdi:file-document-outline" class="text-4xl text-green-600"></iconify-icon>
                Detail Kuesioner
            </h2>
            <a href="{{ route('admin.kuisioner') }}"
               class="inline-flex items-center bg-green-600 hover:bg-green-700 text-white px-5 py-2.5 rounded-lg shadow-md transition-all duration-200 transform hover:-translate-y-0.5">
                <iconify-icon icon="mdi:arrow-left" class="mr-2"></iconify-icon>
                Kembali ke Daftar Kuesioner
            </a>
        </div>

        {{-- Metadata Kuesioner --}}
        <div class="p-8 pt-6 grid grid-cols-1 sm:grid-cols-2 gap-y-6 gap-x-8 border-b border-gray-200">
            <div>
                <p class="text-sm font-medium text-green-600">User ID</p>
                <p class="text-lg font-semibold text-gray-800 mt-1">{{ $kuisioner->user_id }}</p>
            </div>
            <div>
                <p class="text-sm font-medium text-green-600">Nama Alumni</p>
                <p class="text-lg font-semibold text-gray-800 mt-1">{{ $kuisioner->user->name ?? 'Tidak Ditemukan' }}</p>
            </div>
            <div>
                <p class="text-sm font-medium text-green-600">Tanggal Mengisi</p>
                <p class="text-lg font-semibold text-gray-800 mt-1">{{ $kuisioner->created_at ? $kuisioner->created_at->isoFormat('D MMMM YYYY, H:mm') . ' WIB' : '-' }}</p>
            </div>
        </div>

        {{-- Section: Data Pendidikan --}}
        <div class="p-8 border-b border-gray-200">
            <h3 class="text-xl font-semibold text-green-700 mb-4 font-['Poppins'] flex items-center gap-2">
                <iconify-icon icon="mdi:school-outline" class="text-2xl"></iconify-icon> Data Pendidikan
            </h3>
            {{-- Asumsi $kuisioner->pendidikan adalah array atau di-cast ke array/JSON --}}
            @php $pendidikan = is_string($kuisioner->pendidikan) ? json_decode($kuisioner->pendidikan, true) : (array) $kuisioner->pendidikan; @endphp
            @if(is_array($pendidikan) && !empty($pendidikan))
                <div class="bg-green-50 border border-green-200 rounded-lg p-5 space-y-3 text-gray-900 shadow-sm">
                    @foreach($pendidikan as $key => $value)
                        <div class="flex items-start text-base">
                            <span class="text-green-700 mr-2 flex-shrink-0 mt-1">&bullet;</span>
                            <div>
                                <strong class="font-medium text-gray-700 capitalize">{{ str_replace('_', ' ', $key) }}:</strong>
                                <span class="ml-1">{{ $value ?? '-' }}</span>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="bg-gray-50 border border-gray-200 text-gray-600 p-5 rounded-lg text-center italic shadow-sm">
                    <i data-lucide="info" class="w-5 h-5 inline-block mr-2 text-gray-500"></i> Data pendidikan tidak tersedia atau tidak dalam format yang benar.
                </div>
            @endif
        </div>

        {{-- Section: Data Fasilitas --}}
        <div class="p-8 border-b border-gray-200">
            <h3 class="text-xl font-semibold text-green-700 mb-4 font-['Poppins'] flex items-center gap-2">
                <iconify-icon icon="mdi:tools" class="text-2xl"></iconify-icon> Data Fasilitas
            </h3>
            {{-- Asumsi $kuisioner->fasilitas adalah array atau di-cast ke array/JSON --}}
            @php $fasilitas = is_string($kuisioner->fasilitas) ? json_decode($kuisioner->fasilitas, true) : (array) $kuisioner->fasilitas; @endphp
            @if(is_array($fasilitas) && !empty($fasilitas))
                <div class="bg-green-50 border border-green-200 rounded-lg p-5 space-y-3 text-gray-900 shadow-sm">
                    @foreach($fasilitas as $key => $value)
                        <div class="flex items-start text-base">
                            <span class="text-green-700 mr-2 flex-shrink-0 mt-1">&bullet;</span>
                            <div>
                                <strong class="font-medium text-gray-700 capitalize">{{ str_replace('_', ' ', $key) }}:</strong>
                                <span class="ml-1">{{ $value ?? '-' }}</span>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="bg-gray-50 border border-gray-200 text-gray-600 p-5 rounded-lg text-center italic shadow-sm">
                    <i data-lucide="info" class="w-5 h-5 inline-block mr-2 text-gray-500"></i> Data fasilitas tidak tersedia atau tidak dalam format yang benar.
                </div>
            @endif
        </div>

        {{-- Section: Informasi Pekerjaan --}}
        <div class="p-8 border-b border-gray-200">
            <h3 class="text-xl font-semibold text-green-700 mb-4 font-['Poppins'] flex items-center gap-2">
                <iconify-icon icon="mdi:briefcase-outline" class="text-2xl"></iconify-icon> Informasi Pekerjaan
            </h3>
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-y-6 gap-x-8 text-gray-800 bg-green-50 border border-green-200 rounded-lg p-5 shadow-sm">
                @php
                    $jobInfoFields = [
                        'cari_kerja' => 'Kapan Mulai Cari Kerja',
                        'status_pekerjaan' => 'Status Pekerjaan Saat Ini',
                        'waktu_tunggu' => 'Waktu Tunggu (Bulan)',
                        'jumlah_lamaran' => 'Jumlah Lamaran Dikirim',
                        'jumlah_respon' => 'Jumlah Tanggapan Perusahaan',
                        'jumlah_wawancara' => 'Jumlah Wawancara',
                        'jenis_perusahaan' => 'Jenis Tempat Kerja',
                        'nama_perusahaan' => 'Nama Perusahaan',
                        'jenis_pekerjaan' => 'Jenis Pekerjaan',
                        'alamat_perusahaan' => 'Alamat Perusahaan',
                    ];
                @endphp

                @foreach($jobInfoFields as $field => $label)
                <div>
                    <p class="text-sm font-medium text-green-600">{{ $label }}</p>
                    {{-- Akses langsung properti model kuesioner --}}
                    <p class="mt-1 text-base font-semibold">{{ $kuisioner->$field ?? '-' }}</p>
                </div>
                @endforeach
            </div>
        </div>

        {{-- Section: Kritik & Saran --}}
        <div class="p-8">
            <h3 class="text-xl font-semibold text-green-700 mb-4 font-['Poppins'] flex items-center gap-2">
                <iconify-icon icon="mdi:comment-text-outline" class="text-2xl"></iconify-icon>
                Kritik & Saran
            </h3>
            {{-- Asumsi $kuisioner->jawaban berisi kritik dan saran dalam bentuk string --}}
            <div class="bg-green-50 border border-green-200 p-5 rounded-lg text-gray-900 whitespace-pre-line leading-relaxed shadow-sm">
                {{ $kuisioner->jawaban ?? 'Tidak ada kritik atau saran yang diberikan.' }}
            </div>
        </div>

    </div>
@endsection

@push('scripts')
    {{-- Script untuk update waktu di Hero Section (harus diulang karena menggunakan ID spesifik) --}}
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Update current time every second
            function updateTime() {
                const now = new Date();
                const optionsDate = { weekday: 'long', year: 'numeric', month: 'long', day: 'numeric' };
                const formattedDate = now.toLocaleDateString('id-ID', optionsDate);
                const formattedTime = now.toLocaleTimeString('id-ID', { hour: '2-digit', minute: '2-digit' });

                const currentDateElement = document.getElementById('currentDate');
                const currentTimeElement = document.getElementById('currentTime');

                if (currentDateElement) currentDateElement.textContent = formattedDate;
                if (currentTimeElement) currentTimeElement.textContent = formattedTime + ' WIB';
            }

            // Initial call to display time immediately
            updateTime();
            // Update time every second
            setInterval(updateTime, 1000);
        });
    </script>
@endpush
