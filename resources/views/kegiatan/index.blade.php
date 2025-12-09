@extends('layouts.app')

@section('title', 'Daftar Kegiatan')

@section('content')
    <div class="content">

        {{-- Header --}}
        <div style="display:flex;align-items:center;justify-content:space-between;gap:16px;margin-bottom:20px">
            <div>
                <h1 style="margin:0;font-size:22px;font-weight:700;color:#0f172a;">Daftar Kegiatan</h1>
                <p style="margin:6px 0 0 0;font-size:13px;color:rgba(15,23,42,0.6)">
                    Kelola kegiatan RT / RW
                </p>
            </div>

            <div style="display:flex;align-items:center;gap:12px">
                {{-- Search --}}
                <form method="GET" action="{{ route('kegiatan.index') }}" style="display:flex;align-items:center;gap:8px">
                    <div style="position:relative">
                        <input name="q" value="{{ request('q') }}" placeholder="Cari kegiatan..." style="padding:8px 12px 8px 32px;border-radius:10px;
                                                   border:1px solid rgba(148,163,184,0.7);font-size:13px;
                                                   min-width:220px;outline:none;transition:border-color .18s ease"
                            onfocus="this.style.borderColor='#10b981'"
                            onblur="this.style.borderColor='rgba(148,163,184,0.7)'">
                        <i data-lucide="search" style="width:16px;height:16px;color:#94a3b8;position:absolute;
                                                   left:10px;top:50%;transform:translateY(-50%)"></i>
                    </div>
                    <button type="submit" style="padding:8px 14px;border-radius:10px;background:#0f172a;
                                                   color:white;border:none;font-size:13px;font-weight:500;cursor:pointer;">
                        Cari
                    </button>
                </form>

                {{-- Button Tambah (Open Modal) --}}
                <button id="openCreateKegiatanModal" style="display:inline-flex;align-items:center;gap:6px;padding:8px 14px;border-radius:10px;
                                           background:linear-gradient(135deg,#10b981,#059669);color:white;font-size:13px;
                                           font-weight:500;text-decoration:none;cursor:pointer;
                                           box-shadow:0 10px 25px rgba(16,185,129,0.35);border:none;">
                    <i data-lucide="plus" style="width:16px;height:16px;"></i>
                    Tambah Kegiatan
                </button>
            </div>
        </div>

        {{-- Flash --}}
        @if(session('success'))
            <div style="margin-bottom:18px;padding:10px 14px;border-radius:12px;
                                                            background:#ecfdf5;border:1px solid #bbf7d0;color:#166534;
                                                            display:flex;align-items:center;gap:8px;font-size:13px;">
                <i data-lucide="check-circle" style="width:18px;height:18px;"></i>
                {{ session('success') }}
            </div>
        @endif

        {{-- Table Kegiatan --}}
        <div style="background:white;border-radius:12px;border:1px solid rgba(2,6,23,0.04);
                                    box-shadow:0 6px 20px rgba(2,6,23,0.03);overflow:hidden;">
            <div style="overflow-x:auto;">
                <table style="width:100%;font-size:13px;border-collapse:collapse;">
                    <thead style="background:#f8fafc;border-bottom:1px solid rgba(148,163,184,0.4);color:#475569;">
                        <tr>
                            <th style="padding:12px 18px;text-align:left;font-weight:600;">No</th>
                            <th style="padding:12px 18px;text-align:left;font-weight:600;">Nama</th>
                            <th style="padding:12px 18px;text-align:left;font-weight:600;">Jenis</th>
                            <th style="padding:12px 18px;text-align:left;font-weight:600;">Tanggal</th>
                            <th style="padding:12px 18px;text-align:left;font-weight:600;">Waktu</th>
                            <th style="padding:12px 18px;text-align:left;font-weight:600;">Lokasi</th>
                            <th style="padding:12px 18px;text-align:left;font-weight:600;">PJ</th>
                            <th style="padding:12px 18px;text-align:center;font-weight:600;">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>

                        @forelse($kegiatans as $index => $k)
                            <tr style="border-bottom:1px solid #f1f5f9;transition:.15s"
                                onmouseover="this.style.background='#f9fafb'" onmouseout="this.style.background='transparent'">

                                <td style="padding:10px 18px;color:#6b7280;">
                                    {{ $kegiatans->firstItem() + $index }}
                                </td>

                                <td style="padding:10px 18px;font-weight:600;color:#0f172a;">
                                    {{ $k->nama }}
                                </td>

                                <td style="padding:10px 18px;color:#475569;">{{ $k->jenis }}</td>
                                <td style="padding:10px 18px;color:#475569;">{{ $k->tanggal }}</td>
                                <td style="padding:10px 18px;color:#475569;">{{ $k->waktu ?? '-' }}</td>
                                <td style="padding:10px 18px;color:#475569;">{{ $k->lokasi ?? '-' }}</td>

                                <td style="padding:10px 18px;color:#475569;">
                                    {{ optional($k->penanggungJawab)->name ?? '-' }}
                                </td>

                                <td style="padding:10px 18px;text-align:center;">
                                    <form action="{{ route('kegiatan.destroy', $k->id) }}" method="POST"
                                        onsubmit="return confirm('Hapus kegiatan ini?')" style="display:inline;">
                                        @csrf
                                        @method('DELETE')
                                        <button
                                            style="padding:6px 10px;border-radius:8px;background:#fef2f2;border:none;
                                                                                       color:#b91c1c;font-size:12px;cursor:pointer;">
                                            <i data-lucide="trash-2" style="width:14px;height:14px;vertical-align:middle;"></i>
                                            Hapus
                                        </button>
                                    </form>
                                </td>

                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" style="padding:40px 18px;text-align:center;color:#6b7280;">
                                    <i data-lucide="calendar" style="width:32px;height:32px;color:#cbd5e1;"></i>
                                    <p>Belum ada kegiatan.</p>
                                </td>
                            </tr>
                        @endforelse

                    </tbody>
                </table>
            </div>
        </div>

        {{-- Pagination --}}
        {{-- Pagination Custom --}}
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

    {{-- ============================= --}}
    {{-- MODAL TAMBAH --}}
    {{-- ============================= --}}

    <div id="createModal" class="hidden" style="position:fixed;inset:0;z-index:999;
                       background:rgba(15,23,42,0.45);
                       backdrop-filter:blur(4px);
                       display:flex;align-items:center;justify-content:center;">

        <div style="background:#ffffff;border-radius:16px;
                            width:100%;max-width:620px;
                            max-height:90vh;overflow:auto;
                            padding:22px 24px;
                            position:relative;
                            box-shadow:0 24px 60px rgba(15,23,42,0.35);">

            {{-- Modal Header --}}
            <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:18px;">
                <div>
                    <h2 style="margin:0;font-size:18px;font-weight:700;color:#0f172a">Tambah Kegiatan</h2>
                    <p style="margin:4px 0 0 0;font-size:13px;color:rgba(15,23,42,0.6)">
                        Isi formulir berikut untuk menambahkan kegiatan baru.
                    </p>
                </div>

                <button id="closeCreateModal" style="width:34px;height:34px;border-radius:10px;border:none;
                                   background:#f1f5f9;cursor:pointer;display:flex;
                                   align-items:center;justify-content:center;">
                    <i data-lucide="x" style="width:18px;height:18px;color:#475569"></i>
                </button>
            </div>

            {{-- Form --}}
            <form action="{{ route('kegiatan.store') }}" method="POST">
                @csrf

                <div style="display:flex;flex-direction:column;gap:14px;">

                    {{-- Nama --}}
                    <div>
                        <label style="font-size:13px;font-weight:600;color:#0f172a;margin-bottom:4px;display:block">
                            Nama Kegiatan <span style="color:#ef4444">*</span>
                        </label>
                        <input name="nama" required style="width:100%;padding:8px 12px;border-radius:10px;
                                           border:1px solid #e2e8f0;font-size:13px;outline:none;">
                    </div>

                    {{-- Jenis --}}
                    <div>
                        <label style="font-size:13px;font-weight:600;color:#0f172a;margin-bottom:4px;display:block">
                            Jenis Kegiatan <span style="color:#ef4444">*</span>
                        </label>
                        <input name="jenis" required style="width:100%;padding:8px 12px;border-radius:10px;
                                           border:1px solid #e2e8f0;font-size:13px;outline:none;">
                    </div>

                    {{-- Tanggal --}}
                    <div>
                        <label style="font-size:13px;font-weight:600;color:#0f172a;margin-bottom:4px;display:block">
                            Tanggal <span style="color:#ef4444">*</span>
                        </label>
                        <input type="date" name="tanggal" required style="width:100%;padding:8px 12px;border-radius:10px;
                                           border:1px solid #e2e8f0;font-size:13px;outline:none;">
                    </div>

                    {{-- Waktu --}}
                    <div>
                        <label style="font-size:13px;font-weight:600;color:#0f172a;margin-bottom:4px;display:block">
                            Waktu Pelaksanaan
                        </label>
                        <input type="time" name="waktu" style="width:100%;padding:8px 12px;border-radius:10px;
                                           border:1px solid #e2e8f0;font-size:13px;outline:none;">
                    </div>

                    {{-- Lokasi --}}
                    <div>
                        <label style="font-size:13px;font-weight:600;color:#0f172a;margin-bottom:4px;display:block">
                            Lokasi
                        </label>
                        <input name="lokasi" style="width:100%;padding:8px 12px;border-radius:10px;
                                           border:1px solid #e2e8f0;font-size:13px;outline:none;"
                            placeholder="Misal: Balai RT">
                    </div>

                    {{-- Penanggung Jawab --}}
                    <div>
                        <label style="font-size:13px;font-weight:600;color:#0f172a;margin-bottom:4px;display:block">
                            Penanggung Jawab
                        </label>
                        <select name="penanggung_jawab_user_id" style="width:100%;padding:8px 12px;border-radius:10px;
                                           border:1px solid #e2e8f0;font-size:13px;outline:none;">
                            <option value="">— Pilih User —</option>
                            @foreach($users as $u)
                                <option value="{{ $u->id }}">{{ $u->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    {{-- Keterangan --}}
                    <div>
                        <label style="font-size:13px;font-weight:600;color:#0f172a;margin-bottom:4px;display:block">
                            Keterangan
                        </label>
                        <textarea name="keterangan" rows="3" style="width:100%;padding:8px 12px;border-radius:10px;
                                           border:1px solid #e2e8f0;font-size:13px;outline:none;resize:vertical;"
                            placeholder="Catatan tambahan..."></textarea>
                    </div>

                </div>

                {{-- Footer --}}
                <div style="display:flex;justify-content:flex-end;gap:10px;
                                    margin-top:20px;padding-top:14px;border-top:1px solid #e5e7eb;">
                    <button type="button" id="closeCreateModal2" style="padding:8px 14px;border-radius:10px;border:1px solid #e2e8f0;
                                       background:white;color:#475569;font-size:13px;cursor:pointer;">
                        Batal
                    </button>

                    <button type="submit" style="padding:9px 18px;border-radius:10px;background:#0f172a;
                                       color:white;border:none;font-size:13px;font-weight:600;cursor:pointer;
                                       box-shadow:0 8px 20px rgba(15,23,42,0.35);">
                        Simpan Kegiatan
                    </button>
                </div>

            </form>

        </div>
    </div>


    {{-- SCRIPT --}}
    <script>
        const modal = document.getElementById('createModal');
        document.getElementById('openCreateKegiatanModal').onclick = () => modal.classList.remove('hidden');
        document.getElementById('closeCreateModal').onclick = () => modal.classList.add('hidden');
        document.getElementById('closeCreateModal2').onclick = () => modal.classList.add('hidden');

        // Close modal when clicking outside
        modal.addEventListener('click', (e) => {
            if (e.target === modal) modal.classList.add('hidden');
        });
    </script>

@endsection