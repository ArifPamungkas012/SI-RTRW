@extends('layouts.app')

@section('title', 'Laporan Mutasi Warga')

@section('content')
    <div class="content">

        {{-- Filter Form --}}
        <form method="GET" action="{{ route('laporan.mutasi.index') }}"
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
            <select name="jenis"
                style="padding:8px 10px;border-radius:10px;border:1px solid #e2e8f0;font-size:13px;background:white;min-width:130px;">
                <option value="">Semua Jenis</option>
                <option value="masuk" {{ request('jenis') == 'masuk' ? 'selected' : '' }}>Masuk</option>
                <option value="keluar" {{ request('jenis') == 'keluar' ? 'selected' : '' }}>Keluar</option>
                <option value="pindah_rt" {{ request('jenis') == 'pindah_rt' ? 'selected' : '' }}>Pindah RT</option>
                <option value="pindah_rw" {{ request('jenis') == 'pindah_rw' ? 'selected' : '' }}>Pindah RW</option>
            </select>

            {{-- Submit --}}
            <button type="submit" style="padding:8px 14px;border-radius:10px;background:#0f172a;color:white;border:none;font-size:13px;font-weight:500;
                       display:inline-flex;align-items:center;gap:6px;">
                <i data-lucide="filter" style="width:16px;height:16px;"></i>
                Terapkan
            </button>

            <div style="display:flex;align-items:center;gap:10px;margin-left:auto;">
                {{-- Export PDF --}}
                <a href="{{ route('laporan.mutasi.export.pdf', request()->query()) }}"
                    style="padding:8px 14px;border-radius:10px;background:#ef4444;color:white;font-size:13px;font-weight:500;
                           text-decoration:none;display:inline-flex;align-items:center;gap:6px;box-shadow:0 6px 18px rgba(239,68,68,0.35);">
                    <i data-lucide="file-text" style="width:16px;height:16px;"></i>
                    <span>Export PDF</span>
                </a>

                {{-- Export Excel --}}
                <a href="{{ route('laporan.mutasi.export.excel', request()->query()) }}"
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
                            <th style="padding:12px 18px;text-align:left;font-weight:600;">Nama Warga</th>
                            <th style="padding:12px 18px;text-align:left;font-weight:600;">Jenis Mutasi</th>
                            <th style="padding:12px 18px;text-align:left;font-weight:600;">Keterangan</th>
                        </tr>
                    </thead>

                    <tbody>
                        @forelse($mutations as $index => $m)
                            <tr style="border-bottom:1px solid rgba(241,245,249,1);">
                                <td style="padding:10px 18px;">{{ $mutations->firstItem() + $index }}</td>
                                <td style="padding:10px 18px;">
                                    {{ $m->tanggal ? \Carbon\Carbon::parse($m->tanggal)->format('d M Y') : '-' }}
                                </td>
                                <td style="padding:10px 18px;font-weight:600;color:#0f172a;">
                                    {{ $m->warga ? $m->warga->nama : '-' }}
                                </td>
                                <td style="padding:10px 18px;">
                                    @if($m->jenis == 'masuk')
                                        <span style="background:#dcfce7;color:#166534;padding:3px 9px;border-radius:999px;font-size:11px;font-weight:600;">
                                            Masuk
                                        </span>
                                    @elseif($m->jenis == 'keluar')
                                        <span style="background:#fee2e2;color:#991b1b;padding:3px 9px;border-radius:999px;font-size:11px;font-weight:600;">
                                            Keluar
                                        </span>
                                    @else
                                        <span style="background:#eff6ff;color:#1d4ed8;padding:3px 9px;border-radius:999px;font-size:11px;font-weight:600;">
                                            {{ str_replace('_', ' ', ucfirst($m->jenis)) }}
                                        </span>
                                    @endif
                                </td>
                                <td style="padding:10px 18px;color:#6b7280;">
                                    {{ $m->keterangan ?? '-' }}
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" style="padding:40px 18px;text-align:center;color:#6b7280;">
                                    <i data-lucide="arrow-left-right" style="width:32px;height:32px;color:#e2e8f0;"></i>
                                    <p style="margin:0;">Tidak ada data mutasi warga.</p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        {{-- Pagination --}}
        @if ($mutations->hasPages())
            <div class="table-pagination">
                <div class="pagination-info">
                    Menampilkan
                    <strong>{{ $mutations->firstItem() }}</strong> –
                    <strong>{{ $mutations->lastItem() }}</strong>
                    dari
                    <strong>{{ $mutations->total() }}</strong>
                    data
                </div>

                <div class="pagination-nav">
                    {{-- Tombol Sebelumnya --}}
                    @if ($mutations->onFirstPage())
                        <span class="page-btn disabled">Sebelumnya</span>
                    @else
                        <a href="{{ $mutations->previousPageUrl() }}" class="page-btn">Sebelumnya</a>
                    @endif

                    @php
                        $start = max($mutations->currentPage() - 2, 1);
                        $end = min($mutations->currentPage() + 2, $mutations->lastPage());
                    @endphp

                    @for ($page = $start; $page <= $end; $page++)
                        @if ($page == $mutations->currentPage())
                            <span class="page-number active">{{ $page }}</span>
                        @else
                            <a href="{{ $mutations->url($page) }}" class="page-number">{{ $page }}</a>
                        @endif
                    @endfor

                    {{-- Tombol Berikutnya --}}
                    @if ($mutations->hasMorePages())
                        <a href="{{ $mutations->nextPageUrl() }}" class="page-btn">Berikutnya</a>
                    @else
                        <span class="page-btn disabled">Berikutnya</span>
                    @endif
                </div>
            </div>
        @endif

    </div>
@endsection
