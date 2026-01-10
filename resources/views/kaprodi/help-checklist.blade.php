<!doctype html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <title>Panduan Penggunaan - Tracer Study</title>
    <style>
        /* Pengaturan Dasar DomPDF */
        @page {
            margin: 0;
        }

        body {
            font-family: 'Helvetica', 'Arial', sans-serif;
            color: #334155;
            margin: 0;
            padding: 0;
            line-height: 1.5;
            background-color: #ffffff;
        }

        /* Dekorasi Header */
        .top-bar {
            background: #065f46;
            height: 8px;
            width: 100%;
        }

        .container {
            max-width: 980px;
            margin: 0 auto;
            padding: 20px 20px;
        }

        /* Header Modern Tanpa Logo */
        .main-header {
            border-bottom: 3px solid #e2e8f0;
            padding-bottom: 25px;
            margin-bottom: 35px;
        }

        .brand-section {
            width: 100%;
        }

        .document-title {
            font-size: 24pt;
            font-weight: bold;
            color: #0f172a;
            margin: 0;
            letter-spacing: -1px;
        }

        .sub-title {
            font-size: 11pt;
            color: #10b981;
            font-weight: bold;
            text-transform: uppercase;
            letter-spacing: 2px;
            margin-top: 5px;
        }

        .doc-number {
            font-size: 9pt;
            color: #94a3b8;
            margin-top: 10px;
            font-family: monospace;
        }

        /* Hero / Summary Section */
        .hero-card {
            background: #f1f5f9;
            border-radius: 10px;
            padding: 16px;
            margin-bottom: 24px;
        }

        .hero-card h2 {
            margin: 0 0 10px 0;
            font-size: 14pt;
            color: #065f46;
        }

        .hero-card p {
            margin: 0;
            font-size: 10.5pt;
            color: #475569;
        }

        /* Timeline / Step-by-Step Style */
        .step-wrapper {
            width: 100%;
        }

        .step-item {
            margin-bottom: 14px;
            width: 100%;
            display: flex;
            gap: 14px;
            align-items: flex-start;
        }

        .step-number-box {
            background: #10b981;
            color: white;
            width: 36px;
            height: 36px;
            line-height: 36px;
            text-align: center;
            border-radius: 8px;
            font-weight: bold;
            flex: none;
            font-size: 13px;
        }

        .step-body {
            margin-left: 0;
            flex: 1;
        }

        .step-heading {
            font-size: 12pt;
            font-weight: 700;
            color: #0f172a;
            margin-bottom: 4px;
            display: block;
        }

        .step-text {
            font-size: 10pt;
            color: #475569;
            display: block;
            margin-bottom: 8px;
            text-align: justify;
            text-justify: inter-word;
            line-height: 1.45;
        }

        /* Alert / Note Box */
        .alert-box {
            background-color: #ecfdf5;
            border-left: 4px solid #10b981;
            padding: 10px 14px;
            margin-top: 8px;
            border-radius: 4px;
        }

        .alert-box strong {
            color: #065f46;
            font-size: 9.5pt;
        }

        .alert-box p {
            margin: 3px 0 0 0;
            font-size: 9pt;
            color: #047857;
        }

        /* Footer */
        .footer {
            position: fixed;
            bottom: 0;
            width: 100%;
            box-sizing: border-box;
            padding: 8px 18px;
            border-top: 1px solid #f1f5f9;
            background: #f8fafc;
        }

        .footer-table {
            width: 100%;
            table-layout: fixed;
            font-size: 8.5pt;
            color: #94a3b8;
        }

        .footer-table td:first-child { width: 60%; }
        .footer-table td:last-child { width: 40%; }

        .text-right {
            text-align: right;
            white-space: normal;
        }

        .footer-table td { word-break: break-word; }

        .accent-text {
            color: #10b981;
            font-weight: bold;
        }
    </style>
</head>
<body>

    <div class="top-bar"></div>

    <div class="container">
        <div class="main-header">
            <table class="brand-section">
                <tr>
                    <td>
                        <div class="sub-title">Panduan Pengguna</div>
                        <h1 class="document-title">Panduan Kaprodi — Tracer Study</h1>
                        <div class="doc-number">REF NO: {{ date('Y') }}/TS/KPD/001</div>
                    </td>
                    <td class="text-right" style="vertical-align: bottom;">
                        <div style="font-size: 10pt; color: #64748b;">
                            <strong>Sistem Informasi</strong><br>
                            Tracer Study UIN RMS
                        </div>
                    </td>
                </tr>
            </table>
        </div>

        <div class="hero-card">
            <h2>Panduan Singkat untuk Kaprodi</h2>
            <p>Prosedur operasional singkat bagi Koordinator Program Studi untuk verifikasi, validasi, dan pengunduhan data alumni. Data ini digunakan untuk keperluan pelaporan akreditasi dan evaluasi mutu program studi.</p>
        </div>

        <div class="step-wrapper">

            <div class="step-item">
                <div class="step-number-box">01</div>
                <div class="step-body">
                    <span class="step-heading">Otentikasi & Akses Menu</span>
                    <span class="step-text">Masuk ke Dashboard Kaprodi dengan akun resmi. Pada menu utama pilih <strong>"Data Alumni"</strong> untuk mengakses basis data responden.</span>
                </div>
            </div>

            <div class="step-item">
                <div class="step-number-box">02</div>
                <div class="step-body">
                    <span class="step-heading">Penyaringan Data (Filtering)</span>
                    <span class="step-text">Gunakan filter di bagian atas tabel. Pilih <strong>Program Studi</strong>, <strong>Tahun Lulus</strong>, dan parameter lain untuk menyaring data sesuai kebutuhan analisis.</span>
                </div>
            </div>

            <div class="step-item">
                <div class="step-number-box">03</div>
                <div class="step-body">
                    <span class="step-heading">Validasi Kuantitas Responden</span>
                    <span class="step-text">Pantau jumlah responden secara real-time dan bandingkan dengan target partisipasi program studi.</span>
                    <div class="alert-box">
                        <strong>Kriteria Minimum:</strong>
                        <p>Jika jumlah responden kurang dari 30, segera koordinasikan dengan koordinator angkatan untuk meningkatkan tingkat partisipasi.</p>
                    </div>
                </div>
            </div>

            <div class="step-item">
                <div class="step-number-box">04</div>
                <div class="step-body">
                    <span class="step-heading">Verifikasi Kualitas Data</span>
                    <span class="step-text">Lakukan audit menggunakan tombol <strong>"Detail"</strong>. Pastikan konsistensi riwayat pekerjaan dan informasi lain dengan jawaban kuesioner; tandai atau koreksi data yang tidak konsisten.</span>
                </div>
            </div>

            <div class="step-item">
                <div class="step-number-box">05</div>
                <div class="step-body">
                    <span class="step-heading">Finalisasi & Ekstraksi</span>
                    <span class="step-text">Ekspor data melalui fitur <strong>"Export Excel"</strong> atau format lain yang tersedia. Gunakan dataset yang sudah diverifikasi sebagai lampiran borang akreditasi dan laporan program studi.</span>
                </div>
            </div>

        </div>
    </div>

    <div class="footer">
        <table class="footer-table">
            <tr>
                <td>
                    Dicetak otomatis oleh <span class="accent-text">Tracer Study System</span><br>
                    UIN Raden Mas Said Surakarta
                </td>
                <td class="text-right">
                    Waktu Cetak: {{ date('d M Y, H:i') }}<br>
                    Dukungan: <span class="accent-text">it-tracer@uinsaid.ac.id</span>
                </td>
            </tr>
        </table>
    </div>

</body>
</html>
