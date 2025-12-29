@extends('layouts.admin')

@section('title', 'Manajemen Kuesioner')

@section('content')

    {{-- Hero Section --}}
    <div class="bg-gradient-to-r from-emerald-500 to-green-600 text-white p-6 rounded-xl shadow-lg mb-8 flex flex-col md:flex-row items-center justify-between animate-fade-in transform hover:scale-[1.005] transition-transform duration-300">
        <div class="text-center md:text-left mb-4 md:mb-0">
            <h3 class="text-xl md:text-2xl font-bold font-['Poppins']">Halo, Admin! 👋</h3>
            <p class="text-green-100 mt-1 text-sm md:text-base">Selamat datang di Panel Manajemen Kuesioner Alumni UIN Raden Mas Said.</p>
        </div>
        <div class="text-center md:text-right flex-shrink-0">
            <p class="text-xs md:text-sm font-semibold" id="currentDate"></p>
            <p class="text-xs md:text-sm" id="currentTime"></p>
        </div>
    </div>

    <div class="container mx-auto px-0 py-0 max-w-6xl bg-white rounded-2xl shadow-xl border border-gray-200 animate-fade-in overflow-hidden">

        {{-- Header Konten --}}
        <div class="p-6 md:p-8 pb-4 border-b border-gray-200">
            <h1 class="text-2xl md:text-3xl font-extrabold text-green-800 mb-2 font-['Poppins'] flex items-center gap-3 justify-center md:justify-start">
                <iconify-icon icon="mdi:clipboard-text-multiple-outline" class="w-7 h-7 md:w-8 md:h-8 text-green-600"></iconify-icon>
                Manajemen Kuesioner Alumni
            </h1>
            <p class="text-gray-600 text-sm md:text-base text-center md:text-left">Kelola dan lihat detail kuesioner yang telah diisi oleh alumni.</p>
        </div>

        {{-- Alerts --}}
        @if(session('success'))
            <div class="px-6 md:px-8 pt-6">
                <div class="flex items-center gap-3 bg-green-100 border border-green-300 text-green-800 px-5 py-4 rounded-xl shadow-sm justify-between" role="alert">
                    <p class="font-medium flex items-center gap-2 text-sm md:text-base">
                        <span class="iconify" data-icon="mdi:check-circle"></span>
                        {{ session('success') }}
                    </p>
                    <button type="button" class="text-green-700 hover:text-green-900" onclick="this.parentElement.style.display='none'">
                        <span class="iconify" data-icon="mdi:close"></span>
                    </button>
                </div>
            </div>
        @endif

        {{-- Search and Sort Form --}}
        <form action="{{ route('admin.kuisioner') }}" method="GET"
            class="p-6 md:p-8 flex flex-col md:flex-row gap-4 items-center border-b border-gray-200 bg-gray-50">

            <div class="relative w-full md:flex-grow">
                <input type="text" name="search" placeholder="Cari nama alumni..."
                    value="{{ request('search') }}"
                    class="w-full pl-10 pr-4 py-2.5 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500 text-gray-900 placeholder-gray-500 transition text-sm shadow-sm" />
                <span class="absolute left-3 top-1/2 -translate-y-1/2 text-gray-400 iconify" data-icon="mdi:magnify"></span>
            </div>

            <div class="flex flex-row gap-2 w-full md:w-auto">
                <select name="sort" onchange="this.form.submit()"
                        class="flex-grow md:w-40 px-4 py-2.5 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500 transition text-sm shadow-sm bg-white">
                    <option value="asc" {{ request('sort') == 'asc' ? 'selected' : '' }}>Nama A-Z</option>
                    <option value="desc" {{ request('sort') == 'desc' ? 'selected' : '' }}>Nama Z-A</option>
                </select>

                <button type="submit"
                        class="flex items-center justify-center gap-2 bg-green-700 hover:bg-green-800 text-white font-semibold py-2.5 px-6 rounded-lg shadow-md transition transform hover:-translate-y-0.5 whitespace-nowrap text-sm">
                    <span class="iconify" data-icon="mdi:filter-variant"></span>
                    Terapkan
                </button>
            </div>
        </form>

        {{-- Table Section --}}
        <div class="p-0">
            {{-- Desktop View (Laptop & Monitor) --}}
            <div class="hidden md:block overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200 text-gray-800 text-sm">
                    <thead class="bg-green-50">
                        <tr>
                            <th class="px-6 py-4 text-left whitespace-nowrap text-xs uppercase tracking-wider text-green-800 font-bold">User ID</th>
                            <th class="px-6 py-4 text-left whitespace-nowrap text-xs uppercase tracking-wider text-green-800 font-bold">Nama Alumni</th>
                            <th class="px-6 py-4 text-left whitespace-nowrap text-xs uppercase tracking-wider text-green-800 font-bold">Tanggal Mengisi</th>
                            <th class="px-6 py-4 text-center whitespace-nowrap text-xs uppercase tracking-wider text-green-800 font-bold">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100 bg-white">
                        @forelse ($kuisioners as $kuisioner)
                            <tr class="hover:bg-green-50 transition duration-150 ease-in-out">
                                <td class="px-6 py-4 whitespace-nowrap font-medium text-gray-700">{{ $kuisioner->user_id }}</td>
                                <td class="px-6 py-4 whitespace-nowrap font-semibold text-gray-800">{{ $kuisioner->user->name ?? 'Pengguna Tidak Ditemukan' }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-gray-600">{{ $kuisioner->created_at->format('d M Y, H:i') }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-center">
                                    <div class="flex justify-center items-center gap-2">
                                        <a href="{{ route('admin.kuisioner.detail', $kuisioner->id) }}"
                                           class="text-white bg-blue-600 hover:bg-blue-700 px-3 py-1.5 rounded-lg shadow-sm transition transform hover:scale-105 flex items-center gap-2 text-xs font-medium">
                                            <span class="iconify" data-icon="mdi:eye-outline"></span>
                                            <span>Detail</span>
                                        </a>
                                        <form action="{{ route('admin.kuisioner.destroy', $kuisioner->id) }}" method="POST"
                                              onsubmit="return confirm('Apakah Anda yakin ingin menghapus data ini?');" class="inline">
                                            @csrf @method('DELETE')
                                            <button type="submit"
                                                    class="text-white bg-red-600 hover:bg-red-700 px-3 py-1.5 rounded-lg shadow-sm transition transform hover:scale-105 flex items-center gap-2 text-xs font-medium">
                                                <span class="iconify" data-icon="mdi:delete"></span>
                                                <span>Hapus</span>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="text-center py-12 text-gray-500 italic">Belum ada data kuesioner.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            {{-- Mobile View (Smartphone) --}}
            <div class="md:hidden divide-y divide-gray-100">
                @forelse ($kuisioners as $kuisioner)
                    <div class="p-5 bg-white space-y-3">
                        <div class="flex justify-between items-start">
                            <div>
                                <span class="text-[10px] font-bold text-green-600 uppercase tracking-widest">ID: {{ $kuisioner->user_id }}</span>
                                <h4 class="text-base font-bold text-gray-900">{{ $kuisioner->user->name ?? 'Tidak Ada Nama' }}</h4>
                                <p class="text-xs text-gray-500 mt-1 flex items-center gap-1">
                                    <span class="iconify" data-icon="mdi:calendar-clock"></span>
                                    {{ $kuisioner->created_at->format('d M Y, H:i') }}
                                </p>
                            </div>
                        </div>
                        <div class="flex gap-2 pt-2 border-t border-gray-50">
                            <a href="{{ route('admin.kuisioner.detail', $kuisioner->id) }}"
                               class="flex-1 flex justify-center items-center gap-2 bg-blue-50 text-blue-700 py-2 rounded-lg text-xs font-bold border border-blue-100">
                                <span class="iconify" data-icon="mdi:eye-outline"></span> Detail
                            </a>
                            <form action="{{ route('admin.kuisioner.destroy', $kuisioner->id) }}" method="POST" class="flex-1">
                                @csrf @method('DELETE')
                                <button type="submit" class="w-full flex justify-center items-center gap-2 bg-red-50 text-red-700 py-2 rounded-lg text-xs font-bold border border-red-100">
                                    <span class="iconify" data-icon="mdi:delete"></span> Hapus
                                </button>
                            </form>
                        </div>
                    </div>
                @empty
                    <div class="p-10 text-center">
                        <img src="https://www.svgrepo.com/show/472628/no-data.svg" alt="No Data" class="w-24 h-24 mx-auto mb-4 opacity-40">
                        <p class="text-gray-500 text-sm">Belum ada data kuesioner.</p>
                    </div>
                @endforelse
            </div>
        </div>

        {{-- Pagination --}}
        <div class="p-6 flex justify-center border-t border-gray-100 bg-gray-50">
            {{ $kuisioners->links('pagination::tailwind') }}
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

                const currentDateElement = document.getElementById('currentDate');
                const currentTimeElement = document.getElementById('currentTime');

                if (currentDateElement) currentDateElement.textContent = formattedDate;
                if (currentTimeElement) currentTimeElement.textContent = formattedTime + ' WIB';
            }
            updateTime();
            setInterval(updateTime, 1000);
        });
    </script>
@endpush
