@extends('layouts.app')

@section('title', 'Laporan Kegiatan')

@section('content')
    <div class="content">
        {{-- Filter Form --}}
        <form method="GET" action="{{ route('laporan.kegiatan.index') }}"
            style="margin-bottom:18px;display:flex;flex-wrap:wrap;gap:12px;align-items:center;">

            {{-- Filter Tanggal Mulai --}}
            <div style="display:flex;align-items:center;gap:8px;">
                <span style="font-size:13px;color:#64748b;">Dari:</span>
                <input type="date" name="start_date" value="{{ request('start_date') }}"
                    style="padding:8px 10px;border-radius:10px;border:1px solid #e2e8f0;font-size:13px;background:white;outline:none;">
            </div>

            {{-- Filter Tanggal Sampai --}}
            <div style="display:flex;align-items:center;gap:8px;">
                <span style="font-size:13px;color:#64748b;">Sampai:</span>
                <input type="date" name="end_date" value="{{ request('end_date') }}"
                    style="padding:8px 10px;border-radius:10px;border:1px solid #e2e8f0;font-size:13px;background:white;outline:none;">
            </div>

            {{-- Filter Jenis --}}
            {{-- We can use a free text input if types are diverse, or a select if we pass $types from controller --}}
            <select name="jenis"
                style="padding:8px 10px;border-radius:10px;border:1px solid #e2e8f0;font-size:13px;background:white;min-width:130px;">
                <option value="">Semua Jenis</option>
                @if(isset($types))
                    @foreach($types as $t)
                        <option value="{{ $t }}" {{ request('jenis') == $t ? 'selected' : '' }}>{{ $t }}</option>
                    @endforeach
                @endif
            </select>

            {{-- Submit --}}
            <button type="submit" style="padding:8px 14px;border-radius:10px;background:#0f172a;color:white;border:none;font-size:13px;font-weight:500;
                               display:inline-flex;align-items:center;gap:6px;">
                <i data-lucide="filter" style="width:16px;height:16px;"></i>
                Terapkan
            </button>

            <div style="display:flex;align-items:center;gap:10px;margin-left:auto;">
                {{-- Export PDF --}}
                <a href="{{ route('laporan.kegiatan.export.pdf', request()->query()) }}"
                    style="padding:8px 14px;border-radius:10px;background:#ef4444;color:white;font-size:13px;font-weight:500;
                                   text-decoration:none;display:inline-flex;align-items:center;gap:6px;box-shadow:0 6px 18px rgba(239,68,68,0.35);">
                    <i data-lucide="file-text" style="width:16px;height:16px;"></i>
                    <span>Export PDF</span>
                </a>

                {{-- Export Excel --}}
                <a href="{{ route('laporan.kegiatan.export.excel', request()->query()) }}"
                    style="padding:8px 14px;border-radius:10px;background:#10b981;color:white;font-size:13px;font-weight:500;
                                   text-decoration:none;display:inline-flex;align-items:center;gap:6px;box-shadow:0 6px 18px rgba(16,185,129,0.35);">
                    <i data-lucide="table" style="width:16px;height:16px;"></i>
                    <span>Export Excel</span>
                </a>
            </div>
        </form>

        {{-- Card Tabel --}}
        <div style="background:#fff;border-radius:12px;padding:0;border:1px solid rgba(2,6,23,0.04);
                            box-shadow:0 6px 20px rgba(2,6,23,0.03);overflow:hidden;">
            <div style="overflow:auto;">
                <table style="width:100%;border-collapse:collapse;font-size:13px;">
                    <thead style="background:#f8fafc;border-bottom:1px solid rgba(148,163,184,0.4);color:#475569;">
                        <tr>
                            <th style="padding:12px 18px;text-align:left;font-weight:600;">No</th>
                            <th style="padding:12px 18px;text-align:left;font-weight:600;">Tanggal</th>
                            <th style="padding:12px 18px;text-align:left;font-weight:600;">Waktu</th>
                            <th style="padding:12px 18px;text-align:left;font-weight:600;">Nama Kegiatan</th>
                            <th style="padding:12px 18px;text-align:left;font-weight:600;">Jenis</th>
                            <th style="padding:12px 18px;text-align:left;font-weight:600;">Lokasi</th>
                            <th style="padding:12px 18px;text-align:left;font-weight:600;">Penanggung Jawab</th>
                        </tr>
                    </thead>

                    <tbody>
                        @forelse($activities as $index => $item)
                            <tr style="border-bottom:1px solid rgba(241,245,249,1);">
                                <td style="padding:10px 18px;">{{ $activities->firstItem() + $index }}</td>
                                <td style="padding:10px 18px;">
                                    {{ $item->tanggal ? \Carbon\Carbon::parse($item->tanggal)->format('d M Y') : '-' }}
                                </td>
                                <td style="padding:10px 18px;">{{ $item->waktu ?? '-' }}</td>
                                <td style="padding:10px 18px;font-weight:600;color:#0f172a;">{{ $item->nama }}</td>
                                <td style="padding:10px 18px;">
                                    <span
                                        style="background:#eff6ff;color:#1d4ed8;padding:3px 9px;border-radius:999px;font-size:11px;font-weight:600;">
                                        {{ $item->jenis }}
                                    </span>
                                </td>
                                <td style="padding:10px 18px;color:#6b7280;">{{ $item->lokasi ?? '-' }}</td>
                                <td style="padding:10px 18px;color:#6b7280;">
                                    {{ $item->penanggungJawab ? $item->penanggungJawab->name : '-' }}
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" style="padding:40px 18px;text-align:center;color:#6b7280;">
                                    <i data-lucide="calendar" style="width:32px;height:32px;color:#e2e8f0;"></i>
                                    <p style="margin:0;">Tidak ada data kegiatan.</p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        {{-- Pagination --}}
        @if ($activities->hasPages())
            <div class="table-pagination">
                <div class="pagination-info">
                    Menampilkan
                    <strong>{{ $activities->firstItem() }}</strong> –
                    <strong>{{ $activities->lastItem() }}</strong>
                    dari
                    <strong>{{ $activities->total() }}</strong>
                    kegiatan
                </div>

                <div class="pagination-nav">
                    {{-- Tombol Sebelumnya --}}
                    @if ($activities->onFirstPage())
                        <span class="page-btn disabled">Sebelumnya</span>
                    @else
                        <a href="{{ $activities->previousPageUrl() }}" class="page-btn">Sebelumnya</a>
                    @endif

                    @php
                        $start = max($activities->currentPage() - 2, 1);
                        $end = min($activities->currentPage() + 2, $activities->lastPage());
                    @endphp

                    @for ($page = $start; $page <= $end; $page++)
                        @if ($page == $activities->currentPage())
                            <span class="page-number active">{{ $page }}</span>
                        @else
                            <a href="{{ $activities->url($page) }}" class="page-number">{{ $page }}</a>
                        @endif
                    @endfor

                    {{-- Tombol Berikutnya --}}
                    @if ($activities->hasMorePages())
                        <a href="{{ $activities->nextPageUrl() }}" class="page-btn">Berikutnya</a>
                    @else
                        <span class="page-btn disabled">Berikutnya</span>
                    @endif
                </div>
            </div>
        @endif

    </div>
@endsection