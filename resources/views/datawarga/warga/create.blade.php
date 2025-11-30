@extends('layouts.app')

@section('title', 'Tambah Warga')

@section('content')
    <div class="max-w-3xl mx-auto p-4">

        <h1 class="text-xl font-semibold text-gray-900 mb-4">Tambah Warga Baru</h1>

        <a href="{{ route('datawarga.warga.index') }}" class="text-sm text-blue-600 mb-4 inline-block">
            ← Kembali ke Daftar Warga
        </a>

        {{-- Flash message --}}
        @if(session('error'))
            <div class="mb-4 p-3 bg-red-50 border border-red-200 text-red-700 rounded">
                {{ session('error') }}
            </div>
        @endif

        <form action="{{ route('datawarga.warga.store') }}" method="POST"
            class="space-y-4 bg-white border rounded p-6 shadow-sm">
            @csrf

            <div>
                <label class="block text-sm font-medium mb-1">NIK</label>
                <input name="nik" value="{{ old('nik') }}" required class="w-full border rounded px-3 py-2 text-sm"
                    placeholder="Masukkan NIK">
                @error('nik')
                    <p class="text-red-600 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label class="block text-sm font-medium mb-1">Nama Lengkap</label>
                <input name="nama" value="{{ old('nama') }}" required class="w-full border rounded px-3 py-2 text-sm"
                    placeholder="Masukkan nama lengkap">
                @error('nama')
                    <p class="text-red-600 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label class="block text-sm font-medium mb-1">Alamat</label>
                <textarea name="alamat" rows="2" class="w-full border rounded px-3 py-2 text-sm"
                    placeholder="Alamat domisili">{{ old('alamat') }}</textarea>
                @error('alamat')
                    <p class="text-red-600 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="grid grid-cols-3 gap-4">
                <div>
                    <label class="block text-sm font-medium mb-1">No Rumah</label>
                    <input name="no_rumah" value="{{ old('no_rumah') }}" class="w-full border rounded px-3 py-2 text-sm">
                </div>

                <div>
                    <label class="block text-sm font-medium mb-1">RT</label>
                    <input name="rt" value="{{ old('rt') }}" class="w-full border rounded px-3 py-2 text-sm">
                </div>

                <div>
                    <label class="block text-sm font-medium mb-1">RW</label>
                    <input name="rw" value="{{ old('rw') }}" class="w-full border rounded px-3 py-2 text-sm">
                </div>
            </div>

            <div>
                <label class="block text-sm font-medium mb-1">No HP</label>
                <input name="no_hp" value="{{ old('no_hp') }}" class="w-full border rounded px-3 py-2 text-sm"
                    placeholder="Contoh: 08123456789">
                @error('no_hp')
                    <p class="text-red-600 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label class="block text-sm font-medium mb-1">Tanggal Lahir</label>
                <input type="date" name="tanggal_lahir" value="{{ old('tanggal_lahir') }}"
                    class="w-full border rounded px-3 py-2 text-sm">
            </div>

            <div>
                <label class="block text-sm font-medium mb-1">Status Aktif</label>
                <select name="status_aktif" class="w-full border rounded px-3 py-2 text-sm">
                    <option value="1" {{ old('status_aktif') == '1' ? 'selected' : '' }}>Aktif</option>
                    <option value="0" {{ old('status_aktif') == '0' ? 'selected' : '' }}>Tidak Aktif</option>
                </select>
            </div>

            <div class="pt-2">
                <button class="bg-gray-800 text-white px-5 py-2 rounded text-sm">
                    Simpan Data
                </button>
            </div>

        </form>
    </div>
@endsection