<!DOCTYPE html>
<html>

<head>
    <title>Laporan Kegiatan</title>
    <style>
        body {
            font-family: sans-serif;
            font-size: 12px;
        }

        .header {
            text-align: center;
            margin-bottom: 20px;
        }

        .header h1 {
            margin: 0;
            font-size: 18px;
        }

        .header p {
            margin: 2px 0;
            color: #555;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }

        th,
        td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }

        th {
            background-color: #f4f4f4;
        }

        .text-right {
            text-align: right;
        }

        .badge {
            display: inline-block;
            padding: 2px 5px;
            border-radius: 4px;
            font-size: 10px;
            font-weight: bold;
            background-color: #eff6ff;
            color: #1d4ed8;
        }
    </style>
</head>

<body>

    <div class="header">
        <h1>Laporan Kegiatan</h1>
        <p>Dicetak pada: {{ now()->format('d M Y H:i') }}</p>

        @if(isset($filters['start_date']) || isset($filters['end_date']))
            <p>
                Periode:
                {{ $filters['start_date'] ? \Carbon\Carbon::parse($filters['start_date'])->format('d M Y') : 'Awal' }}
                s/d
                {{ $filters['end_date'] ? \Carbon\Carbon::parse($filters['end_date'])->format('d M Y') : 'Akhir' }}
            </p>
        @endif

        @if(isset($filters['jenis']) && $filters['jenis'])
            <p>Jenis: {{ $filters['jenis'] }}</p>
        @endif
    </div>

    <table>
        <thead>
            <tr>
                <th style="width: 5%">No</th>
                <th style="width: 15%">Tanggal & Waktu</th>
                <th style="width: 25%">Nama Kegiatan</th>
                <th style="width: 15%">Jenis</th>
                <th style="width: 20%">Lokasi</th>
                <th style="width: 20%">Penanggung Jawab</th>
            </tr>
        </thead>
        <tbody>
            @forelse($activities as $index => $item)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>
                        {{ $item->tanggal ? \Carbon\Carbon::parse($item->tanggal)->format('d M Y') : '-' }}<br>
                        <small>{{ $item->waktu ?? '' }}</small>
                    </td>
                    <td>{{ $item->nama }}</td>
                    <td><span class="badge">{{ $item->jenis }}</span></td>
                    <td>{{ $item->lokasi ?? '-' }}</td>
                    <td>{{ $item->penanggungJawab ? $item->penanggungJawab->name : '-' }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="6" style="text-align: center; padding: 20px;">Tidak ada data ditemukan.</td>
                </tr>
            @endforelse
        </tbody>
    </table>

</body>

</html>