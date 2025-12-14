<!DOCTYPE html>
<html>

<head>
    <title>Laporan Mutasi Warga</title>
    <style>
        body {
            font-family: sans-serif;
            font-size: 11px;
        }

        .header {
            text-align: center;
            margin-bottom: 20px;
        }

        .header h1 {
            margin: 0;
            font-size: 16px;
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
            padding: 6px;
            text-align: left;
        }

        th {
            background-color: #f4f4f4;
        }

        .badge {
            display: inline-block;
            padding: 2px 5px;
            border-radius: 4px;
            font-size: 9px;
            font-weight: bold;
        }

        .badge-masuk {
            background-color: #dcfce7;
            color: #166534;
        }

        .badge-keluar {
            background-color: #fee2e2;
            color: #991b1b;
        }

        .badge-info {
            background-color: #eff6ff;
            color: #1d4ed8;
        }
    </style>
</head>

<body>

    <div class="header">
        <h1>Laporan Mutasi Warga</h1>
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
            <p>Jenis: {{ ucfirst(str_replace('_', ' ', $filters['jenis'])) }}</p>
        @endif
    </div>

    <table>
        <thead>
            <tr>
                <th style="width: 5%">No</th>
                <th style="width: 15%">Tanggal</th>
                <th style="width: 25%">Nama Warga</th>
                <th style="width: 15%">Jenis Mutasi</th>
                <th style="width: 40%">Keterangan</th>
            </tr>
        </thead>
        <tbody>
            @forelse($mutations as $index => $m)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $m->tanggal ? \Carbon\Carbon::parse($m->tanggal)->format('d M Y') : '-' }}</td>
                    <td>{{ $m->warga ? $m->warga->nama : '-' }}</td>
                    <td>
                        @if($m->jenis == 'masuk')
                            <span class="badge badge-masuk">Masuk</span>
                        @elseif($m->jenis == 'keluar')
                            <span class="badge badge-keluar">Keluar</span>
                        @else
                            <span class="badge badge-info">{{ str_replace('_', ' ', ucfirst($m->jenis)) }}</span>
                        @endif
                    </td>
                    <td>{{ $m->keterangan }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="5" style="text-align: center; padding: 20px;">Tidak ada data ditemukan.</td>
                </tr>
            @endforelse
        </tbody>
    </table>

</body>

</html>