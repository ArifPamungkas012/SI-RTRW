<?php

namespace App\Http\Controllers\DataWarga;

use App\Http\Controllers\Controller;
use App\Models\MutasiWarga;
use App\Models\Warga;
use Illuminate\Http\Request;

class MutasiWargaController extends Controller
{
    /**
     * Tampilkan daftar mutasi warga.
     */
    public function index(Request $request)
    {
        $jenis = $request->input('jenis');
        $search = $request->input('search');

        $mutasiQuery = MutasiWarga::with('warga')
            ->when($jenis, fn($q) => $q->where('jenis', $jenis))
            ->when($search, function ($q) use ($search) {
                $q->whereHas('warga', function ($qw) use ($search) {
                    $qw->where('nama', 'like', "%{$search}%")
                        ->orWhere('nik', 'like', "%{$search}%")
                        ->orWhere('no_rumah', 'like', "%{$search}%");
                });
            })
            ->orderByDesc('tanggal')
            ->orderByDesc('id');

        $mutasi = $mutasiQuery->paginate(15)->withQueryString();
        $wargaList = Warga::orderBy('nama')->get();

        return view('datawarga.mutasi.index', [
            'mutasi' => $mutasi,
            'wargaList' => $wargaList,
            'filterJenis' => $jenis,
            'filterSearch' => $search,
        ]);
    }

    /**
     * Simpan data mutasi baru.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'warga_id' => ['required', 'exists:warga,id'],
            'jenis' => ['required', 'in:masuk,keluar,pindah_rt,pindah_rw'],
            'tanggal' => ['required', 'date'],
            'keterangan' => ['nullable', 'string'],
        ]);

        MutasiWarga::create($validated);

        return redirect()
            ->route('datawarga.mutasi.index')
            ->with('success', 'Data mutasi warga berhasil disimpan.');
    }

    /**
     * Hapus data mutasi.
     */
    public function destroy(MutasiWarga $mutasi)
    {
        $mutasi->delete();

        return redirect()
            ->route('datawarga.mutasi.index')
            ->with('success', 'Data mutasi warga berhasil dihapus.');
    }
}
