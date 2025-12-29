@extends('layouts.admin')

@section('title', 'Manajemen Kaprodi')

@section('header')
    {{-- Header/Title Section Responsif --}}
    <header class="mb-8 p-6 bg-white rounded-xl shadow-md flex flex-col md:flex-row items-center justify-between animate-fade-in gap-4">
        <div class="text-center md:text-left">
            <h1 class="text-2xl lg:text-4xl font-extrabold text-pink-700 tracking-tight font-['Poppins']">
                Manajemen Kaprodi
            </h1>
            <p class="text-gray-600 text-sm md:text-lg mt-1">Kelola data Ketua Program Studi bertanggung jawab.</p>
        </div>
        <div class="flex flex-col items-center md:items-end bg-pink-50 md:bg-transparent p-3 md:p-0 rounded-lg w-full md:w-auto">
            <p class="text-xs md:text-sm font-semibold text-pink-900 md:text-gray-700" id="currentDate"></p>
            <p class="text-xs md:text-sm text-pink-700 md:text-gray-600" id="currentTime"></p>
        </div>
    </header>
@endsection

@section('content')

    <div class="container mx-auto bg-white rounded-2xl shadow-2xl border border-gray-200 flex-1 overflow-hidden">

        {{-- Alerts --}}
        @if(session('success') || session('error'))
            <div class="px-6 pt-6">
                <div class="flex items-center gap-3 {{ session('success') ? 'bg-green-100 border-green-300 text-green-800' : 'bg-red-100 border-red-300 text-red-800' }} px-5 py-4 rounded-xl shadow-sm justify-between" role="alert">
                    <p class="font-medium flex items-center gap-2 text-sm">
                        <i data-lucide="{{ session('success') ? 'check-circle' : 'x-circle' }}" class="w-5 h-5"></i>
                        {{ session('success') ?? session('error') }}
                    </p>
                    <button type="button" onclick="this.parentElement.parentElement.remove()">
                        <i data-lucide="x" class="w-4 h-4"></i>
                    </button>
                </div>
            </div>
        @endif

        <div class="p-6 pb-4 border-b border-gray-200 bg-gray-50 rounded-t-2xl">
            <div class="flex flex-col md:flex-row justify-between items-center mb-6 gap-4">
                <h2 class="text-xl font-bold text-gray-800">Daftar Kaprodi</h2>
                <a href="{{ route('admin.kaprodi.create') }}"
                    class="w-full md:w-auto inline-flex items-center justify-center gap-2 bg-pink-600 hover:bg-pink-700 transition text-white font-semibold py-2.5 px-5 rounded-lg shadow-md transform hover:scale-[1.02] active:scale-95 text-sm">
                     <i data-lucide="user-plus" class="w-4 h-4"></i>
                     Tambah Kaprodi Baru
                </a>
            </div>

            {{-- Search Form --}}
            <form action="{{ route('admin.kaprodi') }}" method="GET" class="flex flex-col md:flex-row items-center gap-3">
                <div class="relative w-full md:flex-grow">
                    <input type="text" name="cari" placeholder="Cari nama, email, atau prodi..."
                            value="{{ request('cari') }}"
                            class="w-full pl-10 pr-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-pink-500 outline-none text-sm transition shadow-sm" />
                    <span class="absolute left-3 top-1/2 -translate-y-1/2 text-gray-400 iconify" data-icon="mdi:magnify"></span>
                </div>
                <button type="submit"
                        class="w-full md:w-auto flex items-center justify-center gap-2 bg-green-700 hover:bg-green-800 text-white font-semibold py-2.5 px-8 rounded-lg shadow-md transition text-sm">
                    <span class="iconify" data-icon="mdi:filter-variant"></span>
                    Filter
                </button>
            </form>
        </div>

        {{-- Data View --}}
        <div class="p-0">
            {{-- Desktop Table View --}}
            <div class="hidden md:block overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200 text-gray-800 text-sm">
                    <thead class="bg-green-50">
                        <tr>
                            <th class="px-6 py-4 text-left text-xs font-bold text-green-800 uppercase tracking-wider">Nama</th>
                            <th class="px-6 py-4 text-left text-xs font-bold text-green-800 uppercase tracking-wider">Kontak / Email</th>
                            <th class="px-6 py-4 text-left text-xs font-bold text-green-800 uppercase tracking-wider">Program Studi</th>
                            <th class="px-6 py-4 text-left text-xs font-bold text-green-800 uppercase tracking-wider text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100 bg-white">
                        @forelse($kaprodiList as $kaprodi)
                            <tr class="hover:bg-pink-50/30 transition duration-150">
                                <td class="px-6 py-4 font-semibold text-gray-800">{{ $kaprodi->name }}</td>
                                <td class="px-6 py-4 text-gray-600">{{ $kaprodi->email }}</td>
                                <td class="px-6 py-4">
                                    <span class="block font-medium text-pink-700">{{ $kaprodi->prodi ?? '-' }}</span>
                                    <span class="text-xs text-gray-400">{{ $kaprodi->fakultas ?? '-' }}</span>
                                </td>
                                <td class="px-6 py-4 text-center">
                                    <div class="flex justify-center gap-2">
                                        <a href="{{ route('admin.kaprodi.edit', $kaprodi->id) }}"
                                           class="text-white bg-blue-600 hover:bg-blue-700 p-2 rounded-lg flex items-center gap-1 text-xs transition transform hover:scale-105">
                                            <i data-lucide="edit-2" class="w-3.5 h-3.5"></i> Edit
                                        </a>
                                        <form action="{{ route('admin.kaprodi.destroy', $kaprodi->id) }}" method="POST" onsubmit="return confirm('Hapus Kaprodi ini?')">
                                            @csrf @method('DELETE')
                                            <button type="submit" class="text-white bg-red-600 hover:bg-red-700 p-2 rounded-lg flex items-center gap-1 text-xs transition transform hover:scale-105">
                                                <i data-lucide="trash-2" class="w-3.5 h-3.5"></i> Hapus
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            {{-- State ditangani oleh empty mobile di bawah atau gabung di sini --}}
                        @endforelse
                    </tbody>
                </table>
            </div>

            {{-- Mobile Card View --}}
            <div class="md:hidden divide-y divide-gray-100">
                @forelse($kaprodiList as $kaprodi)
                    <div class="p-5 bg-white space-y-3">
                        <div class="flex justify-between items-start">
                            <div class="flex-1">
                                <h4 class="font-bold text-gray-900 text-base leading-tight">{{ $kaprodi->name }}</h4>
                                <p class="text-xs text-gray-500 mt-1">{{ $kaprodi->email }}</p>
                            </div>
                            <div class="bg-pink-100 text-pink-700 text-[10px] font-bold px-2 py-1 rounded uppercase">
                                Kaprodi
                            </div>
                        </div>

                        <div class="bg-gray-50 p-3 rounded-lg border border-gray-100">
                            <p class="text-[10px] uppercase text-gray-400 font-bold tracking-widest">Penempatan</p>
                            <p class="text-sm font-semibold text-pink-800">{{ $kaprodi->prodi ?? '-' }}</p>
                            <p class="text-xs text-gray-500">{{ $kaprodi->fakultas ?? '-' }}</p>
                        </div>

                        <div class="flex gap-2 pt-2">
                            <a href="{{ route('admin.kaprodi.edit', $kaprodi->id) }}"
                               class="flex-1 flex justify-center items-center gap-2 bg-blue-50 text-blue-700 py-2.5 rounded-xl text-xs font-bold border border-blue-100">
                                <i data-lucide="edit-2" class="w-4 h-4"></i> Edit
                            </a>
                            <form action="{{ route('admin.kaprodi.destroy', $kaprodi->id) }}" method="POST" class="flex-1">
                                @csrf @method('DELETE')
                                <button type="submit" class="w-full flex justify-center items-center gap-2 bg-red-50 text-red-700 py-2.5 rounded-xl text-xs font-bold border border-red-100">
                                    <i data-lucide="trash-2" class="w-4 h-4"></i> Hapus
                                </button>
                            </form>
                        </div>
                    </div>
                @empty
                    <div class="p-12 text-center bg-gray-50">
                        <img src="https://www.svgrepo.com/show/472628/no-data.svg" alt="No Data" class="w-24 h-24 mx-auto mb-4 opacity-40">
                        <p class="text-gray-500 font-medium">Data Kaprodi tidak ditemukan.</p>
                    </div>
                @endforelse
            </div>
        </div>

        {{-- Pagination --}}
        <div class="mt-4 p-6 flex justify-center border-t border-gray-100 bg-gray-50">
            @if(isset($kaprodiList) && method_exists($kaprodiList, 'links'))
                {{ $kaprodiList->links('pagination::tailwind') }}
            @endif
        </div>

    </div>
@endsection
