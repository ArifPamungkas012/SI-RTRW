@extends('layouts.app')

@section('title', 'Profil Saya')

@section('content')
    <div class="content">
        <div style="margin-bottom:20px;">
            <h1 style="font-size:22px;font-weight:700;color:#0f172a;margin:0;">Profil Saya</h1>
            <p style="margin:6px 0 0 0;font-size:13px;color:rgba(15,23,42,0.6)">
                Kelola informasi akun dan data diri Anda.
            </p>
        </div>

        @if(session('success'))
            <div
                style="margin-bottom:18px;padding:10px 14px;border-radius:12px;background:#ecfdf5;border:1px solid #bbf7d0;color:#166534;display:flex;align-items:center;gap:8px;font-size:13px;">
                <i data-lucide="check-circle" style="width:18px;height:18px;"></i>
                {{ session('success') }}
            </div>
        @endif

        <div style="display:grid;grid-template-columns:1fr 1fr;gap:24px;align-items:start;">

            {{-- INFORMASI AKUN (Editable) --}}
            <div
                style="background:white;border-radius:12px;box-shadow:0 6px 20px rgba(2,6,23,0.03);border:1px solid rgba(2,6,23,0.04);padding:24px;">
                <div
                    style="display:flex;align-items:center;gap:12px;margin-bottom:20px;padding-bottom:16px;border-bottom:1px solid #f1f5f9;">
                    <div
                        style="width:40px;height:40px;border-radius:50%;background:#f1f5f9;display:flex;align-items:center;justify-content:center;font-weight:700;color:#64748b;">
                        {{ substr($user->name, 0, 1) }}
                    </div>
                    <div>
                        <h2 style="margin:0;font-size:16px;font-weight:700;color:#0f172a;">Informasi Akun</h2>
                        <p style="margin:2px 0 0;font-size:12px;color:#64748b;">Update nama dan email login.</p>
                    </div>
                </div>

                <form action="{{ route('account.profile.update') }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div style="display:flex;flex-direction:column;gap:16px;">
                        <div>
                            <label
                                style="display:block;font-size:13px;font-weight:600;color:#0f172a;margin-bottom:6px;">Nama
                                Lengkap</label>
                            <input name="name" value="{{ old('name', $user->name) }}" required
                                style="width:100%;padding:10px 14px;border-radius:10px;border:1px solid #e2e8f0;font-size:13px;outline:none;transition:border-color .15s"
                                onfocus="this.style.borderColor='#10b981'" onblur="this.style.borderColor='#e2e8f0'">
                            @error('name')
                                <p style="color:#ef4444;font-size:12px;margin-top:4px;">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label
                                style="display:block;font-size:13px;font-weight:600;color:#0f172a;margin-bottom:6px;">Email
                                Address</label>
                            <input type="email" name="email" value="{{ old('email', $user->email) }}" required
                                style="width:100%;padding:10px 14px;border-radius:10px;border:1px solid #e2e8f0;font-size:13px;outline:none;transition:border-color .15s"
                                onfocus="this.style.borderColor='#10b981'" onblur="this.style.borderColor='#e2e8f0'">
                            @error('email')
                                <p style="color:#ef4444;font-size:12px;margin-top:4px;">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label
                                style="display:block;font-size:13px;font-weight:600;color:#0f172a;margin-bottom:6px;">Role</label>
                            <div
                                style="padding:10px 14px;border-radius:10px;background:#f8fafc;border:1px solid #e2e8f0;color:#64748b;font-size:13px;">
                                {{ $user->role->label ?? $user->role->name ?? 'User' }}
                            </div>
                        </div>
                    </div>

                    <div style="margin-top:24px;display:flex;justify-content:flex-end;">
                        <button type="submit"
                            style="padding:10px 20px;border-radius:10px;background:#0f172a;color:white;border:none;font-weight:600;font-size:13px;cursor:pointer;box-shadow:0 4px 12px rgba(15,23,42,0.15);">
                            Simpan Perubahan
                        </button>
                    </div>
                </form>
            </div>

            {{-- DATA WARGA TERKAIT (Read Only) --}}
            @if($user->warga)
                <div
                    style="background:white;border-radius:12px;box-shadow:0 6px 20px rgba(2,6,23,0.03);border:1px solid rgba(2,6,23,0.04);padding:24px;">
                    <div
                        style="display:flex;align-items:center;gap:12px;margin-bottom:20px;padding-bottom:16px;border-bottom:1px solid #f1f5f9;">
                        <div
                            style="width:40px;height:40px;border-radius:50%;background:#dcfce7;display:flex;align-items:center;justify-content:center;color:#166534;">
                            <i data-lucide="info" style="width:20px;height:20px;"></i>
                        </div>
                        <div>
                            <h2 style="margin:0;font-size:16px;font-weight:700;color:#0f172a;">Data Warga Terkait</h2>
                            <p style="margin:2px 0 0;font-size:12px;color:#64748b;">Data kependudukan Anda.</p>
                        </div>
                    </div>

                    <div style="display:flex;flex-direction:column;gap:14px;">
                        <div
                            style="display:flex;justify-content:space-between;border-bottom:1px solid #f8fafc;padding-bottom:8px;">
                            <span style="font-size:13px;color:#64748b;">NIK</span>
                            <span style="font-size:13px;font-weight:600;color:#0f172a;">{{ $user->warga->nik }}</span>
                        </div>
                        <div
                            style="display:flex;justify-content:space-between;border-bottom:1px solid #f8fafc;padding-bottom:8px;">
                            <span style="font-size:13px;color:#64748b;">No. KK</span>
                            <span
                                style="font-size:13px;font-weight:600;color:#0f172a;">{{ $user->warga->kk->no_kk ?? '-' }}</span>
                        </div>
                        <div
                            style="display:flex;justify-content:space-between;border-bottom:1px solid #f8fafc;padding-bottom:8px;">
                            <span style="font-size:13px;color:#64748b;">Jenis Kelamin</span>
                            <span style="font-size:13px;font-weight:600;color:#0f172a;">{{ $user->warga->jenis_kelamin }}</span>
                        </div>
                        <div
                            style="display:flex;justify-content:space-between;border-bottom:1px solid #f8fafc;padding-bottom:8px;">
                            <span style="font-size:13px;color:#64748b;">Tempat, Tanggal Lahir</span>
                            <span
                                style="font-size:13px;font-weight:600;color:#0f172a;text-align:right;">{{ $user->warga->tempat_lahir }},
                                {{ \Carbon\Carbon::parse($user->warga->tanggal_lahir)->format('d M Y') }}</span>
                        </div>
                        <div
                            style="display:flex;justify-content:space-between;border-bottom:1px solid #f8fafc;padding-bottom:8px;">
                            <span style="font-size:13px;color:#64748b;">Status Pernikahan</span>
                            <span
                                style="font-size:13px;font-weight:600;color:#0f172a;">{{ $user->warga->status_pernikahan }}</span>
                        </div>
                        <div>
                            <span style="font-size:13px;color:#64748b;display:block;margin-bottom:4px;">Alamat</span>
                            <span
                                style="font-size:13px;font-weight:600;color:#0f172a;line-height:1.4;">{{ $user->warga->alamat }}</span>
                        </div>
                    </div>

                    <div
                        style="margin-top:20px;padding:12px;background:#fffbeb;border:1px solid #fcd34d;border-radius:10px;font-size:12px;color:#92400e;">
                        <i data-lucide="alert-triangle"
                            style="width:14px;height:14px;vertical-align:text-bottom;margin-right:4px;"></i>
                        Jika ada kesalahan pada data warga, silakan hubungi Admin atau Ketua RT.
                    </div>
                </div>
            @endif

        </div>
    </div>
@endsection