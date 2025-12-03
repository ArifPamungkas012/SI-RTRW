{{-- resources/views/datawarga/warga/index.blade.php --}}
@extends('layouts.app')

@section('title', 'Daftar Warga')

@section('content')
    <div class="content">
        {{-- Header halaman --}}
        <div style="display:flex;align-items:center;justify-content:space-between;gap:16px;margin-bottom:20px">
            <div>
                <h1 style="margin:0;font-size:22px;font-weight:700;color:#0f172a;">Daftar Warga</h1>
                <p style="margin:6px 0 0 0;font-size:13px;color:rgba(15,23,42,0.6)">
                    Kelola data penduduk RT / RW
                </p>
            </div>

            <div style="display:flex;align-items:center;gap:12px">
                <form method="GET" action="{{ route('datawarga.warga.index') }}"
                    style="display:flex;align-items:center;gap:8px">
                    <div style="position:relative">
                        <input name="q" value="{{ request('q') }}" placeholder="Cari nama / NIK..."
                            style="padding:8px 12px 8px 32px;border-radius:10px;border:1px solid rgba(148,163,184,0.7);
                                               font-size:13px;min-width:220px;outline:none;transition:border-color .18s ease" onfocus="this.style.borderColor='#10b981'"
                            onblur="this.style.borderColor='rgba(148,163,184,0.7)'" />
                        <i data-lucide="search" style="width:16px;height:16px;color:#94a3b8;position:absolute;left:10px;top:50%;
                                              transform:translateY(-50%);"></i>
                    </div>
                    <button type="submit"
                        style="display:inline-flex;align-items:center;gap:6px;padding:8px 14px;border-radius:10px;
                                               border:none;background:#0f172a;color:white;font-size:13px;font-weight:500;
                                               cursor:pointer;box-shadow:0 6px 16px rgba(15,23,42,0.18);transition:background .18s,transform .12s">
                        <span>Cari</span>
                    </button>
                </form>

                <button type="button" id="openCreateWargaModal"
                        style="display:inline-flex;align-items:center;gap:6px;padding:8px 14px;border-radius:10px;
                            background:linear-gradient(135deg,#10b981,#059669);color:white;font-size:13px;
                            font-weight:500;text-decoration:none;box-shadow:0 10px 25px rgba(16,185,129,0.35);
                            border:none;cursor:pointer;transition:transform .12s,box-shadow .18s;">
                    <i data-lucide="plus" style="width:16px;height:16px;"></i>
                    <span>Tambah Warga</span>
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
        @if(session('warning'))
            <div style="margin-bottom:18px;padding:10px 14px;border-radius:12px;
                                                background:#fffbeb;border:1px solid #fef3c7;
                                                color:#92400e;display:flex;align-items:center;gap:8px;font-size:13px;">
                <i data-lucide="alert-triangle" style="width:18px;height:18px;color:#f97316;"></i>
                <span>{{ session('warning') }}</span>
            </div>
        @endif

        {{-- Card utama daftar warga --}}
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
                            <th style="padding:12px 18px;text-align:left;font-weight:600;">No Rumah</th>
                            <th style="padding:12px 18px;text-align:left;font-weight:600;">No HP</th>
                            <th style="padding:12px 18px;text-align:left;font-weight:600;">Status</th>
                            <th style="padding:12px 18px;text-align:center;font-weight:600;">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($wargas as $index => $warga)
                            <tr style="border-bottom:1px solid rgba(241,245,249,1);transition:background .15s;"
                                onmouseover="this.style.background='#f9fafb'" onmouseout="this.style.background='transparent'">
                                <td style="padding:10px 18px;white-space:nowrap;color:#6b7280;">
                                    {{ $wargas->firstItem() + $index }}
                                </td>
                                <td style="padding:10px 18px;white-space:nowrap;font-weight:600;color:#0f172a;">
                                    {{ $warga->nik }}
                                </td>
                                <td style="padding:10px 18px;white-space:nowrap;color:#0f172a;">
                                    {{ $warga->nama }}
                                </td>
                                <td style="padding:10px 18px;white-space:nowrap;color:#6b7280;">
                                    {{ \Illuminate\Support\Str::limit($warga->alamat, 30) }}
                                </td>
                                <td style="padding:10px 18px;white-space:nowrap;color:#6b7280;">
                                    {{ $warga->rt }} / {{ $warga->rw }}
                                </td>
                                <td style="padding:10px 18px;white-space:nowrap;color:#6b7280;">
                                    {{ $warga->no_rumah }}
                                </td>
                                <td style="padding:10px 18px;white-space:nowrap;color:#6b7280;">
                                    {{ $warga->no_hp }}
                                </td>
                                <td style="padding:10px 18px;white-space:nowrap;">
                                    @if($warga->status_aktif)
                                        <span style="display:inline-flex;align-items:center;padding:3px 9px;
                                                                                         border-radius:999px;font-size:11px;font-weight:600;
                                                                                         background:#dcfce7;color:#166534;">
                                            Aktif
                                        </span>
                                    @else
                                        <span style="display:inline-flex;align-items:center;padding:3px 9px;
                                                                                         border-radius:999px;font-size:11px;font-weight:600;
                                                                                         background:#e5e7eb;color:#4b5563;">
                                            Tidak Aktif
                                        </span>
                                    @endif
                                </td>
                                <td style="padding:10px 18px;white-space:nowrap;">
                                    <div style="display:flex;align-items:center;justify-content:center;gap:6px;">
                                        <a href="{{ route('datawarga.warga.show', $warga->id) }}" title="Lihat Detail"
                                            style="padding:6px;border-radius:10px;color:#6b7280;
                                                                          text-decoration:none;display:inline-flex;align-items:center;
                                                                          justify-content:center;transition:background .15s,color .15s;">
                                            <i data-lucide="eye" style="width:16px;height:16px;"></i>
                                        </a>

                                        <a href="{{ route('datawarga.warga.edit', $warga->id) }}" title="Edit"
                                            style="padding:6px;border-radius:10px;color:#f59e0b;
                                                                          text-decoration:none;display:inline-flex;align-items:center;
                                                                          justify-content:center;transition:background .15s,color .15s;">
                                            <i data-lucide="edit" style="width:16px;height:16px;"></i>
                                        </a>

                                        <form action="{{ route('datawarga.warga.destroy', $warga->id) }}" method="POST"
                                            onsubmit="return confirm('Hapus warga ini?')" style="display:inline;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" title="Hapus"
                                                style="padding:6px;border-radius:10px;border:none;background:transparent;
                                                                                   color:#ef4444;cursor:pointer;display:inline-flex;align-items:center;
                                                                                   justify-content:center;transition:background .15s,color .15s;">
                                                <i data-lucide="trash-2" style="width:16px;height:16px;"></i>
                                            </button>
                                        </form>

                                        @if($warga->trashed())
                                            <form action="{{ route('datawarga.warga.restore', $warga->id) }}" method="POST"
                                                style="display:inline;">
                                                @csrf
                                                <button type="submit" title="Pulihkan"
                                                    style="padding:6px;border-radius:10px;border:none;background:transparent;
                                                                                                   color:#10b981;cursor:pointer;display:inline-flex;align-items:center;
                                                                                                   justify-content:center;transition:background .15s,color .15s;">
                                                    <i data-lucide="rotate-ccw" style="width:16px;height:16px;"></i>
                                                </button>
                                            </form>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="9" style="padding:40px 18px;text-align:center;color:#6b7280;">
                                    <div style="display:flex;flex-direction:column;align-items:center;gap:8px;">
                                        <i data-lucide="users" style="width:32px;height:32px;color:#e2e8f0;"></i>
                                        <p style="margin:0;">Belum ada data warga.</p>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        {{-- Pagination --}}
        <div style="margin-top:18px;">
            {{ $wargas->withQueryString()->links() }}
        </div>

        {{-- MODAL TAMBAH WARGA --}}
        <div id="createWargaModal" class="hidden"
            style="position:fixed;inset:0;z-index:50;display:flex;align-items:center;justify-content:center;
                    background:rgba(15,23,42,0.35);backdrop-filter:blur(3px);">
            <div style="background:#ffffff;border-radius:16px;box-shadow:0 24px 60px rgba(15,23,42,0.35);
                        width:100%;max-width:640px;max-height:90vh;overflow:auto;padding:20px 22px;position:relative;">
                
                {{-- Header modal --}}
                <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:16px;">
                    <div>
                        <h2 style="margin:0;font-size:18px;font-weight:700;color:#0f172a;">Tambah Warga Baru</h2>
                        <p style="margin:4px 0 0 0;font-size:13px;color:rgba(15,23,42,0.6);">
                            Isi formulir berikut untuk menambahkan data warga.
                        </p>
                    </div>
                    <button type="button" data-close-create-modal
                            style="width:32px;height:32px;border-radius:999px;border:none;background:#f1f5f9;
                                display:inline-flex;align-items:center;justify-content:center;cursor:pointer;">
                        <i data-lucide="x" style="width:18px;height:18px;color:#64748b;"></i>
                    </button>
                </div>

                {{-- Flash error khusus tambah --}}
                @if(session('error'))
                    <div style="margin-bottom:14px;padding:10px 14px;border-radius:12px;
                                background:#fef2f2;border:1px solid #fecaca;color:#b91c1c;
                                display:flex;align-items:center;gap:8px;font-size:13px;">
                        <i data-lucide="alert-circle" style="width:18px;height:18px;color:#ef4444;"></i>
                        <span>{{ session('error') }}</span>
                    </div>
                @endif

                {{-- Form Tambah Warga --}}
                <form action="{{ route('datawarga.warga.store') }}" method="POST">
                    @csrf

                    <div style="display:flex;flex-direction:column;gap:14px;">
                        {{-- NIK --}}
                        <div>
                            <label style="display:block;font-size:13px;font-weight:600;color:#0f172a;margin-bottom:4px;">
                                NIK <span style="color:#ef4444;">*</span>
                            </label>
                            <input name="nik" value="{{ old('nik') }}" required
                                placeholder="Masukkan 16 digit NIK"
                                style="width:100%;border-radius:10px;border:1px solid #e2e8f0;padding:8px 10px;
                                        font-size:13px;outline:none;transition:border-color .18s,box-shadow .18s;">
                            @error('nik')
                                <p style="color:#b91c1c;font-size:11px;margin-top:4px;">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- Nama --}}
                        <div>
                            <label style="display:block;font-size:13px;font-weight:600;color:#0f172a;margin-bottom:4px;">
                                Nama Lengkap <span style="color:#ef4444;">*</span>
                            </label>
                            <input name="nama" value="{{ old('nama') }}" required
                                placeholder="Masukkan nama lengkap sesuai KTP"
                                style="width:100%;border-radius:10px;border:1px solid #e2e8f0;padding:8px 10px;
                                        font-size:13px;outline:none;transition:border-color .18s,box-shadow .18s;">
                            @error('nama')
                                <p style="color:#b91c1c;font-size:11px;margin-top:4px;">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- Alamat --}}
                        <div>
                            <label style="display:block;font-size:13px;font-weight:600;color:#0f172a;margin-bottom:4px;">
                                Alamat Domisili
                            </label>
                            <textarea name="alamat" rows="3"
                                    placeholder="Alamat lengkap domisili saat ini"
                                    style="width:100%;border-radius:10px;border:1px solid #e2e8f0;padding:8px 10px;
                                            font-size:13px;outline:none;resize:vertical;transition:border-color .18s,box-shadow .18s;">{{ old('alamat') }}</textarea>
                            @error('alamat')
                                <p style="color:#b91c1c;font-size:11px;margin-top:4px;">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- No rumah / RT / RW --}}
                        <div style="display:grid;grid-template-columns:repeat(3,minmax(0,1fr));gap:10px;">
                            <div>
                                <label style="display:block;font-size:13px;font-weight:600;color:#0f172a;margin-bottom:4px;">
                                    No Rumah
                                </label>
                                <input name="no_rumah" value="{{ old('no_rumah') }}"
                                    style="width:100%;border-radius:10px;border:1px solid #e2e8f0;padding:8px 10px;
                                            font-size:13px;outline:none;">
                            </div>
                            <div>
                                <label style="display:block;font-size:13px;font-weight:600;color:#0f172a;margin-bottom:4px;">
                                    RT
                                </label>
                                <input name="rt" value="{{ old('rt') }}"
                                    style="width:100%;border-radius:10px;border:1px solid #e2e8f0;padding:8px 10px;
                                            font-size:13px;outline:none;">
                            </div>
                            <div>
                                <label style="display:block;font-size:13px;font-weight:600;color:#0f172a;margin-bottom:4px;">
                                    RW
                                </label>
                                <input name="rw" value="{{ old('rw') }}"
                                    style="width:100%;border-radius:10px;border:1px solid #e2e8f0;padding:8px 10px;
                                            font-size:13px;outline:none;">
                            </div>
                        </div>

                        {{-- No HP & Tanggal lahir --}}
                        <div style="display:grid;grid-template-columns:repeat(2,minmax(0,1fr));gap:10px;">
                            <div>
                                <label style="display:block;font-size:13px;font-weight:600;color:#0f172a;margin-bottom:4px;">
                                    No HP / WhatsApp
                                </label>
                                <input name="no_hp" value="{{ old('no_hp') }}"
                                    placeholder="Contoh: 08123456789"
                                    style="width:100%;border-radius:10px;border:1px solid #e2e8f0;padding:8px 10px;
                                            font-size:13px;outline:none;">
                                @error('no_hp')
                                    <p style="color:#b91c1c;font-size:11px;margin-top:4px;">{{ $message }}</p>
                                @enderror
                            </div>
                            <div>
                                <label style="display:block;font-size:13px;font-weight:600;color:#0f172a;margin-bottom:4px;">
                                    Tanggal Lahir
                                </label>
                                <input type="date" name="tanggal_lahir" value="{{ old('tanggal_lahir') }}"
                                    style="width:100%;border-radius:10px;border:1px solid #e2e8f0;padding:8px 10px;
                                            font-size:13px;outline:none;">
                            </div>
                        </div>

                        {{-- Status aktif --}}
                        <div>
                            <label style="display:block;font-size:13px;font-weight:600;color:#0f172a;margin-bottom:4px;">
                                Status Aktif
                            </label>
                            <select name="status_aktif"
                                    style="width:100%;border-radius:10px;border:1px solid #e2e8f0;padding:8px 10px;
                                        font-size:13px;outline:none;background:white;">
                                <option value="1" {{ old('status_aktif','1') == '1' ? 'selected' : '' }}>Aktif</option>
                                <option value="0" {{ old('status_aktif') == '0' ? 'selected' : '' }}>Tidak Aktif</option>
                            </select>
                            <p style="font-size:11px;color:#6b7280;margin-top:4px;">
                                Warga tidak aktif tidak akan muncul di laporan rutin.
                            </p>
                        </div>
                    </div>

                    {{-- Footer aksi --}}
                    <div style="margin-top:18px;padding-top:14px;border-top:1px solid #e5e7eb;
                                display:flex;justify-content:flex-end;gap:8px;">
                        <button type="button" data-close-create-modal
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
                            <span>Simpan Data</span>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    {{-- Script modal --}}
        <script>
        document.addEventListener('DOMContentLoaded', function () {
            var openBtn  = document.getElementById('openCreateWargaModal');
            var modal    = document.getElementById('createWargaModal');
            var closers  = document.querySelectorAll('[data-close-create-modal]');

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

            // Klik di luar card menutup modal
            if (modal) {
                modal.addEventListener('click', function (e) {
                    if (e.target === modal) {
                        modal.classList.add('hidden');
                    }
                });
            }

            // Jika ada error validasi / session error -> otomatis buka modal
            @if ($errors->any() || session('error'))
                if (modal) {
                    modal.classList.remove('hidden');
                }
            @endif
        });
        </script>
@endsection