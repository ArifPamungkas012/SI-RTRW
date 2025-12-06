<?php

namespace App\Http\Controllers\Keuangan;

use App\Http\Controllers\Controller;
use App\Models\Kas;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PengeluaranController extends Controller
{
    /**
     * Daftar pengeluaran (Kas tipe = keluar)
     */
    public function index(Request $request)
    {
        $search = $request->input('search');
        $tanggalFrom = $request->input('tanggal_from');
        $tanggalTo = $request->input('tanggal_to');

        $query = Kas::where('tipe', 'keluar')
            ->when($search, function ($q) use ($search) {
                $q->where('kategori', 'like', "%{$search}%")
                    ->orWhere('keterangan', 'like', "%{$search}%");
            })
            ->when($tanggalFrom, function ($q) use ($tanggalFrom) {
                $q->whereDate('tanggal', '>=', $tanggalFrom);
            })
            ->when($tanggalTo, function ($q) use ($tanggalTo) {
                $q->whereDate('tanggal', '<=', $tanggalTo);
            })
            ->orderByDesc('tanggal')
            ->orderByDesc('id');

        $pengeluaran = $query->paginate(15)->withQueryString();

        return view('keuangan.pengeluaran.index', [
            'pengeluaran' => $pengeluaran,
            'filterSearch' => $search,
            'filterFrom' => $tanggalFrom,
            'filterTo' => $tanggalTo,
        ]);
    }

    /**
     * Simpan pengeluaran baru (Kas tipe = keluar)
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'tanggal' => ['required', 'date'],
            'kategori' => ['nullable', 'string', 'max:100'],
            'nominal' => ['required', 'numeric', 'min:0'],
            'keterangan' => ['nullable', 'string', 'max:500'],
        ]);

        $validated['tipe'] = 'keluar';
        $validated['recorded_by'] = Auth::id();

        Kas::create($validated);

        return redirect()
            ->route('keuangan.pengeluaran.index')
            ->with('success', 'Pengeluaran berhasil dicatat.');
    }

    /**
     * Hapus (soft delete) pengeluaran.
     */
    public function destroy(Kas $kas)
    {
        // pastikan hanya pengeluaran yang bisa dihapus lewat modul ini
        if ($kas->tipe !== 'keluar') {
            return redirect()
                ->route('keuangan.pengeluaran.index')
                ->with('error', 'Data yang dipilih bukan pengeluaran.');
        }

        $kas->delete();

        return redirect()
            ->route('keuangan.pengeluaran.index')
            ->with('success', 'Pengeluaran berhasil dihapus.');
    }
}
