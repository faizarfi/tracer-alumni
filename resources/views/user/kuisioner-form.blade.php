@extends('layouts.user')

@section('title', 'Kuesioner Alumni - UIN Raden Mas Said')

@section('content')
<div class="py-10 px-4 sm:px-6 lg:px-8">
    <div class="max-w-5xl mx-auto bg-white p-8 sm:p-12 rounded-3xl shadow-2xl">
        <div class="text-center mb-12">
            <img src="{{ asset('img/uin.png') }}" class="w-32 h-32 mx-auto rounded-full object-cover shadow-xl transition-transform transform hover:scale-110" alt="Logo UIN">
            <h2 class="text-4xl font-extrabold text-green-800 mt-6 tracking-tight font-['Poppins']">Kuesioner Alumni</h2>
            <p class="text-gray-600 mt-2 text-lg font-medium">Isi kuesioner ini dengan jujur, kontribusimu sangat berarti bagi kemajuan UIN Raden Mas Said!</p>
        </div>

        @if (session('success'))
        <div class="bg-green-100 border border-green-300 text-green-800 px-4 py-3 rounded-lg mb-6 animate-fadeIn flex items-center justify-between" role="alert">
            <p class="font-medium flex items-center gap-2">
                <i data-lucide="check-circle" class="w-5 h-5 text-green-600"></i>
                {{ session('success') }}
            </p>
            <button type="button" class="text-green-700 hover:text-green-900 focus:outline-none" onclick="this.parentElement.style.display='none'">
                <i data-lucide="x" class="w-5 h-5"></i>
            </button>
        </div>
        @endif

        <form id="kuisionerForm" action="{{ route('user.kuisioner') }}" method="POST" class="space-y-12" novalidate>
            @csrf

            <div id="section1">
                <h3 class="text-3xl font-semibold text-green-700 mb-6 font-['Poppins']">1. Pengalaman Pendidikan di UIN</h3>
                @php
                    $options = ['Tidak Sama Sekali', 'Kurang', 'Cukup Besar', 'Besar', 'Sangat Besar'];
                    $items1 = ['Demonstrasi / Peragaan', 'Partisipasi Dalam Proyek Riset', 'Magang', 'Praktikum', 'Kerja Lapangan', 'Diskusi'];
                    $items2 = ['Perpustakaan', 'Teknologi Informasi Dan Komunikasi', 'Modul Belajar', 'Ruang Belajar', 'Laboratorium', 'Variasi Mata Kuliah Yang Ditawarkan', 'Fasilitas Layanan Kesehatan', 'Fasilitas Ibadah'];
                @endphp

                <p class="font-semibold text-lg text-gray-700 mb-4">Seberapa besar implementasi perkuliahan berikut dilaksanakan?</p>
                <div class="space-y-6">
                    @foreach ($items1 as $item)
                    <div class="bg-green-50 p-4 rounded-lg shadow-sm border border-green-200">
                        <label class="text-gray-800 text-base font-medium mb-3 block">{{ $item }}</label>
                        <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-5 gap-3">
                            @foreach ($options as $option)
                            <label class="flex items-center space-x-2 text-sm sm:text-base cursor-pointer hover:bg-green-100 p-2 rounded-md transition-colors duration-200">
                                <input type="radio" name="pendidikan[{{ $item }}]" value="{{ $option }}" required class="required-field w-5 h-5 text-green-600 border-gray-300 focus:ring-2 focus:ring-green-500" {{ old('pendidikan.' . $item) == $option ? 'checked' : '' }}>
                                <span class="text-gray-800">{{ $option }}</span>
                            </label>
                            @endforeach
                        </div>
                    </div>
                    @endforeach
                </div>

                <p class="font-semibold text-lg text-gray-700 mt-10 mb-4">Penilaian terhadap fasilitas berikut:</p>
                <div class="space-y-6">
                    @foreach ($items2 as $item)
                    <div class="bg-green-50 p-4 rounded-lg shadow-sm border border-green-200">
                        <label class="text-gray-800 text-base font-medium mb-3 block">{{ $item }}</label>
                        <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-5 gap-3">
                            @foreach ($options as $option)
                            <label class="flex items-center space-x-2 text-sm sm:text-base cursor-pointer hover:bg-green-100 p-2 rounded-md transition-colors duration-200">
                                <input type="radio" name="fasilitas[{{ $item }}]" value="{{ $option }}" required class="required-field w-5 h-5 text-green-600 border-gray-300 focus:ring-2 focus:ring-green-500" {{ old('fasilitas.' . $item) == $option ? 'checked' : '' }}>
                                <span class="text-gray-800">{{ $option }}</span>
                            </label>
                            @endforeach
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>

            <div id="section2" class="hidden">
                <h3 class="text-3xl font-semibold text-green-700 mb-6 font-['Poppins']">2. Aktivitas Setelah Lulus</h3>
                <div class="grid gap-8 sm:grid-cols-2">
                    <div class="bg-green-50 p-6 rounded-lg shadow-sm border border-green-200">
                        <label class="font-medium text-gray-800 text-lg mb-2 block" for="cari_kerja">Kapan mulai mencari pekerjaan?</label>
                        <select id="cari_kerja" name="cari_kerja" required class="required-field mt-3 w-full p-3 rounded-lg border-green-300 shadow-md focus:ring-green-500 focus:border-green-500 transition-all duration-200">
                            <option value="">-- Pilih --</option>
                            <option {{ old('cari_kerja') == 'Sebelum Lulus' ? 'selected' : '' }}>Sebelum Lulus</option>
                            <option {{ old('cari_kerja') == 'Setelah Lulus' ? 'selected' : '' }}>Setelah Lulus</option>
                            <option {{ old('cari_kerja') == 'Saya Tidak Mencari Kerja' ? 'selected' : '' }}>Saya Tidak Mencari Kerja</option>
                        </select>
                    </div>

                    <div class="bg-green-50 p-6 rounded-lg shadow-sm border border-green-200">
                        <label class="font-medium text-gray-800 text-lg mb-2 block" for="status_pekerjaan">Status pekerjaan saat ini?</label>
                        <select id="status_pekerjaan" name="status_pekerjaan" required class="required-field mt-3 w-full p-3 rounded-lg border-green-300 shadow-md focus:ring-green-500 focus:border-green-500 transition-all duration-200">
                            <option value="">-- Pilih --</option>
                            <option {{ old('status_pekerjaan') == 'Bekerja part time/fulltime' ? 'selected' : '' }}>Bekerja part time/fulltime</option>
                            <option {{ old('status_pekerjaan') == 'Wiraswasta' ? 'selected' : '' }}>Wiraswasta</option>
                            <option {{ old('status_pekerjaan') == 'Pernah bekerja tapi sekarang tidak' ? 'selected' : '' }}>Pernah bekerja tapi sekarang tidak</option>
                            <option {{ old('status_pekerjaan') == 'Melanjutkan studi' ? 'selected' : '' }}>Melanjutkan studi</option>
                            <option {{ old('status_pekerjaan') == 'Bekerja dan studi' ? 'selected' : '' }}>Bekerja dan studi</option>
                            <option {{ old('status_pekerjaan') == 'Wiraswasta dan studi' ? 'selected' : '' }}>Wiraswasta dan studi</option>
                            <option {{ old('status_pekerjaan') == 'Tidak bekerja' ? 'selected' : '' }}>Tidak bekerja</option>
                        </select>
                    </div>
                </div>
            </div>

            <div id="section3" class="hidden">
                <h3 class="text-3xl font-semibold text-green-700 mb-6 font-['Poppins']">3. Informasi Pekerjaan <span class="text-gray-500 text-xl">(Opsional, jika bekerja)</span></h3>
                <div class="grid gap-8 sm:grid-cols-2">
                    {{-- Added new fields for consistency with admin detail view --}}
                    <div class="bg-green-50 p-6 rounded-lg shadow-sm border border-green-200">
                        <label class="font-medium text-gray-800 text-lg mb-2 block" for="nama_perusahaan">Nama Perusahaan</label>
                        <input type="text" id="nama_perusahaan" name="nama_perusahaan" value="{{ old('nama_perusahaan') }}" placeholder="Contoh: PT. Maju Bersama" class="w-full p-3 rounded-lg border-green-300 shadow-md focus:ring-green-500 focus:border-green-500 transition-all duration-200">
                    </div>
                    <div class="bg-green-50 p-6 rounded-lg shadow-sm border border-green-200">
                        <label class="font-medium text-gray-800 text-lg mb-2 block" for="jenis_pekerjaan">Jenis Pekerjaan</label>
                        <input type="text" id="jenis_pekerjaan" name="jenis_pekerjaan" value="{{ old('jenis_pekerjaan') }}" placeholder="Contoh: Software Engineer" class="w-full p-3 rounded-lg border-green-300 shadow-md focus:ring-green-500 focus:border-green-500 transition-all duration-200">
                    </div>
                    <div class="bg-green-50 p-6 rounded-lg shadow-sm border border-green-200 col-span-full">
                        <label class="font-medium text-gray-800 text-lg mb-2 block" for="alamat_perusahaan">Alamat Perusahaan</label>
                        <textarea id="alamat_perusahaan" name="alamat_perusahaan" rows="3" placeholder="Alamat lengkap perusahaan" class="w-full p-3 rounded-lg border-green-300 shadow-md focus:ring-green-500 focus:border-green-500 transition-all duration-200">{{ old('alamat_perusahaan') }}</textarea>
                    </div>

                    @foreach (['waktu_tunggu' => 'Waktu tunggu (bulan)', 'jumlah_lamaran' => 'Jumlah lamaran dikirim', 'jumlah_respon' => 'Jumlah tanggapan perusahaan', 'jumlah_wawancara' => 'Jumlah wawancara'] as $name => $label)
                    <div class="bg-green-50 p-6 rounded-lg shadow-sm border border-green-200">
                        <label class="font-medium text-gray-800 text-lg mb-2 block" for="{{ $name }}">{{ $label }}</label>
                        <input type="number" id="{{ $name }}" name="{{ $name }}" value="{{ old($name) }}" min="0" class="w-full p-3 rounded-lg border-green-300 shadow-md focus:ring-green-500 focus:border-green-500 transition-all duration-200">
                    </div>
                    @endforeach
                    <div class="bg-green-50 p-6 rounded-lg shadow-sm border border-green-200 col-span-full">
                        <label class="font-medium text-gray-800 text-lg mb-2 block" for="jenis_perusahaan">Jenis tempat kerja</label>
                        <select id="jenis_perusahaan" name="jenis_perusahaan" class="w-full p-3 rounded-lg border-green-300 shadow-md focus:ring-green-500 focus:border-green-500 transition-all duration-200">
                            <option value="">-- Pilih --</option>
                            @foreach (['Instansi Pemerintah', 'Swasta', 'Wiraswasta', 'Lembaga Pendidikan', 'Lainnya'] as $option)
                            <option {{ old('jenis_perusahaan') == $option ? 'selected' : '' }}>{{ $option }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>

            <div id="section4" class="hidden">
                <h3 class="text-3xl font-semibold text-green-700 mb-6 font-['Poppins']">4. Kritik & Saran</h3>
                <div class="bg-green-50 p-6 rounded-lg shadow-sm border border-green-200">
                    <label for="jawaban" class="font-medium text-gray-800 text-lg mb-2 block">Tulis kritik dan saran Anda untuk UIN Raden Mas Said:</label>
                    <textarea name="jawaban" id="jawaban" rows="7" required class="required-field w-full p-4 rounded-lg border-green-300 shadow-md focus:ring-green-500 focus:border-green-500 transition-all duration-200" placeholder="Contoh: Saya berharap UIN dapat meningkatkan fasilitas olahraga untuk mahasiswa...">{{ old('jawaban') }}</textarea>
                </div>
            </div>

            <div class="flex justify-between mt-10 pt-6 border-t border-gray-200">
                <button type="button" id="backBtn" class="flex items-center gap-2 bg-gray-500 hover:bg-gray-600 text-white px-6 py-3 rounded-xl shadow-md transition duration-300 disabled:opacity-50 disabled:cursor-not-allowed transform hover:-translate-y-0.5">
                    <span class="iconify" data-icon="mdi:arrow-left"></span> Kembali
                </button>
                <div class="flex space-x-4">
                    <button type="button" id="nextBtn" class="flex items-center gap-2 bg-green-600 hover:bg-green-700 text-white px-6 py-3 rounded-xl shadow-md transition duration-300 transform hover:-translate-y-0.5">
                        Selanjutnya <span class="iconify" data-icon="mdi:arrow-right"></span>
                    </button>
                    <button type="submit" id="submitBtn" class="hidden flex items-center gap-2 bg-blue-600 hover:bg-blue-700 text-white px-6 py-3 rounded-xl shadow-md transition duration-300 transform hover:-translate-y-0.5">
                        <span class="iconify" data-icon="mdi:send"></span> Kirim Kuesioner
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>

<script>
    // Kuesioner multi-step logic
    document.addEventListener('DOMContentLoaded', () => {
        const sections = ['section1', 'section2', 'section3', 'section4'];
        let current = 0;

        const updateUI = () => {
            sections.forEach((id, i) => {
                document.getElementById(id).classList.toggle('hidden', i !== current);
            });
            document.getElementById('backBtn').disabled = current === 0;
            document.getElementById('nextBtn').classList.toggle('hidden', current === sections.length - 1);
            document.getElementById('submitBtn').classList.toggle('hidden', current !== sections.length - 1);
        };

        const validateSection = () => {
            const currentSection = document.getElementById(sections[current]);
            // Select only directly required fields that are visible and not disabled
            const requiredFields = currentSection.querySelectorAll('.required-field:not([disabled])');

            for (let field of requiredFields) {
                if (field.type === 'radio') {
                    const name = field.name;
                    // Check if any radio button with this name in the current section is checked
                    const checked = currentSection.querySelector(`input[name="${name}"]:checked`);
                    if (!checked) {
                        alert(`Mohon pilih salah satu opsi untuk pertanyaan: ${field.closest('div').querySelector('label')?.textContent.trim() || ''}`);
                        return false;
                    }
                } else if (field.value.trim() === '') {
                    alert(`Mohon lengkapi bidang: ${field.previousElementSibling?.textContent.trim() || field.placeholder || ''}`);
                    field.focus();
                    return false;
                }
            }
            return true;
        };

        document.getElementById('nextBtn').addEventListener('click', () => {
            if (!validateSection()) {
                return; // Stop if validation fails
            }

            if (sections[current] === 'section2') {
                const status = document.getElementById('status_pekerjaan').value;
                // If not working or continuing study, skip section 3
                if (status.includes('Tidak bekerja') || status.includes('Melanjutkan studi')) {
                    current = 3; // Jump to section4
                    // Disable section3 fields when skipping to prevent validation issues later
                    document.getElementById('section3').querySelectorAll('input, select, textarea').forEach(field => field.setAttribute('disabled', 'true'));
                } else {
                    current++;
                    // Ensure section3 fields are enabled if previously disabled
                    document.getElementById('section3').querySelectorAll('input, select, textarea').forEach(field => field.removeAttribute('disabled'));
                }
            } else {
                current++;
            }
            updateUI();
        });

        document.getElementById('backBtn').addEventListener('click', () => {
            if (sections[current] === 'section4') {
                // Check if we skipped section 3 previously to go back correctly
                const status = document.getElementById('status_pekerjaan').value;
                if (status.includes('Tidak bekerja') || status.includes('Melanjutkan studi')) {
                    current = 1; // Go back to section2
                } else {
                    current = 2; // Go back to section3
                }
            } else {
                current--;
            }
            // Always re-enable section3 fields when navigating back from section4 or before it
            document.getElementById('section3').querySelectorAll('input, select, textarea').forEach(field => field.removeAttribute('disabled'));
            updateUI();
        });

        updateUI(); // Initial UI setup
    });
</script>
@endsection
