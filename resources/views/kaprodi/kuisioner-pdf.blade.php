@php
    $kaprodiName = $kaprodiProdi ?? 'Prodi';
@endphp

<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <title>Laporan Kuesioner - {{ $kaprodiName }}</title>
    <style>
        body { font-family: DejaVu Sans, Arial, sans-serif; color: #0f172a; }
        .header { text-align: center; margin-bottom: 20px; }
        .meta { font-size: 12px; color: #334155; }
        table { width: 100%; border-collapse: collapse; margin-top: 10px; }
        th, td { border: 1px solid #e2e8f0; padding: 6px 8px; font-size: 11px; }
        th { background: #10b981; color: #fff; }
        .small { font-size: 10px; color: #64748b; }
    </style>
</head>
<body>
    <div class="header">
        <h2>Laporan Kuesioner - {{ $kaprodiName }}</h2>
        <div class="meta">Generated: {{ now()->format('d-m-Y H:i') }}</div>
    </div>

    {{-- Per-user summaries will be displayed inside each respondent's row (Pendidikan & Fasilitas columns) --}}

    <table>
        <thead>
            <tr>
                <th>#</th>
                <th>Nama</th>
                <th>NIM</th>
                <th>Prodi</th>
                <th>Pendidikan</th>
                <th>Fasilitas</th>
                <th>Jawaban (ringkasan)</th>
                <th>Tanggal</th>
            </tr>
        </thead>
        {{-- no aggregated summary row here; we render per-user mappings below --}}
        <tbody>
            @foreach($kuisioners as $i => $k)
                <tr>
                    <td>{{ $i + 1 }}</td>
                    <td>{{ $k->nama ?? $k->user->name ?? '-' }}</td>
                    <td>{{ $k->nim ?? '-' }}</td>
                    <td>{{ $kaprodiProdi }}</td>
                    <td>
                        @if(is_array($k->pendidikan))
                            @php $keys = array_keys($k->pendidikan); $isAssoc = $keys !== range(0, count($keys)-1); @endphp
                            @if($isAssoc)
                                @foreach($k->pendidikan as $q => $ans)
                                    <div style="font-size:11px;">{{ $q }} = <strong>{{ is_array($ans) ? implode(', ', $ans) : ($ans ?? '-') }}</strong></div>
                                @endforeach
                            @else
                                {{ implode(', ', $k->pendidikan) }}
                            @endif
                        @else
                            {{ $k->pendidikan ?? '-' }}
                        @endif
                    </td>
                    <td>
                        @if(is_array($k->fasilitas))
                            @php $keys2 = array_keys($k->fasilitas); $isAssoc2 = $keys2 !== range(0, count($keys2)-1); @endphp
                            @if($isAssoc2)
                                @foreach($k->fasilitas as $q => $ans)
                                    <div style="font-size:11px;">{{ $q }} = <strong>{{ is_array($ans) ? implode(', ', $ans) : ($ans ?? '-') }}</strong></div>
                                @endforeach
                            @else
                                {{ implode(', ', $k->fasilitas) }}
                            @endif
                        @else
                            {{ $k->fasilitas ?? '-' }}
                        @endif
                    </td>
                    <td class="small">{{ Str::limit(strip_tags(is_string($k->jawaban) ? $k->jawaban : json_encode($k->jawaban)), 150) }}</td>
                    <td>{{ $k->created_at ? $k->created_at->format('d-m-Y') : '-' }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <div style="margin-top:18px; font-size:10px; color:#6b7280;">Total records: {{ $kuisioners->count() }}</div>
</body>
</html>
