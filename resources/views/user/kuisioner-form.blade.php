@extends('layouts.user')

@section('title', 'Kuesioner Alumni | UIN Raden Mas Said')

@section('content')
<style>
    .glass-kuesioner {
        background: rgba(255, 255, 255, 0.95);
        backdrop-filter: blur(10px);
        border: 1px solid rgba(255, 255, 255, 0.4);
    }

    .step-indicator {
        transition: all 0.4s ease;
    }

    .step-active {
        background-color: #059669;
        color: white;
        transform: scale(1.1);
        box-shadow: 0 0 20px rgba(5, 150, 105, 0.3);
    }

    .radio-card:checked + label {
        background-color: #ecfdf5;
        border-color: #10b981;
        color: #065f46;
    }

    .custom-scrollbar::-webkit-scrollbar { width: 4px; }
    .custom-scrollbar::-webkit-scrollbar-thumb { background: #10b981; border-radius: 10px; }
</style>

<div class="py-16 px-4 sm:px-6 lg:px-8 bg-slate-50 min-h-screen">
    <div class="max-w-5xl mx-auto">

        {{-- Header & Progress --}}
        <div class="mb-12 text-center">
            <div class="flex justify-center mb-6">
                <div class="p-2 bg-white rounded-3xl shadow-xl animate-float">
                    <img src="{{ asset('img/uin.png') }}" class="w-20 h-20 object-contain" alt="Logo UIN">
                </div>
            </div>
            <h1 class="text-4xl font-black text-slate-900 tracking-tight font-heading">Kuesioner <span class="text-green-600">Tracer Study</span></h1>
            <p class="text-slate-500 mt-3 font-medium max-w-2xl mx-auto">Kontribusi data Anda sangat menentukan akreditasi dan pengembangan kualitas almamater.</p>

            {{-- Stepper Progress Bar --}}
            <div class="flex items-center justify-center mt-10 gap-2 md:gap-4">
                @foreach(['Pendidikan', 'Aktivitas', 'Pekerjaan', 'Saran'] as $index => $label)
                    <div class="flex items-center">
                        <div id="step-dot-{{ $index }}" class="step-indicator w-10 h-10 rounded-full bg-slate-200 text-slate-500 flex items-center justify-center font-bold text-sm">
                            {{ $index + 1 }}
                        </div>
                        @if(!$loop->last)
                            <div class="w-8 md:w-20 h-1 bg-slate-200 mx-2 rounded-full overflow-hidden">
                                <div id="step-line-{{ $index }}" class="h-full bg-green-600 transition-all duration-500" style="width: 0%"></div>
                            </div>
                        @endif
                    </div>
                @endforeach
            </div>
        </div>

        {{-- flash messages handled by SweetAlert in layout --}}

        <div class="glass-kuesioner rounded-[2.5rem] shadow-2xl shadow-slate-200/60 overflow-hidden">
            <form id="kuisionerForm" action="{{ route('user.kuisioner') }}" method="POST" class="p-8 md:p-12" novalidate>
                @csrf

                {{-- SECTION 1: PENDIDIKAN --}}
                <div id="section1" class="space-y-10 animate-fade-in">
                    <div class="border-b border-slate-100 pb-6">
                        <h2 class="text-2xl font-bold text-slate-800 flex items-center gap-3">
                            <i data-lucide="book-open" class="text-green-600"></i> 1. Pengalaman Pendidikan di UIN
                        </h2>
                    </div>

                    @php
                        $options = ['Tidak Sama Sekali', 'Kurang', 'Cukup Besar', 'Besar', 'Sangat Besar'];
                        $items1 = ['Demonstrasi / Peragaan', 'Partisipasi Dalam Proyek Riset', 'Magang', 'Praktikum', 'Kerja Lapangan', 'Diskusi'];
                        $items2 = ['Perpustakaan', 'Teknologi Informasi Dan Komunikasi', 'Modul Belajar', 'Ruang Belajar', 'Laboratorium', 'Variasi Mata Kuliah Yang Ditawarkan', 'Fasilitas Layanan Kesehatan', 'Fasilitas Ibadah'];
                    @endphp

                    <div class="space-y-12">
                        <div>
                            <p class="font-bold text-slate-700 mb-6 bg-green-50 px-4 py-2 rounded-lg inline-block text-sm">A. Implementasi Metode Perkuliahan</p>
                            <div class="grid gap-6">
                                @foreach ($items1 as $item)
                                <div class="p-6 rounded-2xl border border-slate-100 bg-white shadow-sm hover:border-green-200 transition-all group">
                                    <label class="text-slate-800 font-bold mb-4 block">{{ $item }}</label>
                                    <div class="grid grid-cols-1 sm:grid-cols-3 md:grid-cols-5 gap-3">
                                        @foreach ($options as $option)
                                        <div class="relative">
                                            <input type="radio" name="pendidikan[{{ $item }}]" value="{{ $option }}" id="edu-{{ $item }}-{{ $loop->index }}"
                                                   class="radio-card hidden required-field" {{ old('pendidikan.' . $item) == $option ? 'checked' : '' }}>
                                            <label for="edu-{{ $item }}-{{ $loop->index }}"
                                                   class="flex items-center justify-center text-center px-3 py-3 border-2 border-slate-100 rounded-xl text-xs font-bold text-slate-500 cursor-pointer hover:bg-slate-50 transition-all uppercase tracking-tighter">
                                                {{ $option }}
                                            </label>
                                        </div>
                                        @endforeach
                                    </div>
                                </div>
                                @endforeach
                            </div>
                        </div>

                        <div>
                            <p class="font-bold text-slate-700 mb-6 bg-green-50 px-4 py-2 rounded-lg inline-block text-sm">B. Penilaian Fasilitas Kampus</p>
                            <div class="grid gap-6">
                                @foreach ($items2 as $item)
                                <div class="p-6 rounded-2xl border border-slate-100 bg-white shadow-sm hover:border-green-200 transition-all group">
                                    <label class="text-slate-800 font-bold mb-4 block">{{ $item }}</label>
                                    <div class="grid grid-cols-1 sm:grid-cols-3 md:grid-cols-5 gap-3">
                                        @foreach ($options as $option)
                                        <div class="relative">
                                            <input type="radio" name="fasilitas[{{ $item }}]" value="{{ $option }}" id="fac-{{ $item }}-{{ $loop->index }}"
                                                   class="radio-card hidden required-field" {{ old('fasilitas.' . $item) == $option ? 'checked' : '' }}>
                                            <label for="fac-{{ $item }}-{{ $loop->index }}"
                                                   class="flex items-center justify-center text-center px-3 py-3 border-2 border-slate-100 rounded-xl text-xs font-bold text-slate-500 cursor-pointer hover:bg-slate-50 transition-all uppercase tracking-tighter">
                                                {{ $option }}
                                            </label>
                                        </div>
                                        @endforeach
                                    </div>
                                </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>

                {{-- SECTION 2: AKTIVITAS --}}
                <div id="section2" class="hidden space-y-10 animate-fade-in">
                    <div class="border-b border-slate-100 pb-6">
                        <h2 class="text-2xl font-bold text-slate-800 flex items-center gap-3">
                            <i data-lucide="activity" class="text-green-600"></i> 2. Aktivitas Setelah Lulus
                        </h2>
                    </div>

                    <div class="grid gap-8 md:grid-cols-2">
                        <div class="space-y-4">
                            <label class="font-bold text-slate-700 text-sm uppercase tracking-widest ml-1" for="cari_kerja">Waktu Mulai Mencari Kerja</label>
                            <div class="relative">
                                <i data-lucide="search" class="absolute left-4 top-4 w-5 h-5 text-slate-400"></i>
                                <select id="cari_kerja" name="cari_kerja" required class="required-field w-full pl-12 pr-4 py-4 bg-slate-50 border border-slate-200 rounded-2xl outline-none focus:border-green-500 focus:ring-4 focus:ring-green-500/10 font-medium transition-all appearance-none">
                                    <option value="">-- Pilih --</option>
                                    <option {{ old('cari_kerja') == 'Sebelum Lulus' ? 'selected' : '' }}>Sebelum Lulus</option>
                                    <option {{ old('cari_kerja') == 'Setelah Lulus' ? 'selected' : '' }}>Setelah Lulus</option>
                                    <option {{ old('cari_kerja') == 'Saya Tidak Mencari Kerja' ? 'selected' : '' }}>Saya Tidak Mencari Kerja</option>
                                </select>
                            </div>
                        </div>

                        <div class="space-y-4">
                            <label class="font-bold text-slate-700 text-sm uppercase tracking-widest ml-1" for="status_pekerjaan">Status Pekerjaan Saat Ini</label>
                            <div class="relative">
                                <i data-lucide="briefcase" class="absolute left-4 top-4 w-5 h-5 text-slate-400"></i>
                                <select id="status_pekerjaan" name="status_pekerjaan" required class="required-field w-full pl-12 pr-4 py-4 bg-slate-50 border border-slate-200 rounded-2xl outline-none focus:border-green-500 focus:ring-4 focus:ring-green-500/10 font-medium transition-all appearance-none">
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
                </div>

                {{-- SECTION 3: PEKERJAAN --}}
                <div id="section3" class="hidden space-y-10 animate-fade-in">
                    <div class="border-b border-slate-100 pb-6">
                        <h2 class="text-2xl font-bold text-slate-800 flex items-center gap-3">
                            <i data-lucide="building-2" class="text-green-600"></i> 3. Informasi Pekerjaan <span class="text-slate-400 text-sm font-medium italic">(Opsional)</span>
                        </h2>
                    </div>

                    <div class="grid gap-6 md:grid-cols-2">
                        <div class="space-y-2">
                            <label class="text-xs font-black uppercase tracking-widest text-slate-500 ml-1">Nama Perusahaan</label>
                            <input type="text" name="nama_perusahaan" value="{{ old('nama_perusahaan') }}" class="w-full px-5 py-4 bg-slate-50 border border-slate-200 rounded-2xl outline-none focus:border-green-500 font-medium" placeholder="Contoh: PT. Teknologi Indonesia">
                        </div>
                        <div class="space-y-2">
                            <label class="text-xs font-black uppercase tracking-widest text-slate-500 ml-1">Jenis Pekerjaan</label>
                            <input type="text" name="jenis_pekerjaan" value="{{ old('jenis_pekerjaan') }}" class="w-full px-5 py-4 bg-slate-50 border border-slate-200 rounded-2xl outline-none focus:border-green-500 font-medium" placeholder="Contoh: Senior Manager">
                        </div>
                        <div class="md:col-span-2 space-y-2">
                            <label class="text-xs font-black uppercase tracking-widest text-slate-500 ml-1">Alamat Perusahaan</label>
                            <textarea name="alamat_perusahaan" rows="3" class="w-full px-5 py-4 bg-slate-50 border border-slate-200 rounded-2xl outline-none focus:border-green-500 font-medium" placeholder="Alamat kantor Anda saat ini">{{ old('alamat_perusahaan') }}</textarea>
                        </div>

                        @foreach (['waktu_tunggu' => 'Waktu Tunggu (Bulan)', 'jumlah_lamaran' => 'Jumlah Lamaran', 'jumlah_respon' => 'Jumlah Respon', 'jumlah_wawancara' => 'Jumlah Wawancara'] as $name => $label)
                        <div class="space-y-2">
                            <label class="text-xs font-black uppercase tracking-widest text-slate-500 ml-1">{{ $label }}</label>
                            <input type="number" name="{{ $name }}" value="{{ old($name) }}" class="w-full px-5 py-4 bg-slate-50 border border-slate-200 rounded-2xl outline-none focus:border-green-500 font-medium" placeholder="0">
                        </div>
                        @endforeach

                        <div class="md:col-span-2 space-y-2">
                            <label class="text-xs font-black uppercase tracking-widest text-slate-500 ml-1">Jenis Tempat Kerja</label>
                            <select name="jenis_perusahaan" class="w-full px-5 py-4 bg-slate-50 border border-slate-200 rounded-2xl outline-none focus:border-green-500 font-medium appearance-none">
                                <option value="">-- Pilih --</option>
                                @foreach (['Instansi Pemerintah', 'Swasta', 'Wiraswasta', 'Lembaga Pendidikan', 'Lainnya'] as $option)
                                <option {{ old('jenis_perusahaan') == $option ? 'selected' : '' }}>{{ $option }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>

                {{-- SECTION 4: KRITIK SARAN --}}
                <div id="section4" class="hidden space-y-10 animate-fade-in">
                    <div class="border-b border-slate-100 pb-6">
                        <h2 class="text-2xl font-bold text-slate-800 flex items-center gap-3">
                            <i data-lucide="message-square" class="text-green-600"></i> 4. Kritik & Saran
                        </h2>
                    </div>

                    <div class="space-y-4">
                        <label for="jawaban" class="text-sm font-bold text-slate-700 block ml-1">Apa saran Anda untuk pengembangan kurikulum dan fasilitas UIN Raden Mas Said ke depan?</label>
                        <textarea name="jawaban" id="jawaban" rows="8" required class="required-field w-full p-6 bg-slate-50 border border-slate-200 rounded-[2rem] outline-none focus:border-green-500 focus:ring-4 focus:ring-green-500/10 transition-all font-medium text-slate-700" placeholder="Tuliskan pengalaman atau masukan Anda di sini...">{{ old('jawaban') }}</textarea>
                    </div>
                </div>

                {{-- NAVIGATION BUTTONS --}}
                <div class="flex flex-col md:flex-row justify-between items-center gap-4 mt-16 pt-10 border-t border-slate-100">
                    <button type="button" id="backBtn" class="w-full md:w-auto flex items-center justify-center gap-2 px-8 py-4 bg-slate-100 text-slate-600 font-black uppercase tracking-widest text-xs rounded-2xl hover:bg-slate-200 transition-all disabled:opacity-30 active:scale-95">
                        <i data-lucide="arrow-left" class="w-4 h-4"></i> Kembali
                    </button>

                    <div class="flex w-full md:w-auto gap-4">
                        <button type="button" id="nextBtn" class="w-full md:w-auto flex items-center justify-center gap-2 px-10 py-4 bg-green-700 text-white font-black uppercase tracking-widest text-xs rounded-2xl shadow-xl shadow-green-900/20 hover:bg-green-800 transition-all active:scale-95">
                            Selanjutnya <i data-lucide="arrow-right" class="w-4 h-4"></i>
                        </button>

                        <button type="submit" id="submitBtn" class="hidden w-full md:w-auto flex items-center justify-center gap-2 px-10 py-4 bg-blue-600 text-white font-black uppercase tracking-widest text-xs rounded-2xl shadow-xl shadow-blue-900/20 hover:bg-blue-700 transition-all active:scale-95">
                            Kirim Jawaban <i data-lucide="send" class="w-4 h-4"></i>
                        </button>
                    </div>
                </div>
            </form>
        </div>

        <div class="mt-8 text-center">
            <a href="{{ route('user.dashboard') }}" class="text-slate-400 hover:text-green-600 text-xs font-bold uppercase tracking-[0.2em] transition-colors flex items-center justify-center gap-2">
                <i data-lucide="x" class="w-3 h-3"></i> Batalkan & Keluar
            </a>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', () => {
        lucide.createIcons();

        const sections = ['section1', 'section2', 'section3', 'section4'];
        let current = 0;

        const updateUI = () => {
            // Section Visibility
            sections.forEach((id, i) => {
                const el = document.getElementById(id);
                el.classList.toggle('hidden', i !== current);
            });

            // Button States
            document.getElementById('backBtn').disabled = current === 0;
            document.getElementById('nextBtn').classList.toggle('hidden', current === sections.length - 1);
            document.getElementById('submitBtn').classList.toggle('hidden', current !== sections.length - 1);

            // Stepper Logic
            sections.forEach((_, i) => {
                const dot = document.getElementById(`step-dot-${i}`);
                const line = document.getElementById(`step-line-${i}`);

                if (i <= current) {
                    dot.classList.add('step-active');
                    dot.classList.remove('bg-slate-200', 'text-slate-500');
                } else {
                    dot.classList.remove('step-active');
                    dot.classList.add('bg-slate-200', 'text-slate-500');
                }

                if (line) {
                    line.style.width = i < current ? '100%' : '0%';
                }
            });

            window.scrollTo({ top: 0, behavior: 'smooth' });
        };

        const validateSection = () => {
            const currentSection = document.getElementById(sections[current]);
            const requiredFields = currentSection.querySelectorAll('.required-field:not([disabled])');

            for (let field of requiredFields) {
                if (field.type === 'radio') {
                    const name = field.name;
                    const checked = currentSection.querySelector(`input[name="${name}"]:checked`);
                    if (!checked) {
                        Swal.fire({icon: 'warning', title: 'Perhatian', text: 'Mohon jawab seluruh pertanyaan sebelum melanjutkan.'});
                        return false;
                    }
                } else if (field.value.trim() === '') {
                    Swal.fire({icon: 'warning', title: 'Perhatian', text: 'Mohon lengkapi bidang yang wajib diisi.'}).then(() => { field.focus(); });
                    return false;
                }
            }
            return true;
        };

        document.getElementById('nextBtn').addEventListener('click', () => {
            if (!validateSection()) return;

            if (sections[current] === 'section2') {
                const status = document.getElementById('status_pekerjaan').value;
                if (status.includes('Tidak bekerja') || status.includes('Melanjutkan studi')) {
                    current = 3; // Jump to Section 4
                    document.getElementById('section3').querySelectorAll('input, select, textarea').forEach(f => f.setAttribute('disabled', 'true'));
                } else {
                    current++;
                    document.getElementById('section3').querySelectorAll('input, select, textarea').forEach(f => f.removeAttribute('disabled'));
                }
            } else {
                current++;
            }
            updateUI();
        });

        document.getElementById('backBtn').addEventListener('click', () => {
            if (sections[current] === 'section4') {
                const status = document.getElementById('status_pekerjaan').value;
                if (status.includes('Tidak bekerja') || status.includes('Melanjutkan studi')) {
                    current = 1; // Back to Section 2
                } else {
                    current = 2; // Back to Section 3
                }
            } else {
                current--;
            }
            updateUI();
        });

        updateUI();
    });
</script>
@endsection
