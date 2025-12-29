@extends('layouts.admin')

@section('title', 'Detail Kuesioner')

@section('header')
    {{-- Hero Section Responsif --}}
    <div class="bg-gradient-to-r from-emerald-500 to-green-600 text-white p-6 rounded-xl shadow-lg mb-6 flex flex-col md:flex-row items-center justify-between animate-fade-in">
        <div class="text-center md:text-left mb-4 md:mb-0">
            <h3 class="text-xl md:text-2xl font-bold font-['Poppins']">Halo, Admin! 👋</h3>
            <p class="text-green-100 mt-1 text-sm md:text-base">Anda sedang melihat detail kuesioner alumni.</p>
        </div>
        <div class="text-center md:text-right flex-shrink-0">
            <p class="text-xs md:text-sm font-semibold" id="currentDate"></p>
            <p class="text-xs md:text-sm" id="currentTime"></p>
        </div>
    </div>
@endsection

@section('content')
    <div class="container mx-auto max-w-5xl bg-white shadow-xl border border-gray-200 rounded-2xl animate-fade-in overflow-hidden">

        {{-- Header Detail & Tombol Kembali --}}
        <div class="p-6 md:p-8 border-b border-gray-200 flex flex-col gap-4 md:flex-row md:items-center md:justify-between bg-white">
            <h2 class="text-2xl md:text-3xl font-extrabold text-green-800 font-['Poppins'] flex items-center gap-3 justify-center md:justify-start">
                <iconify-icon icon="mdi:file-document-outline" class="text-3xl md:text-4xl text-green-600"></iconify-icon>
                Detail Kuesioner
            </h2>
            <a href="{{ route('admin.kuisioner') }}"
               class="flex items-center justify-center bg-green-600 hover:bg-green-700 text-white px-5 py-2.5 rounded-lg shadow-md transition-all text-sm font-semibold">
                <iconify-icon icon="mdi:arrow-left" class="mr-2"></iconify-icon>
                Kembali
            </a>
        </div>

        {{-- Metadata Utama --}}
        <div class="p-6 md:p-8 grid grid-cols-1 md:grid-cols-3 gap-6 border-b border-gray-100 bg-gray-50/50">
            <div class="text-center md:text-left">
                <p class="text-xs font-bold text-green-600 uppercase tracking-wider">User ID</p>
                <p class="text-lg font-bold text-gray-800 mt-1">#{{ $kuisioner->user_id }}</p>
            </div>
            <div class="text-center md:text-left">
                <p class="text-xs font-bold text-green-600 uppercase tracking-wider">Nama Alumni</p>
                <p class="text-lg font-bold text-gray-800 mt-1">{{ $kuisioner->user->name ?? 'Tidak Ditemukan' }}</p>
            </div>
            <div class="text-center md:text-left">
                <p class="text-xs font-bold text-green-600 uppercase tracking-wider">Tanggal Submit</p>
                <p class="text-base font-semibold text-gray-800 mt-1">
                    {{ $kuisioner->created_at ? $kuisioner->created_at->isoFormat('D MMMM YYYY') : '-' }}
                    <span class="block text-xs font-normal text-gray-500">{{ $kuisioner->created_at ? $kuisioner->created_at->format('H:i') . ' WIB' : '' }}</span>
                </p>
            </div>
        </div>

        <div class="p-6 md:p-8 space-y-8">
            {{-- Section: Data Pendidikan --}}
            <section>
                <h3 class="text-lg font-bold text-green-700 mb-4 flex items-center gap-2 border-l-4 border-green-500 pl-3">
                    <iconify-icon icon="mdi:school-outline"></iconify-icon> Data Pendidikan
                </h3>
                @php $pendidikan = is_string($kuisioner->pendidikan) ? json_decode($kuisioner->pendidikan, true) : (array) $kuisioner->pendidikan; @endphp
                <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
                    @forelse($pendidikan as $key => $value)
                        <div class="bg-green-50/50 p-3 rounded-lg border border-green-100 flex justify-between items-center">
                            <span class="text-sm text-gray-600 capitalize">{{ str_replace('_', ' ', $key) }}</span>
                            <span class="text-sm font-bold text-gray-800">{{ $value ?? '-' }}</span>
                        </div>
                    @empty
                        <p class="text-sm italic text-gray-500">Data tidak tersedia.</p>
                    @endforelse
                </div>
            </section>

            {{-- Section: Data Fasilitas --}}
            <section>
                <h3 class="text-lg font-bold text-green-700 mb-4 flex items-center gap-2 border-l-4 border-green-500 pl-3">
                    <iconify-icon icon="mdi:tools"></iconify-icon> Data Fasilitas
                </h3>
                @php $fasilitas = is_string($kuisioner->fasilitas) ? json_decode($kuisioner->fasilitas, true) : (array) $kuisioner->fasilitas; @endphp
                <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
                    @forelse($fasilitas as $key => $value)
                        <div class="bg-blue-50/50 p-3 rounded-lg border border-blue-100 flex justify-between items-center">
                            <span class="text-sm text-gray-600 capitalize">{{ str_replace('_', ' ', $key) }}</span>
                            <span class="text-sm font-bold text-gray-800">{{ $value ?? '-' }}</span>
                        </div>
                    @empty
                        <p class="text-sm italic text-gray-500">Data tidak tersedia.</p>
                    @endforelse
                </div>
            </section>

            {{-- Section: Informasi Pekerjaan --}}
            <section>
                <h3 class="text-lg font-bold text-green-700 mb-4 flex items-center gap-2 border-l-4 border-green-500 pl-3">
                    <iconify-icon icon="mdi:briefcase-outline"></iconify-icon> Informasi Pekerjaan
                </h3>
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
                    @php
                        $jobFields = [
                            'cari_kerja' => 'Mulai Cari Kerja',
                            'status_pekerjaan' => 'Status Saat Ini',
                            'waktu_tunggu' => 'Waktu Tunggu',
                            'jumlah_lamaran' => 'Jml Lamaran',
                            'jumlah_respon' => 'Jml Respon',
                            'jumlah_wawancara' => 'Jml Wawancara',
                            'jenis_perusahaan' => 'Jenis Perusahaan',
                            'nama_perusahaan' => 'Nama Perusahaan',
                            'jenis_pekerjaan' => 'Jenis Pekerjaan',
                        ];
                    @endphp
                    @foreach($jobFields as $field => $label)
                        <div class="p-4 bg-gray-50 border border-gray-200 rounded-xl">
                            <p class="text-[10px] uppercase font-bold text-gray-400 tracking-widest">{{ $label }}</p>
                            <p class="text-sm font-bold text-gray-800 mt-1">{{ $kuisioner->$field ?? '-' }}</p>
                        </div>
                    @endforeach
                </div>
                {{-- Spesial untuk Alamat Perusahaan (Lebar Full) --}}
                <div class="mt-4 p-4 bg-gray-50 border border-gray-200 rounded-xl">
                    <p class="text-[10px] uppercase font-bold text-gray-400 tracking-widest">Alamat Perusahaan</p>
                    <p class="text-sm font-bold text-gray-800 mt-1">{{ $kuisioner->alamat_perusahaan ?? '-' }}</p>
                </div>
            </section>

            {{-- Section: Kritik & Saran --}}
            <section class="pb-4">
                <h3 class="text-lg font-bold text-green-700 mb-4 flex items-center gap-2 border-l-4 border-green-500 pl-3">
                    <iconify-icon icon="mdi:comment-text-outline"></iconify-icon> Kritik & Saran
                </h3>
                <div class="bg-amber-50 border border-amber-200 p-5 rounded-xl text-gray-800 text-sm leading-relaxed italic shadow-inner">
                    "{{ $kuisioner->jawaban ?? 'Tidak ada kritik atau saran yang diberikan.' }}"
                </div>
            </section>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            function updateTime() {
                const now = new Date();
                const optionsDate = { weekday: 'long', year: 'numeric', month: 'long', day: 'numeric' };
                const formattedDate = now.toLocaleDateString('id-ID', optionsDate);
                const formattedTime = now.toLocaleTimeString('id-ID', { hour: '2-digit', minute: '2-digit' });

                document.getElementById('currentDate').textContent = formattedDate;
                document.getElementById('currentTime').textContent = formattedTime + ' WIB';
            }
            updateTime();
            setInterval(updateTime, 1000);
        });
    </script>
@endpush
