<!DOCTYPE html>
<html>

<head>
    <title>Laporan Iuran</title>
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

        .text-right {
            text-align: right;
        }

        .badge {
            display: inline-block;
            padding: 2px 5px;
            border-radius: 4px;
            font-size: 9px;
            font-weight: bold;
        }

        .badge-verified {
            background-color: #dcfce7;
            color: #166534;
        }

        .badge-rejected {
            background-color: #fee2e2;
            color: #991b1b;
        }

        .badge-pending {
            background-color: #fff7ed;
            color: #9a3412;
        }
    </style>
</head>

<body>

    <div class="header">
        <h1>Laporan Pembayaran Iuran</h1>
        <p>Dicetak pada: {{ now()->format('d M Y H:i') }}</p>

        @if(isset($filters['start_date']) || isset($filters['end_date']))
            <p>
                Periode:
                {{ $filters['start_date'] ? \Carbon\Carbon::parse($filters['start_date'])->format('d M Y') : 'Awal' }}
                s/d
                {{ $filters['end_date'] ? \Carbon\Carbon::parse($filters['end_date'])->format('d M Y') : 'Akhir' }}
            </p>
        @endif

        @if(isset($filters['status']) && $filters['status'])
            <p>Status: {{ ucfirst($filters['status']) }}</p>
        @endif
    </div>

    <table>
        <thead>
            <tr>
                <th style="width: 4%">No</th>
                <th style="width: 14%">Tanggal</th>
                <th style="width: 18%">Warga</th>
                <th style="width: 20%">Iuran / Periode</th>
                <th style="width: 8%">Nominal</th>
                <th style="width: 12%">Metode</th>
                <th style="width: 12%">Pencatat</th>
                <th style="width: 12%">Status</th>
            </tr>
        </thead>
        <tbody>
            @forelse($payments as $index => $p)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $p->tanggal_bayar ? \Carbon\Carbon::parse($p->tanggal_bayar)->format('d M Y H:i') : '-' }}</td>
                    <td>{{ $p->warga ? $p->warga->nama : '-' }}</td>
                    <td>
                        @if($p->instance && $p->instance->template)
                            {{ $p->instance->template->nama }}<br>
                            <small>{{ $p->instance->periode }}</small>
                        @else
                            -
                        @endif
                    </td>
                    <td class="text-right">Rp {{ number_format($p->amount, 0, ',', '.') }}</td>
                    <td>{{ $p->metodePembayaran ? $p->metodePembayaran->nama_metode : ($p->metode ?? '-') }}</td>
                    <td>{{ $p->pencatat ? $p->pencatat->name : '-' }}</td>
                    <td>
                        @if($p->status_verifikasi == 'verified')
                            <span class="badge badge-verified">Verified</span>
                        @elseif($p->status_verifikasi == 'rejected')
                            <span class="badge badge-rejected">Rejected</span>
                        @else
                            <span class="badge badge-pending">Pending</span>
                        @endif
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="8" style="text-align: center; padding: 20px;">Tidak ada data ditemukan.</td>
                </tr>
            @endforelse
        </tbody>
    </table>

</body>

</html>