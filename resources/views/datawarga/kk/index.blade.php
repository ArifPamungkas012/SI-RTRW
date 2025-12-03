{{-- resources/views/datawarga/kk/index.blade.php --}}
@extends('layouts.app')

@section('title', 'Daftar Kartu Keluarga')

@section('content')
    <div class="content">
        {{-- Header --}}
        <div style="display:flex;align-items:center;justify-content:space-between;gap:16px;margin-bottom:20px">
            <div>
                <h1 style="margin:0;font-size:22px;font-weight:700;color:#0f172a;">Daftar Kartu Keluarga</h1>
                <p style="margin:6px 0 0 0;font-size:13px;color:rgba(15,23,42,0.6)">
                    Kelola data Kartu Keluarga (KK)
                </p>
            </div>

            <div style="display:flex;align-items:center;gap:12px">
                <form method="GET" action="{{ route('datawarga.kk.index') }}"
                    style="display:flex;align-items:center;gap:8px">
                    <div style="position:relative">
                        <input name="q" value="{{ request('q') }}" placeholder="Cari no KK / kepala keluarga..." style="padding:8px 12px 8px 32px;border-radius:10px;border:1px solid rgba(148,163,184,0.7);
                                       font-size:13px;min-width:260px;outline:none;transition:border-color .18s ease"
                            onfocus="this.style.borderColor='#10b981'"
                            onblur="this.style.borderColor='rgba(148,163,184,0.7)'" />
                        <i data-lucide="search" style="width:16px;height:16px;color:#94a3b8;position:absolute;left:10px;top:50%;
                                      transform:translateY(-50%);"></i>
                    </div>
                    <button type="submit" style="display:inline-flex;align-items:center;gap:6px;padding:8px 14px;border-radius:10px;
                                       border:none;background:#0f172a;color:white;font-size:13px;font-weight:500;
                                       cursor:pointer;box-shadow:0 6px 16px rgba(15,23,42,0.18);
                                       transition:background .18s,transform .12s">
                        <span>Cari</span>
                    </button>
                </form>

                {{-- Tombol buka modal Tambah KK --}}
                <button type="button" id="openCreateKKModal" style="display:inline-flex;align-items:center;gap:6px;padding:8px 14px;border-radius:10px;
                                   background:linear-gradient(135deg,#10b981,#059669);color:white;font-size:13px;
                                   font-weight:500;text-decoration:none;box-shadow:0 10px 25px rgba(16,185,129,0.35);
                                   border:none;cursor:pointer;transition:transform .12s,box-shadow .18s;">
                    <i data-lucide="plus" style="width:16px;height:16px;"></i>
                    <span>Tambah KK</span>
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

        {{-- Card daftar KK --}}
        <div style="background:#fff;border-radius:12px;padding:0;border:1px solid rgba(2,6,23,0.04);
                        box-shadow:0 6px 20px rgba(2,6,23,0.03);overflow:hidden;">
            <div style="overflow:auto;">
                <table style="width:100%;border-collapse:collapse;font-size:13px;">
                    <thead style="background:#f8fafc;border-bottom:1px solid rgba(148,163,184,0.4);color:#475569;">
                        <tr>
                            <th style="padding:12px 18px;text-align:left;font-weight:600;">No</th>
                            <th style="padding:12px 18px;text-align:left;font-weight:600;">No. KK</th>
                            <th style="padding:12px 18px;text-align:left;font-weight:600;">Kepala Keluarga</th>
                            <th style="padding:12px 18px;text-align:left;font-weight:600;">Alamat</th>
                            <th style="padding:12px 18px;text-align:left;font-weight:600;">RT / RW</th>
                            <th style="padding:12px 18px;text-align:left;font-weight:600;">Tanggal Dibuat</th>
                            <th style="padding:12px 18px;text-align:left;font-weight:600;">Anggota</th>
                            <th style="padding:12px 18px;text-align:center;font-weight:600;">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($kks as $index => $kk)
                            <tr style="border-bottom:1px solid rgba(241,245,249,1);transition:background .15s;"
                                onmouseover="this.style.background='#f9fafb'" onmouseout="this.style.background='transparent'">
                                <td style="padding:10px 18px;white-space:nowrap;color:#6b7280;">
                                    {{ $kks->firstItem() + $index }}
                                </td>
                                <td style="padding:10px 18px;white-space:nowrap;font-weight:600;color:#0f172a;">
                                    {{ $kk->no_kk }}
                                </td>
                                <td style="padding:10px 18px;white-space:nowrap;color:#0f172a;">
                                    {{ $kk->kepala_keluarga }}
                                </td>
                                <td style="padding:10px 18px;white-space:nowrap;color:#6b7280;">
                                    {{ \Illuminate\Support\Str::limit($kk->alamat, 50) }}
                                </td>
                                <td style="padding:10px 18px;white-space:nowrap;color:#6b7280;">
                                    {{ $kk->rt }} / {{ $kk->rw }}
                                </td>
                                <td style="padding:10px 18px;white-space:nowrap;color:#6b7280;">
                                    {{ optional($kk->tanggal_dibuat)->format('Y-m-d') ?? '-' }}
                                </td>
                                <td style="padding:10px 18px;white-space:nowrap;color:#6b7280;">
                                    {{ $kk->anggota->count() ?? 0 }} orang
                                </td>
                                <td style="padding:10px 18px;white-space:nowrap;">
                                    <div style="display:flex;align-items:center;justify-content:center;gap:6px;">
                                        <a href="{{ route('datawarga.kk.show', $kk->id) }}" title="Lihat Detail" style="padding:6px 9px;border-radius:10px;background:#f8fafc;
                                                          color:#0f172a;font-size:12px;font-weight:500;
                                                          text-decoration:none;display:inline-flex;align-items:center;
                                                          justify-content:center;transition:background .15s,color .15s;">
                                            <i data-lucide="eye" style="width:14px;height:14px;margin-right:4px;"></i>
                                            Lihat
                                        </a>

                                        <a href="{{ route('datawarga.kk.edit', $kk->id) }}" title="Edit" style="padding:6px 9px;border-radius:10px;background:#fffbeb;
                                                          color:#b45309;font-size:12px;font-weight:500;
                                                          text-decoration:none;display:inline-flex;align-items:center;
                                                          justify-content:center;transition:background .15s,color .15s;">
                                            <i data-lucide="edit" style="width:14px;height:14px;margin-right:4px;"></i>
                                            Edit
                                        </a>

                                        <form action="{{ route('datawarga.kk.destroy', $kk->id) }}" method="POST"
                                            onsubmit="return confirm('Hapus KK ini?')" style="display:inline;">
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
                                <td colspan="8" style="padding:40px 18px;text-align:center;color:#6b7280;">
                                    <div style="display:flex;flex-direction:column;align-items:center;gap:8px;">
                                        <i data-lucide="users" style="width:32px;height:32px;color:#e2e8f0;"></i>
                                        <p style="margin:0;">Belum ada data Kartu Keluarga.</p>
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
                Menampilkan {{ $kks->firstItem() ?? 0 }} - {{ $kks->lastItem() ?? 0 }}
                dari {{ $kks->total() ?? 0 }} data
            </div>
            <div>
                {{ $kks->withQueryString()->links() }}
            </div>
        </div>
    </div>

    {{-- MODAL TAMBAH KK --}}
    <div id="createKKModal" class="hidden" style="position:fixed;inset:0;z-index:50;display:flex;align-items:center;justify-content:center;
                    background:rgba(15,23,42,0.35);backdrop-filter:blur(3px);">
        <div style="background:#ffffff;border-radius:16px;box-shadow:0 24px 60px rgba(15,23,42,0.35);
                        width:100%;max-width:640px;max-height:90vh;overflow:auto;padding:20px 22px;position:relative;">

            {{-- Header modal --}}
            <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:16px;">
                <div>
                    <h2 style="margin:0;font-size:18px;font-weight:700;color:#0f172a;">Tambah Kartu Keluarga</h2>
                    <p style="margin:4px 0 0 0;font-size:13px;color:rgba(15,23,42,0.6);">
                        Isi formulir berikut untuk menambahkan data KK baru.
                    </p>
                </div>
                <button type="button" data-close-kk-modal style="width:32px;height:32px;border-radius:999px;border:none;background:#f1f5f9;
                                   display:inline-flex;align-items:center;justify-content:center;cursor:pointer;">
                    <i data-lucide="x" style="width:18px;height:18px;color:#64748b;"></i>
                </button>
            </div>

            {{-- Flash error --}}
            @if(session('error'))
                <div style="margin-bottom:14px;padding:10px 14px;border-radius:12px;
                                    background:#fef2f2;border:1px solid #fecaca;color:#b91c1c;
                                    display:flex;align-items:center;gap:8px;font-size:13px;">
                    <i data-lucide="alert-circle" style="width:18px;height:18px;color:#ef4444;"></i>
                    <span>{{ session('error') }}</span>
                </div>
            @endif

            {{-- Form Tambah KK --}}
            <form action="{{ route('datawarga.kk.store') }}" method="POST">
                @csrf

                <div style="display:flex;flex-direction:column;gap:14px;">
                    {{-- No KK --}}
                    <div>
                        <label style="display:block;font-size:13px;font-weight:600;color:#0f172a;margin-bottom:4px;">
                            No. Kartu Keluarga <span style="color:#ef4444;">*</span>
                        </label>
                        <input name="no_kk" value="{{ old('no_kk') }}" required placeholder="Masukkan nomor KK" style="width:100%;border-radius:10px;border:1px solid #e2e8f0;padding:8px 10px;
                                          font-size:13px;outline:none;transition:border-color .18s,box-shadow .18s;">
                        @error('no_kk')
                            <p style="color:#b91c1c;font-size:11px;margin-top:4px;">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Kepala Keluarga --}}
                    <div>
                        <label style="display:block;font-size:13px;font-weight:600;color:#0f172a;margin-bottom:4px;">
                            Kepala Keluarga <span style="color:#ef4444;">*</span>
                        </label>
                        <input name="kepala_keluarga" value="{{ old('kepala_keluarga') }}" required
                            placeholder="Nama kepala keluarga" style="width:100%;border-radius:10px;border:1px solid #e2e8f0;padding:8px 10px;
                                          font-size:13px;outline:none;">
                        @error('kepala_keluarga')
                            <p style="color:#b91c1c;font-size:11px;margin-top:4px;">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Alamat --}}
                    <div>
                        <label style="display:block;font-size:13px;font-weight:600;color:#0f172a;margin-bottom:4px;">
                            Alamat
                        </label>
                        <textarea name="alamat" rows="3" placeholder="Alamat lengkap KK" style="width:100%;border-radius:10px;border:1px solid #e2e8f0;padding:8px 10px;
                                             font-size:13px;outline:none;resize:vertical;">{{ old('alamat') }}</textarea>
                        @error('alamat')
                            <p style="color:#b91c1c;font-size:11px;margin-top:4px;">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- RT / RW --}}
                    <div style="display:grid;grid-template-columns:repeat(2,minmax(0,1fr));gap:10px;">
                        <div>
                            <label style="display:block;font-size:13px;font-weight:600;color:#0f172a;margin-bottom:4px;">
                                RT
                            </label>
                            <input name="rt" value="{{ old('rt') }}" style="width:100%;border-radius:10px;border:1px solid #e2e8f0;padding:8px 10px;
                                              font-size:13px;outline:none;">
                        </div>
                        <div>
                            <label style="display:block;font-size:13px;font-weight:600;color:#0f172a;margin-bottom:4px;">
                                RW
                            </label>
                            <input name="rw" value="{{ old('rw') }}" style="width:100%;border-radius:10px;border:1px solid #e2e8f0;padding:8px 10px;
                                              font-size:13px;outline:none;">
                        </div>
                    </div>

                    {{-- Tanggal dibuat --}}
                    <div>
                        <label style="display:block;font-size:13px;font-weight:600;color:#0f172a;margin-bottom:4px;">
                            Tanggal Dibuat
                        </label>
                        <input type="date" name="tanggal_dibuat" value="{{ old('tanggal_dibuat') }}" style="width:100%;border-radius:10px;border:1px solid #e2e8f0;padding:8px 10px;
                                          font-size:13px;outline:none;">
                    </div>
                </div>

                {{-- Footer aksi --}}
                <div style="margin-top:18px;padding-top:14px;border-top:1px solid #e5e7eb;
                                display:flex;justify-content:flex-end;gap:8px;">
                    <button type="button" data-close-kk-modal style="padding:8px 14px;border-radius:10px;border:1px solid #e5e7eb;
                                       background:white;color:#475569;font-size:13px;font-weight:500;
                                       cursor:pointer;">
                        Batal
                    </button>
                    <button type="submit" style="display:inline-flex;align-items:center;gap:6px;padding:8px 16px;border-radius:10px;
                                       border:none;background:#0f172a;color:white;font-size:13px;font-weight:600;
                                       cursor:pointer;box-shadow:0 8px 20px rgba(15,23,42,0.35);">
                        <i data-lucide="save" style="width:16px;height:16px;"></i>
                        <span>Simpan KK</span>
                    </button>
                </div>
            </form>
        </div>
    </div>

    {{-- Script modal KK --}}
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            var openBtn = document.getElementById('openCreateKKModal');
            var modal = document.getElementById('createKKModal');
            var closers = document.querySelectorAll('[data-close-kk-modal]');

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

            // Kalau ada error validasi / session error, buka modal otomatis
            @if ($errors->any() || session('error'))
                if (modal) {
                    modal.classList.remove('hidden');
                }
            @endif
            });
    </script>
@endsection