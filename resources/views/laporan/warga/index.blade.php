@extends('layouts.app')

@section('title', 'Laporan Warga')

@section('content')
    <div class="content">
        {{-- Filter Form --}}
        <form method="GET" action="{{ route('laporan.warga.index') }}"
            style="margin-bottom:18px;display:flex;flex-wrap:wrap;gap:12px;align-items:center;">

            {{-- Search --}}
            <div style="position:relative;">
                <input name="q" value="{{ request('q') }}" placeholder="Cari nama / NIK..." style="padding:8px 12px 8px 32px;border-radius:10px;border:1px solid rgba(148,163,184,0.7);
                                   font-size:13px;min-width:220px;outline:none;">
                <i data-lucide="search"
                    style="width:16px;height:16px;color:#94a3b8;position:absolute;left:10px;top:50%;transform:translateY(-50%);"></i>
            </div>

            {{-- Filter RT --}}
            <select name="rt"
                style="padding:8px 10px;border-radius:10px;border:1px solid #e2e8f0;font-size:13px;background:white;min-width:100px;">
                <option value="">Semua RT</option>
                @foreach($rts as $r)
                    <option value="{{ $r }}" {{ request('rt') == $r ? 'selected' : '' }}>{{ $r }}</option>
                @endforeach
            </select>

            {{-- Filter RW --}}
            <select name="rw"
                style="padding:8px 10px;border-radius:10px;border:1px solid #e2e8f0;font-size:13px;background:white;min-width:100px;">
                <option value="">Semua RW</option>
                @foreach($rws as $rw)
                    <option value="{{ $rw }}" {{ request('rw') == $rw ? 'selected' : '' }}>{{ $rw }}</option>
                @endforeach
            </select>

            {{-- Filter Status --}}
            <select name="status"
                style="padding:8px 10px;border-radius:10px;border:1px solid #e2e8f0;font-size:13px;background:white;min-width:130px;">
                <option value="">Semua Status</option>
                <option value="1" {{ request('status') == '1' ? 'selected' : '' }}>Aktif</option>
                <option value="0" {{ request('status') == '0' ? 'selected' : '' }}>Tidak Aktif</option>
            </select>

            {{-- Submit --}}
            <button type="submit" style="padding:8px 14px;border-radius:10px;background:#0f172a;color:white;border:none;font-size:13px;font-weight:500;
                               display:inline-flex;align-items:center;gap:6px;">
                <i data-lucide="filter" style="width:16px;height:16px;"></i>
                Terapkan
            </button>

            <div style="display:flex;align-items:center;gap:10px;margin-left:auto;">
                {{-- Export PDF --}}
                <a href="{{ route('laporan.warga.export.pdf', request()->query()) }}"
                    style="padding:8px 14px;border-radius:10px;background:#ef4444;color:white;font-size:13px;font-weight:500;
                                   text-decoration:none;display:inline-flex;align-items:center;gap:6px;box-shadow:0 6px 18px rgba(239,68,68,0.35);">
                    <i data-lucide="file-text" style="width:16px;height:16px;"></i>
                    <span>Export PDF</span>
                </a>

                {{-- Export Excel --}}
                <a href="{{ route('laporan.warga.export.excel', request()->query()) }}"
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
                            <th style="padding:12px 18px;text-align:left;font-weight:600;">NIK</th>
                            <th style="padding:12px 18px;text-align:left;font-weight:600;">Nama</th>
                            <th style="padding:12px 18px;text-align:left;font-weight:600;">Alamat</th>
                            <th style="padding:12px 18px;text-align:left;font-weight:600;">RT / RW</th>
                            <th style="padding:12px 18px;text-align:left;font-weight:600;">No HP</th>
                            <th style="padding:12px 18px;text-align:left;font-weight:600;">Status</th>
                        </tr>
                    </thead>

                    <tbody>
                        @forelse($wargas as $index => $w)
                            <tr style="border-bottom:1px solid rgba(241,245,249,1);">
                                <td style="padding:10px 18px;">{{ $wargas->firstItem() + $index }}</td>
                                <td style="padding:10px 18px;font-weight:600;color:#0f172a;">{{ $w->nik }}</td>
                                <td style="padding:10px 18px;">{{ $w->nama }}</td>
                                <td style="padding:10px 18px;color:#6b7280;">
                                    {{ \Illuminate\Support\Str::limit($w->alamat, 30) }}
                                </td>
                                <td style="padding:10px 18px;">{{ $w->rt }} / {{ $w->rw }}</td>
                                <td style="padding:10px 18px;">{{ $w->no_hp }}</td>
                                <td style="padding:10px 18px;">
                                    @if($w->status_aktif)
                                        <span
                                            style="background:#dcfce7;color:#166534;padding:3px 9px;border-radius:999px;font-size:11px;font-weight:600;">Aktif</span>
                                    @else
                                        <span
                                            style="background:#e5e7eb;color:#4b5563;padding:3px 9px;border-radius:999px;font-size:11px;font-weight:600;">Tidak
                                            Aktif</span>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" style="padding:40px 18px;text-align:center;color:#6b7280;">
                                    <i data-lucide="users" style="width:32px;height:32px;color:#e2e8f0;"></i>
                                    <p style="margin:0;">Tidak ada data ditemukan.</p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        {{-- Pagination --}}
        @if ($wargas->hasPages())
            <div class="table-pagination">
                <div class="pagination-info">
                    Menampilkan
                    <strong>{{ $wargas->firstItem() }}</strong> –
                    <strong>{{ $wargas->lastItem() }}</strong>
                    dari
                    <strong>{{ $wargas->total() }}</strong>
                    warga
                </div>

                <div class="pagination-nav">
                    {{-- Tombol Sebelumnya --}}
                    @if ($wargas->onFirstPage())
                        <span class="page-btn disabled">Sebelumnya</span>
                    @else
                        <a href="{{ $wargas->previousPageUrl() }}" class="page-btn">Sebelumnya</a>
                    @endif

                    @php
                        $start = max($wargas->currentPage() - 2, 1);
                        $end = min($wargas->currentPage() + 2, $wargas->lastPage());
                    @endphp

                    @for ($page = $start; $page <= $end; $page++)
                        @if ($page == $wargas->currentPage())
                            <span class="page-number active">{{ $page }}</span>
                        @else
                            <a href="{{ $wargas->url($page) }}" class="page-number">{{ $page }}</a>
                        @endif
                    @endfor

                    {{-- Tombol Berikutnya --}}
                    @if ($wargas->hasMorePages())
                        <a href="{{ $wargas->nextPageUrl() }}" class="page-btn">Berikutnya</a>
                    @else
                        <span class="page-btn disabled">Berikutnya</span>
                    @endif
                </div>
            </div>
        @endif

    </div>
@endsection