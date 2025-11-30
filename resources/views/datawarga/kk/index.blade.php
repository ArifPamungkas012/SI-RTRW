{{-- resources/views/datawarga/kk/index.blade.php --}}
@extends('layouts.app')

@section('title', 'Daftar Kartu Keluarga')

@section('content')
    <div class="max-w-7xl mx-auto p-4">
        <div class="flex items-center justify-between mb-4">
            <div>
                <h1 class="text-lg font-semibold text-gray-900">Daftar Kartu Keluarga</h1>
                <p class="text-sm text-gray-500">Kelola data Kartu Keluarga (KK)</p>
            </div>

            <div class="flex items-center gap-3">
                <form method="GET" action="{{ route('datawarga.kk.index') }}" class="flex items-center gap-2">
                    <input name="q" value="{{ request('q') }}" placeholder="Cari no KK / kepala keluarga..."
                        class="border rounded px-3 py-2 text-sm" />
                    <button type="submit" class="px-3 py-2 bg-slate-800 text-white rounded text-sm">Cari</button>
                </form>

                <a href="{{ route('datawarga.kk.create') }}"
                    class="px-3 py-2 bg-green-600 text-white rounded text-sm">Tambah KK</a>
            </div>
        </div>

        {{-- Flash messages --}}
        @if(session('success'))
            <div class="mb-4 p-3 bg-green-50 border border-green-200 text-green-800 rounded">
                {{ session('success') }}
            </div>
        @endif

        <div class="bg-white border rounded shadow-sm overflow-x-auto">
            <table class="min-w-full text-sm">
                <thead class="bg-gray-50 text-gray-700">
                    <tr>
                        <th class="px-4 py-3 text-left">#</th>
                        <th class="px-4 py-3 text-left">No. KK</th>
                        <th class="px-4 py-3 text-left">Kepala Keluarga</th>
                        <th class="px-4 py-3 text-left">Alamat</th>
                        <th class="px-4 py-3 text-left">RT / RW</th>
                        <th class="px-4 py-3 text-left">Tanggal Dibuat</th>
                        <th class="px-4 py-3 text-left">Anggota</th>
                        <th class="px-4 py-3 text-left">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y">
                    @forelse($kks as $index => $kk)
                        <tr>
                            <td class="px-4 py-3 whitespace-nowrap">{{ $kks->firstItem() + $index }}</td>
                            <td class="px-4 py-3 whitespace-nowrap">{{ $kk->no_kk }}</td>
                            <td class="px-4 py-3 whitespace-nowrap">{{ $kk->kepala_keluarga }}</td>
                            <td class="px-4 py-3 whitespace-nowrap">{{ \Illuminate\Support\Str::limit($kk->alamat, 50) }}</td>
                            <td class="px-4 py-3 whitespace-nowrap">{{ $kk->rt }} / {{ $kk->rw }}</td>
                            <td class="px-4 py-3 whitespace-nowrap">{{ optional($kk->tanggal_dibuat)->format('Y-m-d') ?? '-' }}
                            </td>
                            <td class="px-4 py-3 whitespace-nowrap">
                                {{-- tampilkan jumlah anggota (relasi 'anggota' harus eager-loaded di controller) --}}
                                {{ $kk->anggota->count() ?? 0 }} orang
                            </td>
                            <td class="px-4 py-3 whitespace-nowrap">
                                <div class="flex items-center gap-2">
                                    <a href="{{ route('datawarga.kk.show', $kk->id) }}"
                                        class="px-2 py-1 border rounded text-xs">Lihat</a>
                                    <a href="{{ route('datawarga.kk.edit', $kk->id) }}"
                                        class="px-2 py-1 border rounded text-xs">Edit</a>

                                    <form action="{{ route('datawarga.kk.destroy', $kk->id) }}" method="POST"
                                        onsubmit="return confirm('Hapus KK ini?')" class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                            class="px-2 py-1 border rounded text-xs text-red-600">Hapus</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="px-4 py-6 text-center text-gray-500">Belum ada data Kartu Keluarga.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="mt-4 flex items-center justify-between">
            <div class="text-sm text-gray-500">
                Menampilkan {{ $kks->firstItem() ?? 0 }} - {{ $kks->lastItem() ?? 0 }} dari {{ $kks->total() ?? 0 }} data
            </div>

            <div>
                {{ $kks->withQueryString()->links() }}
            </div>
        </div>
    </div>
@endsection