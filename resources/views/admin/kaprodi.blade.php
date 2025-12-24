@extends('layouts.admin')

@section('title', 'Manajemen Kaprodi')

@section('header')
    {{-- Header/Title Section --}}
    <header class="mb-8 p-4 bg-white rounded-xl shadow-md flex items-center justify-between animate-fade-in">
        <div>
            <h1 class="text-3xl lg:text-4xl font-extrabold text-pink-700 tracking-tight font-['Poppins']">
                Manajemen Ketua Program Studi (Kaprodi)
            </h1>
            <p class="text-gray-600 text-lg mt-1">Kelola data Kaprodi yang bertanggung jawab atas program studi.</p>
        </div>
        <div class="flex flex-col items-end">
            <p class="text-sm font-semibold text-gray-700" id="currentDate"></p>
            <p class="text-sm text-gray-600" id="currentTime"></p>
        </div>
    </header>
@endsection

@section('content')

    <div class="container mx-auto bg-white rounded-2xl shadow-2xl border border-gray-200 flex-1">

        {{-- Success/Error Alerts (Placeholder) --}}
        @if(session('success'))
            <div class="px-6 pt-6">
                <div class="flex items-center gap-3 bg-green-100 border border-green-300 text-green-800 px-5 py-4 rounded-xl shadow-sm justify-between" role="alert">
                    <p class="font-medium flex items-center gap-2"><i data-lucide="check-circle" class="w-5 h-5"></i> {{ session('success') }}</p>
                </div>
            </div>
        @endif
        @if(session('error'))
            <div class="px-6 pt-6">
                <div class="flex items-center gap-3 bg-red-100 border border-red-300 text-red-800 px-5 py-4 rounded-xl shadow-sm justify-between" role="alert">
                    <p class="font-medium flex items-center gap-2"><i data-lucide="x-circle" class="w-5 h-5"></i> {{ session('error') }}</p>
                </div>
            </div>
        @endif


        <div class="p-6 pb-4 border-b border-gray-200 bg-gray-50 rounded-t-2xl">
            <div class="flex flex-wrap justify-between items-center mb-4 gap-3">
                    <h2 class="text-xl font-bold text-gray-800">Daftar Kaprodi</h2>
                    <a href="{{ route('admin.kaprodi.create') }}"
                        class="inline-flex items-center gap-2 bg-pink-600 hover:bg-pink-700 transition text-white font-semibold py-2 px-4 rounded-lg shadow-md focus:outline-none focus:ring-2 focus:ring-pink-500 transform hover:scale-[1.03] text-sm">
                         <i data-lucide="user-plus" class="w-5 h-5"></i>
                         Tambah Kaprodi Baru
                    </a>
            </div>

            {{-- Search Form --}}
            <form action="{{ route('admin.kaprodi') }}" method="GET" class="flex flex-col sm:flex-row items-center gap-4">
                <div class="relative w-full sm:flex-grow">
                    <input type="text" name="cari" placeholder="Cari nama / email / prodi..."
                            value="{{ request('cari') }}"
                            class="w-full pl-10 pr-4 py-2.5 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-green-500 text-gray-900 placeholder-gray-500 transition text-sm shadow-sm" />
                    <span class="absolute left-3 top-1/2 -translate-y-1/2 text-gray-400 iconify" data-icon="mdi:magnify"></span>
                </div>
                <button type="submit"
                        class="flex items-center justify-center gap-2 bg-green-700 hover:bg-green-800 text-white font-semibold py-2.5 px-6 rounded-lg shadow-md transition transform hover:-translate-y-0.5 w-full sm:w-auto">
                    <span class="iconify" data-icon="mdi:filter-variant" style="font-size: 18px;"></span>
                    Filter
                </button>
            </form>
        </div>

        {{-- Data Table --}}
        <div class="overflow-x-auto p-6 pt-0">
            <table class="min-w-full divide-y divide-gray-200 text-gray-800 text-sm">
                <thead class="bg-green-50">
                    <tr>
                        <th class="px-5 py-4 text-left whitespace-nowrap text-xs uppercase tracking-wider rounded-tl-lg text-green-800 font-bold">Nama</th>
                        <th class="px-5 py-4 text-left whitespace-nowrap text-xs uppercase tracking-wider text-green-800 font-bold">Email</th>
                        <th class="px-5 py-4 text-left whitespace-nowrap text-xs uppercase tracking-wider text-green-800 font-bold">Program Studi</th>
                        <th class="px-5 py-4 text-left whitespace-nowrap text-xs uppercase tracking-wider text-green-800 font-bold">Fakultas</th>
                        <th class="px-5 py-4 text-center whitespace-nowrap text-xs uppercase tracking-wider rounded-tr-lg text-green-800 font-bold">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse($kaprodiList as $kaprodi)
                        <tr class="odd:bg-white even:bg-green-50 hover:bg-green-100 transition duration-150 ease-in-out">
                            <td class="px-5 py-3.5 whitespace-nowrap font-semibold text-gray-800">{{ $kaprodi->name }}</td>
                            <td class="px-5 py-3.5 whitespace-nowrap text-gray-600">{{ $kaprodi->email }}</td>
                            <td class="px-5 py-3.5 whitespace-nowrap text-gray-600">{{ $kaprodi->prodi ?? '-' }}</td>
                            <td class="px-5 py-3.5 whitespace-nowrap text-gray-600">{{ $kaprodi->fakultas ?? '-' }}</td>
                            <td class="px-5 py-3.5 whitespace-nowrap text-center flex justify-center gap-2 items-center">
                                <a href="{{ route('admin.kaprodi.edit', $kaprodi->id) }}"
                                   class="text-white bg-blue-600 hover:bg-blue-700 p-2 text-xs rounded-lg shadow-md transition transform hover:scale-105 flex items-center justify-center gap-1 focus:outline-none focus:ring-2 focus:ring-blue-500"
                                   title="Edit Data">
                                    <span class="iconify" data-icon="mdi:pencil" style="font-size: 14px;"></span>
                                    <span class="hidden sm:inline">Edit</span>
                                </a>
                                <form action="{{ route('admin.kaprodi.destroy', $kaprodi->id) }}" method="POST" onsubmit="return confirm('Anda yakin menghapus Kaprodi ini? Semua akses Kaprodi akan dicabut.');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"
                                            class="text-white bg-red-600 hover:bg-red-700 p-2 text-xs rounded-lg shadow-md transition transform hover:scale-105 flex items-center justify-center gap-1 focus:outline-none focus:ring-2 focus:ring-red-500"
                                            title="Hapus Data">
                                        <span class="iconify" data-icon="mdi:delete" style="font-size: 14px;"></span>
                                        <span class="hidden sm:inline">Hapus</span>
                                    </button>
                                </form>
                            </td>
                        </tr>
                            @empty
                            <tr>
                                <td colspan="5" class="text-center py-12 text-gray-500 italic bg-gray-50 rounded-b-lg">
                                    <img src="https://www.svgrepo.com/show/472628/no-data.svg" alt="No Data" class="w-36 h-36 mx-auto mb-5 opacity-60">
                                    <p class="text-lg font-medium">Data Kaprodi Tidak Ditemukan</p>
                                    <p class="text-sm mt-1">Tidak ada pengguna dengan peran 'kaprodi' di database.</p>
                                </td>
                            </tr>
                        @endforelse
                </tbody>
            </table>
        </div>

        {{-- Pagination Links --}}
        <div class="mt-4 p-6 flex justify-center border-t border-gray-100">
            @if(isset($kaprodiList) && method_exists($kaprodiList, 'links'))
                {{ $kaprodiList->links('pagination::tailwind') }}
            @endif
        </div>

    </div>
@endsection

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Logic untuk Date/Time Header
            const currentDateElement = document.getElementById('currentDate');
            const currentTimeElement = document.getElementById('currentTime');

            function updateTime() {
                const now = new Date();
                const optionsDate = { weekday: 'long', year: 'numeric', month: 'long', day: 'numeric' };
                const formattedDate = now.toLocaleDateString('id-ID', optionsDate);
                const formattedTime = now.toLocaleTimeString('id-ID', { hour: '2-digit', minute: '2-digit' });

                if (currentDateElement && currentTimeElement) {
                    currentDateElement.textContent = formattedDate;
                    currentTimeElement.textContent = formattedTime + ' WIB';
                }
            }

            updateTime();
            setInterval(updateTime, 1000);
        });
    </script>
@endpush
