@extends('layouts.admin')

@section('title', 'Edit Profil Alumni - ' . ($alumni->nama ?? 'N/A'))

@section('content')
<style>
    .glass-card-form {
        background: rgba(255, 255, 255, 0.98);
        backdrop-filter: blur(10px);
        border: 1px solid rgba(226, 232, 240, 0.8);
        border-radius: 2rem;
        box-shadow: 0 20px 40px -15px rgba(0, 0, 0, 0.05);
    }

    /* Padding kiri (3.5rem) agar teks tidak menabrak ikon */
    .input-premium {
        width: 100%;
        background-color: #f8fafc;
        border: 1px solid #cbd5e1;
        color: #1e293b !important;
        border-radius: 1rem;
        padding: 0.75rem 1rem 0.75rem 3.5rem;
        outline: none;
        transition: all 0.3s ease;
        font-size: 0.875rem;
        font-weight: 500;
    }

    .input-premium:focus {
        border-color: #3b82f6;
        background-color: #ffffff;
        box-shadow: 0 0 0 4px rgba(59, 130, 246, 0.1);
    }

    .label-premium {
        display: block;
        font-size: 0.65rem;
        font-weight: 800;
        text-transform: uppercase;
        letter-spacing: 0.1em;
        color: #64748b;
        margin-bottom: 0.5rem;
        margin-left: 0.25rem;
    }

    .section-title {
        font-size: 0.875rem;
        font-weight: 800;
        text-transform: uppercase;
        letter-spacing: 0.1em;
        color: #1e293b;
        display: flex;
        align-items: center;
        gap: 0.75rem;
        margin-bottom: 1.5rem;
        padding-bottom: 1rem;
        border-bottom: 1px solid #f1f5f9;
    }

    .input-icon {
        position: absolute;
        left: 1.25rem;
        top: 50%;
        transform: translateY(-50%);
        pointer-events: none;
        z-index: 10;
    }
</style>

<div class="space-y-8 font-['Plus_Jakarta_Sans'] pb-12">
    {{-- HEADER SECTION --}}
    <header class="flex flex-col md:flex-row md:items-center justify-between gap-6 animate-fade-in">
        <div class="flex items-center gap-4">
            <a href="{{ route('admin.alumni') }}" class="w-12 h-12 bg-white border border-slate-200 rounded-2xl flex items-center justify-center shadow-sm hover:bg-slate-50 transition-all active:scale-90">
                <i data-lucide="arrow-left" class="w-5 h-5 text-slate-600"></i>
            </a>
            <div>
                <h1 class="text-3xl font-black text-slate-900 tracking-tight">Edit <span class="text-blue-600">Profil Alumni</span></h1>
                <p class="text-slate-500 mt-1 font-medium italic uppercase text-[10px] tracking-widest">Update Data Master Alumni</p>
            </div>
        </div>
    </header>

    <form action="{{ route('admin.alumni.update', $alumni->user_id) }}" method="POST" class="space-y-8">
        @csrf
        @method('PUT')

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
            {{-- 1. DATA PRIBADI --}}
            <section class="glass-card-form p-8 md:p-10 space-y-6">
                <h2 class="section-title text-blue-600 border-blue-100">
                    <i data-lucide="user-cog" class="w-5 h-5"></i> Informasi Personal
                </h2>

                <div>
                    <label class="label-premium">Nama Lengkap Alumni</label>
                    <div class="relative">
                        <i data-lucide="user" class="input-icon text-slate-400"></i>
                        <input type="text" name="nama" value="{{ old('nama', $alumni->nama) }}" class="input-premium" placeholder="Nama Lengkap">
                    </div>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                    <div>
                        <label class="label-premium">NIM</label>
                        <div class="relative">
                            <i data-lucide="credit-card" class="input-icon text-slate-400"></i>
                            <input type="text" name="nim" value="{{ old('nim', $alumni->nim) }}" class="input-premium font-mono">
                        </div>
                    </div>
                    <div>
                        <label class="label-premium">Tanggal Lahir</label>
                        <div class="relative">
                            {{-- Memastikan Value Tanggal Lahir Terisi dari DB --}}
                            <input type="date" name="tanggal_lahir"
                                value="{{ old('tanggal_lahir', $alumni->tanggal_lahir ? \Carbon\Carbon::parse($alumni->tanggal_lahir)->format('Y-m-d') : '') }}"
                                class="input-premium" style="padding-left: 1rem;">
                        </div>
                    </div>
                </div>

                <div>
                    <label class="label-premium">Domisili / Asal Daerah</label>
                    <div class="relative">
                        <i data-lucide="map-pin" class="input-icon text-slate-400"></i>
                        <input type="text" name="asal" value="{{ old('asal', $alumni->asal) }}" class="input-premium" placeholder="Kota Asal">
                    </div>
                </div>
            </section>

            {{-- 2. DATA AKADEMIK --}}
            <section class="glass-card-form p-8 md:p-10 space-y-6">
                <h2 class="section-title text-emerald-600 border-emerald-100">
                    <i data-lucide="graduation-cap" class="w-5 h-5"></i> Riwayat Akademik
                </h2>

                <div class="grid grid-cols-2 gap-6">
                    <div>
                        <label class="label-premium">Tahun Masuk</label>
                        <input type="number" name="tahun_masuk" value="{{ old('tahun_masuk', $alumni->tahun_masuk) }}" class="input-premium" style="padding-left: 1rem;">
                    </div>
                    <div>
                        <label class="label-premium">Tahun Lulus</label>
                        <input type="number" name="tahun_keluar" value="{{ old('tahun_keluar', $alumni->tahun_keluar) }}" class="input-premium" style="padding-left: 1rem;">
                    </div>
                </div>

                <div>
                    <label class="label-premium">Fakultas</label>
                    <select name="fakultas" id="fakultas" class="input-premium" style="padding-left: 1rem;">
                        <option value="">-- Pilih Fakultas --</option>
                        <option value="Fakultas Adab dan Bahasa" {{ old('fakultas', $alumni->fakultas) == 'Fakultas Adab dan Bahasa' ? 'selected' : '' }}>Fakultas Adab dan Bahasa</option>
                        <option value="Fakultas Ekonomi Dan Bisnis Islam" {{ old('fakultas', $alumni->fakultas) == 'Fakultas Ekonomi Dan Bisnis Islam' ? 'selected' : '' }}>Fakultas Ekonomi Dan Bisnis Islam</option>
                        <option value="Fakultas Ilmu Tarbiyah" {{ old('fakultas', $alumni->fakultas) == 'Fakultas Ilmu Tarbiyah' ? 'selected' : '' }}>Fakultas Ilmu Tarbiyah</option>
                        <option value="Fakultas Ushuluddin dan Dakwah" {{ old('fakultas', $alumni->fakultas) == 'Fakultas Ushuluddin dan Dakwah' ? 'selected' : '' }}>Fakultas Ushuluddin dan Dakwah</option>
                        <option value="Fakultas Syariah" {{ old('fakultas', $alumni->fakultas) == 'Fakultas Syariah' ? 'selected' : '' }}>Fakultas Syariah</option>
                    </select>
                </div>

                <div>
                    <label class="label-premium">Program Studi / Jurusan</label>
                    <select name="jurusan" id="jurusan" class="input-premium" style="padding-left: 1rem;">
                        <option value="">-- Pilih Jurusan --</option>
                    </select>
                </div>
            </section>

            {{-- 3. STATUS PROFESIONAL --}}
            <section class="glass-card-form p-8 md:p-10 lg:col-span-2 space-y-8">
                <h2 class="section-title text-indigo-600 border-indigo-100">
                    <i data-lucide="briefcase" class="w-5 h-5"></i> Status Profesional & Karir
                </h2>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                    <div>
                        <label class="label-premium">Status Kerja Saat Ini</label>
                        <div class="relative">
                            <i data-lucide="activity" class="input-icon text-slate-400"></i>
                            <select name="sudah_bekerja" id="sudah_bekerja" class="input-premium">
                                <option value="1" {{ old('sudah_bekerja', $alumni->sudah_bekerja) == 1 ? 'selected' : '' }}>Sudah Bekerja / Studi Lanjut</option>
                                <option value="0" {{ old('sudah_bekerja', $alumni->sudah_bekerja) == 0 ? 'selected' : '' }}>Belum Bekerja / Mencari Kerja</option>
                            </select>
                        </div>
                    </div>

                    <div id="tempat_bekerja_group">
                        <label class="label-premium">Nama Institusi / Perusahaan</label>
                        <div class="relative">
                            <i data-lucide="building-2" class="input-icon text-slate-400"></i>
                            <input type="text" id="tempat_bekerja" name="tempat_bekerja"
                                value="{{ old('tempat_bekerja', $alumni->tempat_bekerja) }}"
                                class="input-premium" placeholder="Contoh: PT. Teknologi Indonesia">
                        </div>
                    </div>
                </div>
            </section>
        </div>

        {{-- ACTIONS --}}
        <div class="flex flex-col sm:flex-row items-center justify-end gap-4 pt-6">
            <a href="{{ route('admin.alumni') }}" class="w-full sm:w-auto px-8 py-3.5 rounded-2xl font-black text-[10px] uppercase tracking-widest text-slate-500 hover:bg-slate-100 transition-all text-center">Batal</a>
            <button type="submit" class="w-full sm:w-auto px-10 py-4 bg-green-700 hover:bg-green-800 text-white rounded-2xl font-black text-[10px] uppercase tracking-[0.2em] shadow-xl transition-all active:scale-95 flex items-center justify-center gap-2">
                <i data-lucide="save" class="w-4 h-4"></i> Simpan Perubahan
            </button>
        </div>
    </form>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        lucide.createIcons();

        // LOGIKA DROPDOWN JURUSAN
        const jurusanOptions = {
            "Fakultas Adab dan Bahasa": ["S1 - Bahasa dan Sastra Arab", "S1 - Ilmu Perpustakaan dan Informasi Islam", "S1 - Pendidikan Bahasa Inggris", "S1 - Sastra Inggris", "S1 - Sejarah Peradaban Islam", "S1 - Tadris Bahasa Indonesia"],
            "Fakultas Ekonomi Dan Bisnis Islam": ["S1 - Akuntansi Syariah", "S1 - Ekonomi Syariah", "S1 - Manajemen Bisnis Syariah", "S1 - Perbankan Syariah", "S1 - Manajemen Zakat dan Wakaf", "S1 - Bisnis Digital"],
            "Fakultas Ilmu Tarbiyah": ["S1 - Bioteknologi", "S1 - Ilmu Lingkungan", "S1 - Manajemen Pendidikan Islam", "S1 - Pendidikan Agama Islam", "S1 - Pendidikan Bahasa Arab", "S1 - Pendidikan Guru Madrasah Ibtidaiyah", "S1 - Pendidikan Islam Anak Usia Dini", "S1 - Sains Data", "S1 - Tadris Biologi", "S1 - Tadris Matematika", "S1 - Teknologi Pangan", "S1 - Informatika"],
            "Fakultas Ushuluddin dan Dakwah": ["S1 - Aqidah dan Filsafat Islam", "S1 - Bimbingan dan Konseling Islam", "S1 - Ilmu Al-Qur’an dan Tafsir", "S1 - Komunikasi dan Penyiaran Islam", "S1 - Manajemen Dakwah", "S1 - Psikologi Islam", "S1 - Pemikiran Politik Islam", "S1 - Tasawuf dan Psikoterapi"],
            "Fakultas Syariah": ["S1 - Hukum Ekonomi Syariah", "S1 - Hukum Keluarga Islam", "S1 - Hukum Pidana Islam", "S1 - Hukum Bisnis"]
        };

        const selectFakultas = document.getElementById('fakultas');
        const selectJurusan = document.getElementById('jurusan');
        const currentJurusan = "{{ old('jurusan', $alumni->jurusan) }}";

        function updateJurusan() {
            const val = selectFakultas.value;
            const options = jurusanOptions[val] || [];
            selectJurusan.innerHTML = '<option value="">-- Pilih Jurusan --</option>';
            options.forEach(j => {
                const opt = document.createElement('option');
                opt.value = j;
                opt.textContent = j;
                if(j === currentJurusan) opt.selected = true;
                selectJurusan.appendChild(opt);
            });
        }

        selectFakultas.addEventListener('change', updateJurusan);
        updateJurusan();

        // TOGGLE INPUT TEMPAT BEKERJA BERDASARKAN STATUS
        const statusKerja = document.getElementById('sudah_bekerja');
        const workGroup = document.getElementById('tempat_bekerja_group');

        function toggleWork() {
            if(statusKerja.value == "1") {
                workGroup.style.opacity = "1";
                workGroup.style.pointerEvents = "auto";
                document.getElementById('tempat_bekerja').disabled = false;
            } else {
                workGroup.style.opacity = "0.5";
                workGroup.style.pointerEvents = "none";
                document.getElementById('tempat_bekerja').disabled = true;
            }
        }

        statusKerja.addEventListener('change', toggleWork);
        toggleWork();
    });
</script>
@endsection
