@extends('layouts.app')

@section('title', 'Management Role')

@section('content')
    <div class="content">
        {{-- Header --}}
        <div style="display:flex;align-items:center;justify-content:space-between;gap:16px;margin-bottom:20px">
            <div>
                <h1 style="margin:0;font-size:22px;font-weight:700;color:#0f172a;">Management Role</h1>
                <p style="margin:6px 0 0 0;font-size:13px;color:rgba(15,23,42,0.6)">
                    Kelola daftar peran pengguna (Role) dan hak akses sistem.
                </p>
            </div>

            <div style="display:flex;align-items:center;gap:12px">
                {{-- Search --}}
                <form method="GET" action="{{ route('administrasi.roles.index') }}">
                    <input name="q" value="{{ request('q') }}" placeholder="Cari role..."
                        style="padding:8px 12px;border-radius:10px;border:1px solid rgba(148,163,184,0.7);font-size:13px;width:200px;">
                </form>

                <button id="openCreateModal" style="padding:8px 14px;border-radius:10px;background:#0f172a;color:white;
                                       border:none;font-size:13px;font-weight:500;cursor:pointer;">
                    <i data-lucide="plus" style="width:14px;height:14px;margin-bottom:-2px;"></i> Tambah Role
                </button>
            </div>
        </div>

        {{-- Flash Message --}}
        @if(session('success'))
            <div
                style="margin-bottom:18px;padding:10px 14px;border-radius:12px;background:#ecfdf5;border:1px solid #bbf7d0;color:#166534;font-size:13px;">
                <i data-lucide="check-circle" style="width:16px;height:16px;margin-bottom:-3px;"></i> {{ session('success') }}
            </div>
        @endif
        @if(session('error'))
            <div
                style="margin-bottom:18px;padding:10px 14px;border-radius:12px;background:#fef2f2;border:1px solid #fecaca;color:#b91c1c;font-size:13px;">
                <i data-lucide="alert-circle" style="width:16px;height:16px;margin-bottom:-3px;"></i> {{ session('error') }}
            </div>
        @endif

        {{-- Table --}}
        <div
            style="background:white;border-radius:12px;border:1px solid rgba(2,6,23,0.04);box-shadow:0 6px 20px rgba(2,6,23,0.03);overflow:hidden;">
            <table style="width:100%;font-size:13px;border-collapse:collapse;">
                <thead style="background:#f8fafc;border-bottom:1px solid rgba(148,163,184,0.4);color:#475569;">
                    <tr>
                        <th style="padding:12px 18px;text-align:left;">No</th>
                        <th style="padding:12px 18px;text-align:left;">Nama Role (Slug)</th>
                        <th style="padding:12px 18px;text-align:left;">Label</th>
                        <th style="padding:12px 18px;text-align:left;">Deskripsi</th>
                        <th style="padding:12px 18px;text-align:center;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($roles as $index => $role)
                        <tr style="border-bottom:1px solid #f1f5f9;">
                            <td style="padding:10px 18px;color:#6b7280;">{{ $roles->firstItem() + $index }}</td>
                            <td style="padding:10px 18px;font-family:monospace;color:#0f172a;">{{ $role->name }}</td>
                            <td style="padding:10px 18px;font-weight:600;">{{ $role->label }}</td>
                            <td style="padding:10px 18px;color:#64748b;">{{ $role->description }}</td>
                            <td style="padding:10px 18px;text-align:center;">
                                <div style="display:flex;align-items:center;justify-content:center;gap:6px;">
                                    <button class="btn-edit-role" data-id="{{ $role->id }}" data-name="{{ $role->name }}"
                                        data-label="{{ $role->label }}" data-description="{{ $role->description }}"
                                        style="padding:6px 10px;border-radius:8px;background:#fffbeb;border:none;color:#92400e;font-size:12px;cursor:pointer;">
                                        Edit
                                    </button>

                                    @if(!in_array($role->name, ['admin', 'ketua_rt', 'bendahara', 'warga']))
                                        <form action="{{ route('administrasi.roles.destroy', $role->id) }}" method="POST"
                                            onsubmit="return confirm('Hapus role ini?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit"
                                                style="padding:6px 10px;border-radius:8px;background:#fef2f2;border:none;color:#b91c1c;font-size:12px;cursor:pointer;">
                                                Hapus
                                            </button>
                                        </form>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" style="padding:40px;text-align:center;color:#6b7280;">Belum ada data role.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- Pagination --}}
        <div style="margin-top:10px;">
            {{ $roles->withQueryString()->links() }}
        </div>
    </div>

    {{-- MODAL CREATE --}}
    <div id="createModal" class="hidden"
        style="position:fixed;inset:0;background:rgba(0,0,0,0.5);display:flex;justify-content:center;align-items:center;z-index:999;">
        <div style="background:white;padding:24px;border-radius:12px;width:100%;max-width:500px;">
            <h3 style="margin-top:0;margin-bottom:16px;font-size:18px;font-weight:700;">Tambah Role Baru</h3>
            <form action="{{ route('administrasi.roles.store') }}" method="POST">
                @csrf
                <div style="margin-bottom:12px;">
                    <label style="display:block;font-size:13px;font-weight:600;margin-bottom:4px;">Nama Role (Slug)</label>
                    <input name="name" required placeholder="Contoh: keamanan, sekretaris"
                        style="width:100%;padding:8px;border-radius:6px;border:1px solid #cbd5e1;">
                    <small style="color:#64748b;">Harus unik, huruf kecil, tanpa spasi (gunakan underscore).</small>
                </div>
                <div style="margin-bottom:12px;">
                    <label style="display:block;font-size:13px;font-weight:600;margin-bottom:4px;">Label</label>
                    <input name="label" required placeholder="Contoh: Petugas Keamanan"
                        style="width:100%;padding:8px;border-radius:6px;border:1px solid #cbd5e1;">
                </div>
                <div style="margin-bottom:20px;">
                    <label style="display:block;font-size:13px;font-weight:600;margin-bottom:4px;">Deskripsi</label>
                    <textarea name="description" rows="3"
                        style="width:100%;padding:8px;border-radius:6px;border:1px solid #cbd5e1;"></textarea>
                </div>
                <div style="text-align:right;gap:8px;display:flex;justify-content:flex-end;">
                    <button type="button" id="closeCreateModal"
                        style="padding:8px 16px;border-radius:6px;border:1px solid #cbd5e1;background:white;cursor:pointer;">Batal</button>
                    <button type="submit"
                        style="padding:8px 16px;border-radius:6px;border:none;background:#0f172a;color:white;cursor:pointer;">Simpan</button>
                </div>
            </form>
        </div>
    </div>

    {{-- MODAL EDIT --}}
    <div id="editModal" class="hidden"
        style="position:fixed;inset:0;background:rgba(0,0,0,0.5);display:flex;justify-content:center;align-items:center;z-index:999;">
        <div style="background:white;padding:24px;border-radius:12px;width:100%;max-width:500px;">
            <h3 style="margin-top:0;margin-bottom:16px;font-size:18px;font-weight:700;">Edit Role</h3>
            <form id="editForm" method="POST">
                @csrf
                @method('PUT')
                <div style="margin-bottom:12px;">
                    <label style="display:block;font-size:13px;font-weight:600;margin-bottom:4px;">Nama Role (Slug)</label>
                    <input id="edit_name" disabled
                        style="width:100%;padding:8px;border-radius:6px;border:1px solid #e2e8f0;background:#f8fafc;color:#64748b;">
                    <small style="color:#64748b;">Slug role tidak dapat diubah.</small>
                </div>
                <div style="margin-bottom:12px;">
                    <label style="display:block;font-size:13px;font-weight:600;margin-bottom:4px;">Label</label>
                    <input name="label" id="edit_label" required
                        style="width:100%;padding:8px;border-radius:6px;border:1px solid #cbd5e1;">
                </div>
                <div style="margin-bottom:20px;">
                    <label style="display:block;font-size:13px;font-weight:600;margin-bottom:4px;">Deskripsi</label>
                    <textarea name="description" id="edit_description" rows="3"
                        style="width:100%;padding:8px;border-radius:6px;border:1px solid #cbd5e1;"></textarea>
                </div>
                <div style="text-align:right;gap:8px;display:flex;justify-content:flex-end;">
                    <button type="button" id="closeEditModal"
                        style="padding:8px 16px;border-radius:6px;border:1px solid #cbd5e1;background:white;cursor:pointer;">Batal</button>
                    <button type="submit"
                        style="padding:8px 16px;border-radius:6px;border:none;background:#0f172a;color:white;cursor:pointer;">Update</button>
                </div>
            </form>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            // Create Modal
            const createModal = document.getElementById('createModal');
            document.getElementById('openCreateModal').onclick = () => createModal.classList.remove('hidden');
            document.getElementById('closeCreateModal').onclick = () => createModal.classList.add('hidden');

            // Edit Modal
            const editModal = document.getElementById('editModal');
            document.querySelectorAll('.btn-edit-role').forEach(btn => {
                btn.onclick = () => {
                    const id = btn.dataset.id;
                    const name = btn.dataset.name;
                    const label = btn.dataset.label;
                    const desc = btn.dataset.description;

                    document.getElementById('editForm').action = "{{ url('administrasi/roles') }}/" + id;
                    document.getElementById('edit_name').value = name;
                    document.getElementById('edit_label').value = label;
                    document.getElementById('edit_description').value = desc;

                    editModal.classList.remove('hidden');
                };
            });
            document.getElementById('closeEditModal').onclick = () => editModal.classList.add('hidden');
        });
    </script>
@endsection