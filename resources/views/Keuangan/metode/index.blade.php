{{-- resources/views/keuangan/metode/index.blade.php --}}
@extends('layouts.app')

@section('title', 'Master Metode Pembayaran')

@section('content')
    <div class="content">
        {{-- HEADER --}}
        <div style="display:flex;align-items:center;justify-content:space-between;gap:16px;margin-bottom:20px">
            <div>
                <h1 style="margin:0;font-size:22px;font-weight:700;color:#0f172a;">
                    Master Metode Pembayaran
                </h1>
                <p style="margin:6px 0 0 0;font-size:13px;color:rgba(15,23,42,0.6)">
                    Kelola daftar metode pembayaran yang digunakan untuk iuran dan transaksi lainnya.
                </p>
            </div>

            <div style="display:flex;align-items:center;gap:12px">
                {{-- FILTER / SEARCH --}}
                <form method="GET" action="{{ route('keuangan.metode.index') }}"
                    style="display:flex;align-items:center;gap:8px">
                    <div style="position:relative">
                        <input name="q" value="{{ $filterSearch }}" placeholder="Cari nama / deskripsi..." style="padding:8px 12px 8px 32px;border-radius:10px;border:1px solid rgba(148,163,184,0.7);
                                          font-size:13px;min-width:220px;outline:none;transition:.18s;"
                            onfocus="this.style.borderColor='#10b981'"
                            onblur="this.style.borderColor='rgba(148,163,184,0.7)'">
                        <i data-lucide="search" style="width:16px;height:16px;color:#94a3b8;position:absolute;left:10px;top:50%;
                                      transform:translateY(-50%);"></i>
                    </div>

                    <div>
                        <select name="active" style="padding:8px 10px;border-radius:10px;border:1px solid rgba(148,163,184,0.7);
                                           font-size:13px;outline:none;min-width:140px;">
                            <option value="">Semua Status</option>
                            <option value="1" {{ $filterActive === '1' ? 'selected' : '' }}>Aktif</option>
                            <option value="0" {{ $filterActive === '0' ? 'selected' : '' }}>Nonaktif</option>
                        </select>
                    </div>

                    <button type="submit" style="padding:8px 14px;border-radius:10px;background:#0f172a;color:white;border:none;
                                       font-size:13px;font-weight:500;cursor:pointer;">
                        Filter
                    </button>

                    @if($filterSearch || $filterActive !== null && $filterActive !== '')
                        <a href="{{ route('keuangan.metode.index') }}"
                            style="font-size:12px;color:#64748b;text-decoration:none;">
                            Reset
                        </a>
                    @endif
                </form>

                {{-- Button Modal Tambah --}}
                <button id="openCreateMetodeModal" style="display:flex;align-items:center;gap:6px;padding:8px 14px;border-radius:10px;
                                   background:linear-gradient(135deg,#10b981,#059669);color:white;font-size:13px;
                                   font-weight:500;cursor:pointer;border:none;">
                    <i data-lucide="plus" style="width:16px;height:16px;"></i>
                    Tambah Metode
                </button>
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

        @if($errors->any())
            <div style="margin-bottom:14px;padding:10px 14px;border-radius:12px;
                                background:#fef2f2;border:1px solid #fecaca;color:#b91c1c;
                                display:flex;align-items:center;gap:8px;font-size:13px;">
                <i data-lucide="alert-circle" style="width:18px;height:18px;color:#ef4444;"></i>
                <span>Terjadi kesalahan pada input, periksa kembali formulir.</span>
            </div>
        @endif

        {{-- TABLE CARD --}}
        <div style="background:white;border-radius:12px;border:1px solid rgba(2,6,23,0.04);
                        box-shadow:0 6px 20px rgba(2,6,23,0.03);overflow:hidden;">
            <div style="overflow:auto;">
                <table style="width:100%;font-size:13px;border-collapse:collapse;">
                    <thead style="background:#f8fafc;border-bottom:1px solid rgba(148,163,184,0.4);color:#475569;">
                        <tr>
                            <th style="padding:12px 18px;text-align:left;">No</th>
                            <th style="padding:12px 18px;text-align:left;">Nama Metode</th>
                            <th style="padding:12px 18px;text-align:left;">Deskripsi</th>
                            <th style="padding:12px 18px;text-align:left;">Status</th>
                            <th style="padding:12px 18px;text-align:center;">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($metodes as $i => $m)
                            <tr style="border-bottom:1px solid #f1f5f9;transition:.15s"
                                onmouseover="this.style.background='#f9fafb'" onmouseout="this.style.background='transparent'">
                                <td style="padding:10px 18px;color:#6b7280;">
                                    {{ $metodes->firstItem() + $i }}
                                </td>
                                <td style="padding:10px 18px;color:#0f172a;font-weight:600;">
                                    {{ $m->nama }}
                                </td>
                                <td style="padding:10px 18px;color:#6b7280;">
                                    {{ \Illuminate\Support\Str::limit($m->deskripsi, 80) ?? '-' }}
                                </td>
                                <td style="padding:10px 18px;">
                                    @if($m->is_active)
                                        <span style="padding:4px 10px;border-radius:999px;background:#ecfdf5;
                                                                 color:#166534;font-size:11px;font-weight:600;">
                                            Aktif
                                        </span>
                                    @else
                                        <span style="padding:4px 10px;border-radius:999px;background:#f9fafb;
                                                                 color:#6b7280;font-size:11px;font-weight:600;">
                                            Nonaktif
                                        </span>
                                    @endif
                                </td>
                                <td style="padding:10px 18px;text-align:center;white-space:nowrap;">
                                    <div style="display:flex;align-items:center;justify-content:center;gap:6px;">
                                        {{-- Edit --}}
                                        <button type="button" class="btn-edit-metode" data-id="{{ $m->id }}"
                                            data-nama="{{ $m->nama }}" data-deskripsi="{{ $m->deskripsi }}"
                                            data-active="{{ $m->is_active ? 1 : 0 }}" style="padding:6px 10px;border-radius:8px;background:#fffbeb;
                                                               border:none;color:#92400e;font-size:12px;cursor:pointer;">
                                            <i data-lucide="edit" style="width:14px;height:14px;margin-right:4px;"></i>
                                            Edit
                                        </button>

                                        {{-- Hapus --}}
                                        <form action="{{ route('keuangan.metode.destroy', $m->id) }}" method="POST"
                                            onsubmit="return confirm('Hapus metode pembayaran ini?');" style="display:inline;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" style="padding:6px 10px;border-radius:8px;background:#fef2f2;border:none;
                                                                   color:#b91c1c;font-size:12px;cursor:pointer;">
                                                <i data-lucide="trash-2" style="width:14px;height:14px;margin-right:4px;"></i>
                                                Hapus
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" style="padding:40px;text-align:center;color:#6b7280;">
                                    <i data-lucide="credit-card" style="width:32px;height:32px;color:#cbd5e1;"></i>
                                    <p style="margin-top:8px;">Belum ada metode pembayaran.</p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        {{-- PAGINATION --}}
        <div style="margin-top:18px;display:flex;align-items:center;justify-content:space-between;gap:12px;flex-wrap:wrap;">
            <div style="font-size:12px;color:#6b7280;">
                Menampilkan {{ $metodes->firstItem() ?? 0 }} - {{ $metodes->lastItem() ?? 0 }}
                dari {{ $metodes->total() ?? 0 }} data
            </div>
            <div>
                {{ $metodes->withQueryString()->links() }}
            </div>
        </div>
    </div>

    {{-- MODAL TAMBAH --}}
    <div id="createMetodeModal" class="hidden" style="position:fixed;inset:0;background:rgba(15,23,42,0.45);
                    backdrop-filter:blur(4px);display:flex;align-items:center;
                    justify-content:center;z-index:999;">
        <div style="background:white;padding:22px 24px;border-radius:16px;
                        max-width:520px;width:100%;max-height:90vh;overflow:auto;
                        box-shadow:0 24px 60px rgba(15,23,42,0.35);">

            <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:16px;">
                <div>
                    <h2 style="font-size:18px;font-weight:700;color:#0f172a;margin:0;">
                        Tambah Metode Pembayaran
                    </h2>
                    <p style="margin:4px 0 0;color:#64748b;font-size:13px;">
                        Misal: Cash, Transfer BCA, Transfer BRI, E-Wallet, dll.
                    </p>
                </div>
                <button type="button" id="closeCreateMetodeModal" style="width:32px;height:32px;border-radius:10px;background:#f1f5f9;
                                   border:none;cursor:pointer;display:flex;align-items:center;justify-content:center;">
                    <i data-lucide="x" style="width:18px;height:18px;color:#475569;"></i>
                </button>
            </div>

            <form action="{{ route('keuangan.metode.store') }}" method="POST">
                @csrf

                <div style="display:flex;flex-direction:column;gap:14px;">
                    <div>
                        <label style="font-size:13px;font-weight:600;">Nama Metode *</label>
                        <input name="nama" value="{{ old('nama') }}" required
                            placeholder="Contoh: Cash, Transfer BCA, Qris, dll"
                            style="width:100%;padding:8px 12px;border-radius:10px;border:1px solid #e2e8f0;">
                    </div>

                    <div>
                        <label style="font-size:13px;font-weight:600;">Deskripsi</label>
                        <textarea name="deskripsi" rows="3" placeholder="Contoh: Transfer ke Rekening BCA 1234 a.n RT 05"
                            style="width:100%;padding:8px 12px;border-radius:10px;border:1px solid #e2e8f0;
                                             resize:vertical;">{{ old('deskripsi') }}</textarea>
                    </div>

                    <div style="display:flex;align-items:center;gap:8px;margin-top:4px;">
                        <input type="checkbox" name="is_active" id="is_active_create" {{ old('is_active', true) ? 'checked' : '' }}>
                        <label for="is_active_create" style="font-size:13px;color:#4b5563;">
                            Aktif digunakan
                        </label>
                    </div>
                </div>

                <div style="margin-top:20px;display:flex;justify-content:flex-end;gap:10px;">
                    <button type="button" id="closeCreateMetodeModal2" style="padding:8px 14px;border-radius:10px;border:1px solid #e2e8f0;
                                       background:white;color:#475569;font-size:13px;">
                        Batal
                    </button>
                    <button type="submit" style="padding:9px 16px;border-radius:10px;background:#0f172a;color:white;
                                       border:none;font-size:13px;font-weight:600;">
                        Simpan Metode
                    </button>
                </div>
            </form>
        </div>
    </div>

    {{-- MODAL EDIT --}}
    <div id="editMetodeModal" class="hidden" style="position:fixed;inset:0;background:rgba(15,23,42,0.45);
                    backdrop-filter:blur(4px);display:flex;align-items:center;
                    justify-content:center;z-index:999;">
        <div style="background:white;padding:22px 24px;border-radius:16px;
                        max-width:520px;width:100%;max-height:90vh;overflow:auto;
                        box-shadow:0 24px 60px rgba(15,23,42,0.35);">

            <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:16px;">
                <div>
                    <h2 style="font-size:18px;font-weight:700;color:#0f172a;margin:0;">
                        Edit Metode Pembayaran
                    </h2>
                </div>
                <button type="button" id="closeEditMetodeModal" style="width:32px;height:32px;border-radius:10px;background:#f1f5f9;
                                   border:none;cursor:pointer;display:flex;align-items:center;justify-content:center;">
                    <i data-lucide="x" style="width:18px;height:18px;color:#475569;"></i>
                </button>
            </div>

            <form id="formEditMetode" method="POST">
                @csrf
                @method('PUT')

                <div style="display:flex;flex-direction:column;gap:14px;">
                    <div>
                        <label style="font-size:13px;font-weight:600;">Nama Metode *</label>
                        <input id="edit_nama" name="nama" required
                            style="width:100%;padding:8px 12px;border-radius:10px;border:1px solid #e2e8f0;">
                    </div>

                    <div>
                        <label style="font-size:13px;font-weight:600;">Deskripsi</label>
                        <textarea id="edit_deskripsi" name="deskripsi" rows="3" style="width:100%;padding:8px 12px;border-radius:10px;border:1px solid #e2e8f0;
                                             resize:vertical;"></textarea>
                    </div>

                    <div style="display:flex;align-items:center;gap:8px;margin-top:4px;">
                        <input type="checkbox" name="is_active" id="edit_is_active">
                        <label for="edit_is_active" style="font-size:13px;color:#4b5563;">
                            Aktif digunakan
                        </label>
                    </div>
                </div>

                <div style="margin-top:20px;display:flex;justify-content:flex-end;gap:10px;">
                    <button type="button" id="closeEditMetodeModal2" style="padding:8px 14px;border-radius:10px;border:1px solid #e2e8f0;
                                       background:white;color:#475569;font-size:13px;">
                        Batal
                    </button>
                    <button type="submit" style="padding:9px 16px;border-radius:10px;background:#0f172a;color:white;
                                       border:none;font-size:13px;font-weight:600;">
                        Simpan Perubahan
                    </button>
                </div>
            </form>
        </div>
    </div>

    {{-- JS MODAL & EDIT --}}
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // Create modal
            const createModal = document.getElementById('createMetodeModal');
            const openCreateBtn = document.getElementById('openCreateMetodeModal');
            const closeCreate1 = document.getElementById('closeCreateMetodeModal');
            const closeCreate2 = document.getElementById('closeCreateMetodeModal2');

            if (openCreateBtn && createModal) {
                openCreateBtn.onclick = () => createModal.classList.remove('hidden');
            }
            [closeCreate1, closeCreate2].forEach(btn => {
                if (btn) btn.onclick = () => createModal.classList.add('hidden');
            });
            if (createModal) {
                createModal.addEventListener('click', e => {
                    if (e.target === createModal) createModal.classList.add('hidden');
                });
            }

            // Edit modal
            const editModal = document.getElementById('editMetodeModal');
            const closeEdit1 = document.getElementById('closeEditMetodeModal');
            const closeEdit2 = document.getElementById('closeEditMetodeModal2');
            const formEdit = document.getElementById('formEditMetode');

            const inputNama = document.getElementById('edit_nama');
            const inputDesk = document.getElementById('edit_deskripsi');
            const inputActive = document.getElementById('edit_is_active');

            document.querySelectorAll('.btn-edit-metode').forEach(btn => {
                btn.addEventListener('click', function () {
                    const id = this.dataset.id;
                    const nama = this.dataset.nama || '';
                    const deskripsi = this.dataset.deskripsi || '';
                    const active = this.dataset.active === '1';

                    if (formEdit) {
                        formEdit.action = "{{ url('keuangan/metode-pembayaran') }}/" + id;
                    }
                    if (inputNama) inputNama.value = nama;
                    if (inputDesk) inputDesk.value = deskripsi;
                    if (inputActive) inputActive.checked = active;

                    if (editModal) editModal.classList.remove('hidden');
                });
            });

            [closeEdit1, closeEdit2].forEach(btn => {
                if (btn) btn.onclick = () => editModal.classList.add('hidden');
            });
            if (editModal) {
                editModal.addEventListener('click', e => {
                    if (e.target === editModal) editModal.classList.add('hidden');
                });
            }
        });
    </script>
@endsection