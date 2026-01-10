@extends('layouts.user')

@section('title', 'Formulir Alumni | UIN Raden Mas Said')

@section('content')
<style>
    .glass-form-card {
        background: rgba(255, 255, 255, 0.9);
        backdrop-filter: blur(10px);
        border: 1px solid rgba(255, 255, 255, 0.4);
    }

    .input-group-focus:focus-within {
        border-color: #10b981;
        box-shadow: 0 0 0 4px rgba(16, 185, 129, 0.1);
    }

    .profile-img-preview {
        width: 150px;
        height: 150px;
        border-radius: 2rem;
        object-fit: cover;
        border: 4px solid white;
        box-shadow: 0 10px 25px rgba(0,0,0,0.1);
        transition: transform 0.3s ease;
    }

    .profile-img-preview:hover {
        transform: scale(1.05) rotate(2deg);
    }

    .section-divider {
        position: relative;
        display: flex;
        align-items: center;
        margin: 2rem 0 1.5rem;
    }

    .section-divider::after {
        content: "";
        flex: 1;
        height: 1px;
        background: linear-gradient(to right, #e2e8f0, transparent);
        margin-left: 1rem;
    }
</style>

<div class="py-16 px-4 sm:px-6 lg:px-8 bg-slate-50 min-h-screen">
    <div class="max-w-6xl mx-auto">

        {{-- Header Navigation --}}
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-6 mb-10">
            <div>
                <h1 class="text-4xl font-black text-slate-900 tracking-tight">Profil <span class="text-green-600">Alumni</span></h1>
                <p class="text-slate-500 mt-2 font-medium">Lengkapi data diri Anda untuk membangun jejaring yang lebih kuat.</p>
            </div>
            <a href="{{ route('user.dashboard') }}"
                class="inline-flex items-center gap-2 px-6 py-3 rounded-2xl bg-white text-slate-700 font-bold hover:bg-slate-50 shadow-sm border border-slate-200 transition-all active:scale-95">
                <i data-lucide="layout-dashboard" class="w-5 h-5"></i>
                Dashboard
            </a>
        </div>

        {{-- Flash messages shown via SweetAlert in layout --}}

        <form action="{{ url('/user/profil') }}" method="POST" enctype="multipart/form-data">
            @csrf
            @if(isset($alumni) && $alumni->exists) @method('PUT') @endif

            <div class="grid grid-cols-1 lg:grid-cols-12 gap-8">

                {{-- Left Side: Avatar & Basic Stats --}}
                <div class="lg:col-span-4 space-y-6">
                    <div class="glass-form-card p-8 rounded-[2.5rem] text-center shadow-xl shadow-slate-200/50">
                        <div class="relative inline-block mb-6">
                            <img id="profile-preview"
                                src="{{ (isset($alumni) && $alumni->foto_path) ? \Illuminate\Support\Facades\Storage::url($alumni->foto_path) : 'https://placehold.co/300x300/e2e8f0/64748b?text=Avatar' }}"
                                class="profile-img-preview mx-auto">
                            <label for="foto" class="absolute bottom-0 right-0 p-2 bg-green-600 text-white rounded-xl shadow-lg cursor-pointer hover:bg-green-700 transition-colors">
                                <i data-lucide="camera" class="w-5 h-5"></i>
                                <input type="file" name="foto" id="foto" class="hidden" accept="image/*">
                            </label>
                        </div>
                        <h3 class="text-xl font-bold text-slate-800">{{ $alumni->nama ?? auth()->user()->name }}</h3>
                        <p class="text-slate-400 text-sm mb-6">{{ $alumni->nim ?? 'NIM Belum Diatur' }}</p>

                        <div class="text-left space-y-2">
                            <p class="text-xs font-black uppercase tracking-widest text-slate-400">Instruksi</p>
                            <p class="text-xs text-slate-500 leading-relaxed italic">Gunakan foto formal dengan format JPG/PNG, maksimal ukuran 2MB.</p>
                        </div>
                    </div>
                </div>

                {{-- Right Side: Form Details --}}
                <div class="lg:col-span-8 space-y-8">
                    <div class="glass-form-card p-8 md:p-10 rounded-[2.5rem] shadow-xl shadow-slate-200/50">

                        {{-- Section: Personal --}}
                        <div class="section-divider">
                            <span class="text-sm font-black uppercase tracking-[0.2em] text-green-600 flex items-center gap-2">
                                <i data-lucide="user" class="w-4 h-4"></i> Informasi Pribadi
                            </span>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div class="space-y-2">
                                <label class="text-sm font-bold text-slate-700 ml-1">Nama Lengkap</label>
                                <div class="relative group input-group-focus border border-slate-200 rounded-2xl transition-all">
                                    <i data-lucide="user" class="absolute left-4 top-3.5 w-5 h-5 text-slate-400"></i>
                                    <input type="text" name="nama" value="{{ old('nama', $alumni->nama ?? '') }}" class="w-full bg-transparent pl-12 pr-4 py-3.5 outline-none text-slate-700 font-medium" placeholder="Nama Lengkap" required>
                                </div>
                            </div>
                            <div class="space-y-2">
                                <label class="text-sm font-bold text-slate-700 ml-1">NIM</label>
                                <div class="relative group input-group-focus border border-slate-200 rounded-2xl transition-all">
                                    <i data-lucide="hash" class="absolute left-4 top-3.5 w-5 h-5 text-slate-400"></i>
                                    <input type="text" name="nim" value="{{ old('nim', $alumni->nim ?? '') }}" class="w-full bg-transparent pl-12 pr-4 py-3.5 outline-none text-slate-700 font-medium" placeholder="Nomor Induk Mahasiswa" required>
                                </div>
                            </div>
                            <div class="space-y-2">
                                <label class="text-sm font-bold text-slate-700 ml-1">Asal Daerah</label>
                                <div class="relative group input-group-focus border border-slate-200 rounded-2xl transition-all">
                                    <i data-lucide="map-pin" class="absolute left-4 top-3.5 w-5 h-5 text-slate-400"></i>
                                    <input type="text" name="asal" value="{{ old('asal', $alumni->asal ?? '') }}" class="w-full bg-transparent pl-12 pr-4 py-3.5 outline-none text-slate-700 font-medium" placeholder="Contoh: Surakarta" required>
                                </div>
                            </div>
                            <div class="space-y-2">
                                <label class="text-sm font-bold text-slate-700 ml-1">Tanggal Lahir</label>
                                <div class="relative group input-group-focus border border-slate-200 rounded-2xl transition-all">
                                    <i data-lucide="calendar" class="absolute left-4 top-3.5 w-5 h-5 text-slate-400"></i>
                                    <input type="date" name="tanggal_lahir" value="{{ old('tanggal_lahir', isset($alumni->tanggal_lahir) && $alumni->tanggal_lahir ? \Illuminate\Support\Carbon::parse($alumni->tanggal_lahir)->format('Y-m-d') : '') }}" class="w-full bg-transparent pl-12 pr-4 py-3.5 outline-none text-slate-700 font-medium" required>
                                </div>
                            </div>
                        </div>

                        {{-- Section: Academic --}}
                        <div class="section-divider">
                            <span class="text-sm font-black uppercase tracking-[0.2em] text-green-600 flex items-center gap-2">
                                <i data-lucide="graduation-cap" class="w-4 h-4"></i> Riwayat Akademik
                            </span>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div class="space-y-2">
                                <label class="text-sm font-bold text-slate-700 ml-1">Fakultas</label>
                                <select name="fakultas" id="fakultas" class="w-full bg-slate-50 border border-slate-200 rounded-2xl px-4 py-3.5 outline-none focus:border-green-500 transition-all font-medium text-slate-700 appearance-none" required>
                                    <option value="">-- Pilih Fakultas --</option>
                                    @foreach(['Fakultas Adab dan Bahasa', 'Fakultas Ekonomi Dan Bisnis Islam', 'Fakultas Ilmu Tarbiyah', 'Fakultas Ushuluddin dan Dakwah', 'Fakultas Syariah'] as $f)
                                        <option value="{{ $f }}" {{ old('fakultas', $alumni->fakultas ?? '') == $f ? 'selected' : '' }}>{{ $f }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="space-y-2">
                                <label class="text-sm font-bold text-slate-700 ml-1">Jurusan</label>
                                <select name="jurusan" id="jurusan" class="w-full bg-slate-50 border border-slate-200 rounded-2xl px-4 py-3.5 outline-none focus:border-green-500 transition-all font-medium text-slate-700" required>
                                    <option value="">-- Pilih Jurusan --</option>
                                </select>
                            </div>
                            <div class="space-y-2">
                                <label class="text-sm font-bold text-slate-700 ml-1">Tahun Masuk</label>
                                <input id="tahun_masuk" type="number" name="tahun_masuk" value="{{ old('tahun_masuk', $alumni->tahun_masuk ?? '') }}" class="w-full bg-slate-50 border border-slate-200 rounded-2xl px-4 py-3.5 outline-none focus:border-green-500 transition-all font-medium" placeholder="2018" required inputmode="numeric" pattern="\d*" min="1900" step="1">
                            </div>
                            <div class="space-y-2">
                                <label class="text-sm font-bold text-slate-700 ml-1">Tahun Keluar</label>
                                <input id="tahun_keluar" type="number" name="tahun_keluar" value="{{ old('tahun_keluar', $alumni->tahun_keluar ?? '') }}" class="w-full bg-slate-50 border border-slate-200 rounded-2xl px-4 py-3.5 outline-none focus:border-green-500 transition-all font-medium" placeholder="2022" required inputmode="numeric" pattern="\d*" min="1900" step="1">
                                <p id="tahun-error" class="text-sm text-rose-600 mt-2 hidden"></p>
                            </div>
                        </div>

                        {{-- Section: Professional --}}
                        <div class="section-divider">
                            <span class="text-sm font-black uppercase tracking-[0.2em] text-green-600 flex items-center gap-2">
                                <i data-lucide="briefcase" class="w-4 h-4"></i> Karir & Testimoni
                            </span>
                        </div>

                        <div class="space-y-6">
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div class="space-y-2">
                                    <label class="text-sm font-bold text-slate-700 ml-1">Status Pekerjaan</label>
                                    <select name="sudah_bekerja" id="status-kerja" class="w-full bg-slate-50 border border-slate-200 rounded-2xl px-4 py-3.5 outline-none focus:border-green-500 transition-all font-medium">
                                        <option value="1" {{ old('sudah_bekerja', $alumni->sudah_bekerja ?? '') == 1 ? 'selected' : '' }}>Sudah Bekerja</option>
                                        <option value="0" {{ old('sudah_bekerja', $alumni->sudah_bekerja ?? '') == 0 ? 'selected' : '' }}>Belum Bekerja</option>
                                    </select>
                                </div>
                                <div class="space-y-2" id="input-tempat-kerja">
                                    <label class="text-sm font-bold text-slate-700 ml-1">Tempat Bekerja</label>
                                    <input type="text" name="tempat_bekerja" id="tempat_bekerja" value="{{ old('tempat_bekerja', $alumni->tempat_bekerja ?? '') }}" class="w-full bg-slate-50 border border-slate-200 rounded-2xl px-4 py-3.5 outline-none focus:border-green-500 transition-all font-medium" placeholder="Contoh: PT. Maju Jaya">
                                </div>
                            </div>

                            <div class="p-6 bg-green-50/50 border border-green-100 rounded-[2rem] space-y-4">
                                <label class="text-sm font-bold text-green-800 flex items-center gap-2">
                                    <i data-lucide="message-square" class="w-4 h-4"></i> Testimoni Anda
                                </label>
                                <textarea name="testimonial_quote" rows="4" class="w-full bg-white border border-green-200 rounded-2xl p-4 outline-none focus:ring-4 focus:ring-green-500/10 transition-all text-slate-700 font-medium" placeholder="Berikan kutipan inspiratif Anda untuk adik tingkat...">{{ old('testimonial_quote', $alumni->testimonial_quote ?? '') }}</textarea>

                                <label class="flex items-center gap-3 p-2 cursor-pointer group">
                                    <div class="relative flex items-center justify-center">
                                        <input type="checkbox" name="request_publish" value="1" id="request_publish_checkbox" class="peer h-6 w-6 cursor-pointer appearance-none rounded-lg border border-slate-300 bg-white checked:bg-green-600 checked:border-green-600 transition-all" {{ (old('request_publish') == 1 || (isset($alumni) && in_array($alumni->testimonial_status, ['pending', 'approved']))) ? 'checked' : '' }}>
                                        <i data-lucide="check" class="absolute w-4 h-4 text-white opacity-0 peer-checked:opacity-100 transition-opacity"></i>
                                    </div>
                                    <span class="text-sm font-semibold text-slate-600 group-hover:text-green-700 transition-colors">Tampilkan testimoni ini di Dashboard Publik</span>
                                </label>

                                @if(isset($alumni) && $alumni->testimonial_status)
                                    <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full text-[10px] font-black uppercase tracking-widest
                                        {{ $alumni->testimonial_status == 'approved' ? 'bg-emerald-100 text-emerald-700' : ($alumni->testimonial_status == 'rejected' ? 'bg-rose-100 text-rose-700' : 'bg-amber-100 text-amber-700') }}">
                                        Status: {{ $alumni->testimonial_status }}
                                    </div>
                                @endif
                            </div>
                        </div>

                        {{-- Footer Form --}}
                        <div class="mt-10 pt-8 border-t border-slate-100 flex justify-end">
                            <button type="submit" class="flex items-center gap-3 bg-green-700 text-white px-10 py-4 rounded-2xl font-black uppercase tracking-widest text-xs shadow-xl shadow-green-900/20 hover:bg-green-800 transition-all active:scale-95">
                                <i data-lucide="save" class="w-5 h-5"></i>
                                Simpan Perubahan
                            </button>
                        </div>

                    </div>
                </div>
            </div>
        </form>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        lucide.createIcons();

        // Toggle Tempat Kerja
        const statusKerja = document.getElementById('status-kerja');
        const tempatKerjaDiv = document.getElementById('input-tempat-kerja');
        const tempatKerjaInput = document.getElementById('tempat_bekerja');

        function updateWorkStatus() {
            if (statusKerja.value === '1') {
                tempatKerjaDiv.style.opacity = '1';
                tempatKerjaDiv.style.pointerEvents = 'auto';
                tempatKerjaInput.required = true;
            } else {
                tempatKerjaDiv.style.opacity = '0.5';
                tempatKerjaDiv.style.pointerEvents = 'none';
                tempatKerjaInput.required = false;
                tempatKerjaInput.value = '';
            }
        }
        statusKerja.addEventListener('change', updateWorkStatus);
        updateWorkStatus();

        // Image Preview
        document.getElementById('foto').addEventListener('change', function(e) {
            const reader = new FileReader();
            reader.onload = function(event) {
                document.getElementById('profile-preview').src = event.target.result;
            }
            reader.readAsDataURL(e.target.files[0]);
        });

        // Dynamic Jurusan
        const selectFakultas = document.getElementById('fakultas');
        const selectJurusan = document.getElementById('jurusan');
        const oldJurusanValue = "{{ old('jurusan', $alumni->jurusan ?? '') }}";

        const jurusanOptions = {
            "Fakultas Adab dan Bahasa": ["S1 - Bahasa dan Sastra Arab", "S1 - Ilmu Perpustakaan", "S1 - Pendidikan Bahasa Inggris", "S1 - Sastra Inggris", "S1 - Sejarah Peradaban Islam", "S1 - Tadris Bahasa Indonesia"],
            "Fakultas Ekonomi Dan Bisnis Islam": ["S1 - Akuntansi Syariah", "S1 - Ekonomi Syariah", "S1 - Manajemen Bisnis Syariah", "S1 - Perbankan Syariah", "S1 - Manajemen Zakat dan Wakaf", "S1 - Bisnis Digital"],
            "Fakultas Ilmu Tarbiyah": ["S1 - Manajemen Pendidikan Islam", "S1 - Pendidikan Agama Islam", "S1 - Pendidikan Bahasa Arab", "S1 - PGMI", "S1 - PIAUD", "S1 - Tadris Biologi", "S1 - Tadris Matematika", "S1 - Informatika"],
            "Fakultas Ushuluddin dan Dakwah": ["S1 - Aqidah dan Filsafat Islam", "S1 - Bimbingan dan Konseling Islam", "S1 - IQT", "S1 - Komunikasi dan Penyiaran Islam", "S1 - Psikologi Islam"],
            "Fakultas Syariah": ["S1 - Hukum Ekonomi Syariah", "S1 - Hukum Keluarga Islam", "S1 - Hukum Pidana Islam", "S1 - Hukum Bisnis"]
        };

        function updateJurusan() {
            const val = selectFakultas.value;
            const options = jurusanOptions[val] || [];
            selectJurusan.innerHTML = '<option value="">-- Pilih Jurusan --</option>';
            options.forEach(j => {
                const opt = new Option(j, j);
                if (j === oldJurusanValue) opt.selected = true;
                selectJurusan.add(opt);
            });
        }
        selectFakultas.addEventListener('change', updateJurusan);
        updateJurusan();

        // Validasi UX: Tahun Keluar tidak boleh kurang dari Tahun Masuk
        const form = document.querySelector('form');
        const tmInput = document.querySelector('input[name="tahun_masuk"], #tahun_masuk');
        const tkInput = document.querySelector('input[name="tahun_keluar"], #tahun_keluar');
        const tahunError = document.getElementById('tahun-error');

        function validateYears() {
            if (!tmInput || !tkInput) return true;
            const tmRaw = tmInput.value;
            const tkRaw = tkInput.value;
            const tm = parseInt(tmRaw, 10);
            const tk = parseInt(tkRaw, 10);
            const minYear = 1900;

            if ((tmRaw && (isNaN(tm) || tm < minYear)) || (tkRaw && (isNaN(tk) || tk < minYear))) {
                const msg = 'Masukkan tahun valid (hanya angka, minimal ' + minYear + ').';
                if (typeof tkInput.setCustomValidity === 'function') tkInput.setCustomValidity(msg);
                if (tahunError) { tahunError.textContent = msg; tahunError.classList.remove('hidden'); }
                return false;
            }

            if (!isNaN(tm) && !isNaN(tk) && tk < tm) {
                const msg = 'Tahun keluar tidak boleh kurang dari tahun masuk.';
                if (typeof tkInput.setCustomValidity === 'function') tkInput.setCustomValidity(msg);
                if (tahunError) { tahunError.textContent = msg; tahunError.classList.remove('hidden'); }
                return false;
            }

            if (typeof tkInput.setCustomValidity === 'function') tkInput.setCustomValidity('');
            if (tahunError) { tahunError.textContent = ''; tahunError.classList.add('hidden'); }
            return true;
        }

        function sanitizeNumberInput(e) {
            const el = e.target;
            const cleaned = el.value.replace(/[^0-9]/g, '');
            if (el.value !== cleaned) {
                el.value = cleaned;
            }
        }

        if (tmInput && tkInput) {
            tmInput.addEventListener('input', function(e) { sanitizeNumberInput(e); validateYears(); });
            tkInput.addEventListener('input', function(e) { sanitizeNumberInput(e); validateYears(); });
        }

        if (form) {
            form.addEventListener('submit', function (e) {
                if (!validateYears()) {
                    e.preventDefault();
                    if (typeof tkInput.reportValidity === 'function') tkInput.reportValidity();
                    else tkInput.focus();
                    return false;
                }
            });
        }
    });
</script>
@endsection
