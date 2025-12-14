@extends('layouts.app')

@section('title', 'Pengaturan Akun')

@section('content')
    <div class="content">
        <div style="margin-bottom:20px;">
            <h1 style="font-size:22px;font-weight:700;color:#0f172a;margin:0;">Pengaturan Akun</h1>
            <p style="margin:6px 0 0 0;font-size:13px;color:rgba(15,23,42,0.6)">
                Kelola keamanan password dan preferensi akun.
            </p>
        </div>

        @if(session('success'))
            <div
                style="margin-bottom:18px;padding:10px 14px;border-radius:12px;background:#ecfdf5;border:1px solid #bbf7d0;color:#166534;display:flex;align-items:center;gap:8px;font-size:13px;">
                <i data-lucide="check-circle" style="width:18px;height:18px;"></i>
                {{ session('success') }}
            </div>
        @endif

        @if($errors->any())
            <div
                style="margin-bottom:18px;padding:10px 14px;border-radius:12px;background:#fef2f2;border:1px solid #fecaca;color:#b91c1c;display:flex;align-items:center;gap:8px;font-size:13px;">
                <i data-lucide="alert-circle" style="width:18px;height:18px;"></i>
                Terjadi kesalahan, periksa input password Anda.
            </div>
        @endif

        <div style="max-width:600px;">
            <div
                style="background:white;border-radius:12px;box-shadow:0 6px 20px rgba(2,6,23,0.03);border:1px solid rgba(2,6,23,0.04);padding:24px;">
                <div
                    style="display:flex;align-items:center;gap:12px;margin-bottom:20px;padding-bottom:16px;border-bottom:1px solid #f1f5f9;">
                    <div
                        style="width:40px;height:40px;border-radius:50%;background:#fee2e2;display:flex;align-items:center;justify-content:center;color:#b91c1c;">
                        <i data-lucide="lock" style="width:20px;height:20px;"></i>
                    </div>
                    <div>
                        <h2 style="margin:0;font-size:16px;font-weight:700;color:#0f172a;">Ganti Password</h2>
                        <p style="margin:2px 0 0;font-size:12px;color:#64748b;">Pastikan menggunakan password yang aman.</p>
                    </div>
                </div>

                <form action="{{ route('account.settings.password') }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div style="display:flex;flex-direction:column;gap:16px;">
                        <div>
                            <label
                                style="display:block;font-size:13px;font-weight:600;color:#0f172a;margin-bottom:6px;">Password
                                Saat Ini</label>
                            <input type="password" name="current_password" required
                                style="width:100%;padding:10px 14px;border-radius:10px;border:1px solid #e2e8f0;font-size:13px;outline:none;"
                                placeholder="Masukkan password lama">
                            @error('current_password')
                                <p style="color:#ef4444;font-size:12px;margin-top:4px;">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label
                                style="display:block;font-size:13px;font-weight:600;color:#0f172a;margin-bottom:6px;">Password
                                Baru</label>
                            <input type="password" name="password" required
                                style="width:100%;padding:10px 14px;border-radius:10px;border:1px solid #e2e8f0;font-size:13px;outline:none;"
                                placeholder="Minimal 8 karakter">
                            @error('password')
                                <p style="color:#ef4444;font-size:12px;margin-top:4px;">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label
                                style="display:block;font-size:13px;font-weight:600;color:#0f172a;margin-bottom:6px;">Konfirmasi
                                Password Baru</label>
                            <input type="password" name="password_confirmation" required
                                style="width:100%;padding:10px 14px;border-radius:10px;border:1px solid #e2e8f0;font-size:13px;outline:none;"
                                placeholder="Ulangi password baru">
                        </div>
                    </div>

                    <div style="margin-top:24px;display:flex;justify-content:flex-end;">
                        <button type="submit"
                            style="padding:10px 20px;border-radius:10px;background:#0f172a;color:white;border:none;font-weight:600;font-size:13px;cursor:pointer;box-shadow:0 4px 12px rgba(15,23,42,0.15);">
                            Update Password
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection