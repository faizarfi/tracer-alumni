<!doctype html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Data Alumni - {{ date('Y') }}</title>
    <style>
        /* Menggunakan font yang lebih modern dan bersih */
        body {
            font-family: 'Helvetica', 'Arial', sans-serif;
            color: #333;
            line-height: 1.5;
            margin: 0;
            padding: 20px;
        }

        /* Header styling */
        .header {
            border-bottom: 3px solid #4a90e2;
            padding-bottom: 10px;
            margin-bottom: 20px;
        }

        h1 {
            font-size: 24px;
            color: #1a365d;
            margin: 0;
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        .meta {
            font-size: 13px;
            color: #718096;
            margin-top: 5px;
        }

        /* Table styling */
        table {
            width: 100%;
            border-collapse: collapse;
            font-size: 11px; /* Sedikit lebih kecil agar muat banyak kolom */
            background-color: white;
            box-shadow: 0 1px 3px rgba(0,0,0,0.1);
        }

        th {
            background-color: #4a90e2;
            color: white;
            font-weight: bold;
            text-align: left;
            padding: 12px 10px;
            text-transform: uppercase;
        }

        td {
            border-bottom: 1px solid #e2e8f0;
            padding: 10px;
            vertical-align: middle;
        }

        /* Zebra striping untuk kemudahan membaca */
        tr:nth-child(even) { background-color: #f8fafc; }

        /* Status Badge Styling */
        .badge {
            padding: 4px 8px;
            border-radius: 12px;
            font-size: 10px;
            font-weight: bold;
            text-align: center;
            display: inline-block;
            width: 60px;
        }
        .bg-success { background-color: #c6f6d5; color: #22543d; border: 1px solid #9ae6b4; }
        .bg-warning { background-color: #feebc8; color: #744210; border: 1px solid #fbd38d; }

        /* Menghilangkan border luar table untuk kesan clean */
        table { border: 1px solid #e2e8f0; }

    </style>
</head>
<body>

    <div class="header">
        <h1>Laporan Data Alumni</h1>
        <div class="meta">
            Dicetak pada: {{ date('d F Y') }} | Total: <strong>{{ $alumnis->count() }}</strong> alumni terdaftar
        </div>
    </div>

    <table>
        <thead>
            <tr>
                <th style="width: 30px; text-align: center;">No</th>
                <th>Nama Lengkap</th>
                <th style="width: 100px;">NIM</th>
                <th>Program Studi / Fakultas</th>
                <th style="text-align: center;">Lulus</th>
                <th style="text-align: center;">Status</th>
            </tr>
        </thead>
        <tbody>
            @foreach($alumnis as $i => $a)
            <tr>
                <td style="text-align: center;">{{ $i + 1 }}</td>
                <td><strong>{{ strtoupper($a->nama) }}</strong></td>
                <td><code>{{ $a->nim }}</code></td>
                <td>
                    {{ $a->jurusan }}<br>
                    <small style="color: #718096;">{{ $a->fakultas }}</small>
                </td>
                <td style="text-align: center;">{{ $a->tahun_keluar }}</td>
                <td style="text-align: center;">
                    @if($a->sudah_bekerja)
                        <span class="badge bg-success">BEKERJA</span>
                    @else
                        <span class="badge bg-warning">MENCARI</span>
                    @endif
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>

</body>
</html>
