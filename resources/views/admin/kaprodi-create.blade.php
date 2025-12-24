@extends('layouts.admin')

@section('title', 'Tambah Kaprodi Baru')

@section('header')
    {{-- Header/Title Section --}}
    <header class="mb-6 p-3 bg-white rounded-xl shadow-md flex items-center justify-between animate-fade-in">
        {{-- TOMBOL TOGGLE SIDEBAR (Diperlukan untuk Mobile) - Tombol ini seharusnya ada di layout induk atau di luar @section, tapi kita pertahankan strukturnya dari input Anda. --}}
        <button id="sidebarToggle" class="mr-3 text-pink-700 md:hidden p-2 rounded hover:bg-pink-100 transition duration-150" aria-label="Toggle Menu">
            <i data-lucide="menu" class="w-5 h-5"></i>
        </button>
        <div class="flex-grow">
            <h1 class="text-xl lg:text-2xl font-extrabold text-pink-800 tracking-tight font-['Poppins']">
                Tambah Data Ketua Program Studi (Kaprodi)
            </h1>
            <p class="text-pink-700 text-sm mt-1">Isi formulir di bawah untuk mendaftarkan Kaprodi baru.</p>
        </div>
        <div class="flex flex-col items-end flex-shrink-0 ml-4">
            <p class="text-sm font-semibold text-gray-700" id="currentDate"></p>
            <p class="text-sm text-gray-600" id="currentTime"></p>
        </div>
    </header>
@endsection

@section('content')

    <div class="container mx-auto bg-white rounded-xl shadow-md border border-gray-200 p-4 flex-1 max-w-4xl">

        @if (session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4 animate-fade-in" role="alert">
                <span class="block sm:inline">{{ session('success') }}</span>
            </div>
        @endif
        @if (session('error'))
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4 animate-fade-in" role="alert">
                <span class="block sm:inline">{{ session('error') }}</span>
            </div>
        @endif
        @if ($errors->any())
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4 animate-fade-in" role="alert">
                <p class="font-semibold">Mohon periksa kesalahan berikut:</p>
                <ul class="mt-1 list-disc list-inside text-sm">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <h2 class="text-xl font-bold text-gray-800 mb-6 border-b pb-2">Formulir Pendaftaran</h2>

        {{-- Formulir Tambah Kaprodi (ACTION POST) --}}
        <form action="{{ route('admin.kaprodi.store') }}" method="POST" class="space-y-6">
            @csrf

            <div class="space-y-4 p-4 border border-pink-100 rounded-lg bg-pink-50">
                <h3 class="text-lg font-semibold text-pink-800 mb-2">Data Dasar Kaprodi</h3>

                <div>
                    <label for="name" class="block text-sm font-medium text-gray-700 mb-1">Nama Kaprodi <span class="text-red-500">*</span></label>
                    <input type="text" name="name" id="name" value="{{ old('name') }}" required
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-pink-500 transition shadow-sm text-gray-900 hover:border-pink-400"
                        placeholder="Nama Lengkap Kaprodi"/>
                </div>

                <div>
                    <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Email (Digunakan untuk Login) <span class="text-red-500">*</span></label>
                    <input type="email" name="email" id="email" value="{{ old('email') }}" required
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-pink-500 transition shadow-sm text-gray-900 hover:border-pink-400"
                        placeholder="email@uinsaid.ac.id"/>
                </div>

                <div>
                    <label for="prodi" class="block text-sm font-medium text-gray-700 mb-1">Program Studi yang Diampu <span class="text-red-500">*</span></label>
                    <input type="text" name="prodi" id="prodi" value="{{ old('prodi') }}" required
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-pink-500 transition shadow-sm text-gray-900 hover:border-pink-400"
                        placeholder="Contoh: Manajemen Pendidikan Islam"/>
                </div>

                <div>
                    <label for="fakultas" class="block text-sm font-medium text-gray-700 mb-1">Fakultas <span class="text-red-500">*</span></label>
                    <select name="fakultas" id="fakultas" required
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-pink-500 transition shadow-sm text-gray-900 hover:border-pink-400">
                        <option value="" disabled {{ old('fakultas') ? '' : 'selected' }}>Pilih Fakultas</option>
                        {{-- Options akan diisi oleh JavaScript --}}
                    </select>
                </div>
            </div> {{-- End Data Dasar --}}


            <div class="space-y-4 p-4 border border-yellow-100 rounded-lg bg-yellow-50">
                <h3 class="text-lg font-semibold text-yellow-800 pt-1 border-t-0">Data Akun (Wajib Diisi)</h3>

                <div class="relative">
                    <label for="password" class="block text-sm font-medium text-gray-700 mb-1">Password <span class="text-red-500">*</span></label>
                    <input type="password" name="password" id="password" required
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-yellow-500 transition shadow-sm text-gray-900 pr-10"
                        placeholder="Minimal 8 karakter"/>
                    <button type="button" id="togglePassword" class="absolute inset-y-0 right-0 top-6 pt-1.5 flex items-center pr-3 text-gray-500 hover:text-yellow-600 transition" aria-label="Show password">
                        <i data-lucide="eye" class="w-4 h-4"></i>
                    </button>
                </div>

                <div class="relative">
                    <label for="password_confirmation" class="block text-sm font-medium text-gray-700 mb-1">Konfirmasi Password <span class="text-red-500">*</span></label>
                    <input type="password" name="password_confirmation" id="password_confirmation" required
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-yellow-500 transition shadow-sm text-gray-900 pr-10"
                        placeholder="Ulangi password"/>
                    <button type="button" id="togglePasswordConfirmation" class="absolute inset-y-0 right-0 top-6 pt-1.5 flex items-center pr-3 text-gray-500 hover:text-yellow-600 transition" aria-label="Show password confirmation">
                        <i data-lucide="eye" class="w-4 h-4"></i>
                    </button>
                </div>
            </div> {{-- End Data Akun --}}


            <div class="flex justify-between pt-6">
                <a href="{{ route('admin.kaprodi') }}"
                    class="inline-flex items-center gap-2 bg-gray-300 hover:bg-gray-400 text-gray-800 font-semibold py-2 px-3 rounded-lg shadow-sm transition duration-150">
                    <i data-lucide="arrow-left" class="w-4 h-4"></i> Kembali
                </a>

                <button type="submit"
                    class="inline-flex items-center gap-2 bg-green-600 hover:bg-green-700 text-white font-semibold py-2 px-3 rounded-lg shadow-sm transition duration-150 focus:outline-none focus:ring-2 focus:ring-green-400 focus:ring-opacity-50">
                    <i data-lucide="plus-circle" class="w-4 h-4"></i> Tambah Kaprodi
                </button>
            </div>

        </form>
    </div>
@endsection

@push('scripts')
    <script>
        // Data Fakultas yang akan di-populate
        const FAKULTAS_LIST = [
            "Fakultas Adab dan Bahasa",
            "Fakultas Ekonomi Dan Bisnis Islam",
            "Fakultas Ilmu Tarbiyah",
            "Fakultas Ushuluddin dan Dakwah",
            "Fakultas Syariah"
        ];
        const SELECTED_FAKULTAS = "{{ old('fakultas') ?? '' }}";

        function populateFakultas() {
            const fakultasSelect = document.getElementById('fakultas');
            if (!fakultasSelect) return;

            // Clear all dynamic options except the placeholder
            while (fakultasSelect.options.length > 1) {
                fakultasSelect.remove(1);
            }

            FAKULTAS_LIST.forEach(fakultasName => {
                const option = document.createElement('option');
                option.value = fakultasName;
                option.textContent = fakultasName;
                if (SELECTED_FAKULTAS && SELECTED_FAKULTAS === fakultasName) {
                    option.selected = true;
                }
                fakultasSelect.appendChild(option);
            });
        }

        // Fungsi untuk mengaktifkan toggle visibility password
        function setupPasswordToggle(toggleId, inputId) {
            const toggleButton = document.getElementById(toggleId);
            const inputField = document.getElementById(inputId);
            if (toggleButton && inputField) {
                const icon = toggleButton.querySelector('i');
                toggleButton.addEventListener('click', () => {
                    const type = inputField.getAttribute('type') === 'password' ? 'text' : 'password';
                    inputField.setAttribute('type', type);

                    if (type === 'text') {
                        icon.setAttribute('data-lucide', 'eye-off');
                    } else {
                        icon.setAttribute('data-lucide', 'eye');
                    }
                    lucide.createIcons();
                });
            }
        }

        // --- Init Logic ---
        document.addEventListener('DOMContentLoaded', function() {
            // Populate fakultas dropdown
            populateFakultas();

            // Setup Password Toggle untuk kedua field password
            setupPasswordToggle('togglePassword', 'password');
            setupPasswordToggle('togglePasswordConfirmation', 'password_confirmation');

            // Logic untuk Date/Time Header (Disalin dari file Anda)
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

            lucide.createIcons();
        });
    </script>
@endpush
