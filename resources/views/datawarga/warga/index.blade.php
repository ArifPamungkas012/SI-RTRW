{{-- resources/views/datawarga/warga/index.blade.php --}}
@extends('layouts.app')

@section('title', 'Daftar Warga')

@section('content')
    <div class="max-w-7xl mx-auto p-4">
        <div class="flex items-center justify-between mb-4">
            <div>
                <h1 class="text-lg font-semibold text-gray-900">Daftar Warga</h1>
                <p class="text-sm text-gray-500">Kelola data penduduk RT / RW</p>
            </div>

            <div class="flex items-center gap-3">
                <form method="GET" action="{{ route('datawarga.warga.index') }}" class="flex items-center gap-2">
                    <input name="q" value="{{ request('q') }}" placeholder="Cari nama / NIK..."
                        class="border rounded px-3 py-2 text-sm" />
                    <button type="submit" class="px-3 py-2 bg-slate-800 text-white rounded text-sm">Cari</button>
                </form>

                <a href="{{ route('datawarga.warga.create') }}"
                    class="px-3 py-2 bg-green-600 text-white rounded text-sm">Tambah Warga</a>
            </div>
        </div>

        {{-- Flash messages --}}
        @if(session('success'))
            <div class="mb-4 p-3 bg-green-50 border border-green-200 text-green-800 rounded">
                {{ session('success') }}
            </div>
        @endif
        @if(session('warning'))
            <div class="mb-4 p-3 bg-yellow-50 border border-yellow-200 text-yellow-800 rounded">
                {{ session('warning') }}
            </div>
        @endif

        <div class="bg-white border rounded shadow-sm overflow-x-auto">
            <table class="min-w-full text-sm">
                <thead class="bg-gray-50 text-gray-700">
                    <tr>
                        <th class="px-4 py-3 text-left">#</th>
                        <th class="px-4 py-3 text-left">NIK</th>
                        <th class="px-4 py-3 text-left">Nama</th>
                        <th class="px-4 py-3 text-left">Alamat</th>
                        <th class="px-4 py-3 text-left">RT / RW</th>
                        <th class="px-4 py-3 text-left">No Rumah</th>
                        <th class="px-4 py-3 text-left">No HP</th>
                        <th class="px-4 py-3 text-left">Status</th>
                        <th class="px-4 py-3 text-left">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y">
                    @forelse($wargas as $index => $warga)
                        <tr>
                            <td class="px-4 py-3 whitespace-nowrap">{{ $wargas->firstItem() + $index }}</td>
                            <td class="px-4 py-3 whitespace-nowrap">{{ $warga->nik }}</td>
                            <td class="px-4 py-3 whitespace-nowrap">{{ $warga->nama }}</td>
                            <td class="px-4 py-3 whitespace-nowrap">{{ \Illuminate\Support\Str::limit($warga->alamat, 40) }}
                            </td>
                            <td class="px-4 py-3 whitespace-nowrap">{{ $warga->rt }} / {{ $warga->rw }}</td>
                            <td class="px-4 py-3 whitespace-nowrap">{{ $warga->no_rumah }}</td>
                            <td class="px-4 py-3 whitespace-nowrap">{{ $warga->no_hp }}</td>
                            <td class="px-4 py-3 whitespace-nowrap">
                                @if($warga->status_aktif)
                                    <span class="inline-block px-2 py-0.5 text-xs bg-green-100 text-green-800 rounded">Aktif</span>
                                @else
                                    <span class="inline-block px-2 py-0.5 text-xs bg-gray-100 text-gray-700 rounded">Tidak
                                        Aktif</span>
                                @endif
                            </td>
                            <td class="px-4 py-3 whitespace-nowrap">
                                <div class="flex items-center gap-2">
                                    <a href="{{ route('datawarga.warga.show', $warga->id) }}"
                                        class="px-2 py-1 border rounded text-xs">Lihat</a>
                                    <a href="{{ route('datawarga.warga.edit', $warga->id) }}"
                                        class="px-2 py-1 border rounded text-xs">Edit</a>

                                    <form action="{{ route('datawarga.warga.destroy', $warga->id) }}" method="POST"
                                        onsubmit="return confirm('Hapus warga ini?')" class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                            class="px-2 py-1 border rounded text-xs text-red-600">Hapus</button>
                                    </form>

                                    @if($warga->trashed())
                                        <form action="{{ route('datawarga.warga.restore', $warga->id) }}" method="POST"
                                            class="inline">
                                            @csrf
                                            <button type="submit"
                                                class="px-2 py-1 border rounded text-xs text-green-600">Pulihkan</button>
                                        </form>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="9" class="px-4 py-6 text-center text-gray-500">Belum ada data warga.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="mt-4 flex items-center justify-between">
            <div class="text-sm text-gray-500">
                Menampilkan {{ $wargas->firstItem() ?? 0 }} - {{ $wargas->lastItem() ?? 0 }} dari
                {{ $wargas->total() ?? 0 }} data
            </div>

            <div>
                {{ $wargas->withQueryString()->links() }}
            </div>
        </div>
    </div>
@endsection