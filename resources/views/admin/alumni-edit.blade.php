<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8" />
    <title>Edit Data Alumni - {{ $alumni->nama ?? 'Admin UIN RMS' }}</title>
    <meta name="viewport" content="width=device-width, initial-scale=1" />

    <link rel="icon" type="image/png" href="{{ asset('img/uin.png') }}" />

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&family=Poppins:wght@600;700;800&display=swap" rel="stylesheet">

    <script src="https://cdn.tailwindcss.com"></script>

    <script src="https://code.iconify.design/iconify-icon/1.0.7/iconify-icon.min.js"></script>
    <script src="https://unpkg.com/lucide@latest"></script>

    <style>
        /* Global Styles for smooth scroll and font consistency */
        html { scroll-behavior: smooth; }
        body { font-family: 'Inter', sans-serif; @apply text-gray-800; background-color: #f0fdf4; /* Light fresh green background */ }
        h1, h2, h3, h4 { font-family: 'Poppins', sans-serif; }

        /* Custom scrollbar */
        ::-webkit-scrollbar { width: 8px; }
        ::-webkit-scrollbar-track { background: #f0fdf4; }
        ::-webkit-scrollbar-thumb { background: #065f46; border-radius: 4px; }
        ::-webkit-scrollbar-thumb:hover { background: #047857; }

        /* Animations */
        @keyframes fade-in { from { opacity: 0; transform: translateY(20px); } to { opacity: 1; transform: translateY(0); } }
        .animate-fade-in { animation: fade-in 0.8s ease-out forwards; }

        /* Sidebar specific styles */
        #sidebar {
            position: fixed; top: 0; left: 0; width: 100%; max-width: 256px; height: 100vh;
            transform: translateX(-100%); transition: transform 0.3s ease-in-out; z-index: 50;
            box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05);
            display: flex; flex-direction: column;
        }
        #sidebar.open { transform: translateX(0); }
        @media (min-width: 768px) {
            #sidebar { position: sticky; transform: translateX(0); flex-shrink: 0; width: 256px; height: 100vh; z-index: 30; }
        }
        #sidebar-overlay {
            position: fixed; top: 0; left: 0; width: 100%; height: 100%;
            background-color: rgba(0, 0, 0, 0.5); z-index: 40; display: none;
        }

        /* Active Sidebar Link Style */
        .sidebar-link { transition: background-color 0.2s; }
        .sidebar-link.active {
            background-color: rgba(255, 255, 255, 0.2);
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
        }

        /* Input focus glow effect: Adjusted to blue for contrast in form */
        input:focus, select:focus, textarea:focus {
            --tw-ring-color: #3B82F6 !important; /* blue-500 */
            border-color: #2563EB !important; /* blue-600 */
        }
    </style>
</head>

<body class="bg-green-50 min-h-screen flex flex-col">

    {{-- Main wrapper for sidebar and content --}}
    <div class="flex flex-1 flex-col md:flex-row">

        {{-- Sidebar (Using static code since it's a self-contained file) --}}
        <aside id="sidebar" class="bg-gradient-to-b from-green-900 via-green-800 to-green-700 text-white">
            <div class="p-5 border-b border-green-700 text-center select-none bg-green-950">
                <h2 class="text-xl font-extrabold tracking-wide font-['Poppins']">Admin Panel</h2>
            </div>
            <nav class="px-4 py-6 flex flex-col space-y-3 flex-1">
                {{-- Navigation Links --}}
                <a href="{{ route('admin.dashboard') }}" class="sidebar-link flex items-center gap-3 px-4 py-2.5 rounded-lg text-white font-semibold text-sm hover:bg-white/10 group">
                    <iconify-icon icon="mdi:view-dashboard" class="w-5 h-5 text-green-300"></iconify-icon>
                    <span>Dashboard</span>
                </a>
                <a href="{{ route('admin.kuisioner') }}" class="sidebar-link flex items-center gap-3 px-4 py-2.5 rounded-lg text-white font-semibold text-sm hover:bg-white/10 group">
                    <iconify-icon icon="mdi:clipboard-text-outline" class="w-5 h-5 text-yellow-300"></iconify-icon>
                    <span>Manajemen Kuesioner</span>
                </a>
                <div class="space-y-1">
                    <a href="javascript:void(0)" class="flex items-center gap-3 px-4 py-2.5 rounded-lg text-white font-semibold text-sm hover:bg-white/10 group">
                        <iconify-icon icon="mdi:message-badge-outline" class="w-5 h-5 text-red-300"></iconify-icon>
                        <span>Manajemen Testimoni</span>
                    </a>
                    <div class="pl-6 space-y-1 border-l ml-3 border-red-500">
                        <a href="{{ route('admin.testimonials.review') }}" class="sidebar-link flex items-center gap-3 px-4 py-2.5 rounded-lg text-white font-normal text-xs hover:bg-white/10"><i data-lucide="bell" class="w-4 h-4 text-red-400"></i><span>Menunggu Review</span></a>
                        <a href="{{ route('admin.testimonials.approved') }}" class="sidebar-link flex items-center gap-3 px-4 py-2.5 rounded-lg text-white font-normal text-xs active"><i data-lucide="check-circle" class="w-4 h-4 text-green-300"></i><span>Testimoni Disetujui</span></a>
                        <a href="{{ route('admin.testimonials.rejected') }}" class="sidebar-link flex items-center gap-3 px-4 py-2.5 rounded-lg text-white font-normal text-xs hover:bg-white/10"><i data-lucide="x-circle" class="w-4 h-4 text-yellow-300"></i><span>Testimoni Ditolak</span></a>
                    </div>
                </div>

                <a href="{{ route('admin.alumni') }}" class="sidebar-link flex items-center gap-3 px-4 py-2.5 rounded-lg text-white font-semibold text-sm active group">
                    <iconify-icon icon="mdi:account-multiple-outline" class="w-5 h-5 text-blue-300"></iconify-icon>
                    <span>Manajemen Alumni</span>
                </a>
                <a href="{{ route('admin.gallery') }}"
                   class="sidebar-link flex items-center gap-3 px-4 py-2.5 rounded-lg text-white font-semibold text-sm hover:bg-white/10 group">
                    <iconify-icon icon="mdi:image-multiple-outline" class="w-5 h-5 text-purple-300"></iconify-icon>
                    <span>Manajemen Gallery</span>
                </a>

                {{-- Logout Button --}}
                <form action="{{ route('logout') }}" method="POST" class="mt-auto pt-6">
                    @csrf
                    <button type="submit"
                        class="flex items-center gap-3 w-full px-4 py-2.5 rounded-lg bg-red-600 hover:bg-red-700 text-white font-semibold text-sm shadow-md transition duration-300 ease-in-out group">
                        <iconify-icon icon="mdi:logout" class="w-5 h-5"></iconify-icon>
                        <span>Logout</span>
                    </button>
                </form>
            </nav>
        </aside>

        {{-- Sidebar Overlay for Mobile --}}
        <div id="sidebar-overlay" class="md:hidden"></div>

        {{-- Main Content --}}
        <main class="flex-1 p-4 sm:p-6 lg:p-8 flex flex-col">
            {{-- Top Bar for Mobile/Tablet --}}
            <div class="flex justify-between items-center mb-6 md:hidden w-full">
                <button id="sidebarToggle" class="text-white bg-green-700 p-2.5 rounded-md shadow-md hover:bg-green-800 transition-colors focus:outline-none focus:ring-2 focus:ring-green-600">
                    <iconify-icon icon="mdi:menu" class="w-5 h-5"></iconify-icon>
                </button>
                <div class="flex items-center gap-3">
                    <span class="text-base font-semibold text-green-900">Halo, Admin!</span>
                    <img src="https://via.placeholder.com/36/065f46/ffffff?text=AD" alt="Admin Avatar" class="w-9 h-9 rounded-full border-2 border-green-700 shadow-md">
                </div>
            </div>

            {{-- START CONTENT (Edit Data Alumni) --}}
            <div class="container mx-auto p-8 bg-white rounded-2xl shadow-xl max-w-4xl border border-gray-200 animate-fade-in">

                <header class="mb-8 border-b pb-4 flex justify-between items-center">
                    <div>
                        <h1 class="text-3xl font-extrabold text-blue-700 drop-shadow-sm font-['Poppins']">
                            Edit Data Alumni
                        </h1>
                        <p class="text-gray-600 mt-1">Mengubah data profil: <strong class="text-gray-800">{{ $alumni->nama ?? 'N/A' }}</strong> (ID: {{ $alumni->user_id ?? 'N/A' }})</p>
                    </div>
                     <a href="{{ route('admin.alumni') }}"
                        class="hidden md:inline-flex items-center justify-center gap-2 text-green-600 hover:text-green-800 font-semibold py-2.5 px-4 rounded-full border border-green-600 bg-green-50 transition duration-300 transform hover:scale-[1.02]">
                        <span class="iconify" data-icon="mdi:arrow-left-circle-outline"></span>
                        Kembali
                    </a>
                </header>

                {{-- Notifikasi error dari Laravel --}}
                @if ($errors->any())
                    <div class="bg-red-100 border border-red-300 text-red-800 p-5 mb-8 rounded-xl shadow-sm animate-fade-in">
                        <p class="font-bold mb-3 flex items-center gap-2">
                            <i data-lucide="alert-triangle" class="w-6 h-6 flex-shrink-0"></i>
                            Terjadi kesalahan validasi:
                        </p>
                        <ul class="list-disc list-inside space-y-1 text-sm">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form id="editAlumniForm" action="{{ route('admin.alumni.update', $alumni->user_id ?? '0') }}" method="POST" class="space-y-8" novalidate>
                    @csrf
                    @method('PUT')

                    {{-- Section: Data Pribadi & Akademik --}}
                    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">

                        {{-- KOLOM KIRI: DATA PRIBADI --}}
                        <div class="space-y-6 bg-blue-50 p-6 rounded-xl border border-blue-200 shadow-lg">
                            <h3 class="text-xl font-bold text-blue-700 border-b pb-2 mb-4 flex items-center gap-2">
                                <i data-lucide="user-square" class="w-5 h-5"></i> Data Pribadi
                            </h3>

                            {{-- Helper PHP (Input Fields) --}}
                            @php
                                function inputField($id, $label, $type, $value, $placeholder, $required = false) {
                                    $req = $required ? 'required' : '';
                                    $reqClass = $required ? 'after:content-["*"] after:ml-1 after:text-red-500' : '';
                                    $iconMap = [
                                        'nama' => 'mdi:account-outline',
                                        'nim' => 'mdi:card-account-details-outline',
                                        'tanggal_lahir' => 'mdi:calendar-check-outline',
                                        'asal' => 'mdi:map-marker-radius-outline',
                                    ];
                                    $icon = $iconMap[$id] ?? '';
                                    $iconHtml = $icon ? '<span class="absolute left-3 top-1/2 -translate-y-1/2 text-gray-400 iconify" data-icon="' . $icon . '"></span>' : '';
                                    $inputClasses = "w-full px-4 py-2.5 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 transition duration-200 placeholder-gray-400 text-gray-900 text-base" . ($icon ? ' pl-10' : '');

                                    return <<<HTML
                                    <div>
                                        <label for="$id" class="block mb-1 font-semibold text-gray-700 text-sm $reqClass">$label</label>
                                        <div class="relative">
                                            $iconHtml
                                            <input type="$type" id="$id" name="$id" value="$value" $req
                                                placeholder="$placeholder"
                                                class="$inputClasses" />
                                            <p class="text-xs text-red-600 mt-1 hidden" id="${id}Error">Field ini wajib diisi.</p>
                                        </div>
                                    </div>
                                    HTML;
                                }
                            @endphp

                            {!! inputField('nama', 'Nama Lengkap', 'text', old('nama', $alumni->nama ?? ''), 'Masukkan nama lengkap', true) !!}
                            {!! inputField('nim', 'NIM', 'text', old('nim', $alumni->nim ?? ''), 'Masukkan NIM', true) !!}
                            {!! inputField('tanggal_lahir', 'Tanggal Lahir', 'date', old('tanggal_lahir', $alumni->tanggal_lahir ?? ''), 'Pilih tanggal lahir', true) !!}
                            {!! inputField('asal', 'Asal Daerah', 'text', old('asal', $alumni->asal ?? ''), 'Masukkan asal daerah') !!}
                        </div>

                        {{-- KOLOM KANAN: DATA AKADEMIK & PEKERJAAN --}}
                        <div class="space-y-6 bg-green-50 p-6 rounded-xl border border-green-200 shadow-lg">
                            <h3 class="text-xl font-bold text-green-700 border-b pb-2 mb-4 flex items-center gap-2">
                                <i data-lucide="graduation-cap" class="w-5 h-5"></i> Akademik & Status Kerja
                            </h3>

                            {{-- Tahun Masuk / Keluar --}}
                            <div class="grid grid-cols-2 gap-4">
                                {!! inputField('tahun_masuk', 'Tahun Masuk', 'number', old('tahun_masuk', $alumni->tahun_masuk ?? ''), '2018', true) !!}
                                {!! inputField('tahun_keluar', 'Tahun Keluar', 'number', old('tahun_keluar', $alumni->tahun_keluar ?? ''), '2023', true) !!}
                            </div>

                            {{-- Fakultas --}}
                            <div>
                                <label for="fakultas" class="block mb-1 font-semibold text-gray-700 text-sm after:content-['*'] after:ml-1 after:text-red-500">
                                    Fakultas
                                </label>
                                <select name="fakultas" id="fakultas"
                                    class="w-full px-4 py-2.5 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-green-500 transition duration-200 text-gray-900 text-base" required>
                                    <option value="">-- Pilih Fakultas --</option>
                                    <option value="Fakultas Adab dan Bahasa" {{ old('fakultas', $alumni->fakultas ?? '') == 'Fakultas Adab dan Bahasa' ? 'selected' : '' }}>Fakultas Adab dan Bahasa</option>
                                    <option value="Fakultas Ekonomi Dan Bisnis Islam" {{ old('fakultas', $alumni->fakultas ?? '') == 'Fakultas Ekonomi Dan Bisnis Islam' ? 'selected' : '' }}>Fakultas Ekonomi Dan Bisnis Islam</option>
                                    <option value="Fakultas Ilmu Tarbiyah" {{ old('fakultas', $alumni->fakultas ?? '') == 'Fakultas Ilmu Tarbiyah' ? 'selected' : '' }}>Fakultas Ilmu Tarbiyah</option>
                                    <option value="Fakultas Ushuluddin dan Dakwah" {{ old('fakultas', $alumni->fakultas ?? '') == 'Fakultas Ushuluddin dan Dakwah' ? 'selected' : '' }}>Fakultas Ushuluddin dan Dakwah</option>
                                    <option value="Fakultas Syariah" {{ old('fakultas', $alumni->fakultas ?? '') == 'Fakultas Syariah' ? 'selected' : '' }}>Fakultas Syariah</option>
                                </select>
                                <p class="text-xs text-red-600 mt-1 hidden" id="fakultasError">Field ini wajib diisi.</p>
                            </div>

                            {{-- Jurusan (Dynamic) --}}
                            <div>
                                <label for="jurusan" class="block mb-1 font-semibold text-gray-700 text-sm after:content-['*'] after:ml-1 after:text-red-500">
                                    Jurusan
                                </label>
                                <select name="jurusan" id="jurusan"
                                    class="w-full px-4 py-2.5 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-green-500 transition duration-200 text-gray-900 text-base" required>
                                    <option value="">-- Pilih Jurusan --</option>
                                </select>
                                <p class="text-xs text-red-600 mt-1 hidden" id="jurusanError">Field ini wajib diisi.</p>
                            </div>

                            {{-- Status Kerja --}}
                            <div>
                                <label for="sudah_bekerja" class="block mb-1 font-semibold text-gray-700 text-sm after:content-['*'] after:ml-1 after:text-red-500">
                                    Status Kerja
                                </label>
                                <select name="sudah_bekerja" id="sudah_bekerja" required
                                    class="w-full px-4 py-2.5 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-green-500 transition duration-200 text-gray-900 text-base">
                                    <option value="" disabled {{ old('sudah_bekerja', $alumni->sudah_bekerja ?? null) === null ? 'selected' : '' }}>-- Pilih Status --</option>
                                    <option value="1" {{ old('sudah_bekerja', $alumni->sudah_bekerja ?? '') == 1 ? 'selected' : '' }}>Bekerja</option>
                                    <option value="0" {{ old('sudah_bekerja', $alumni->sudah_bekerja ?? '') == 0 ? 'selected' : '' }}>Belum Bekerja</option>
                                </select>
                                <p class="text-xs text-red-600 mt-1 hidden" id="sudah_bekerjaError">Pilih status kerja.</p>
                            </div>

                            {{-- Tempat Bekerja (Conditional) --}}
                            <div id="tempat_bekerja_group">
                                <label for="tempat_bekerja" class="block mb-1 font-semibold text-gray-700 text-sm">Tempat Bekerja</label>
                                <div class="relative">
                                    <span class="absolute left-3 top-1/2 -translate-y-1/2 text-gray-400 iconify" data-icon="mdi:office-building-outline"></span>
                                    <input type="text" id="tempat_bekerja" name="tempat_bekerja" value="{{ old('tempat_bekerja', $alumni->tempat_bekerja ?? '') }}"
                                        placeholder="Isi jika status kerja 'Bekerja'"
                                        class="pl-10 w-full px-4 py-2.5 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-green-500 transition duration-200 disabled:bg-gray-100 disabled:text-gray-400 text-gray-900 text-base" />
                                    <p class="text-xs text-red-600 mt-1 hidden" id="tempat_bekerjaError">Tempat bekerja wajib diisi.</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Form Actions (Buttons) --}}
                    <div class="pt-6 flex flex-col sm:flex-row justify-between items-center gap-4 border-t border-gray-200">
                        <a href="{{ route('admin.alumni') }}"
                            class="w-full sm:w-auto text-center inline-flex items-center justify-center gap-2 text-green-600 hover:underline font-semibold py-2.5 px-6 rounded-full border border-green-600 transition duration-300 transform hover:-translate-y-0.5">
                            <span class="iconify" data-icon="mdi:arrow-left-circle-outline"></span>
                            Kembali ke Data Alumni
                        </a>

                        <button type="submit" id="submitBtn"
                            class="w-full sm:w-auto inline-flex items-center justify-center gap-2 bg-gradient-to-r from-green-500 to-green-600 hover:from-green-600 hover:to-green-700 text-white px-8 py-3 rounded-full shadow-lg transition-all duration-300 ease-in-out focus:ring-2 focus:ring-green-300 transform hover:-translate-y-0.5 font-semibold">
                            <span class="iconify" data-icon="mdi:content-save-outline"></span>
                            Simpan Perubahan
                        </button>
                    </div>
                </form>
            </div>

            <script>
                // Define the full list of jurusans based on the updated structure
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

                document.addEventListener('DOMContentLoaded', function () {
                    const sudahBekerjaSelect = document.getElementById('sudah_bekerja');
                    const tempatBekerjaGroup = document.getElementById('tempat_bekerja_group');
                    const tempatBekerjaInput = document.getElementById('tempat_bekerja');
                    const selectFakultas = document.getElementById('fakultas');
                    const selectJurusan = document.getElementById('jurusan');
                    const form = document.getElementById('editAlumniForm');

                    // --- Utility Functions ---
                    function showError(fieldId, message = 'Field ini wajib diisi.') {
                        const errorEl = document.getElementById(fieldId + 'Error');
                        const fieldInput = document.getElementById(fieldId);
                        if (errorEl && fieldInput) {
                            errorEl.textContent = message;
                            errorEl.classList.remove('hidden');
                            fieldInput.classList.add('ring-2', 'ring-red-500', 'border-red-500');
                        }
                    }

                    function hideError(fieldId) {
                        const errorEl = document.getElementById(fieldId + 'Error');
                        const fieldInput = document.getElementById(fieldId);
                        if (errorEl && fieldInput) {
                            errorEl.classList.add('hidden');
                            fieldInput.classList.remove('ring-2', 'ring-red-500', 'border-red-500');
                        }
                    }

                    function validateField(field) {
                        const value = field.value.trim();
                        const id = field.id;
                        let isValid = true;

                        if (field.hasAttribute('required') && !value) {
                            showError(id);
                            isValid = false;
                        } else if (id === 'tempat_bekerja' && field.hasAttribute('required') && !value) {
                            showError(id, 'Tempat bekerja wajib diisi jika status kerja "Bekerja".');
                            isValid = false;
                        } else {
                            hideError(id);
                        }
                        return isValid;
                    }

                    // --- Logic Functions ---

                    function toggleTempatBekerja() {
                        const isBekerja = sudahBekerjaSelect.value === '1';

                        if (isBekerja) {
                            tempatBekerjaGroup.style.display = 'block';
                            tempatBekerjaInput.setAttribute('required', 'required');
                            tempatBekerjaInput.removeAttribute('disabled');
                            tempatBekerjaInput.classList.remove('bg-gray-100', 'text-gray-400');
                        } else {
                            tempatBekerjaGroup.style.display = 'none';
                            tempatBekerjaInput.removeAttribute('required');
                            tempatBekerjaInput.setAttribute('disabled', 'true');
                            tempatBekerjaInput.classList.add('bg-gray-100', 'text-gray-400');
                            hideError('tempat_bekerja');
                        }
                    }

                    function updateJurusanDropdown() {
                        const selectedFakultas = selectFakultas.value;
                        const jurusans = jurusanOptions[selectedFakultas] || [];

                        // Mengambil nilai lama (dari DB atau old input)
                        const oldJurusanValue = selectJurusan.value;

                        selectJurusan.innerHTML = '<option value="">-- Pilih Jurusan --</option>';

                        jurusans.forEach(jurusan => {
                            const option = document.createElement('option');
                            option.value = jurusan;
                            option.textContent = jurusan;
                            selectJurusan.appendChild(option);
                        });

                        // Re-select old value if it's still valid
                        if (jurusans.includes(oldJurusanValue)) {
                             selectJurusan.value = oldJurusanValue;
                        } else {
                            // Logic to retain original DB value if possible or default to blank
                            const initialJurusan = "{{ $alumni->jurusan ?? '' }}";
                            const initialFakultas = "{{ $alumni->fakultas ?? '' }}";

                            if (selectedFakultas === initialFakultas && jurusans.includes(initialJurusan)) {
                                 selectJurusan.value = initialJurusan;
                            } else if (selectJurusan.value === '') {
                                 // If still empty, use the actual old input if available
                                 const currentOldJurusan = "{{ old('jurusan') ?? '' }}";
                                 if (jurusans.includes(currentOldJurusan)) {
                                     selectJurusan.value = currentOldJurusan;
                                 }
                            }
                        }

                        validateField(selectJurusan); // Re-validate jurusan after options change
                    }

                    // --- Event Listeners and Initialization ---

                    sudahBekerjaSelect.addEventListener('change', toggleTempatBekerja);
                    selectFakultas.addEventListener('change', updateJurusanDropdown);
                    selectJurusan.addEventListener('change', () => validateField(selectJurusan));

                    // Attach validation listeners for user input
                    document.querySelectorAll('input, select, textarea').forEach(field => {
                        field.addEventListener('blur', () => validateField(field));
                        field.addEventListener('change', () => validateField(field));
                    });

                    // Initial setup
                    toggleTempatBekerja();
                    updateJurusanDropdown(); // Must be called on load to populate based on initial fakultas value

                    // --- Form Submission Validation ---
                    form.addEventListener('submit', e => {
                        let formIsValid = true;

                        // Validate all required fields
                        document.querySelectorAll('input[required], select[required], textarea[required]').forEach(field => {
                            // Skip disabled fields
                            if (!field.hasAttribute('disabled')) {
                                if (!validateField(field)) {
                                    formIsValid = false;
                                }
                            }
                        });

                        if (!formIsValid) {
                            e.preventDefault();
                            alert('Mohon isi semua field wajib dengan benar sebelum menyimpan.');
                            const firstInvalid = document.querySelector('.ring-red-500');
                            if (firstInvalid) {
                                firstInvalid.scrollIntoView({ behavior: 'smooth', block: 'center' });
                            }
                        }
                    });
                });
            </script>
        </main>
    </div>

    {{-- Footer --}}
    <footer class="bg-gradient-to-r from-green-900 to-emerald-800 text-white mt-16 pt-16 pb-8 shadow-inner">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-10 text-sm">
            <div>
                <h2 class="text-xl font-bold mb-4 font-['Poppins']">Tracer Alumni UIN RMS</h2>
                <p class="text-green-200 leading-relaxed text-sm">
                    Sistem Tracer Alumni ini dirancang untuk menghimpun data alumni, mendukung peningkatan mutu pendidikan, dan akreditasi kampus.
                    Partisipasi Anda sangat berarti!
                </p>
            </div>

            <div>
                <h2 class="text-xl font-bold mb-4 flex items-center gap-2 font-['Poppins']" aria-label="Navigasi Cepat">
                    <i data-lucide="compass" class="w-5 h-5 text-green-300"></i> Navigasi Cepat
                </h2>
                <ul class="space-y-3 text-green-200">
                    <li>
                        <a href="{{ route('user.dashboard') }}#beranda" class="flex items-center gap-2 hover:text-white transition duration-300 ease-in-out">
                            <i data-lucide="info" class="w-4 h-4"></i> Beranda (User)
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('user.dashboard') }}#tentang" class="flex items-center gap-2 hover:text-white transition duration-300 ease-in-out">
                            <i data-lucide="info" class="w-4 h-4"></i> Tentang Tracer
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('user.kuisioner') }}" class="flex items-center gap-2 hover:text-white transition duration-300 ease-in-out">
                            <i data-lucide="clipboard-check" class="w-4 h-4"></i> Isi Kuesioner
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('user.cari-alumni') }}" class="flex items-center gap-2 hover:text-white transition duration-300 ease-in-out">
                            <i data-lucide="search" class="w-4 h-4"></i> Cari Alumni
                        </a>
                    </li>
                </ul>
            </div>

            <div>
                <h2 class="text-xl font-bold mb-4 font-['Poppins']">Tautan Terkait</h2>
                <ul class="space-y-3 text-green-200">
                    <li>
                        <a href="https://uinsaid.ac.id" target="_blank" rel="noopener noreferrer" class="hover:underline flex items-center gap-2">
                            <i data-lucide="globe" class="w-4 h-4"></i> Website Resmi UIN RMS
                        </a>
                    </li>
                    <li>
                        <a href="https://pmb.uinsaid.ac.id" target="_blank" rel="noopener noreferrer" class="hover:underline flex items-center gap-2">
                            <i data-lucide="graduation-cap" class="w-4 h-4"></i> PMB UIN RMS
                        </a>
                    </li>
                    <li>
                        <a href="https://e-journal.uinsaid.ac.id/" target="_blank" rel="noopener noreferrer" class="hover:underline flex items-center gap-2">
                            <i data-lucide="book-text" class="w-4 h-4"></i> E-Journal UIN RMS
                        </a>
                    </li>
                </ul>
            </div>

            <div>
                <h2 class="text-xl font-bold mb-4 font-['Poppins']">Kontak Kami</h2>
                <ul class="text-green-200 space-y-3">
                    <li>
                        <i data-lucide="mail" class="inline-block w-4 h-4 mr-2"></i>
                        <a href="mailto:tracer@uinsaid.ac.id" class="hover:underline" target="_blank">tracer@uinsaid.ac.id</a>
                    </li>
                    <li>
                        <i data-lucide="phone" class="inline-block w-4 h-4 mr-2"></i> (0271) 678901
                    </li>
                    <li>
                        <i data-lucide="instagram" class="inline-block w-4 h-4 mr-2"></i>
                        <a href="#" class="hover:underline" target="_blank">@traceruinrms</a>
                    </li>
                    <li>
                        <i data-lucide="map-pin" class="inline-block w-4 h-4 mr-2"></i>
                        Jl. Pandawa, Pucangan, Kartasura, Sukoharjo, Jawa Tengah 57168
                    </li>
                </ul>
            </div>
        </div>

        <div class="text-center text-green-300 text-xs border-t border-green-800 py-6 mt-12">
            &copy; {{ date('Y') }} UIN Raden Mas Said Surakarta. Hak Cipta Dilindungi Undang-Undang.

        </div>
    </footer>

    {{-- Scroll to Top Button --}}
    <button id="scrollTop" aria-label="Scroll to top"
        class="fixed bottom-6 right-6 z-50 hidden bg-green-700 hover:bg-green-800 text-white p-3 rounded-full shadow-xl transition-all duration-300 focus:outline-none focus:ring-2 focus:ring-green-500">
        <iconify-icon icon="mdi:arrow-up-bold" class="w-6 h-6"></iconify-icon>
    </button>

    {{-- Scripts --}}
    <script>
        // Global Modal Control (Minimal)
        function openModal(id) {
            const modal = document.getElementById(id);
            if(modal) {
                 modal.classList.remove('hidden');
                 document.body.style.overflow = 'hidden';
            }
        }
        function closeModal(id) {
            const modal = document.getElementById(id);
            if(modal) {
                modal.classList.add('hidden');
                document.body.style.overflow = '';
            }
        }

        document.addEventListener('DOMContentLoaded', function() {
            // New: Dynamic Header Date/Time
            const currentDateElement = document.getElementById('currentDate');
            const currentTimeElement = document.getElementById('currentTime');

            function updateTime() {
                const now = new Date();
                const optionsDate = { weekday: 'long', year: 'numeric', month: 'long', day: 'numeric' };
                const formattedDate = now.toLocaleDateString('id-ID', optionsDate);
                const formattedTime = now.toLocaleTimeString('id-ID', { hour: '2-digit', minute: '2-digit' });

                if(currentDateElement && currentTimeElement) {
                     currentDateElement.textContent = formattedDate;
                     currentTimeElement.textContent = formattedTime + ' WIB';
                }
            }

            updateTime();
            setInterval(updateTime, 1000);

            // Sidebar toggle for mobile
            const sidebarToggle = document.getElementById('sidebarToggle');
            const sidebar = document.getElementById('sidebar');
            const sidebarOverlay = document.getElementById('sidebar-overlay');

            // Handler untuk tombol toggle
            if (sidebarToggle && sidebar && sidebarOverlay) {
                sidebarToggle.addEventListener('click', () => {
                    sidebar.classList.toggle('open');
                    if (sidebar.classList.contains('open')) {
                        sidebarOverlay.style.display = 'block'; // Show overlay
                        document.body.style.overflow = 'hidden'; // Prevent body scroll when sidebar is open
                    } else {
                        sidebarOverlay.style.display = 'none'; // Hide overlay
                        document.body.style.overflow = ''; // Restore body scroll
                    }
                });

                // Handler untuk overlay (klik di luar sidebar)
                sidebarOverlay.addEventListener('click', () => {
                    sidebar.classList.remove('open');
                    sidebarOverlay.style.display = 'none'; // Hide overlay
                    document.body.style.overflow = ''; // Restore body scroll
                });

                // Close sidebar and hide overlay if window is resized to desktop from mobile
                window.addEventListener('resize', () => {
                    if (window.innerWidth >= 768) {
                        sidebar.classList.remove('open');
                        sidebarOverlay.style.display = 'none';
                        document.body.style.overflow = ''; // Ensure scroll is restored
                    }
                });
            }

            // Scroll to Top Button Logic
            const scrollTopBtn = document.getElementById('scrollTop');
            if (scrollTopBtn) {
                window.addEventListener('scroll', () => {
                    if (window.scrollY > 250) {
                        scrollTopBtn.classList.remove('hidden');
                    } else {
                        scrollTopBtn.classList.add('hidden');
                    }
                });
                scrollTopBtn.addEventListener('click', () => {
                    window.scrollTo({ top: 0, behavior: 'smooth' });
                });
            }

            // Initialize Lucide icons
            lucide.createIcons();


            // --- FORM LOGIC (START) ---
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

            const sudahBekerjaSelect = document.getElementById('sudah_bekerja');
            const tempatBekerjaGroup = document.getElementById('tempat_bekerja_group');
            const tempatBekerjaInput = document.getElementById('tempat_bekerja');
            const selectFakultas = document.getElementById('fakultas');
            const selectJurusan = document.getElementById('jurusan');
            const form = document.getElementById('editAlumniForm');


            // --- Utility & Validation Functions ---

            function showError(fieldId, message = 'Field ini wajib diisi.') {
                const errorEl = document.getElementById(fieldId + 'Error');
                const fieldInput = document.getElementById(fieldId);
                if (errorEl && fieldInput) {
                    errorEl.textContent = message;
                    errorEl.classList.remove('hidden');
                    fieldInput.classList.add('ring-2', 'ring-red-500', 'border-red-500');
                }
            }

            function hideError(fieldId) {
                const errorEl = document.getElementById(fieldId + 'Error');
                const fieldInput = document.getElementById(fieldId);
                if (errorEl && fieldInput) {
                    errorEl.classList.add('hidden');
                    fieldInput.classList.remove('ring-2', 'ring-red-500', 'border-red-500');
                }
            }

            function validateField(field) {
                const value = field.value.trim();
                const id = field.id;
                let isValid = true;

                if (field.hasAttribute('required') && !value) {
                    showError(id);
                    isValid = false;
                } else if (id === 'tempat_bekerja' && field.hasAttribute('required') && !value) {
                    showError(id, 'Tempat bekerja wajib diisi jika status kerja "Bekerja".');
                    isValid = false;
                } else {
                    hideError(id);
                }
                return isValid;
            }

            function toggleTempatBekerja() {
                const isBekerja = sudahBekerjaSelect.value === '1';

                if (isBekerja) {
                    tempatBekerjaGroup.style.display = 'block';
                    tempatBekerjaInput.setAttribute('required', 'required');
                    tempatBekerjaInput.removeAttribute('disabled');
                    tempatBekerjaInput.classList.remove('bg-gray-100', 'text-gray-400');
                } else {
                    tempatBekerjaGroup.style.display = 'none';
                    tempatBekerjaInput.removeAttribute('required');
                    tempatBekerjaInput.setAttribute('disabled', 'true');
                    tempatBekerjaInput.classList.add('bg-gray-100', 'text-gray-400');
                    hideError('tempat_bekerja');
                }
            }

            function updateJurusanDropdown() {
                const selectedFakultas = selectFakultas.value;
                const jurusans = jurusanOptions[selectedFakultas] || [];

                // Mengambil nilai lama (dari DB atau old input)
                const oldJurusanValue = selectJurusan.value;

                selectJurusan.innerHTML = '<option value="">-- Pilih Jurusan --</option>';

                jurusans.forEach(jurusan => {
                    const option = document.createElement('option');
                    option.value = jurusan;
                    option.textContent = jurusan;
                    selectJurusan.appendChild(option);
                });

                // Re-select old value if it's still valid
                if (jurusans.includes(oldJurusanValue)) {
                     selectJurusan.value = oldJurusanValue;
                } else {
                    // Logic to retain original DB value if possible or default to blank
                    const initialJurusan = "{{ $alumni->jurusan ?? '' }}";
                    const initialFakultas = "{{ $alumni->fakultas ?? '' }}";

                    if (selectedFakultas === initialFakultas && jurusans.includes(initialJurusan)) {
                         selectJurusan.value = initialJurusan;
                    } else if (selectJurusan.value === '') {
                         // If still empty, use the actual old input if available
                         const currentOldJurusan = "{{ old('jurusan') ?? '' }}";
                         if (jurusans.includes(currentOldJurusan)) {
                             selectJurusan.value = currentOldJurusan;
                         }
                    }
                }

                validateField(selectJurusan); // Re-validate jurusan after options change
            }

            // --- Event Listeners and Initialization ---

            sudahBekerjaSelect.addEventListener('change', toggleTempatBekerja);
            selectFakultas.addEventListener('change', updateJurusanDropdown);
            selectJurusan.addEventListener('change', () => validateField(selectJurusan));

            // Attach validation listeners for user input
            document.querySelectorAll('input, select, textarea').forEach(field => {
                field.addEventListener('blur', () => validateField(field));
                field.addEventListener('change', () => validateField(field));
            });

            // Initial setup
            toggleTempatBekerja();
            updateJurusanDropdown(); // Must be called on load to populate based on initial fakultas value

            // --- Form Submission Validation ---
            form.addEventListener('submit', e => {
                let formIsValid = true;

                // Validate all required fields
                document.querySelectorAll('input[required], select[required], textarea[required]').forEach(field => {
                    // Skip disabled fields
                    if (!field.hasAttribute('disabled')) {
                        if (!validateField(field)) {
                            formIsValid = false;
                        }
                    }
                });

                if (!formIsValid) {
                    e.preventDefault();
                    alert('Mohon isi semua field wajib dengan benar sebelum menyimpan.');
                    const firstInvalid = document.querySelector('.ring-red-500');
                    if (firstInvalid) {
                        firstInvalid.scrollIntoView({ behavior: 'smooth', block: 'center' });
                    }
                }
            });
            // --- FORM LOGIC (END) ---
        });
    </script>
</body>

</html>
