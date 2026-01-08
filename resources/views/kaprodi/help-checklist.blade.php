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
            padding: 40px 50px;
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
            border-radius: 12px;
            padding: 25px;
            margin-bottom: 40px;
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
            margin-bottom: 30px;
            width: 100%;
        }

        .step-number-box {
            background: #10b981;
            color: white;
            width: 32px;
            height: 32px;
            line-height: 32px;
            text-align: center;
            border-radius: 8px;
            font-weight: bold;
            float: left;
        }

        .step-body {
            margin-left: 50px;
        }

        .step-heading {
            font-size: 12pt;
            font-weight: bold;
            color: #1e293b;
            margin-bottom: 4px;
            display: block;
        }

        .step-text {
            font-size: 10pt;
            color: #64748b;
            display: block;
            margin-bottom: 12px;
        }

        /* Alert / Note Box */
        .alert-box {
            background-color: #ecfdf5;
            border-left: 4px solid #10b981;
            padding: 12px 18px;
            margin-top: 10px;
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
            padding: 20px 50px;
            border-top: 1px solid #f1f5f9;
            background: #f8fafc;
        }

        .footer-table {
            width: 100%;
            font-size: 8.5pt;
            color: #94a3b8;
        }

        .text-right {
            text-align: right;
        }

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
                        <div class="sub-title">User Guide Protocol</div>
                        <h1 class="document-title">Pemberitahuan Tata Cara</h1>
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
            <h2>Petunjuk Teknis Kaprodi</h2>
            <p>Prosedur standar pengoperasian sistem untuk keperluan verifikasi, validasi, dan penarikan data alumni pada Program Studi guna mendukung pelaporan akreditasi dan evaluasi internal.</p>
        </div>

        <div class="step-wrapper">

            <div class="step-item">
                <div class="step-number-box">01</div>
                <div class="step-body">
                    <span class="step-heading">Otentikasi & Akses Menu</span>
                    <span class="step-text">Masuk ke Dashboard RMS menggunakan akun resmi. Navigasikan pada menu utama, kemudian pilih sub-menu <strong>"Data Alumni"</strong> untuk membuka basis data responden.</span>
                </div>
            </div>

            <div class="step-item">
                <div class="step-number-box">02</div>
                <div class="step-body">
                    <span class="step-heading">Penyaringan Data (Filtering)</span>
                    <span class="step-text">Gunakan fitur pemfilteran di bagian atas tabel. Sesuaikan parameter <strong>Program Studi</strong> dan <strong>Tahun Lulus</strong> untuk memisahkan data sesuai kebutuhan analisis.</span>
                </div>
            </div>

            <div class="step-item">
                <div class="step-number-box">03</div>
                <div class="step-body">
                    <span class="step-heading">Validasi Kuantitas Responden</span>
                    <span class="step-text">Pantau jumlah responden yang masuk secara real-time.</span>
                    <div class="alert-box">
                        <strong>Kriteria Minimum:</strong>
                        <p>Jika jumlah responden < 30 orang, harap segera berkoordinasi dengan koordinator angkatan untuk meningkatkan tingkat partisipasi (Response Rate).</p>
                    </div>
                </div>
            </div>

            <div class="step-item">
                <div class="step-number-box">04</div>
                <div class="step-body">
                    <span class="step-heading">Verifikasi Kualitas Data</span>
                    <span class="step-text">Lakukan audit data dengan menekan tombol <strong>"Detail"</strong>. Pastikan konsistensi antara riwayat pekerjaan dengan jawaban kuesioner yang diberikan alumni.</span>
                </div>
            </div>

            <div class="step-item">
                <div class="step-number-box">05</div>
                <div class="step-body">
                    <span class="step-heading">Finalisasi & Ekstraksi</span>
                    <span class="step-text">Lakukan unduhan data melalui fungsi <strong>"Export Excel"</strong>. Data ini merupakan dokumen valid untuk lampiran borang akreditasi atau laporan kinerja Program Studi.</span>
                </div>
            </div>

        </div>
    </div>

    <div class="footer">
        <table class="footer-table">
            <tr>
                <td>
                    Dicetak secara sistematis oleh <span class="accent-text">Tracer Study System</span><br>
                    UIN Raden Mas Said Surakarta
                </td>
                <td class="text-right">
                    Waktu Cetak: {{ date('d M Y, H:i') }}<br>
                    Support: <span class="accent-text">it-tracer@uinsaid.ac.id</span>
                </td>
            </tr>
        </table>
    </div>

</body>
</html>
