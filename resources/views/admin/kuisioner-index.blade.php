@extends('layouts.admin')

@section('title', 'Manajemen Kuesioner')

{{-- Di halaman ini, kita tidak memerlukan library chart, jadi section scripts dikosongkan --}}
{{-- Namun, kita perlu menambahkan Hero Section dan konten utama --}}

@section('content')

    {{-- Hero Section (Pengganti Header statis di layout admin) --}}
    <div class="bg-gradient-to-r from-emerald-500 to-green-600 text-white p-6 rounded-xl shadow-lg mb-8 flex flex-col md:flex-row items-center justify-between animate-fade-in transform hover:scale-[1.005] transition-transform duration-300">
        <div class="text-center md:text-left mb-4 md:mb-0">
            <h3 class="text-2xl font-bold font-['Poppins']">Halo, Admin! 👋</h3>
            <p class="text-green-100 mt-1">Selamat datang di Panel Manajemen Kuesioner Alumni UIN Raden Mas Said.</p>
        </div>
        <div class="text-right flex-shrink-0">
            <p class="text-sm font-semibold" id="currentDate"></p>
            <p class="text-sm" id="currentTime"></p>
        </div>
    </div>

    <div class="container mx-auto px-0 py-0 max-w-6xl bg-white rounded-2xl shadow-xl border border-gray-200 animate-fade-in">

        <div class="p-8 pb-4 border-b border-gray-200">
            <h1 class="text-3xl font-extrabold text-green-800 mb-2 font-['Poppins'] flex items-center gap-3">
                <iconify-icon icon="mdi:clipboard-text-multiple-outline" class="w-8 h-8 text-green-600"></iconify-icon>
                Manajemen Kuesioner Alumni
            </h1>
            <p class="text-gray-600 text-base">Kelola dan lihat detail kuesioner yang telah diisi oleh alumni.</p>
        </div>

        @if(session('success'))
            <div class="px-8 pt-6">
                <div class="flex items-center gap-3 bg-green-100 border border-green-300 text-green-800 px-5 py-4 rounded-xl shadow-sm justify-between" role="alert">
                    <p class="font-medium flex items-center gap-2">
                        <i data-lucide="check-circle" class="w-5 h-5 text-green-600"></i>
                        {{ session('success') }}
                    </p>
                    <button type="button" class="text-green-700 hover:text-green-900 focus:outline-none" onclick="this.parentElement.style.display='none'">
                        <i data-lucide="x" class="w-5 h-5"></i>
                    </button>
                </div>
            </div>
        @endif

        @if(session('error'))
            <div class="px-8 pt-6">
                <div class="flex items-center gap-3 bg-red-100 border border-red-300 text-red-800 px-5 py-4 rounded-xl shadow-sm justify-between" role="alert">
                    <p class="font-medium flex items-center gap-2">
                        <i data-lucide="x-circle" class="w-5 h-5 text-red-600"></i>
                        {{ session('error') }}
                    </p>
                    <button type="button" class="text-red-700 hover:text-red-900 focus:outline-none" onclick="this.parentElement.style.display='none'">
                        <i data-lucide="x" class="w-5 h-5"></i>
                    </button>
                </div>
            </div>
        @endif

        {{-- Search and Sort Form --}}
        <form action="{{ route('admin.kuisioner') }}" method="GET"
            class="p-8 flex flex-col sm:flex-row gap-4 items-center border-b border-gray-200 bg-gray-50 rounded-b-lg sm:rounded-b-none">

            <div class="relative w-full sm:flex-grow">
                <input type="text" name="search" placeholder="Cari nama alumni..."
                    value="{{ request('search') }}"
                    class="w-full pl-10 pr-4 py-2.5 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-green-500 text-gray-900 placeholder-gray-500 transition text-sm shadow-sm" />
                <span class="absolute left-3 top-1/2 -translate-y-1/2 text-gray-400 iconify" data-icon="mdi:magnify"></span>
            </div>

            <select name="sort" onchange="this.form.submit()"
                    class="w-full sm:w-auto px-4 py-2.5 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-green-500 transition text-sm shadow-sm">
                <option value="asc" {{ request('sort') == 'asc' ? 'selected' : '' }}>Nama A-Z</option>
                <option value="desc" {{ request('sort') == 'desc' ? 'selected' : '' }}>Nama Z-A</option>
            </select>

            <button type="submit"
                    class="flex items-center justify-center gap-2 bg-green-700 hover:bg-green-800 text-white font-semibold py-2.5 px-6 rounded-lg shadow-md transition transform hover:-translate-y-0.5 w-full sm:w-auto">
                <span class="iconify" data-icon="mdi:filter-variant" style="font-size: 18px;"></span>
                Terapkan
            </button>
        </form>

        {{-- Table Section --}}
        <div class="overflow-x-auto p-6 pt-0">
            <table class="min-w-full divide-y divide-gray-200 text-gray-800 text-sm">
                <thead class="bg-green-50">
                    <tr>
                        <th class="px-5 py-4 text-left whitespace-nowrap text-xs uppercase tracking-wider rounded-tl-lg text-green-800 font-bold">User ID</th>
                        <th class="px-5 py-4 text-left whitespace-nowrap text-xs uppercase tracking-wider text-green-800 font-bold">Nama Alumni</th>
                        <th class="px-5 py-4 text-left whitespace-nowrap text-xs uppercase tracking-wider text-green-800 font-bold">Tanggal Mengisi</th>
                        <th class="px-5 py-4 text-center whitespace-nowrap text-xs uppercase tracking-wider rounded-tr-lg text-green-800 font-bold">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    {{-- Loop data kuesioner. Asumsi variabel $kuisioners dilempar dari Controller --}}
                    @forelse ($kuisioners as $kuisioner)
                        <tr class="odd:bg-white even:bg-green-50 hover:bg-green-100 transition duration-150 ease-in-out">
                            <td class="px-5 py-3.5 whitespace-nowrap font-medium text-gray-700">{{ $kuisioner->user_id }}</td>
                            <td class="px-5 py-3.5 whitespace-nowrap font-semibold text-gray-800">{{ $kuisioner->user->name ?? 'Pengguna Tidak Ditemukan' }}</td>
                            <td class="px-5 py-3.5 whitespace-nowrap text-gray-600">{{ $kuisioner->created_at->format('d M Y, H:i') }}</td>
                            <td class="px-5 py-3.5 whitespace-nowrap text-center flex justify-center gap-2 items-center">
                                <a href="{{ route('admin.kuisioner.detail', $kuisioner->id) }}"
                                   class="text-white bg-blue-600 hover:bg-blue-700 p-2 rounded-lg shadow-md transition transform hover:scale-105 flex items-center justify-center gap-1 focus:outline-none focus:ring-2 focus:ring-blue-500"
                                   title="Lihat Detail">
                                    <span class="iconify" data-icon="mdi:eye-outline" style="font-size: 18px;"></span>
                                    <span>Detail</span>
                                </a>
                                <form action="{{ route('admin.kuisioner.destroy', $kuisioner->id) }}" method="POST"
                                    onsubmit="return confirm('Apakah Anda yakin ingin menghapus data kuesioner ini? Tindakan ini tidak dapat dibatalkan.');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"
                                            class="text-white bg-red-600 hover:bg-red-700 p-2 rounded-lg shadow-md transition transform hover:scale-105 flex items-center justify-center gap-1 focus:outline-none focus:ring-2 focus:ring-red-500"
                                            title="Hapus Kuesioner">
                                        <span class="iconify" data-icon="mdi:delete" style="font-size: 18px;"></span>
                                        <span>Hapus</span>
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="text-center py-12 text-gray-500 italic bg-gray-50 rounded-b-lg">
                                <img src="https://www.svgrepo.com/show/472628/no-data.svg" alt="No Data" class="w-36 h-36 mx-auto mb-5 opacity-60">
                                <p class="text-lg font-medium">Belum ada data kuesioner yang masuk.</p>
                                <p class="text-sm mt-1">Sistem akan menampilkan data di sini setelah alumni mengisi kuesioner.</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- Pagination --}}
        <div class="mt-4 p-6 flex justify-center border-t border-gray-100">
            {{ $kuisioners->links('pagination::tailwind') }}
        </div>

    </div>
@endsection

@push('scripts')
    {{-- Tambahkan script yang diperlukan khusus untuk halaman ini (misalnya, jika ada JS untuk modal) --}}

    {{-- Script untuk update waktu di Hero Section (disalin dari file asli) --}}
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
