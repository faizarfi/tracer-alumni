@extends('layouts.admin')

@section('title', 'Edit Kaprodi - ' . ($kaprodi->name ?? 'N/A'))

@section('header')
    {{-- Header Section Responsif --}}
    <header class="mb-6 p-4 bg-white rounded-xl shadow-md flex flex-col md:flex-row items-center justify-between animate-fade-in gap-4">
        <div class="flex items-center w-full md:w-auto">
            {{-- Tombol Toggle Sidebar (Khusus Mobile) --}}
            <button id="sidebarToggle" class="mr-3 text-pink-700 md:hidden p-2 rounded-lg hover:bg-pink-100 transition duration-150" aria-label="Toggle Menu">
                <i data-lucide="menu" class="w-6 h-6"></i>
            </button>
            <div>
                <h1 class="text-xl lg:text-2xl font-extrabold text-pink-800 tracking-tight font-['Poppins']">
                    Edit Data Kaprodi
                </h1>
                <p class="text-pink-600 text-xs md:text-sm mt-0.5">Memperbarui informasi: <span class="font-bold">{{ $kaprodi->name ?? 'N/A' }}</span></p>
            </div>
        </div>
        <div class="flex flex-col items-center md:items-end w-full md:w-auto bg-pink-50 md:bg-transparent p-2 md:p-0 rounded-lg">
            <p class="text-xs md:text-sm font-semibold text-gray-700" id="currentDate"></p>
            <p class="text-xs text-gray-500" id="currentTime"></p>
        </div>
    </header>
@endsection

@section('content')

    <div class="container mx-auto max-w-4xl bg-white rounded-2xl shadow-xl border border-gray-200 p-6 md:p-8 animate-fade-in">

        {{-- Alerts --}}
        @if (session('success') || session('error'))
            <div class="{{ session('success') ? 'bg-green-50 border-green-200 text-green-700' : 'bg-red-50 border-red-200 text-red-700' }} border px-4 py-3 rounded-xl mb-6 flex items-center justify-between" role="alert">
                <span class="text-sm font-medium">{{ session('success') ?? session('error') }}</span>
                <button type="button" onclick="this.parentElement.remove()"><i data-lucide="x" class="w-4 h-4"></i></button>
            </div>
        @endif

        <h2 class="text-xl font-bold text-gray-800 mb-6 flex items-center gap-2">
            <i data-lucide="user-cog" class="text-pink-600"></i>
            Formulir Pembaruan Data
        </h2>

        {{-- Formulir Edit Kaprodi --}}
        <form action="{{ route('admin.kaprodi.update', $kaprodi->id) }}" method="POST" class="space-y-8">
            @csrf
            @method('PUT')

            {{-- Section: Data Dasar --}}
            <div class="space-y-5 p-5 md:p-6 border border-pink-100 rounded-2xl bg-pink-50/50">
                <h3 class="text-md font-bold text-pink-800 flex items-center gap-2 mb-2">
                    <i data-lucide="info" class="w-4 h-4"></i> Data Identitas
                </h3>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                    <div>
                        <label for="name" class="block text-sm font-bold text-gray-700 mb-1.5">Nama Lengkap <span class="text-red-500">*</span></label>
                        <input type="text" name="name" id="name" value="{{ old('name', $kaprodi->name) }}" required
                            class="w-full px-4 py-2.5 bg-white border border-gray-300 rounded-xl focus:ring-2 focus:ring-pink-500 outline-none transition text-sm"
                            placeholder="Contoh: Dr. Ahmad, M.Pd"/>
                        @error('name') <p class="text-red-500 text-[10px] mt-1">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label for="email" class="block text-sm font-bold text-gray-700 mb-1.5">Email Login <span class="text-red-500">*</span></label>
                        <input type="email" name="email" id="email" value="{{ old('email', $kaprodi->email) }}" required
                            class="w-full px-4 py-2.5 bg-white border border-gray-300 rounded-xl focus:ring-2 focus:ring-pink-500 outline-none transition text-sm"
                            placeholder="nama@uinsaid.ac.id"/>
                        @error('email') <p class="text-red-500 text-[10px] mt-1">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label for="prodi" class="block text-sm font-bold text-gray-700 mb-1.5">Program Studi <span class="text-red-500">*</span></label>
                        <input type="text" name="prodi" id="prodi" value="{{ old('prodi', $kaprodi->prodi) }}" required
                            class="w-full px-4 py-2.5 bg-white border border-gray-300 rounded-xl focus:ring-2 focus:ring-pink-500 outline-none transition text-sm"
                            placeholder="Nama Prodi"/>
                        @error('prodi') <p class="text-red-500 text-[10px] mt-1">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label for="fakultas" class="block text-sm font-bold text-gray-700 mb-1.5">Fakultas <span class="text-red-500">*</span></label>
                        <input type="text" name="fakultas" id="fakultas" value="{{ old('fakultas', $kaprodi->fakultas) }}" required
                            class="w-full px-4 py-2.5 bg-white border border-gray-300 rounded-xl focus:ring-2 focus:ring-pink-500 outline-none transition text-sm"
                            placeholder="Nama Fakultas"/>
                        @error('fakultas') <p class="text-red-500 text-[10px] mt-1">{{ $message }}</p> @enderror
                    </div>
                </div>
            </div>

            {{-- Section: Password --}}
            <div class="space-y-5 p-5 md:p-6 border border-yellow-100 rounded-2xl bg-yellow-50/50">
                <div class="flex items-center gap-2 mb-2">
                    <h3 class="text-md font-bold text-yellow-800">Ubah Keamanan</h3>
                    <span class="text-[10px] bg-yellow-200 text-yellow-800 px-2 py-0.5 rounded-full font-bold uppercase">Opsional</span>
                </div>
                <p class="text-xs text-yellow-700 leading-relaxed mb-4">Kosongkan jika tidak ingin mengganti kata sandi kaprodi.</p>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                    <div class="relative">
                        <label for="password" class="block text-sm font-bold text-gray-700 mb-1.5">Password Baru</label>
                        <div class="relative">
                            <input type="password" name="password" id="password"
                                class="w-full pl-4 pr-10 py-2.5 bg-white border border-gray-300 rounded-xl focus:ring-2 focus:ring-yellow-500 outline-none transition text-sm"
                                placeholder="Min. 8 karakter"/>
                            <button type="button" id="togglePassword" class="absolute inset-y-0 right-3 flex items-center text-gray-400 hover:text-yellow-600 transition">
                                <i data-lucide="eye" class="w-5 h-5"></i>
                            </button>
                        </div>
                        @error('password') <p class="text-red-500 text-[10px] mt-1">{{ $message }}</p> @enderror
                    </div>

                    <div class="relative">
                        <label for="password_confirmation" class="block text-sm font-bold text-gray-700 mb-1.5">Konfirmasi Password</label>
                        <div class="relative">
                            <input type="password" name="password_confirmation" id="password_confirmation"
                                class="w-full pl-4 pr-10 py-2.5 bg-white border border-gray-300 rounded-xl focus:ring-2 focus:ring-yellow-500 outline-none transition text-sm"
                                placeholder="Ulangi password"/>
                            <button type="button" id="togglePasswordConfirmation" class="absolute inset-y-0 right-3 flex items-center text-gray-400 hover:text-yellow-600 transition">
                                <i data-lucide="eye" class="w-5 h-5"></i>
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Tombol Aksi Responsif --}}
            <div class="flex flex-col-reverse md:flex-row justify-between items-center gap-4 pt-4 border-t border-gray-100">
                <a href="{{ route('admin.kaprodi') }}"
                    class="w-full md:w-auto inline-flex items-center justify-center gap-2 bg-gray-100 hover:bg-gray-200 text-gray-700 font-bold py-3 px-6 rounded-xl transition-all duration-200">
                    <i data-lucide="arrow-left" class="w-5 h-5"></i> Kembali
                </a>

                <button type="submit"
                    class="w-full md:w-auto inline-flex items-center justify-center gap-2 bg-green-600 hover:bg-green-700 text-white font-bold py-3 px-8 rounded-xl shadow-lg shadow-green-100 transition-all duration-300 transform hover:scale-[1.03] active:scale-95">
                    <i data-lucide="save" class="w-5 h-5"></i> Simpan Perubahan
                </button>
            </div>

        </form>
    </div>
@endsection

@push('scripts')
    <script>
        // Fungsi Toggle Password modern
        function initPasswordToggle(btnId, inputId) {
            const btn = document.getElementById(btnId);
            const input = document.getElementById(inputId);
            if (btn && input) {
                btn.addEventListener('click', () => {
                    const isPassword = input.type === 'password';
                    input.type = isPassword ? 'text' : 'password';
                    btn.innerHTML = `<i data-lucide="${isPassword ? 'eye-off' : 'eye'}" class="w-5 h-5"></i>`;
                    lucide.createIcons();
                });
            }
        }

        document.addEventListener('DOMContentLoaded', function() {
            initPasswordToggle('togglePassword', 'password');
            initPasswordToggle('togglePasswordConfirmation', 'password_confirmation');

            // Clock update
            function updateClock() {
                const now = new Date();
                const d = now.toLocaleDateString('id-ID', { weekday: 'long', year: 'numeric', month: 'long', day: 'numeric' });
                const t = now.toLocaleTimeString('id-ID', { hour: '2-digit', minute: '2-digit' }) + ' WIB';
                document.getElementById('currentDate').textContent = d;
                document.getElementById('currentTime').textContent = t;
            }
            updateClock();
            setInterval(updateClock, 1000);
            lucide.createIcons();
        });
    </script>
@endpush
