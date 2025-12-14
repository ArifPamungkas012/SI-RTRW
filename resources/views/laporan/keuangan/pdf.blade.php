<!DOCTYPE html>
<html>

<head>
    <title>Laporan Keuangan</title>
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
        }

        .badge-masuk {
            background-color: #dcfce7;
            color: #166534;
        }

        .badge-keluar {
            background-color: #fee2e2;
            color: #991b1b;
        }
    </style>
</head>

<body>

    <div class="header">
        <h1>Laporan Keuangan</h1>
        <p>Dicetak pada: {{ now()->format('d M Y H:i') }}</p>

        @if(isset($filters['start_date']) || isset($filters['end_date']))
            <p>
                Periode:
                {{ $filters['start_date'] ? \Carbon\Carbon::parse($filters['start_date'])->format('d M Y') : 'Awal' }}
                s/d
                {{ $filters['end_date'] ? \Carbon\Carbon::parse($filters['end_date'])->format('d M Y') : 'Akhir' }}
            </p>
        @endif

        @if(isset($filters['tipe']) && $filters['tipe'])
            <p>Tipe: {{ ucfirst($filters['tipe']) }}</p>
        @endif
    </div>

    <table>
        <thead>
            <tr>
                <th style="width: 5%">No</th>
                <th style="width: 15%">Tanggal</th>
                <th style="width: 10%">Tipe</th>
                <th style="width: 15%">Kategori</th>
                <th style="width: 30%">Keterangan</th>
                <th style="width: 15%" class="text-right">Nominal</th>
                <th style="width: 10%">Pencatat</th>
            </tr>
        </thead>
        <tbody>
            @forelse($transactions as $index => $item)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $item->tanggal ? \Carbon\Carbon::parse($item->tanggal)->format('d M Y') : '-' }}</td>
                    <td>
                        @if($item->tipe === 'masuk')
                            <span class="badge badge-masuk">Masuk</span>
                        @else
                            <span class="badge badge-keluar">Keluar</span>
                        @endif
                    </td>
                    <td>{{ $item->kategori }}</td>
                    <td>{{ $item->keterangan }}</td>
                    <td class="text-right">Rp {{ number_format($item->nominal, 0, ',', '.') }}</td>
                    <td>{{ $item->pencatat ? $item->pencatat->name : '-' }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="7" style="text-align: center; padding: 20px;">Tidak ada data ditemukan.</td>
                </tr>
            @endforelse
        </tbody>
    </table>

</body>

</html>