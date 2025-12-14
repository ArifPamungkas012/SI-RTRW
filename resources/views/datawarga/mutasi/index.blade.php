{{-- resources/views/datawarga/mutasi/index.blade.php --}}
@extends('layouts.app')

@section('title', 'Mutasi Warga')

@section('content')
    <div class="content">

        {{-- ================= HEADER ================= --}}
        <div style="display:flex;align-items:center;justify-content:space-between;gap:16px;margin-bottom:20px">
        



                {{-- FILTER --}}
                <form method="GET" action="{{ route('datawarga.mutasi.index') }}"
                    style="display:flex;align-items:center;gap:8px">

                    <div style="position:relative">
                        <input name="search" value="{{ $filterSearch }}" placeholder="Cari nama / NIK / No Rumah..." style="padding:8px 12px 8px 32px;border-radius:10px;border:1px solid rgba(148,163,184,0.7);
                                      font-size:13px;min-width:220px;outline:none;" />
                        <i data-lucide="search" style="width:16px;height:16px;color:#94a3b8;position:absolute;left:10px;top:50%;
                                  transform:translateY(-50%);"></i>
                    </div>

                    <select name="jenis" style="padding:8px 10px;border-radius:10px;border:1px solid rgba(148,163,184,0.7);
                                   font-size:13px;outline:none;min-width:140px;">
                        <option value="">Semua Jenis</option>
                        <option value="masuk" {{ $filterJenis === 'masuk' ? 'selected' : '' }}>Masuk</option>
                        <option value="keluar" {{ $filterJenis === 'keluar' ? 'selected' : '' }}>Keluar</option>
                        <option value="pindah_rt" {{ $filterJenis === 'pindah_rt' ? 'selected' : '' }}>Pindah RT</option>
                        <option value="pindah_rw" {{ $filterJenis === 'pindah_rw' ? 'selected' : '' }}>Pindah RW</option>
                    </select>

                    <button type="submit" style="padding:8px 14px;border-radius:10px;border:none;background:#0f172a;color:white;
                                   font-size:13px;font-weight:500;cursor:pointer;">
                        Filter
                    </button>

                    @if ($filterSearch || $filterJenis)
                        <a href="{{ route('datawarga.mutasi.index') }}"
                            style="font-size:12px;color:#64748b;text-decoration:none;">
                            Reset
                        </a>
                    @endif
                </form>

                {{-- TOMBOL TAMBAH --}}
                <button type="button" id="openCreateMutasiModal" style="padding:8px 14px;border-radius:10px;
                               background:linear-gradient(135deg,#10b981,#059669);
                               color:white;font-size:13px;border:none;cursor:pointer;">
                    + Tambah Mutasi
                </button>

        </div>

        {{-- ================= TABLE ================= --}}
        <div style="background:#fff;border-radius:12px;border:1px solid #e5e7eb;overflow:hidden;">
            <table style="width:100%;border-collapse:collapse;font-size:13px;">
                <thead style="background:#f8fafc;border-bottom:1px solid #e5e7eb;">
                    <tr>
                        <th style="padding:12px 18px;">No</th>
                        <th style="padding:12px 18px;">Tanggal</th>
                        <th style="padding:12px 18px;">Warga</th>
                        <th style="padding:12px 18px;">Jenis</th>
                        <th style="padding:12px 18px;">Keterangan</th>
                        <th style="padding:12px 18px;text-align:center;">Aksi</th>
                    </tr>
                </thead>
                <tbody>

                    @forelse($mutasi as $index => $row)
                        <tr style="border-bottom:1px solid #f1f5f9;">
                            <td style="padding:10px 18px;">{{ $mutasi->firstItem() + $index }}</td>
                            <td style="padding:10px 18px;">{{ $row->tanggal?->format('d-m-Y') }}</td>
                            <td style="padding:10px 18px;">
                                <strong>{{ $row->warga->nama ?? '-' }}</strong><br>
                                <small>NIK: {{ $row->warga->nik ?? '-' }}</small>
                            </td>
                            <td style="padding:10px 18px;">{{ strtoupper($row->jenis) }}</td>
                            <td style="padding:10px 18px;">{{ $row->keterangan ?? '-' }}</td>
                            <td style="padding:10px 18px;text-align:center;">
                                <form method="POST" action="{{ route('datawarga.mutasi.destroy', $row->id) }}"
                                    onsubmit="return confirm('Hapus data ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" style="padding:6px 10px;border-radius:8px;background:#fee2e2;
                                                   border:none;color:#b91c1c;">
                                        Hapus
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" style="text-align:center;padding:30px;color:#9ca3af;">
                                Belum ada data mutasi
                            </td>
                        </tr>
                    @endforelse

                </tbody>
            </table>
        </div>

        {{-- ================= CUSTOM PAGINATION ================= --}}
        @if ($mutasi->hasPages())
            <div class="table-pagination">
                <div class="pagination-info">
                    Menampilkan
                    <strong>{{ $mutasi->firstItem() }}</strong>
                    –
                    <strong>{{ $mutasi->lastItem() }}</strong>
                    dari
                    <strong>{{ $mutasi->total() }}</strong>
                    data
                </div>

                <div class="pagination-nav">
                    {{-- Tombol Sebelumnya --}}
                    @if ($mutasi->onFirstPage())
                        <span class="page-btn disabled">Sebelumnya</span>
                    @else
                        <a href="{{ $mutasi->previousPageUrl() }}" class="page-btn">Sebelumnya</a>
                    @endif

                    {{-- Nomor halaman --}}
                    @php
                        $start = max($mutasi->currentPage() - 2, 1);
                        $end = min($mutasi->currentPage() + 2, $mutasi->lastPage());
                    @endphp

                    @for ($page = $start; $page <= $end; $page++)
                        @if ($page == $mutasi->currentPage())
                            <span class="page-number active">{{ $page }}</span>
                        @else
                            <a href="{{ $mutasi->url($page) }}" class="page-number">{{ $page }}</a>
                        @endif
                    @endfor

                    {{-- Tombol Berikutnya --}}
                    @if ($mutasi->hasMorePages())
                        <a href="{{ $mutasi->nextPageUrl() }}" class="page-btn">Berikutnya</a>
                    @else
                        <span class="page-btn disabled">Berikutnya</span>
                    @endif
                </div>
            </div>
        @endif

    </div>
@endsection