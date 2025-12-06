{{-- resources/views/datawarga/mutasi/index.blade.php --}}
@extends('layouts.app')

@section('title', 'Mutasi Warga')

@section('content')
    <div class="content">
            {{-- Header --}}
            <div style="display:flex;align-items:center;justify-content:space-between;gap:16px;margin-bottom:20px">
                <div>
                    <h1 style="margin:0;font-size:22px;font-weight:700;color:#0f172a;">Mutasi Warga</h1>
                    <p style="margin:6px 0 0 0;font-size:13px;color:rgba(15,23,42,0.6)">
                        Catatan perpindahan / perubahan status warga (masuk, keluar, pindah RT/RW).
                    </p>
                </div>

                <div style="display:flex;align-items:center;gap:12px">
                    {{-- Filter form: search + jenis --}}
                    <form method="GET" action="{{ route('datawarga.mutasi.index') }}"
                        style="display:flex;align-items:center;gap:8px">
                        <div style="position:relative">
                            <input name="search" value="{{ $filterSearch }}" placeholder="Cari nama / NIK / No Rumah..."
                                   style="padding:8px 12px 8px 32px;border-radius:10px;border:1px solid rgba(148,163,184,0.7);
                                          font-size:13px;min-width:220px;outline:none;transition:border-color .18s ease"
                                   onfocus="this.style.borderColor='#10b981'"
                                   onblur="this.style.borderColor='rgba(148,163,184,0.7)'" />
                            <i data-lucide="search" style="width:16px;height:16px;color:#94a3b8;position:absolute;left:10px;top:50%;
                                          transform:translateY(-50%);"></i>
                        </div>

                        <div>
                            <select name="jenis" style="padding:8px 10px;border-radius:10px;border:1px solid rgba(148,163,184,0.7);
                                            font-size:13px;outline:none;min-width:140px;">
                                <option value="">Semua Jenis</option>
                                <option value="masuk" {{ $filterJenis === 'masuk' ? 'selected' : '' }}>Masuk</option>
                                <option value="keluar" {{ $filterJenis === 'keluar' ? 'selected' : '' }}>Keluar</option>
                                <option value="pindah_rt" {{ $filterJenis === 'pindah_rt' ? 'selected' : '' }}>Pindah RT</option>
                                <option value="pindah_rw" {{ $filterJenis === 'pindah_rw' ? 'selected' : '' }}>Pindah RW</option>
                            </select>
                        </div>

                        <button type="submit" style="display:inline-flex;align-items:center;gap:6px;padding:8px 14px;border-radius:10px;
                                           border:none;background:#0f172a;color:white;font-size:13px;font-weight:500;
                                           cursor:pointer;box-shadow:0 6px 16px rgba(15,23,42,0.18);
                                           transition:background .18s,transform .12s">
                            <span>Filter</span>
                        </button>

                        @if ($filterSearch || $filterJenis)
                            <a href="{{ route('datawarga.mutasi.index') }}"
                               style="font-size:12px;color:#64748b;text-decoration:none;">
                                Reset
                            </a>
                        @endif
                    </form>

                    {{-- Tombol buka modal Tambah Mutasi --}}
                    <button type="button" id="openCreateMutasiModal"
                            style="display:inline-flex;align-items:center;gap:6px;padding:8px 14px;border-radius:10px;
                                       background:linear-gradient(135deg,#10b981,#059669);color:white;font-size:13px;
                                       font-weight:500;text-decoration:none;box-shadow:0 10px 25px rgba(16,185,129,0.35);
                                       border:none;cursor:pointer;transition:transform .12s,box-shadow .18s;">
                        <i data-lucide="plus" style="width:16px;height:16px;"></i>
                        <span>Tambah Mutasi</span>
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

            @if ($errors->any())
                <div style="margin-bottom:14px;padding:10px 14px;border-radius:12px;
                            background:#fef2f2;border:1px solid #fecaca;color:#b91c1c;
                            display:flex;align-items:center;gap:8px;font-size:13px;">
                    <i data-lucide="alert-circle" style="width:18px;height:18px;color:#ef4444;"></i>
                    <span>Terjadi kesalahan pada input, periksa kembali formulir.</span>
                </div>
            @endif

            {{-- Card daftar Mutasi --}}
            <div style="background:#fff;border-radius:12px;padding:0;border:1px solid rgba(2,6,23,0.04);
                            box-shadow:0 6px 20px rgba(2,6,23,0.03);overflow:hidden;">
                <div style="overflow:auto;">
                    <table style="width:100%;border-collapse:collapse;font-size:13px;">
                        <thead style="background:#f8fafc;border-bottom:1px solid rgba(148,163,184,0.4);color:#475569;">
                            <tr>
                                <th style="padding:12px 18px;text-align:left;font-weight:600;">No</th>
                                <th style="padding:12px 18px;text-align:left;font-weight:600;">Tanggal</th>
                                <th style="padding:12px 18px;text-align:left;font-weight:600;">Warga</th>
                                <th style="padding:12px 18px;text-align:left;font-weight:600;">Jenis</th>
                                <th style="padding:12px 18px;text-align:left;font-weight:600;">Keterangan</th>
                                <th style="padding:12px 18px;text-align:center;font-weight:600;">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($mutasi as $index => $row)
                                <tr style="border-bottom:1px solid rgba(241,245,249,1);transition:background .15s;"
                                    onmouseover="this.style.background='#f9fafb'"
                                    onmouseout="this.style.background='transparent'">
                                    {{-- No --}}
                                    <td style="padding:10px 18px;white-space:nowrap;color:#6b7280;">
                                        {{ $mutasi->firstItem() + $index }}
                                    </td>

                                    {{-- Tanggal --}}
                                    <td style="padding:10px 18px;white-space:nowrap;color:#0f172a;">
                                        {{ $row->tanggal_formatted ?? ($row->tanggal ? $row->tanggal->format('d-m-Y') : '-') }}
                                    </td>

                                    {{-- Warga --}}
                                    <td style="padding:10px 18px;white-space:nowrap;color:#0f172a;">
                                        @if($row->warga)
                                            <div style="font-weight:600;color:#0f172a;">
                                                {{ $row->warga->nama }}
                                            </div>
                                            <div style="font-size:11px;color:#6b7280;">
                                                NIK: {{ $row->warga->nik ?? '-' }}<br>
                                                Rumah: {{ $row->warga->no_rumah ?? '-' }} (RT {{ $row->warga->rt }}/RW {{ $row->warga->rw }})
                                            </div>
                                        @else
                                            <span style="font-size:11px;color:#9ca3af;font-style:italic;">
                                                Data warga tidak ditemukan
                                            </span>
                                        @endif
                                    </td>

                                    {{-- Jenis --}}
                                    <td style="padding:10px 18px;white-space:nowrap;">
                                        @php
                                            $label = [
                                                'masuk' => 'Masuk',
                                                'keluar' => 'Keluar',
                                                'pindah_rt' => 'Pindah RT',
                                                'pindah_rw' => 'Pindah RW',
                                            ][$row->jenis] ?? $row->jenis;

                                            $style = [
                                                'masuk' => 'background:#ecfdf5;border:1px solid #bbf7d0;color:#166534;',
                                                'keluar' => 'background:#fef2f2;border:1px solid #fecaca;color:#b91c1c;',
                                                'pindah_rt' => 'background:#fffbeb;border:1px solid #fde68a;color:#92400e;',
                                                'pindah_rw' => 'background:#eff6ff;border:1px solid #bfdbfe;color:#1d4ed8;',
                                            ][$row->jenis] ?? 'background:#f8fafc;border:1px solid #e5e7eb;color:#475569;';
                                        @endphp
                                        <span style="display:inline-flex;align-items:center;justify-content:center;
                                                     padding:4px 10px;border-radius:999px;font-size:11px;font-weight:500;{{ $style }}">
                                            {{ $label }}
                                        </span>
                                    </td>

                                    {{-- Keterangan --}}
                                    <td style="padding:10px 18px;color:#6b7280;">
                                        <span style="font-size:12px;">
                                            {{ $row->keterangan ?: '-' }}
                                        </span>
                                    </td>

                                    {{-- Aksi --}}
                                    <td style="padding:10px 18px;white-space:nowrap;">
                                        <div style="display:flex;align-items:center;justify-content:center;gap:6px;">
                                            <form action="{{ route('datawarga.mutasi.destroy', $row->id) }}" method="POST"
                                                  onsubmit="return confirm('Hapus data mutasi ini?')" style="display:inline;">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" title="Hapus"
                                                        style="padding:6px 9px;border-radius:10px;border:none;
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
                                    <td colspan="6" style="padding:40px 18px;text-align:center;color:#6b7280;">
                                        <div style="display:flex;flex-direction:column;align-items:center;gap:8px;">
                                            <i data-lucide="shuffle" style="width:32px;height:32px;color:#e2e8f0;"></i>
                                            <p style="margin:0;">Belum ada data mutasi warga.</p>
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
                    Menampilkan {{ $mutasi->firstItem() ?? 0 }} - {{ $mutasi->lastItem() ?? 0 }}
                    dari {{ $mutasi->total() ?? 0 }} data
                </div>
                <div>
                    {{ $mutasi->withQueryString()->links() }}
                </div>
            </div>
        </div>

        {{-- MODAL TAMBAH MUTASI --}}
        <div id="createMutasiModal" class="hidden"
             style="position:fixed;inset:0;z-index:50;display:flex;align-items:center;justify-content:center;
                    background:rgba(15,23,42,0.35);backdrop-filter:blur(3px);">
            <div style="background:#ffffff;border-radius:16px;box-shadow:0 24px 60px rgba(15,23,42,0.35);
                            width:100%;max-width:640px;max-height:90vh;overflow:auto;padding:20px 22px;position:relative;">

                {{-- Header modal --}}
                <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:16px;">
                    <div>
                        <h2 style="margin:0;font-size:18px;font-weight:700;color:#0f172a;">Tambah Mutasi Warga</h2>
                        <p style="margin:4px 0 0 0;font-size:13px;color:rgba(15,23,42,0.6);">
                            Isi formulir berikut untuk mencatat mutasi warga (masuk/keluar/pindah).
                        </p>
                    </div>
                    <button type="button" data-close-mutasi-modal
                            style="width:32px;height:32px;border-radius:999px;border:none;background:#f1f5f9;
                                   display:inline-flex;align-items:center;justify-content:center;cursor:pointer;">
                        <i data-lucide="x" style="width:18px;height:18px;color:#64748b;"></i>
                    </button>
                </div>

                {{-- Form Tambah Mutasi --}}
                <form action="{{ route('datawarga.mutasi.store') }}" method="POST">
                    @csrf

                    <div style="display:flex;flex-direction:column;gap:14px;">
                        {{-- Warga --}}
                        <div>
                            <label style="display:block;font-size:13px;font-weight:600;color:#0f172a;margin-bottom:4px;">
                                Warga <span style="color:#ef4444;">*</span>
                            </label>
                            <select name="warga_id" required
                                    style="width:100%;border-radius:10px;border:1px solid #e2e8f0;padding:8px 10px;
                                           font-size:13px;outline:none;">
                                <option value="">Pilih Warga...</option>
                                @foreach($wargaList as $w)
                                    <option value="{{ $w->id }}" @selected(old('warga_id') == $w->id)>
                                        {{ $w->nama }}
                                        @if($w->no_rumah)
                                            - No {{ $w->no_rumah }} RT {{ $w->rt }}/RW {{ $w->rw }}
                                        @endif
                                    </option>
                                @endforeach
                            </select>
                            @error('warga_id')
                                <p style="color:#b91c1c;font-size:11px;margin-top:4px;">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- Jenis & Tanggal --}}
                        <div style="display:grid;grid-template-columns:repeat(2,minmax(0,1fr));gap:10px;">
                            <div>
                                <label style="display:block;font-size:13px;font-weight:600;color:#0f172a;margin-bottom:4px;">
                                    Jenis Mutasi <span style="color:#ef4444;">*</span>
                                </label>
                                <select name="jenis" required
                                        style="width:100%;border-radius:10px;border:1px solid #e2e8f0;padding:8px 10px;
                                               font-size:13px;outline:none;">
                                    <option value="">Pilih...</option>
                                    <option value="masuk" @selected(old('jenis') == 'masuk')>Masuk</option>
                                    <option value="keluar" @selected(old('jenis') == 'keluar')>Keluar</option>
                                    <option value="pindah_rt" @selected(old('jenis') == 'pindah_rt')>Pindah RT</option>
                                    <option value="pindah_rw" @selected(old('jenis') == 'pindah_rw')>Pindah RW</option>
                                </select>
                                @error('jenis')
                                    <p style="color:#b91c1c;font-size:11px;margin-top:4px;">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label style="display:block;font-size:13px;font-weight:600;color:#0f172a;margin-bottom:4px;">
                                    Tanggal <span style="color:#ef4444;">*</span>
                                </label>
                                <input type="date" name="tanggal" required
                                       value="{{ old('tanggal', now()->toDateString()) }}"
                                       style="width:100%;border-radius:10px;border:1px solid #e2e8f0;padding:8px 10px;
                                              font-size:13px;outline:none;">
                                @error('tanggal')
                                    <p style="color:#b91c1c;font-size:11px;margin-top:4px;">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        {{-- Keterangan --}}
                        <div>
                            <label style="display:block;font-size:13px;font-weight:600;color:#0f172a;margin-bottom:4px;">
                                Keterangan
                            </label>
                            <textarea name="keterangan" rows="3"
                                      style="width:100%;border-radius:10px;border:1px solid #e2e8f0;padding:8px 10px;
                                             font-size:13px;outline:none;resize:vertical;"
                                      placeholder="Misal: pindah ke RT 03 / RW 07, alasan pindah, dll">{{ old('keterangan') }}</textarea>
                            @error('keterangan')
                                <p style="color:#b91c1c;font-size:11px;margin-top:4px;">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    {{-- Footer aksi --}}
                    <div style="margin-top:18px;padding-top:14px;border-top:1px solid #e5e7eb;
                                    display:flex;justify-content:flex-end;gap:8px;">
                        <button type="button" data-close-mutasi-modal
                                style="padding:8px 14px;border-radius:10px;border:1px solid #e5e7eb;
                                       background:white;color:#475569;font-size:13px;font-weight:500;
                                       cursor:pointer;">
                            Batal
                        </button>
                        <button type="submit"
                                style="display:inline-flex;align-items:center;gap:6px;padding:8px 16px;border-radius:10px;
                                       border:none;background:#0f172a;color:white;font-size:13px;font-weight:600;
                                       cursor:pointer;box-shadow:0 8px 20px rgba(15,23,42,0.35);">
                            <i data-lucide="save" style="width:16px;height:16px;"></i>
                            <span>Simpan Mutasi</span>
                        </button>
                    </div>
                </form>
            </div>
        </div>

        {{-- Script modal Mutasi --}}
        <script>
            document.addEventListener('DOMContentLoaded', function () {
                var openBtn = document.getElementById('openCreateMutasiModal');
                var modal = document.getElementById('createMutasiModal');
                var closers = document.querySelectorAll('[data-close-mutasi-modal]');

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
