@extends('layouts.app')

@section('title', 'Management User')

@section('content')
    <div class="content">
        {{-- Header --}}
        <div style="display:flex;align-items:center;justify-content:space-between;gap:16px;margin-bottom:20px">
            <div>
                <h1 style="margin:0;font-size:22px;font-weight:700;color:#0f172a;">Management User</h1>
                <p style="margin:6px 0 0 0;font-size:13px;color:rgba(15,23,42,0.6)">
                    Daftar pengguna sistem dan pengaturan role
                </p>
            </div>

            <div style="display:flex;gap:10px">
                <form method="GET" action="{{ route('administrasi.users.index') }}">
                    <input name="q" value="{{ request('q') }}" placeholder="Cari nama / email..."
                        style="padding:8px 12px;border-radius:10px;border:1px solid #e2e8f0;font-size:13px;width:240px;outline:none;transition:border-color 0.2s;">
                </form>

                <button id="btnCreateUser"
                    style="padding:8px 14px;border-radius:10px;background:#0f172a;color:white;border:none;font-size:13px;font-weight:500;cursor:pointer;display:flex;align-items:center;gap:6px;box-shadow:0 4px 12px rgba(15,23,42,0.15);">
                    <i data-lucide="plus" style="width:16px;height:16px;"></i>
                    Tambah User
                </button>
            </div>
        </div>

        {{-- Flash --}}
        @if(session('success'))
            <div
                style="margin-bottom:18px;padding:10px 14px;border-radius:12px;background:#ecfdf5;border:1px solid #bbf7d0;color:#166534;font-size:13px;">
                <i data-lucide="check-circle" style="width:16px;height:16px;margin-bottom:-3px;margin-right:6px;"></i>
                {{ session('success') }}
            </div>
        @endif

        {{-- Table Card --}}
        <div style="background:#fff;border-radius:12px;padding:0;border:1px solid rgba(2,6,23,0.04);
                            box-shadow:0 6px 20px rgba(2,6,23,0.03);overflow:hidden;">
            <div style="overflow:auto;">
                <table style="width:100%;border-collapse:collapse;font-size:13px;">
                    <thead style="background:#f8fafc;border-bottom:1px solid rgba(148,163,184,0.4);color:#475569;">
                        <tr>
                            <th style="padding:12px 18px;text-align:left;font-weight:600;">No</th>
                            <th style="padding:12px 18px;text-align:left;font-weight:600;">Nama</th>
                            <th style="padding:12px 18px;text-align:left;font-weight:600;">Username</th>
                            <th style="padding:12px 18px;text-align:left;font-weight:600;"></th>Email</th>
                            <th style="padding:12px 18px;text-align:left;font-weight:600;">Role</th>
                            <th style="padding:12px 18px;text-align:right;font-weight:600;">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($users as $i => $user)
                            <tr style="border-bottom:1px solid rgba(241,245,249,1);transition:background 0.2s;"
                                onmouseover="this.style.background='#f8fafc'" onmouseout="this.style.background='transparent'">
                                <td style="padding:10px 18px;color:#64748b;">{{ $users->firstItem() + $i }}</td>
                                <td style="padding:10px 18px;font-weight:500;color:#0f172a;">
                                    {{ $user->name }}
                                    @if($user->warga)
                                        <div
                                            style="font-size:11px;color:#64748b;font-weight:400;margin-top:2px;display:flex;align-items:center;gap:4px;">
                                            <i data-lucide="link" style="width:10px;height:10px;"></i> {{ $user->warga->nama }}
                                        </div>
                                    @endif
                                </td>
                                <td style="padding:10px 18px;color:#64748b;">{{ $user->username }}</td>
                                <td style="padding:10px 18px;color:#64748b;">{{ $user->email }}</td>
                                <td style="padding:10px 18px;">
                                    @php
                                        $roleName = $user->role?->name;
                                        $roleLabel = $user->role?->label ?? 'No Role';
                                        $bg = '#f1f5f9';
                                        $fg = '#64748b'; // default
                                        if ($roleName == 'admin') {
                                            $bg = '#fee2e2';
                                            $fg = '#991b1b';
                                        } elseif ($roleName == 'ketua_rt') {
                                            $bg = '#e0f2fe';
                                            $fg = '#075985';
                                        } elseif ($roleName == 'bendahara') {
                                            $bg = '#dcfce7';
                                            $fg = '#166534';
                                        } elseif ($roleName == 'warga') {
                                            $bg = '#fef9c3';
                                            $fg = '#854d0e';
                                        }
                                    @endphp
                                    <span
                                        style="padding:3px 10px;border-radius:999px;font-size:11px;font-weight:600;background:{{$bg}};color:{{$fg}}">
                                        {{ $roleLabel }}
                                    </span>
                                </td>
                                <td style="padding:10px 18px;text-align:right;">
                                    <div style="display:flex;justify-content:flex-end;gap:6px;">
                                        <button class="btn-edit-role" data-id="{{ $user->id }}" data-name="{{ $user->name }}"
                                            data-role-id="{{ $user->role_id }}" data-warga-id="{{ $user->warga_id }}"
                                            style="padding:6px 10px;border-radius:8px;background:#f1f5f9;color:#475569;border:none;font-size:12px;font-weight:500;cursor:pointer;display:inline-flex;align-items:center;gap:4px;">
                                            <i data-lucide="edit-3" style="width:12px;height:12px;"></i> Edit
                                        </button>
                                        <form action="{{ route('administrasi.users.destroy', $user->id) }}" method="POST"
                                            onsubmit="return confirm('Hapus user ini?');" style="margin:0">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit"
                                                style="padding:6px 10px;border-radius:8px;background:#fef2f2;color:#ef4444;border:none;font-size:12px;font-weight:500;cursor:pointer;display:inline-flex;align-items:center;gap:4px;">
                                                <i data-lucide="trash-2" style="width:12px;height:12px;"></i> Hapus
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" style="padding:40px;text-align:center;color:#6b7280;">
                                    <div style="margin-bottom:10px;display:flex;justify-content:center;">
                                        <i data-lucide="users" style="width:32px;height:32px;color:#e2e8f0;"></i>
                                    </div>
                                    Tidak ada data pengguna.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <div style="margin-top:20px">
            {{ $users->links() }}
        </div>
    </div>

    {{-- MODAL CREATE USER --}}
    <div id="createUserModal" class="hidden"
        style="position:fixed;inset:0;background:rgba(15,23,42,0.4);backdrop-filter:blur(2px);display:flex;align-items:center;justify-content:center;z-index:50">
        <div
            style="background:white;padding:24px;border-radius:16px;width:100%;max-width:440px;box-shadow:0 20px 25px -5px rgba(0,0,0,0.1)">
            <h3 style="margin-top:0;margin-bottom:20px;font-size:18px;font-weight:700;color:#0f172a">Tambah User Baru</h3>

            <form method="POST" action="{{ route('administrasi.users.store') }}">
                @csrf

                <div style="margin-bottom:16px">
                    <label style="display:block;margin-bottom:6px;font-size:13px;font-weight:600;color:#475569">Hubungkan
                        Warga</label>
                    <select name="warga_id" required
                        style="width:100%;padding:10px;border-radius:8px;border:1px solid #e2e8f0;font-size:14px;background:#f8fafc;outline:none">
                        <option value="">-- Pilih Warga --</option>
                        @foreach($wargas as $w)
                            <option value="{{ $w->id }}">{{ $w->nama }} ({{ $w->nik }})</option>
                        @endforeach
                    </select>
                    <p style="margin:4px 0 0 0;font-size:11px;color:#64748b">Nama akan otomatis diambil dari data
                        warga.</p>
                </div>

                <div style="margin-bottom:16px">
                    <label
                        style="display:block;margin-bottom:6px;font-size:13px;font-weight:600;color:#475569">Username</label>
                    <input type="text" name="username" required
                        style="width:100%;padding:10px;border-radius:8px;border:1px solid #e2e8f0;font-size:14px;outline:none">
                </div>

                <div style="margin-bottom:16px">
                    <label
                        style="display:block;margin-bottom:6px;font-size:13px;font-weight:600;color:#475569">Email</label>
                    <input type="email" name="email" required
                        style="width:100%;padding:10px;border-radius:8px;border:1px solid #e2e8f0;font-size:14px;outline:none">
                </div>

                <div style="margin-bottom:16px">
                    <label
                        style="display:block;margin-bottom:6px;font-size:13px;font-weight:600;color:#475569">Password</label>
                    <input type="password" name="password" required minlength="6"
                        style="width:100%;padding:10px;border-radius:8px;border:1px solid #e2e8f0;font-size:14px;outline:none">
                </div>

                <div style="margin-bottom:24px">
                    <label style="display:block;margin-bottom:6px;font-size:13px;font-weight:600;color:#475569">Role
                        Akses</label>
                    <select name="role_id" required
                        style="width:100%;padding:10px;border-radius:8px;border:1px solid #e2e8f0;font-size:14px;background:#f8fafc;outline:none">
                        @foreach($roles as $role)
                            <option value="{{ $role->id }}">{{ $role->label }}</option>
                        @endforeach
                    </select>
                </div>

                <div style="display:flex;justify-content:flex-end;gap:12px">
                    <button type="button" id="closeCreateModal"
                        style="padding:10px 16px;border-radius:8px;background:white;border:1px solid #cbd5e1;color:#475569;font-weight:600;cursor:pointer">Batal</button>
                    <button type="submit"
                        style="padding:10px 24px;border-radius:8px;background:#0f172a;color:white;border:none;font-weight:600;cursor:pointer">Simpan</button>
                </div>
            </form>
        </div>
    </div>

    {{-- MODAL EDIT ROLE --}}
    <div id="editRoleModal" class="hidden"
        style="position:fixed;inset:0;background:rgba(15,23,42,0.4);backdrop-filter:blur(2px);display:flex;align-items:center;justify-content:center;z-index:50">
        <div
            style="background:white;padding:24px;border-radius:16px;width:100%;max-width:400px;box-shadow:0 20px 25px -5px rgba(0,0,0,0.1)">
            <h3 style="margin-top:0;margin-bottom:8px;font-size:18px;font-weight:700;color:#0f172a">Edit User</h3>
            <p id="editModalName" style="margin:0 0 20px 0;font-size:13px;color:#64748b;font-weight:500">Target User</p>

            <form id="editRoleForm" method="POST">
                @csrf
                @method('PUT')

                <div style="margin-bottom:16px">
                    <label style="display:block;margin-bottom:6px;font-size:13px;font-weight:600;color:#475569">Warga
                        Terhubung</label>
                    <select name="warga_id" id="editWargaId"
                        style="width:100%;padding:10px;border-radius:8px;border:1px solid #e2e8f0;font-size:14px;background:#f8fafc;outline:none">
                        <option value="">-- Tidak Terhubung --</option>
                        @foreach($wargas as $w)
                            <option value="{{ $w->id }}">{{ $w->nama }}</option>
                        @endforeach
                    </select>
                </div>

                <div style="margin-bottom:24px">
                    <label style="display:block;margin-bottom:6px;font-size:13px;font-weight:600;color:#475569">Role
                        Akses</label>
                    <select name="role_id" id="editRoleId" required
                        style="width:100%;padding:10px;border-radius:8px;border:1px solid #e2e8f0;font-size:14px;background:#f8fafc;outline:none">
                        @foreach($roles as $role)
                            <option value="{{ $role->id }}">{{ $role->label }}</option>
                        @endforeach
                    </select>
                </div>

                <div style="display:flex;justify-content:flex-end;gap:12px">
                    <button type="button" id="closeEditModal"
                        style="padding:10px 16px;border-radius:8px;background:white;border:1px solid #cbd5e1;color:#475569;font-weight:600;cursor:pointer">Batal</button>
                    <button type="submit"
                        style="padding:10px 24px;border-radius:8px;background:#0f172a;color:white;border:none;font-weight:600;cursor:pointer">Simpan
                        Perubahan</button>
                </div>
            </form>
        </div>
    </div>

    <script>
        // Create Modal
        const createModal = document.getElementById('createUserModal');
        document.getElementById('btnCreateUser').onclick = () => createModal.classList.remove('hidden');
        document.getElementById('closeCreateModal').onclick = () => createModal.classList.add('hidden');

        // Edit Modal
        const editModal = document.getElementById('editRoleModal');
        const editForm = document.getElementById('editRoleForm');
        const editName = document.getElementById('editModalName');
        const editRole = document.getElementById('editRoleId');
        const editWarga = document.getElementById('editWargaId');

        document.querySelectorAll('.btn-edit-role').forEach(btn => {
            btn.onclick = () => {
                const id = btn.dataset.id;
                const name = btn.dataset.name;
                const roleId = btn.dataset.roleId;
                const wargaId = btn.dataset.wargaId;

                editForm.action = "{{ url('administrasi/users') }}/" + id;
                editName.innerText = name;
                editRole.value = roleId;
                editWarga.value = wargaId;

                editModal.classList.remove('hidden');
            };
        });

        document.getElementById('closeEditModal').onclick = () => editModal.classList.add('hidden');

        // Close on click outside
        window.onclick = (e) => {
            if (e.target === createModal) createModal.classList.add('hidden');
            if (e.target === editModal) editModal.classList.add('hidden');
        }
    </script>
@endsection