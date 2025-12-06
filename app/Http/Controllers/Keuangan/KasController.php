<?php

namespace App\Http\Controllers\Keuangan;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Kas; // pastikan model ini ada

class KasController extends Controller
{
    /**
     * Tampilkan daftar kas RT/RW
     */
    public function index(Request $request)
    {
        $q = $request->get('q');

        $kas = Kas::query()
            ->when($q, function ($query) use ($q) {
                $query->where('kategori', 'like', "%{$q}%")
                    ->orWhere('keterangan', 'like', "%{$q}%");
            })
            ->orderBy('tanggal', 'desc')
            ->orderBy('id', 'desc')
            ->paginate(10)
            ->withQueryString();

        return view('keuangan.kas.index', compact('kas', 'q'));
    }

    /**
     * Simpan transaksi kas baru
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'tanggal' => ['required', 'date'],
            'tipe' => ['required', 'in:masuk,keluar'],
            'kategori' => ['required', 'string', 'max:100'],
            'nominal' => ['required', 'numeric', 'min:0'],
            'keterangan' => ['nullable', 'string'],
        ]);

        Kas::create($data);

        return redirect()
            ->route('keuangan.kas.index')
            ->with('success', 'Transaksi kas berhasil disimpan.');
    }

    /**
     * Hapus transaksi kas
     */
    public function destroy(Kas $kas)
    {
        $kas->delete();

        return redirect()
            ->route('keuangan.kas.index')
            ->with('success', 'Transaksi kas berhasil dihapus.');
    }
}
