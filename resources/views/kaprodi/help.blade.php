@extends('layouts.kaprodi') {{-- Menggunakan template utama --}}

@section('title', 'Panduan & Bantuan')

@section('head_extras')
<style>
    /* Styling untuk FAQ Accordion */
    .faq-item { margin-bottom: 1rem; border-radius: 0.5rem; }
    .faq-question {
        background-color: #f0fdf4; /* green-50 */
        border: 1px solid #d1fae5; /* green-100 */
        padding: 1rem;
        cursor: pointer;
        font-weight: 600;
        color: #065f46; /* green-700 */
        display: flex;
        justify-content: space-between;
        align-items: center;
        transition: background-color 0.2s;
    }
    .faq-question:hover {
        background-color: #d1fae5; /* green-100 */
    }
    .faq-answer {
        padding: 1rem;
        border: 1px solid #d1fae5;
        border-top: none;
        background-color: white;
        display: none;
    }
    /* Style untuk rotasi ikon */
    .rotate-180 {
        transform: rotate(180deg);
    }
</style>
@endsection

@section('content')

    {{-- Header/Title Section --}}
    <header class="mb-6 p-4 bg-white rounded-xl shadow-md flex items-center justify-between">
        <button id="sidebarToggle" class="mr-3 text-green-700 md:hidden p-2 rounded hover:bg-green-100 transition duration-150" aria-label="Toggle Menu">
            <i data-lucide="menu" class="w-5 h-5"></i>
        </button>
        <div class="flex-grow">
            <h1 class="text-xl lg:text-2xl font-extrabold text-green-800 tracking-tight font-['Poppins']">
                <i data-lucide="life-buoy" class="inline-block w-6 h-6 mr-2 text-green-600"></i> Panduan Penggunaan
            </h1>
            <p class="text-gray-600 text-sm mt-1">FAQ, petunjuk, dan cara interpretasi data untuk Program Studi Anda.</p>
        </div>
    </header>

    {{-- Bagian Sumber Daya Cepat --}}
    <section class="mb-6 grid grid-cols-1 md:grid-cols-3 gap-4">
        <a href="#faq-accordion" class="flex flex-col p-4 bg-white rounded-xl shadow-md border-l-4 border-indigo-500 hover:shadow-lg transition">
            <span class="text-xs font-semibold text-indigo-600 uppercase">Akses Cepat</span>
            <span class="text-lg font-bold text-gray-700">Tanya Jawab (FAQ)</span>
        </a>
            <a href="#interpretasi" class="flex flex-col p-4 bg-white rounded-xl shadow-md border-l-4 border-yellow-500 hover:shadow-lg transition">
            <span class="text-xs font-semibold text-yellow-600 uppercase">Data Literacy</span>
            <span class="text-lg font-bold text-gray-700">Interpretasi Metrik Kunci</span>
        </a>
            <a href="{{ route('kaprodi.alumni') ?? '#' }}" class="flex flex-col p-4 bg-white rounded-xl shadow-md border-l-4 border-blue-500 hover:shadow-lg transition">
            <span class="text-xs font-semibold text-blue-600 uppercase">Data Mentah</span>
            <span class="text-lg font-bold text-gray-700">Lihat Semua Data Alumni</span>
        </a>
    </section>


    <section class="bg-white p-6 rounded-2xl shadow-xl border border-gray-200">

        {{-- Bagian FAQ --}}
        <h2 class="text-2xl font-bold text-gray-800 mb-5 border-b pb-3 flex items-center gap-2">
            <i data-lucide="messages-square" class="w-6 h-6 text-indigo-600"></i> Pertanyaan Umum (FAQ)
        </h2>

        <div class="space-y-4" id="faq-accordion">

            {{-- FAQ 1 --}}
            <div class="faq-item rounded-lg overflow-hidden">
                <div class="faq-question">
                    Apa perbedaan antara 'Total Alumni' dan 'Total Responden'?
                    <i data-lucide="chevron-down" class="w-5 h-5 transition-transform transform"></i>
                </div>
                <div class="faq-answer">
                    <p class="text-gray-700">
                        <span class="font-bold text-green-700">Total Alumni</span> merujuk pada jumlah keseluruhan lulusan Program Studi Anda yang tercatat dalam database sistem. Angka ini adalah dasar untuk menghitung tingkat partisipasi dan metrik umum lainnya yang diperlukan untuk laporan akademik dan akreditasi.
                        <br><br>
                        <span class="font-bold text-green-700">Total Responden</span> adalah metrik yang lebih spesifik, yaitu jumlah lulusan yang telah secara aktif berpartisipasi dan menyelesaikan pengisian Kuesioner Tracer Study. Semakin tinggi angka ini, semakin valid dan representatif data analisis yang Anda miliki di dashboard.
                    </p>
                </div>
            </div>

            {{-- FAQ 2 --}}
            <div class="faq-item rounded-lg overflow-hidden">
                <div class="faq-question">
                    Bagaimana cara data di grafik 'Alumni Berdasarkan Tahun Keluar' dihitung?
                    <i data-lucide="chevron-down" class="w-5 h-5 transition-transform transform"></i>
                </div>
                <div class="faq-answer">
                    <p class="text-gray-700">
                        Grafik ini dihasilkan dengan mengelompokkan dan menghitung semua alumni berdasarkan kolom Tahun Keluar (`tahun_keluar`) mereka. Ini memberikan visualisasi tren demografi kelulusan dari tahun ke tahun.
                        <br><br>
                        Interpretasi: Dengan grafik ini, Anda dapat mengidentifikasi periode dengan jumlah lulusan tertinggi atau terendah. Data ini penting untuk membandingkan efisiensi studi dan memproyeksikan kapasitas alumni di masa mendatang.
                    </p>
                </div>
            </div>

            {{-- FAQ 3 --}}
            <div class="faq-item rounded-lg overflow-hidden">
                <div class="faq-question">
                    Apa yang diukur oleh grafik 'Status Serapan Kerja'?
                    <i data-lucide="chevron-down" class="w-5 h-5 transition-transform transform"></i>
                </div>
                <div class="faq-answer">
                    <p class="text-gray-700">
                        Grafik ini memvisualisasikan proporsi alumni yang terdata dengan status telah bekerja atau melanjutkan studi (`sudah_bekerja = 1`) berbanding dengan yang belum bekerja (`sudah_bekerja = 0`).
                        <br><br>
                        Status Serapan Kerja (Employability Rate) adalah indikator kinerja utama Program Studi. Persentase yang tinggi menunjukkan keberhasilan program dalam mempersiapkan lulusan untuk pasar kerja segera setelah lulus. Data ini juga sering menjadi syarat penting dalam laporan akreditasi.
                    </p>
                </div>
            </div>
        </div>

        {{-- Bagian Interpretasi Data Laporan Kuesioner --}}
        <h2 class="text-2xl font-bold text-gray-800 mt-10 mb-5 border-b pb-3 flex items-center gap-2" id="interpretasi">
            <i data-lucide="trending-up" class="w-6 h-6 text-yellow-600"></i> Interpretasi Laporan Kuesioner
        </h2>

        <div class="space-y-4 text-gray-700">
            <div class="p-4 border border-blue-200 bg-blue-50 rounded-lg">
                <h3 class="font-semibold text-blue-800 mb-1">P1: Relevansi Pekerjaan (Job Match)</h3>
                <p class="text-sm">
                    Metrik ini mengukur tingkat kecocokan pekerjaan alumni dengan latar belakang pendidikan mereka. Nilai tinggi pada "Ya, Relevan" mengindikasikan keberhasilan kurikulum dalam memenuhi kebutuhan industri yang sesuai dengan bidang Program Studi. Jika nilai "Tidak Relevan" tinggi, ini dapat memicu inisiatif peninjauan kurikulum, peningkatan layanan karir, atau penyesuaian fokus keahlian agar lebih sejalan dengan tuntutan pasar.
                </p>
            </div>

            <div class="p-4 border border-indigo-200 bg-indigo-50 rounded-lg">
                <h3 class="font-semibold text-indigo-800 mb-1">Waktu Tunggu Mendapatkan Pekerjaan</h3>
                <p class="text-sm">
                    Data ini (ditemukan di halaman Detail Kuesioner) diukur dalam bulan, dari tanggal kelulusan hingga alumni mendapatkan pekerjaan pertama. Waktu tunggu yang singkat (ideal < 6 bulan) menunjukkan efektivitas Program Studi dalam membangun jaringan profesional dan relevansi lulusan di mata pemberi kerja. Ini adalah metrik kunci untuk daya saing Program Studi.
                </p>
            </div>

            <div class="p-4 border border-purple-200 bg-purple-50 rounded-lg">
                <h3 class="font-semibold text-purple-800 mb-1">Indeks Kepuasan Rata-rata</h3>
                <p class="text-sm">
                    Indeks Kepuasan adalah skor rata-rata (biasanya 1 hingga 5) yang diberikan responden terhadap kualitas fasilitas kampus atau proses akademik tertentu. Skor yang mendekati 5 menunjukkan kepuasan tinggi. Kaprodi harus fokus pada skor yang rendah (di bawah 3) untuk memprioritaskan alokasi sumber daya perbaikan.
                </p>
            </div>

            <div class="p-4 border border-yellow-200 bg-yellow-50 rounded-lg">
                <h3 class="font-semibold text-yellow-800 mb-1">P3 & P4: Proses Pendidikan dan Fasilitas (Skala Penilaian)</h3>
                <p class="text-sm">
                    Grafik Grouped Bar P3 (Proses Pendidikan) dan P4 (Fasilitas) menggunakan skala penilaian (Likert). Fokus analisis harus diarahkan pada komponen spesifik yang mendapat skor tinggi pada kategori negatif ("Kurang" atau "Tidak Sama Sekali"). Area-area tersebut (misalnya 'Magang' di P3 atau 'Laboratorium' di P4) adalah prioritas utama untuk perbaikan strategis, baik itu kurikulum atau infrastruktur.
                </p>
            </div>
        </div>

    </section>
@endsection

@section('scripts')
    <script>
        // Logika FAQ Accordion (Perbaikan)
        const faqItems = document.querySelectorAll('.faq-item');
        faqItems.forEach(item => {
            const question = item.querySelector('.faq-question');
            const answer = item.querySelector('.faq-answer');
            const icon = question.lastElementChild;

            question.addEventListener('click', () => {
                // Close all other open answers
                faqItems.forEach(i => {
                    const otherAnswer = i.querySelector('.faq-answer');
                    const otherIcon = i.querySelector('.faq-question').lastElementChild;

                    if (i !== item) {
                        otherAnswer.style.display = 'none';
                        otherIcon.classList.remove('rotate-180');
                    }
                });

                // Toggle current answer
                const isVisible = answer.style.display === 'block';
                answer.style.display = isVisible ? 'none' : 'block';
                icon.classList.toggle('rotate-180');
            });
        });
    </script>
@endsection
