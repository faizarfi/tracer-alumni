@extends('layouts.user')

@section('title', 'Formulir Alumni - UIN Raden Mas Said')

@section('content')
<div class="py-10 px-4 sm:px-6 lg:px-8">
    <div class="max-w-5xl mx-auto bg-white p-8 md:p-10 lg:p-12 rounded-[2rem] shadow-2xl mt-10 border border-gray-200 animate-fade-in">

        <div class="mb-10 text-center md:text-left">
            <a href="{{ route('user.dashboard') }}"
                class="inline-flex items-center px-6 py-2 rounded-full bg-emerald-600 text-white font-semibold hover:bg-emerald-700 shadow-lg transition duration-300 transform hover:-translate-y-1">
                <span class="iconify mr-2" data-icon="mdi:arrow-left" style="font-size: 20px;"></span>
                Kembali ke Dashboard
            </a>
        </div>

        <h2 class="text-3xl sm:text-4xl font-extrabold text-gray-800 mb-10 text-center font-['Poppins'] flex items-center justify-center gap-3">
            <span class="iconify w-9 h-9 text-green-600" data-icon="mdi:account-box-multiple-outline"></span>
            Formulir Profil Alumni
        </h2>
        <p class="text-center text-gray-600 mb-8">Lengkapi atau perbarui informasi pribadi dan akademik Anda.</p>

        {{-- Success/Error Alerts --}}
        @if(session('success'))
            <div id="alert-success" class="flex items-center gap-3 bg-green-100 border border-green-300 text-green-800 px-5 py-4 rounded-xl mb-8 shadow-sm justify-between" role="alert">
                <span class="flex items-center gap-2 font-medium">
                    <i data-lucide="check-circle" class="w-6 h-6 text-green-600"></i>
                    <span>{{ session('success') }}</span>
                </span>
                <button type="button" class="text-green-700 hover:text-green-900 focus:outline-none" onclick="this.parentElement.style.display='none'">
                    <i data-lucide="x" class="w-5 h-5"></i>
                </button>
            </div>
        @endif
        @if ($errors->any())
            <div class="flex flex-col gap-2 bg-red-100 border border-red-300 text-red-800 px-5 py-4 rounded-xl mb-8 shadow-sm" role="alert">
                <div class="flex items-center gap-3">
                    <i data-lucide="alert-octagon" class="w-6 h-6 text-red-600 flex-shrink-0"></i>
                    <span class="font-bold">Mohon koreksi kesalahan berikut sebelum menyimpan data:</span>
                </div>
                <ul class="list-disc ml-8 text-sm">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        {{-- Form Starts Here --}}
        <form action="{{ url('/user/profil') }}" method="POST" enctype="multipart/form-data" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @csrf
            {{-- Gunakan PUT untuk update jika data alumni sudah ada --}}
            @if(isset($alumni) && $alumni->exists)
                @method('PUT')
            @endif

            {{-- Kolom 1: Foto Profil (diperluas ke 3 kolom untuk tampilan yang lebih baik) --}}
            <div class="col-span-1 md:col-span-2 lg:col-span-3 bg-green-50 p-6 rounded-xl border border-green-200 shadow-inner flex flex-col items-center mb-4">
                <label class="block text-lg font-bold text-green-800 mb-4">
                    Foto Profil <span class="text-red-500">*</span>
                </label>
                <div class="profile-img-container mb-4 relative">
                    {{-- PEMANGGILAN FOTO PROFIL DENGAN STORAGE::URL --}}
                    <img id="profile-preview"
                            src="{{ (isset($alumni) && $alumni->foto_path)
                                    ? \Illuminate\Support\Facades\Storage::url($alumni->foto_path)
                                    : 'https://placehold.co/150x150/e5e7eb/6b7280?text=U+P' }}"
                            alt="Foto Profil"
                            onerror="this.onerror=null;this.src='https://placehold.co/150x150/e5e7eb/6b7280?text=U+P';"
                            class="w-full h-full object-cover">
                </div>
                {{-- INPUT FOTO --}}
                <input type="file" name="foto" id="foto" accept="image/jpeg,image/png"
                        class="text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-green-100 file:text-green-700 hover:file:bg-green-200 transition duration-200"
                        {{ !(isset($alumni) && $alumni->foto_path) ? 'required' : '' }}>
                <p class="text-xs text-gray-500 mt-2">Max 2MB. JPG/PNG. {{ (isset($alumni) && $alumni->foto_path) ? 'Kosongkan jika tidak ingin diganti.' : '' }}</p>
                @error('foto') <p class="text-sm text-red-500 mt-1">{{ $message }}</p> @enderror
            </div>

            {{-- Group 1: Data Pribadi --}}
            <div class="lg:col-span-1 md:col-span-2 space-y-6">
                <h3 class="text-xl font-bold text-green-700 border-b pb-2 mb-4">Data Pribadi</h3>

                {{-- Nama Lengkap --}}
                <div class="bg-white p-4 rounded-xl shadow-sm border border-gray-200">
                    <label for="nama" class="block text-sm font-semibold text-gray-700 mb-1">Nama Lengkap <span class="text-red-500">*</span></label>
                    <div class="relative">
                        <span class="absolute left-3 top-1/2 -translate-y-1/2 text-gray-400 iconify" data-icon="mdi:account"></span>
                        <input type="text" name="nama" id="nama" value="{{ old('nama', $alumni->nama ?? '') }}"
                            placeholder="Ahmad Yani"
                            class="pl-10 w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-green-500 transition duration-200 text-gray-800" required>
                    </div>
                    @error('nama') <p class="text-sm text-red-500 mt-1">{{ $message }}</p> @enderror
                </div>

                {{-- NIM --}}
                <div class="bg-white p-4 rounded-xl shadow-sm border border-gray-200">
                    <label for="nim" class="block text-sm font-semibold text-gray-700 mb-1">NIM <span class="text-red-500">*</span></label>
                    <div class="relative">
                        <span class="absolute left-3 top-1/2 -translate-y-1/2 text-gray-400 iconify" data-icon="mdi:card-account-details-outline"></span>
                        <input type="text" name="nim" id="nim" value="{{ old('nim', $alumni->nim ?? '') }}"
                            placeholder="202012345"
                            class="pl-10 w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-green-500 transition duration-200 text-gray-800" required>
                    </div>
                    @error('nim') <p class="text-sm text-red-500 mt-1">{{ $message }}</p> @enderror
                </div>

                {{-- Tanggal Lahir --}}
                <div class="bg-white p-4 rounded-xl shadow-sm border border-gray-200">
                    <label for="tanggal_lahir" class="block text-sm font-semibold text-gray-700 mb-1">Tanggal Lahir <span class="text-red-500">*</span></label>
                    <input type="date" name="tanggal_lahir" id="tanggal_lahir" value="{{ old('tanggal_lahir', $alumni->tanggal_lahir ?? '') }}"
                        class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-green-500 transition duration-200 text-gray-800" required>
                    @error('tanggal_lahir') <p class="text-sm text-red-500 mt-1">{{ $message }}</p> @enderror
                </div>

                {{-- Asal Daerah --}}
                <div class="bg-white p-4 rounded-xl shadow-sm border border-gray-200">
                    <label for="asal" class="block text-sm font-semibold text-gray-700 mb-1">Asal Daerah <span class="text-red-500">*</span></label>
                    <div class="relative">
                        <span class="absolute left-3 top-1/2 -translate-y-1/2 text-gray-400 iconify" data-icon="mdi:map-marker-radius-outline"></span>
                        <input type="text" name="asal" id="asal" value="{{ old('asal', $alumni->asal ?? '') }}"
                            placeholder="Surakarta"
                            class="pl-10 w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-green-500 transition duration-200 text-gray-800" required>
                    </div>
                    @error('asal') <p class="text-sm text-red-500 mt-1">{{ $message }}</p> @enderror
                </div>
            </div>

            {{-- Group 2: Data Akademik --}}
            <div class="lg:col-span-1 md:col-span-2 space-y-6">
                <h3 class="text-xl font-bold text-green-700 border-b pb-2 mb-4">Data Akademik</h3>

                {{-- Tahun Masuk --}}
                <div class="bg-white p-4 rounded-xl shadow-sm border border-gray-200">
                    <label for="tahun_masuk" class="block text-sm font-semibold text-gray-700 mb-1">Tahun Masuk <span class="text-red-500">*</span></label>
                    <div class="relative">
                        <span class="absolute left-3 top-1/2 -translate-y-1/2 text-gray-400 iconify" data-icon="mdi:calendar-arrow-left"></span>
                        <input type="number" name="tahun_masuk" id="tahun_masuk" value="{{ old('tahun_masuk', $alumni->tahun_masuk ?? '') }}"
                            placeholder="2018" min="1950" max="{{ date('Y') }}"
                            class="pl-10 w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-green-500 transition duration-200 text-gray-800" required>
                    </div>
                    @error('tahun_masuk') <p class="text-sm text-red-500 mt-1">{{ $message }}</p> @enderror
                </div>

                {{-- Tahun Keluar --}}
                <div class="bg-white p-4 rounded-xl shadow-sm border border-gray-200">
                    <label for="tahun_keluar" class="block text-sm font-semibold text-gray-700 mb-1">Tahun Keluar <span class="text-red-500">*</span></label>
                    <div class="relative">
                        <span class="absolute left-3 top-1/2 -translate-y-1/2 text-gray-400 iconify" data-icon="mdi:calendar-arrow-right"></span>
                        <input type="number" name="tahun_keluar" id="tahun_keluar" value="{{ old('tahun_keluar', $alumni->tahun_keluar ?? '') }}"
                            placeholder="2023" min="1950" max="{{ date('Y') + 5 }}"
                            class="pl-10 w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-green-500 transition duration-200 text-gray-800" required>
                    </div>
                    @error('tahun_keluar') <p class="text-sm text-red-500 mt-1">{{ $message }}</p> @enderror
                </div>

                {{-- Fakultas --}}
                <div class="bg-white p-4 rounded-xl shadow-sm border border-gray-200">
                    <label for="fakultas" class="block text-sm font-semibold text-gray-700 mb-1">Fakultas <span class="text-red-500">*</span></label>
                    <select name="fakultas" id="fakultas"
                        class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-green-500 transition duration-200 text-gray-800" required>
                        <option value="">-- Pilih Fakultas --</option>
                        <option value="Fakultas Adab dan Bahasa" {{ old('fakultas', $alumni->fakultas ?? '') == 'Fakultas Adab dan Bahasa' ? 'selected' : '' }}>Fakultas Adab dan Bahasa</option>
                        <option value="Fakultas Ekonomi Dan Bisnis Islam" {{ old('fakultas', $alumni->fakultas ?? '') == 'Fakultas Ekonomi Dan Bisnis Islam' ? 'selected' : '' }}>Fakultas Ekonomi Dan Bisnis Islam</option>
                        <option value="Fakultas Ilmu Tarbiyah" {{ old('fakultas', $alumni->fakultas ?? '') == 'Fakultas Ilmu Tarbiyah' ? 'selected' : '' }}>Fakultas Ilmu Tarbiyah</option>
                        <option value="Fakultas Ushuluddin dan Dakwah" {{ old('fakultas', $alumni->fakultas ?? '') == 'Fakultas Ushuluddin dan Dakwah' ? 'selected' : '' }}>Fakultas Ushuluddin dan Dakwah</option>
                        <option value="Fakultas Syariah" {{ old('fakultas', $alumni->fakultas ?? '') == 'Fakultas Syariah' ? 'selected' : '' }}>Fakultas Syariah</option>
                    </select>
                    @error('fakultas') <p class="text-sm text-red-500 mt-1">{{ $message }}</p> @enderror
                </div>

                {{-- Jurusan (Dynamic) --}}
                <div class="bg-white p-4 rounded-xl shadow-sm border border-gray-200">
                    <label for="jurusan" class="block text-sm font-semibold text-gray-700 mb-1">Jurusan <span class="text-red-500">*</span></label>
                    <select name="jurusan" id="jurusan"
                        class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-green-500 transition duration-200 text-gray-800" required>
                        <option value="">-- Pilih Jurusan --</option>
                    </select>
                    @error('jurusan') <p class="text-sm text-red-500 mt-1">{{ $message }}</p> @enderror
                </div>
            </div>

            {{-- Group 3: Data Pekerjaan & Testimoni --}}
            <div class="lg:col-span-1 md:col-span-2 space-y-6">
                <h3 class="text-xl font-bold text-green-700 border-b pb-2 mb-4">Status Pekerjaan</h3>

                {{-- Status Pekerjaan --}}
                <div class="bg-white p-4 rounded-xl shadow-sm border border-gray-200">
                    <label for="status-kerja" class="block text-sm font-semibold text-gray-700 mb-1">Status Pekerjaan <span class="text-red-500">*</span></label>
                    <select name="sudah_bekerja" id="status-kerja"
                        class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-green-500 transition duration-200 text-gray-800" required>
                        <option value="1" {{ old('sudah_bekerja', $alumni->sudah_bekerja ?? '') == 1 ? 'selected' : '' }}>Sudah Bekerja</option>
                        <option value="0" {{ old('sudah_bekerja', $alumni->sudah_bekerja ?? '') == 0 ? 'selected' : '' }}>Belum Bekerja</option>
                    </select>
                    @error('sudah_bekerja') <p class="text-sm text-red-500 mt-1">{{ $message }}</p> @enderror
                </div>

                {{-- Kolom Tempat Bekerja (Conditional) --}}
                <div id="input-tempat-kerja" class="bg-white p-4 rounded-xl shadow-sm border border-gray-200">
                    <label for="tempat_bekerja" class="block text-sm font-semibold text-gray-700 mb-1">Tempat Bekerja <span class="text-red-500">*</span></label>
                    <div class="relative">
                        <span class="absolute left-3 top-1/2 -translate-y-1/2 text-gray-400 iconify" data-icon="mdi:office-building-outline"></span>
                        <input type="text" name="tempat_bekerja" id="tempat_bekerja" value="{{ old('tempat_bekerja', $alumni->tempat_bekerja ?? '') }}"
                            placeholder="Contoh: PT Telkom Indonesia"
                            class="pl-10 w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-green-500 transition duration-200 text-gray-800">
                    </div>
                    @error('tempat_bekerja') <p class="text-sm text-red-500 mt-1">{{ $message }}</p> @enderror
                </div>

                {{-- TESTIMONI SECTION (Revisi untuk Pengiriman Pending) --}}
                <div class="bg-blue-50 p-4 rounded-xl shadow-sm border border-blue-200 col-span-full">
                    <h3 class="text-xl font-bold text-blue-700 border-b pb-2 mb-4">Testimoni Anda</h3>

                    <label for="testimonial_quote" class="font-medium text-gray-800 text-sm mb-1 block">Kutipan Testimoni (Maksimal 500 Karakter):</label>
                    <textarea name="testimonial_quote" id="testimonial_quote" rows="3" maxlength="500" class="w-full p-3 rounded-lg border-blue-300 shadow-md focus:ring-blue-500 focus:border-blue-500 transition-all duration-200" placeholder="UIN RMS sangat membantu karir saya...">{{ old('testimonial_quote', $alumni->testimonial_quote ?? '') }}</textarea>
                    @error('testimonial_quote') <p class="text-sm text-red-500 mt-1">{{ $message }}</p> @enderror


                    <div class="mt-4 pt-3 border-t border-blue-100">
                        <label class="flex items-center space-x-3 cursor-pointer">
                            {{-- Hidden field agar nilai false tetap terkirim jika checkbox tidak dicentang --}}
                            <input type="hidden" name="request_publish" value="0">
                            {{-- Checkbox mencatat kesediaan untuk publikasi. Status akan menjadi 'pending' di Controller --}}
                            @php
                                // Cek apakah testimoni saat ini sudah pernah disetujui/pending atau old input meminta publish
                                $isRequestingPublish = old('request_publish') == 1 ||
                                                        (isset($alumni) && in_array($alumni->testimonial_status, ['pending', 'approved']));
                            @endphp
                            <input type="checkbox" name="request_publish" value="1" id="request_publish_checkbox" class="w-5 h-5 text-green-600 border-gray-300 rounded focus:ring-green-500" {{ $isRequestingPublish ? 'checked' : '' }}>

                            <span class="text-sm text-gray-700 font-medium">
                                Saya bersedia testimoni ini ditinjau dan dipublikasikan di Dashboard Alumni (setelah disetujui Admin).
                            </span>
                        </label>

                        {{-- Tampilkan Status Testimoni Saat Ini --}}
                        @if(isset($alumni) && $alumni->testimonial_quote)
                            <p class="text-xs mt-2 text-blue-600">Status Testimoni Sebelumnya:
                                @if($alumni->testimonial_status == 'approved')
                                    <span class="font-bold text-green-600">Disetujui dan Tampil</span>
                                @elseif($alumni->testimonial_status == 'rejected')
                                    <span class="font-bold text-red-600">Ditolak</span>
                                @else
                                    <span class="font-bold text-yellow-600">Menunggu Review Admin</span>
                                @endif
                            </p>
                        @endif
                    </div>
                </div>
            </div>


            {{-- Submit Button (Full Width di Bawah) --}}
            <div class="col-span-1 md:col-span-2 lg:col-span-3 flex justify-end items-center mt-6 pt-6 border-t border-gray-200">
                <button type="submit"
                    class="inline-flex items-center gap-2 bg-gradient-to-r from-green-500 to-green-600 hover:from-green-600 hover:to-green-700 text-white px-8 py-3 rounded-full shadow-xl transition-all duration-300 ease-in-out focus:ring-2 focus:ring-green-300 transform hover:-translate-y-1">
                    <span class="iconify w-5 h-5" data-icon="mdi:content-save-outline"></span>
                    Simpan Data Profil
                </button>
            </div>

        </form>
    </div>
</div>

<script>
    // JavaScript Interaktif untuk form
    document.addEventListener('DOMContentLoaded', function () {
        const selectStatusKerja = document.getElementById('status-kerja');
        const tempatKerjaDiv = document.getElementById('input-tempat-kerja');
        const tempatKerjaInput = document.getElementById('tempat_bekerja');
        const inputFoto = document.getElementById('foto');
        const profilePreview = document.getElementById('profile-preview');

        // --- Logika Status Pekerjaan ---
        function toggleTempatKerja() {
            // Check if 'Sudah Bekerja' (value '1') is selected
            const isBekerja = selectStatusKerja.value === '1';

            if (isBekerja) {
                tempatKerjaDiv.style.display = 'block';
                // Jika isBekerja, pastikan inputnya diperlukan
                tempatKerjaInput.setAttribute('required', 'required');
            } else {
                tempatKerjaDiv.style.display = 'none';
                tempatKerjaInput.removeAttribute('required');
                tempatKerjaInput.value = ''; // Clear value if hidden
            }
        }

        selectStatusKerja.addEventListener('change', toggleTempatKerja);
        toggleTempatKerja(); // Initialize on page load

        // --- Jurusan Dropdown Logic ---
        const selectFakultas = document.getElementById('fakultas');
        const selectJurusan = document.getElementById('jurusan');
        // Dapatkan nilai lama dari Blade
        const oldJurusanValue = "{{ old('jurusan', $alumni->jurusan ?? '') }}";

        // Define your jurusan options based on faculty (UPDATED with new data)
        const jurusanOptions = {
            "Fakultas Adab dan Bahasa": [
                "S1 - Bahasa dan Sastra Arab",
                "S1 - Ilmu Perpustakaan dan Informasi Islam",
                "S1 - Pendidikan Bahasa Inggris",
                "S1 - Sastra Inggris",
                "S1 - Sejarah Peradaban Islam",
                "S1 - Tadris Bahasa Indonesia"
            ],
            "Fakultas Ekonomi Dan Bisnis Islam": [
                "S1 - Akuntansi Syariah",
                "S1 - Ekonomi Syariah",
                "S1 - Manajemen Bisnis Syariah",
                "S1 - Perbankan Syariah",
                "S1 - Manajemen Zakat dan Wakaf",
                "S1 - Bisnis Digital"
            ],
            "Fakultas Ilmu Tarbiyah": [
                "S1 - Bioteknologi",
                "S1 - Ilmu Lingkungan",
                "S1 - Manajemen Pendidikan Islam",
                "S1 - Pendidikan Agama Islam",
                "S1 - Pendidikan Bahasa Arab",
                "S1 - Pendidikan Guru Madrasah Ibtidaiyah",
                "S1 - Pendidikan Islam Anak Usia Dini",
                "S1 - Sains Data",
                "S1 - Tadris Biologi",
                "S1 - Tadris Matematika",
                "S1 - Teknologi Pangan",
                "S1 - Informatika"
            ],
            "Fakultas Ushuluddin dan Dakwah": [
                "S1 - Aqidah dan Filsafat Islam",
                "S1 - Bimbingan dan Konseling Islam",
                "S1 - Ilmu Al-Qur’an dan Tafsir",
                "S1 - Komunikasi dan Penyiaran Islam",
                "S1 - Manajemen Dakwah",
                "S1 - Psikologi Islam",
                "S1 - Pemikiran Politik Islam",
                "S1 - Tasawuf dan Psikoterapi"
            ],
            "Fakultas Syariah": [
                "S1 - Hukum Ekonomi Syariah",
                "S1 - Hukum Keluarga Islam",
                "S1 - Hukum Pidana Islam",
                "S1 - Hukum Bisnis"
            ]
        };

        function updateJurusanDropdown() {
            const selectedFakultas = selectFakultas.value;
            const jurusans = jurusanOptions[selectedFakultas] || [];

            selectJurusan.innerHTML = '<option value="">-- Pilih Jurusan --</option>';

            jurusans.forEach(jurusan => {
                const option = document.createElement('option');
                option.value = jurusan;
                option.textContent = jurusan;

                // Retain old value if it matches
                if (oldJurusanValue === jurusan) {
                    option.selected = true;
                }
                selectJurusan.appendChild(option);
            });
        }

        selectFakultas.addEventListener('change', updateJurusanDropdown);
        updateJurusanDropdown();

        // --- Image Preview Logic ---
        inputFoto.addEventListener('change', function(event) {
            const file = event.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    profilePreview.src = e.target.result;
                };
                reader.readAsDataURL(file);
            }
        });

    });
</script>
@endsection
