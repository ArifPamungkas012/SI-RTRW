{{-- resources/views/kegiatan/riwayat/index.blade.php --}}
@extends('layouts.app')

@section('title', 'Riwayat Kegiatan')

@section('content')
    <div class="content">
        {{-- HEADER --}}
        <div style="display:flex;align-items:center;justify-content:space-between;gap:16px;margin-bottom:20px">
            <div>
                <h1 style="margin:0;font-size:22px;font-weight:700;color:#0f172a;">
                    Riwayat Kegiatan
                </h1>
                <p style="margin:6px 0 0 0;font-size:13px;color:rgba(15,23,42,0.6)">
                    Daftar kegiatan yang sudah berlangsung, akan datang, dan yang telah dihapus.
                </p>
            </div>

            <div style="display:flex;align-items:center;gap:12px">
                {{-- FILTER & SEARCH --}}
                <form method="GET" action="{{ route('kegiatan.riwayat.index') }}"
                    style="display:flex;align-items:center;gap:8px">
                    <div style="position:relative">
                        <input name="q" value="{{ $filterSearch }}" placeholder="Cari nama / jenis / lokasi..." style="padding:8px 12px 8px 32px;border-radius:10px;
                                          border:1px solid rgba(148,163,184,0.7);font-size:13px;min-width:220px;
                                          outline:none;transition:.18s;" onfocus="this.style.borderColor='#10b981'"
                            onblur="this.style.borderColor='rgba(148,163,184,0.7)'">
                        <i data-lucide="search" style="width:16px;height:16px;color:#94a3b8;position:absolute;
                                      left:10px;top:50%;transform:translateY(-50%)"></i>
                    </div>

                    <div>
                        <select name="status" style="padding:8px 10px;border-radius:10px;border:1px solid rgba(148,163,184,0.7);
                                           font-size:13px;outline:none;min-width:150px;">
                            <option value="">Semua Status</option>
                            <option value="upcoming" {{ $filterStatus === 'upcoming' ? 'selected' : '' }}>Akan Datang</option>
                            <option value="past" {{ $filterStatus === 'past' ? 'selected' : '' }}>Sudah Berlalu</option>
                            <option value="deleted" {{ $filterStatus === 'deleted' ? 'selected' : '' }}>Dihapus</option>
                        </select>
                    </div>

                    <button type="submit" style="padding:8px 14px;border-radius:10px;background:#0f172a;color:white;
                                       border:none;font-size:13px;font-weight:500;cursor:pointer;">
                        Filter
                    </button>

                    @if($filterStatus || $filterSearch)
                        <a href="{{ route('kegiatan.riwayat.index') }}"
                            style="font-size:12px;color:#64748b;text-decoration:none;">
                            Reset
                        </a>
                    @endif
                </form>
            </div>
        </div>

        {{-- FLASH --}}
        @if(session('success'))
            <div style="margin-bottom:18px;padding:10px 14px;border-radius:12px;
                                background:#ecfdf5;border:1px solid #bbf7d0;color:#166534;
                                display:flex;align-items:center;gap:8px;font-size:13px;">
                <i data-lucide="check-circle" style="width:18px;height:18px;"></i>
                {{ session('success') }}
            </div>
        @endif

        {{-- CARD TABLE --}}
        <div style="background:white;border-radius:12px;border:1px solid rgba(2,6,23,0.04);
                        box-shadow:0 6px 20px rgba(2,6,23,0.03);overflow:hidden;">
            <div style="overflow:auto;">
                <table style="width:100%;font-size:13px;border-collapse:collapse;">
                    <thead style="background:#f8fafc;border-bottom:1px solid rgba(148,163,184,0.4);color:#475569;">
                        <tr>
                            <th style="padding:12px 18px;text-align:left;">Tanggal</th>
                            <th style="padding:12px 18px;text-align:left;">Nama Kegiatan</th>
                            <th style="padding:12px 18px;text-align:left;">Jenis</th>
                            <th style="padding:12px 18px;text-align:left;">Lokasi</th>
                            <th style="padding:12px 18px;text-align:left;">Penanggung Jawab</th>
                            <th style="padding:12px 18px;text-align:left;">Status</th>
                            <th style="padding:12px 18px;text-align:center;">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($kegiatans as $k)
                            @php
                                $isDeleted = !is_null($k->deleted_at);
                                $isPast = !$isDeleted && $k->tanggal && $k->tanggal < $today;
                                $isUpcoming = !$isDeleted && $k->tanggal && $k->tanggal >= $today;

                                if ($isDeleted) {
                                    $statusLabel = 'Dihapus';
                                    $statusStyle = 'background:#fef2f2;color:#b91c1c;border:1px solid #fecaca;';
                                } elseif ($isUpcoming) {
                                    $statusLabel = 'Akan Datang';
                                    $statusStyle = 'background:#eff6ff;color:#1d4ed8;border:1px solid #bfdbfe;';
                                } else {
                                    $statusLabel = 'Selesai';
                                    $statusStyle = 'background:#ecfdf5;color:#166534;border:1px solid #bbf7d0;';
                                }
                            @endphp
                            <tr style="border-bottom:1px solid #f1f5f9;transition:.15s"
                                onmouseover="this.style.background='#f9fafb'" onmouseout="this.style.background='transparent'">

                                <td style="padding:10px 18px;white-space:nowrap;color:#0f172a;">
                                    {{ $k->tanggal ? \Carbon\Carbon::parse($k->tanggal)->format('d M Y') : '-' }}
                                    @if($k->waktu)
                                        <div style="font-size:11px;color:#6b7280;">
                                            Jam {{ $k->waktu }}
                                        </div>
                                    @endif
                                </td>

                                <td style="padding:10px 18px;color:#0f172a;">
                                    <div style="font-weight:600;">{{ $k->nama }}</div>
                                    @if($k->keterangan)
                                        <div style="font-size:11px;color:#6b7280;margin-top:2px;">
                                            {{ \Illuminate\Support\Str::limit($k->keterangan, 60) }}
                                        </div>
                                    @endif
                                </td>

                                <td style="padding:10px 18px;color:#6b7280;">
                                    {{ $k->jenis ?? '-' }}
                                </td>

                                <td style="padding:10px 18px;color:#6b7280;">
                                    {{ $k->lokasi ?? '-' }}
                                </td>

                                <td style="padding:10px 18px;color:#6b7280;">
                                    {{ optional($k->penanggungJawab)->name ?? '-' }}
                                </td>

                                <td style="padding:10px 18px;">
                                    <span style="display:inline-flex;align-items:center;gap:6px;
                                                         padding:4px 10px;border-radius:999px;font-size:11px;
                                                         font-weight:600;{{ $statusStyle }}">
                                        {{ $statusLabel }}
                                    </span>
                                </td>

                                <td style="padding:10px 18px;text-align:center;white-space:nowrap;">
                                    <div style="display:flex;align-items:center;justify-content:center;gap:6px;">
                                        @if($isDeleted)
                                            {{-- Pulihkan --}}
                                            <form action="{{ route('kegiatan.restore', $k->id) }}" method="POST"
                                                onsubmit="return confirm('Pulihkan kegiatan ini?');" style="display:inline;">
                                                @csrf
                                                <button type="submit" style="padding:6px 10px;border-radius:8px;background:#ecfdf5;border:none;
                                                                           color:#166534;font-size:12px;cursor:pointer;">
                                                    <i data-lucide="rotate-ccw"
                                                        style="width:14px;height:14px;margin-right:4px;"></i>
                                                    Pulihkan
                                                </button>
                                            </form>
                                        @else
                                            {{-- Hapus dari sini juga boleh, panggil destroy di KegiatanController --}}
                                            <form action="{{ route('kegiatan.destroy', $k->id) }}" method="POST"
                                                onsubmit="return confirm('Tandai kegiatan ini sebagai dihapus?');"
                                                style="display:inline;">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" style="padding:6px 10px;border-radius:8px;background:#fef2f2;border:none;
                                                                           color:#b91c1c;font-size:12px;cursor:pointer;">
                                                    <i data-lucide="trash-2" style="width:14px;height:14px;margin-right:4px;"></i>
                                                    Hapus
                                                </button>
                                            </form>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" style="padding:40px;text-align:center;color:#6b7280;">
                                    <i data-lucide="calendar-off" style="width:32px;height:32px;color:#cbd5e1;"></i>
                                    <p style="margin-top:8px;">Belum ada data riwayat kegiatan.</p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        {{-- PAGINATION --}}
        {{-- PAGINATION (FORMAT TERSIMPAN) --}}
@if ($kegiatans->hasPages())
    <div style="margin-top:18px;display:flex;align-items:center;justify-content:space-between;
                flex-wrap:wrap;gap:12px;font-size:13px;">

        {{-- Info --}}
        <div style="color:#475569;">
            Menampilkan
            <strong>{{ $kegiatans->firstItem() }}</strong>
            –
            <strong>{{ $kegiatans->lastItem() }}</strong>
            dari
            <strong>{{ $kegiatans->total() }}</strong>
            kegiatan
        </div>

        {{-- Navigation --}}
        <div style="display:flex;align-items:center;gap:6px;">

            {{-- Tombol Sebelumnya --}}
            @if ($kegiatans->onFirstPage())
                <span style="padding:6px 10px;border-radius:8px;background:#f1f5f9;
                             color:#94a3b8;cursor:not-allowed;">
                    Sebelumnya
                </span>
            @else
                <a href="{{ $kegiatans->previousPageUrl() }}"
                    style="padding:6px 10px;border-radius:8px;background:#0f172a;color:white;
                           text-decoration:none;">
                    Sebelumnya
                </a>
            @endif

            {{-- Nomor halaman dinamis --}}
            @php
                $start = max($kegiatans->currentPage() - 2, 1);
                $end = min($kegiatans->currentPage() + 2, $kegiatans->lastPage());
            @endphp

            @for ($page = $start; $page <= $end; $page++)
                @if ($page == $kegiatans->currentPage())
                    <span style="padding:6px 10px;border-radius:8px;
                                 background:#0f172a;color:white;font-weight:600;">
                        {{ $page }}
                    </span>
                @else
                    <a href="{{ $kegiatans->url($page) }}"
                        style="padding:6px 10px;border-radius:8px;background:#f8fafc;
                               border:1px solid #e2e8f0;color:#475569;text-decoration:none;">
                        {{ $page }}
                    </a>
                @endif
            @endfor

            {{-- Tombol Berikutnya --}}
            @if ($kegiatans->hasMorePages())
                <a href="{{ $kegiatans->nextPageUrl() }}"
                    style="padding:6px 10px;border-radius:8px;background:#0f172a;color:white;
                           text-decoration:none;">
                    Berikutnya
                </a>
            @else
                <span style="padding:6px 10px;border-radius:8px;background:#f1f5f9;
                             color:#94a3b8;cursor:not-allowed;">
                    Berikutnya
                </span>
            @endif

        </div>
    </div>
@endif

    </div>
@endsection