{{-- resources/views/datawarga/kk/show.blade.php --}}
@extends('layouts.app')

@section('title', 'Detail Kartu Keluarga')

@section('content')
    <div class="content">
        {{-- Header --}}
        <div style="display:flex;align-items:center;justify-content:space-between;gap:16px;margin-bottom:20px">
            <div>
                <h1 style="margin:0;font-size:22px;font-weight:700;color:#0f172a;">
                    Detail Kartu Keluarga
                </h1>
                <p style="margin:6px 0 0 0;font-size:13px;color:rgba(15,23,42,0.6)">
                    Kelola anggota untuk KK: <strong>{{ $kk->no_kk }}</strong>
                </p>
            </div>

            <a href="{{ route('datawarga.kk.index') }}" style="display:inline-flex;align-items:center;gap:6px;padding:8px 14px;border-radius:10px;
                      border:1px solid #e5e7eb;background:#ffffff;color:#0f172a;font-size:13px;
                      text-decoration:none;">
                <i data-lucide="arrow-left" style="width:16px;height:16px;"></i>
                <span>Kembali</span>
            </a>
        </div>

        {{-- Flash message --}}
        @if(session('success'))
            <div style="margin-bottom:18px;padding:10px 14px;border-radius:12px;
                            background:#ecfdf5;border:1px solid #bbf7d0;
                            color:#166534;display:flex;align-items:center;gap:8px;font-size:13px;">
                <i data-lucide="check-circle" style="width:18px;height:18px;color:#16a34a;"></i>
                <span>{{ session('success') }}</span>
            </div>
        @endif

        {{-- Info KK --}}
        <div style="background:#fff;border-radius:12px;padding:16px 18px;margin-bottom:18px;
                    border:1px solid rgba(148,163,184,0.3);">
            <div style="display:grid;grid-template-columns:repeat(2,minmax(0,1fr));gap:12px;font-size:13px;">
                <div>
                    <div style="font-size:12px;color:#6b7280;">No. KK</div>
                    <div style="font-weight:600;color:#0f172a;">{{ $kk->no_kk }}</div>
                </div>
                <div>
                    <div style="font-size:12px;color:#6b7280;">Kepala Keluarga</div>
                    <div style="font-weight:600;color:#0f172a;">{{ $kk->kepala_keluarga }}</div>
                </div>
                <div>
                    <div style="font-size:12px;color:#6b7280;">Alamat</div>
                    <div style="color:#0f172a;">{{ $kk->alamat }}</div>
                </div>
                <div>
                    <div style="font-size:12px;color:#6b7280;">RT / RW</div>
                    <div style="color:#0f172a;">{{ $kk->rt }} / {{ $kk->rw }}</div>
                </div>
                <div>
                    <div style="font-size:12px;color:#6b7280;">Tanggal Dibuat</div>
                    <div style="color:#0f172a;">
                        {{ optional($kk->tanggal_dibuat)->format('Y-m-d') ?? '-' }}
                    </div>
                </div>
            </div>
        </div>

        {{-- Header Anggota + tombol tambah --}}
        <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:10px;">
            <h2 style="margin:0;font-size:16px;font-weight:600;color:#0f172a;">Anggota Keluarga</h2>

            <button type="button" id="openCreateAnggotaModal" style="display:inline-flex;align-items:center;gap:6px;padding:8px 14px;border-radius:10px;
                           background:linear-gradient(135deg,#0ea5e9,#0369a1);color:white;font-size:13px;
                           font-weight:500;border:none;cursor:pointer;">
                <i data-lucide="user-plus" style="width:16px;height:16px;"></i>
                <span>Tambah Anggota</span>
            </button>
        </div>

        {{-- Tabel Anggota --}}
        <div style="background:#fff;border-radius:12px;padding:0;border:1px solid rgba(2,6,23,0.04);
                    box-shadow:0 6px 20px rgba(2,6,23,0.03);overflow:hidden;">
            <table style="width:100%;border-collapse:collapse;font-size:13px;">
                <thead style="background:#f8fafc;border-bottom:1px solid rgba(148,163,184,0.4);color:#475569;">
                    <tr>
                        <th style="padding:10px 16px;text-align:left;">No</th>
                        <th style="padding:10px 16px;text-align:left;">Nama</th>
                        <th style="padding:10px 16px;text-align:left;">NIK</th>
                        <th style="padding:10px 16px;text-align:left;">Hubungan</th>
                        <th style="padding:10px 16px;text-align:left;">No Rumah</th>
                        <th style="padding:10px 16px;text-align:center;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($kk->anggota as $index => $anggota)
                        <tr style="border-bottom:1px solid #f1f5f9;">
                            <td style="padding:10px 16px;color:#6b7280;">{{ $index + 1 }}</td>
                            <td style="padding:10px 16px;color:#0f172a;">
                                {{ $anggota->warga->nama ?? '-' }}
                            </td>
                            <td style="padding:10px 16px;color:#6b7280;">
                                {{ $anggota->warga->nik ?? '-' }}
                            </td>
                            <td style="padding:10px 16px;color:#0f172a;">
                                {{ $anggota->hubungan }}
                            </td>
                            <td style="padding:10px 16px;color:#6b7280;">
                                {{ $anggota->warga->no_rumah ?? '-' }}
                            </td>
                            <td style="padding:10px 16px;text-align:center;">
                                <form action="{{ route('datawarga.kk.anggota.destroy', [$kk->id, $anggota->id]) }}"
                                    method="POST" onsubmit="return confirm('Hapus anggota ini dari KK?')"
                                    style="display:inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" style="padding:6px 10px;border-radius:10px;border:none;
                                                       background:#fef2f2;color:#b91c1c;font-size:12px;
                                                       font-weight:500;cursor:pointer;display:inline-flex;align-items:center;">
                                        <i data-lucide="user-minus" style="width:14px;height:14px;margin-right:4px;"></i>
                                        Hapus
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" style="padding:32px 16px;text-align:center;color:#6b7280;">
                                <div style="display:flex;flex-direction:column;align-items:center;gap:8px;">
                                    <i data-lucide="users" style="width:28px;height:28px;color:#e2e8f0;"></i>
                                    <p style="margin:0;">Belum ada anggota untuk KK ini.</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    {{-- MODAL TAMBAH ANGGOTA --}}
    <div id="createAnggotaModal" class="hidden" style="position:fixed;inset:0;z-index:50;display:flex;align-items:center;justify-content:center;
                background:rgba(15,23,42,0.35);backdrop-filter:blur(3px);">
        <div style="background:#ffffff;border-radius:16px;box-shadow:0 24px 60px rgba(15,23,42,0.35);
                    width:100%;max-width:560px;max-height:90vh;overflow:auto;padding:20px 22px;position:relative;">

            <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:16px;">
                <div>
                    <h2 style="margin:0;font-size:18px;font-weight:700;color:#0f172a;">Tambah Anggota KK</h2>
                    <p style="margin:4px 0 0 0;font-size:13px;color:rgba(15,23,42,0.6);">
                        Pilih warga yang akan menjadi anggota KK ini.
                    </p>
                </div>
                <button type="button" data-close-anggota-modal style="width:32px;height:32px;border-radius:999px;border:none;background:#f1f5f9;
                               display:inline-flex;align-items:center;justify-content:center;cursor:pointer;">
                    <i data-lucide="x" style="width:18px;height:18px;color:#64748b;"></i>
                </button>
            </div>

            <form action="{{ route('datawarga.kk.anggota.store', $kk->id) }}" method="POST">
                @csrf

                <div style="display:flex;flex-direction:column;gap:14px;">
                    {{-- Pilih Warga --}}
                    <div>
                        <label style="display:block;font-size:13px;font-weight:600;color:#0f172a;margin-bottom:4px;">
                            Warga <span style="color:#ef4444;">*</span>
                        </label>
                        <select name="warga_id" required style="width:100%;border-radius:10px;border:1px solid #e2e8f0;padding:8px 10px;
                                       font-size:13px;outline:none;">
                            <option value="">-- Pilih Warga --</option>
                            @foreach($wargaList as $warga)
                                <option value="{{ $warga->id }}" {{ old('warga_id') == $warga->id ? 'selected' : '' }}>
                                    {{ $warga->nama }} ({{ $warga->nik }})
                                </option>
                            @endforeach
                        </select>
                        @error('warga_id')
                            <p style="color:#b91c1c;font-size:11px;margin-top:4px;">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Hubungan --}}
                    <div>
                        <label style="display:block;font-size:13px;font-weight:600;color:#0f172a;margin-bottom:4px;">
                            Hubungan <span style="color:#ef4444;">*</span>
                        </label>
                        <input name="hubungan" value="{{ old('hubungan') }}" required
                            placeholder="Contoh: Kepala Keluarga, Istri, Anak" style="width:100%;border-radius:10px;border:1px solid #e2e8f0;padding:8px 10px;
                                      font-size:13px;outline:none;">
                        @error('hubungan')
                            <p style="color:#b91c1c;font-size:11px;margin-top:4px;">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div style="margin-top:18px;padding-top:14px;border-top:1px solid #e5e7eb;
                            display:flex;justify-content:flex-end;gap:8px;">
                    <button type="button" data-close-anggota-modal style="padding:8px 14px;border-radius:10px;border:1px solid #e5e7eb;
                                   background:white;color:#475569;font-size:13px;font-weight:500;
                                   cursor:pointer;">
                        Batal
                    </button>
                    <button type="submit" style="display:inline-flex;align-items:center;gap:6px;padding:8px 16px;border-radius:10px;
                                   border:none;background:#0f172a;color:white;font-size:13px;font-weight:600;
                                   cursor:pointer;box-shadow:0 8px 20px rgba(15,23,42,0.35);">
                        <i data-lucide="save" style="width:16px;height:16px;"></i>
                        <span>Simpan Anggota</span>
                    </button>
                </div>
            </form>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            var openBtn = document.getElementById('openCreateAnggotaModal');
            var modal = document.getElementById('createAnggotaModal');
            var closers = document.querySelectorAll('[data-close-anggota-modal]');

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

            // kalau ada error validasi, buka modal otomatis
            @if ($errors->any())
                if (modal) {
                    modal.classList.remove('hidden');
                }
            @endif
    });
    </script>
@endsection