@extends('layouts.admin')

@section('title', 'Edit Data Alumni - ' . ($alumni->nama ?? 'N/A'))

@section('header')
    {{-- Header kustom untuk halaman Edit Alumni, menampilkan nama dan ID alumni --}}
    <header class="mb-8 p-4 bg-white rounded-xl shadow-md flex items-center justify-between animate-fade-in">
        <div>
            <h1 class="text-3xl lg:text-4xl font-extrabold text-green-800 tracking-tight font-['Poppins']">
                Manajemen Data Alumni
            </h1>
            <p class="text-green-700 text-lg mt-1">Anda sedang mengedit data: <strong class="text-gray-800">{{ $alumni->nama ?? 'N/A' }}</strong> (ID: {{ $alumni->user_id ?? 'N/A' }})</p>
        </div>
        <div class="flex flex-col items-end">
            <p class="text-sm font-semibold text-gray-700" id="currentDate"></p>
            <p class="text-sm text-gray-600" id="currentTime"></p>
        </div>
    </header>
@endsection

@section('content')

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

                            // Use old() helper for form persistence on validation failure
                            $displayValue = old($id, $value);

                            return <<<HTML
                            <div>
                                <label for="$id" class="block mb-1 font-semibold text-gray-700 text-sm $reqClass">$label</label>
                                <div class="relative">
                                    $iconHtml
                                    <input type="$type" id="$id" name="$id" value="$displayValue" $req
                                        placeholder="$placeholder"
                                        class="$inputClasses" />
                                    <p class="text-xs text-red-600 mt-1 hidden" id="{$id}Error">Field ini wajib diisi.</p>
                                </div>
                            </div>
                            HTML;
                        }
                    @endphp

                    {!! inputField('nama', 'Nama Lengkap', 'text', $alumni->nama ?? '', 'Masukkan nama lengkap', true) !!}
                    {!! inputField('nim', 'NIM', 'text', $alumni->nim ?? '', 'Masukkan NIM', true) !!}
                    {!! inputField('tanggal_lahir', 'Tanggal Lahir', 'date', $alumni->tanggal_lahir ?? '', 'Pilih tanggal lahir', true) !!}
                    {!! inputField('asal', 'Asal Daerah', 'text', $alumni->asal ?? '', 'Masukkan asal daerah') !!}
                </div>

                {{-- KOLOM KANAN: DATA AKADEMIK & PEKERJAAN --}}
                <div class="space-y-6 bg-green-50 p-6 rounded-xl border border-green-200 shadow-lg">
                    <h3 class="text-xl font-bold text-green-700 border-b pb-2 mb-4 flex items-center gap-2">
                        <i data-lucide="graduation-cap" class="w-5 h-5"></i> Akademik & Status Kerja
                    </h3>

                    {{-- Tahun Masuk / Keluar --}}
                    <div class="grid grid-cols-2 gap-4">
                        {!! inputField('tahun_masuk', 'Tahun Masuk', 'number', $alumni->tahun_masuk ?? '', '2018', true) !!}
                        {!! inputField('tahun_keluar', 'Tahun Keluar', 'number', $alumni->tahun_keluar ?? '', '2023', true) !!}
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
                            {{-- Opsi akan diisi oleh JavaScript berdasarkan pilihan Fakultas --}}
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
                            @php
                                $currentStatus = old('sudah_bekerja', $alumni->sudah_bekerja ?? null);
                            @endphp
                            <option value="" disabled {{ $currentStatus === null ? 'selected' : '' }}>-- Pilih Status --</option>
                            <option value="1" {{ $currentStatus == 1 ? 'selected' : '' }}>Bekerja</option>
                            <option value="0" {{ $currentStatus == 0 ? 'selected' : '' }}>Belum Bekerja</option>
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
@endsection

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Data Jurusan Didefinisikan di sini
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
                    // Tambahkan ring untuk visual error
                    fieldInput.classList.add('ring-2', 'ring-red-500', 'border-red-500');
                }
            }

            function hideError(fieldId) {
                const errorEl = document.getElementById(fieldId + 'Error');
                const fieldInput = document.getElementById(fieldId);
                if (errorEl && fieldInput) {
                    errorEl.classList.add('hidden');
                    // Hapus ring error
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
                } else if (id === 'tempat_bekerja' && field.hasAttribute('required') && !value && sudahBekerjaSelect.value === '1') {
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
                    validateField(tempatBekerjaInput); // Langsung validasi saat muncul
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

                // Simpan nilai jurusan saat ini sebelum di-reset
                const currentOldJurusanValue = "{{ old('jurusan', $alumni->jurusan ?? '') }}";

                selectJurusan.innerHTML = '<option value="">-- Pilih Jurusan --</option>';

                jurusans.forEach(jurusan => {
                    const option = document.createElement('option');
                    option.value = jurusan;
                    option.textContent = jurusan;
                    selectJurusan.appendChild(option);
                });

                // Coba pilih kembali nilai lama (dari input lama atau DB)
                if (jurusans.includes(currentOldJurusanValue)) {
                    selectJurusan.value = currentOldJurusanValue;
                } else if (currentOldJurusanValue && jurusans.length > 0) {
                     // Jika nilai lama tidak valid untuk fakultas baru, reset dan tampilkan pesan
                     selectJurusan.value = '';
                }

                validateField(selectJurusan); // Re-validate jurusan after options change
            }

            // --- Event Listeners and Initialization ---

            sudahBekerjaSelect.addEventListener('change', toggleTempatBekerja);
            selectFakultas.addEventListener('change', updateJurusanDropdown);

            // Attach validation listeners for user input
            document.querySelectorAll('input, select, textarea').forEach(field => {
                field.addEventListener('blur', () => validateField(field));
                field.addEventListener('change', () => validateField(field));
            });

            // Initial setup (Penting agar dropdown dan conditional field terisi/tersembunyi dengan benar saat halaman dimuat)
            toggleTempatBekerja();
            updateJurusanDropdown();

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
                    // Tampilkan notifikasi yang lebih ramah
                    alert('Mohon periksa kembali formulir Anda. Pastikan semua field wajib (bertanda *) sudah terisi dengan benar.');
                    const firstInvalid = document.querySelector('.ring-red-500');
                    if (firstInvalid) {
                        firstInvalid.scrollIntoView({ behavior: 'smooth', block: 'center' });
                    }
                }
            });

            // Logic untuk Date/Time Header
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
        });
    </script>
@endpush
