{{-- resources/views/keuangan/pengeluaran/index.blade.php --}}
@extends('layouts.app')

@section('title', 'Pengeluaran RT/RW')

@section('content')
    <div class="content">
        {{-- Header --}}
        <div style="display:flex;align-items:center;justify-content:space-between;gap:16px;margin-bottom:20px">
            <div>
                <h1 style="margin:0;font-size:22px;font-weight:700;color:#0f172a;">Pengeluaran RT/RW</h1>
                <p style="margin:6px 0 0 0;font-size:13px;color:rgba(15,23,42,0.6)">
                    Catatan kas keluar untuk keperluan operasional, kegiatan, dan kebutuhan RT/RW lainnya.
                </p>
            </div>

            <div style="display:flex;align-items:center;gap:12px">
                {{-- Filter form --}}
                <form method="GET" action="{{ route('keuangan.pengeluaran.index') }}"
                    style="display:flex;align-items:center;gap:8px">
                    <div style="position:relative">
                        <input name="search" value="{{ $filterSearch }}" placeholder="Cari kategori / keterangan..."
                            style="padding:8px 12px 8px 32px;border-radius:10px;border:1px solid rgba(148,163,184,0.7);
                                              font-size:13px;min-width:220px;outline:none;transition:border-color .18s ease" onfocus="this.style.borderColor='#10b981'"
                            onblur="this.style.borderColor='rgba(148,163,184,0.7)'" />
                        <i data-lucide="search" style="width:16px;height:16px;color:#94a3b8;position:absolute;left:10px;top:50%;
                                          transform:translateY(-50%);"></i>
                    </div>

                    <div>
                        <input type="date" name="tanggal_from" value="{{ $filterFrom }}" style="padding:8px 10px;border-radius:10px;border:1px solid rgba(148,163,184,0.7);
                                              font-size:13px;outline:none;min-width:140px;">
                    </div>
                    <div>
                        <input type="date" name="tanggal_to" value="{{ $filterTo }}" style="padding:8px 10px;border-radius:10px;border:1px solid rgba(148,163,184,0.7);
                                              font-size:13px;outline:none;min-width:140px;">
                    </div>

                    <button type="submit" style="display:inline-flex;align-items:center;gap:6px;padding:8px 14px;border-radius:10px;
                                           border:none;background:#0f172a;color:white;font-size:13px;font-weight:500;
                                           cursor:pointer;box-shadow:0 6px 16px rgba(15,23,42,0.18);
                                           transition:background .18s,transform .12s">
                        <span>Filter</span>
                    </button>

                    @if($filterSearch || $filterFrom || $filterTo)
                        <a href="{{ route('keuangan.pengeluaran.index') }}"
                            style="font-size:12px;color:#64748b;text-decoration:none;">
                            Reset
                        </a>
                    @endif
                </form>

                {{-- Tombol buka modal Tambah Pengeluaran --}}
                <button type="button" id="openCreatePengeluaranModal" style="display:inline-flex;align-items:center;gap:6px;padding:8px 14px;border-radius:10px;
                                       background:linear-gradient(135deg,#ef4444,#b91c1c);color:white;font-size:13px;
                                       font-weight:500;text-decoration:none;box-shadow:0 10px 25px rgba(248,113,113,0.35);
                                       border:none;cursor:pointer;transition:transform .12s,box-shadow .18s;">
                    <i data-lucide="minus-circle" style="width:16px;height:16px;"></i>
                    <span>Tambah Pengeluaran</span>
                </button>
            </div>
        </div>

        {{-- Flash messages --}}
        @if(session('success'))
            <div style="margin-bottom:18px;padding:10px 14px;border-radius:12px;
                                        background:#ecfdf5;border:1px solid #bbf7d0;
                                        color:#166534;display:flex;align-items:center;gap:8px;font-size:13px;">
                <i data-lucide="check-circle" style="width:18px;height:18px;color:#16a34a;"></i>
                <span>{{ session('success') }}</span>
            </div>
        @endif

        @if(session('error'))
            <div style="margin-bottom:14px;padding:10px 14px;border-radius:12px;
                                        background:#fef2f2;border:1px solid #fecaca;color:#b91c1c;
                                        display:flex;align-items:center;gap:8px;font-size:13px;">
                <i data-lucide="alert-circle" style="width:18px;height:18px;color:#ef4444;"></i>
                <span>{{ session('error') }}</span>
            </div>
        @endif

        @if($errors->any())
            <div style="margin-bottom:14px;padding:10px 14px;border-radius:12px;
                                        background:#fef2f2;border:1px solid #fecaca;color:#b91c1c;
                                        display:flex;align-items:center;gap:8px;font-size:13px;">
                <i data-lucide="alert-circle" style="width:18px;height:18px;color:#ef4444;"></i>
                <span>Terjadi kesalahan pada input, periksa kembali formulir.</span>
            </div>
        @endif

        {{-- Card daftar Pengeluaran --}}
        <div style="background:#fff;border-radius:12px;padding:0;border:1px solid rgba(2,6,23,0.04);
                            box-shadow:0 6px 20px rgba(2,6,23,0.03);overflow:hidden;">
            <div style="overflow:auto;">
                <table style="width:100%;border-collapse:collapse;font-size:13px;">
                    <thead style="background:#f8fafc;border-bottom:1px solid rgba(148,163,184,0.4);color:#475569;">
                        <tr>
                            <th style="padding:12px 18px;text-align:left;font-weight:600;">No</th>
                            <th style="padding:12px 18px;text-align:left;font-weight:600;">Tanggal</th>
                            <th style="padding:12px 18px;text-align:left;font-weight:600;">Kategori</th>
                            <th style="padding:12px 18px;text-align:left;font-weight:600;">Keterangan</th>
                            <th style="padding:12px 18px;text-align:right;font-weight:600;">Nominal</th>
                            <th style="padding:12px 18px;text-align:left;font-weight:600;">Dicatat Oleh</th>
                            <th style="padding:12px 18px;text-align:center;font-weight:600;">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($pengeluaran as $index => $row)
                            <tr style="border-bottom:1px solid rgba(241,245,249,1);transition:background .15s;"
                                onmouseover="this.style.background='#f9fafb'" onmouseout="this.style.background='transparent'">
                                <td style="padding:10px 18px;white-space:nowrap;color:#6b7280;">
                                    {{ $pengeluaran->firstItem() + $index }}
                                </td>
                                <td style="padding:10px 18px;white-space:nowrap;color:#0f172a;">
                                    {{ \Carbon\Carbon::parse($row->tanggal)->format('d-m-Y') }}
                                </td>
                                <td style="padding:10px 18px;white-space:nowrap;color:#0f172a;font-weight:600;">
                                    {{ $row->kategori ?: '-' }}
                                </td>
                                <td style="padding:10px 18px;color:#6b7280;">
                                    {{ \Illuminate\Support\Str::limit($row->keterangan, 60) ?: '-' }}
                                </td>
                                <td
                                    style="padding:10px 18px;white-space:nowrap;text-align:right;color:#b91c1c;font-weight:600;">
                                    {{ $row->nominal_formatted ?? ('Rp ' . number_format($row->nominal, 0, ',', '.')) }}
                                </td>
                                <td style="padding:10px 18px;white-space:nowrap;color:#6b7280;">
                                    {{ optional($row->pencatat)->name ?? '-' }}
                                </td>
                                <td style="padding:10px 18px;white-space:nowrap;">
                                    <div style="display:flex;align-items:center;justify-content:center;gap:6px;">
                                        <form action="{{ route('keuangan.pengeluaran.destroy', $row->id) }}" method="POST"
                                            onsubmit="return confirm('Hapus pengeluaran ini?')" style="display:inline;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" title="Hapus" style="padding:6px 9px;border-radius:10px;border:none;
                                                                           background:#fef2f2;color:#b91c1c;font-size:12px;
                                                                           font-weight:500;cursor:pointer;display:inline-flex;
                                                                           align-items:center;justify-content:center;">
                                                <i data-lucide="trash-2" style="width:14px;height:14px;margin-right:4px;"></i>
                                                Hapus
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" style="padding:40px 18px;text-align:center;color:#6b7280;">
                                    <div style="display:flex;flex-direction:column;align-items:center;gap:8px;">
                                        <i data-lucide="wallet" style="width:32px;height:32px;color:#e2e8f0;"></i>
                                        <p style="margin:0;">Belum ada data pengeluaran.</p>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        {{-- Footer + pagination --}}
        <div style="margin-top:18px;display:flex;align-items:center;justify-content:space-between;gap:12px;flex-wrap:wrap;">
            <div style="font-size:12px;color:#6b7280;">
                Menampilkan {{ $pengeluaran->firstItem() ?? 0 }} - {{ $pengeluaran->lastItem() ?? 0 }}
                dari {{ $pengeluaran->total() ?? 0 }} data
            </div>
            <div>
                {{ $pengeluaran->withQueryString()->links() }}
            </div>
        </div>
    </div>

    {{-- MODAL TAMBAH PENGELUARAN --}}
    <div id="createPengeluaranModal" class="hidden" style="position:fixed;inset:0;z-index:50;display:flex;align-items:center;justify-content:center;
                        background:rgba(15,23,42,0.35);backdrop-filter:blur(3px);">
        <div
            style="background:#ffffff;border-radius:16px;box-shadow:0 24px 60px rgba(15,23,42,0.35);
                                width:100%;max-width:640px;max-height:90vh;overflow:auto;padding:20px 22px;position:relative;">

            {{-- Header modal --}}
            <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:16px;">
                <div>
                    <h2 style="margin:0;font-size:18px;font-weight:700;color:#0f172a;">Tambah Pengeluaran</h2>
                    <p style="margin:4px 0 0 0;font-size:13px;color:rgba(15,23,42,0.6);">
                        Isi formulir berikut untuk mencatat pengeluaran kas RT/RW.
                    </p>
                </div>
                <button type="button" data-close-pengeluaran-modal style="width:32px;height:32px;border-radius:999px;border:none;background:#f1f5f9;
                                       display:inline-flex;align-items:center;justify-content:center;cursor:pointer;">
                    <i data-lucide="x" style="width:18px;height:18px;color:#64748b;"></i>
                </button>
            </div>

            {{-- Form --}}
            <form action="{{ route('keuangan.pengeluaran.store') }}" method="POST">
                @csrf

                <div style="display:flex;flex-direction:column;gap:14px;">
                    {{-- Tanggal --}}
                    <div>
                        <label style="display:block;font-size:13px;font-weight:600;color:#0f172a;margin-bottom:4px;">
                            Tanggal <span style="color:#ef4444;">*</span>
                        </label>
                        <input type="date" name="tanggal" required value="{{ old('tanggal', now()->toDateString()) }}"
                            style="width:100%;border-radius:10px;border:1px solid #e2e8f0;padding:8px 10px;
                                              font-size:13px;outline:none;">
                        @error('tanggal')
                            <p style="color:#b91c1c;font-size:11px;margin-top:4px;">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Kategori --}}
                    <div>
                        <label style="display:block;font-size:13px;font-weight:600;color:#0f172a;margin-bottom:4px;">
                            Kategori
                        </label>
                        <input name="kategori" value="{{ old('kategori') }}"
                            placeholder="Misal: Operasional, Kegiatan, Perbaikan, dll" style="width:100%;border-radius:10px;border:1px solid #e2e8f0;padding:8px 10px;
                                              font-size:13px;outline:none;">
                        @error('kategori')
                            <p style="color:#b91c1c;font-size:11px;margin-top:4px;">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Nominal --}}
                    <div>
                        <label style="display:block;font-size:13px;font-weight:600;color:#0f172a;margin-bottom:4px;">
                            Nominal <span style="color:#ef4444;">*</span>
                        </label>
                        <input type="number" name="nominal" value="{{ old('nominal') }}" min="0" step="1000" required
                            placeholder="Contoh: 150000" style="width:100%;border-radius:10px;border:1px solid #e2e8f0;padding:8px 10px;
                                              font-size:13px;outline:none;">
                        @error('nominal')
                            <p style="color:#b91c1c;font-size:11px;margin-top:4px;">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Keterangan --}}
                    <div>
                        <label style="display:block;font-size:13px;font-weight:600;color:#0f172a;margin-bottom:4px;">
                            Keterangan
                        </label>
                        <textarea name="keterangan" rows="3"
                            placeholder="Contoh: Pembelian cat untuk pos ronda, konsumsi rapat, dll"
                            style="width:100%;border-radius:10px;border:1px solid #e2e8f0;padding:8px 10px;
                                                 font-size:13px;outline:none;resize:vertical;">{{ old('keterangan') }}</textarea>
                        @error('keterangan')
                            <p style="color:#b91c1c;font-size:11px;margin-top:4px;">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                {{-- Footer --}}
                <div style="margin-top:18px;padding-top:14px;border-top:1px solid #e5e7eb;
                                    display:flex;justify-content:flex-end;gap:8px;">
                    <button type="button" data-close-pengeluaran-modal style="padding:8px 14px;border-radius:10px;border:1px solid #e5e7eb;
                                           background:white;color:#475569;font-size:13px;font-weight:500;
                                           cursor:pointer;">
                        Batal
                    </button>
                    <button type="submit" style="display:inline-flex;align-items:center;gap:6px;padding:8px 16px;border-radius:10px;
                                           border:none;background:#b91c1c;color:white;font-size:13px;font-weight:600;
                                           cursor:pointer;box-shadow:0 8px 20px rgba(248,113,113,0.35);">
                        <i data-lucide="save" style="width:16px;height:16px;"></i>
                        <span>Simpan Pengeluaran</span>
                    </button>
                </div>
            </form>
        </div>
    </div>

    {{-- Script modal Pengeluaran --}}
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            var openBtn = document.getElementById('openCreatePengeluaranModal');
            var modal = document.getElementById('createPengeluaranModal');
            var closers = document.querySelectorAll('[data-close-pengeluaran-modal]');

            if (openBtn && modal) {
                openBtn.addEventListener('click', function () {
                    modal.classList.remove('hidden');
                });
            }

            closers.forEach(function (btn) {
                btn.addEventListener('click', function () {
                    modal.classList.add('hidden');
                });
            });

            if (modal) {
                modal.addEventListener('click', function (e) {
                    if (e.target === modal) {
                        modal.classList.add('hidden');
                    }
                });
            }

            // Kalau ada error validasi, buka modal otomatis
            @if ($errors->any())
                if (modal) {
                    modal.classList.remove('hidden');
                }
            @endif
                });
    </script>
@endsection