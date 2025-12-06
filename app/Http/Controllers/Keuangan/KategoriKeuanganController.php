<?php

namespace App\Http\Controllers\Keuangan;

use App\Http\Controllers\Controller;
use App\Models\KategoriKeuangan;
use Illuminate\Http\Request;

class KategoriKeuanganController extends Controller
{
    /**
     * List kategori keuangan
     */
    public function index(Request $request)
    {
        $tipe = $request->input('tipe');   // masuk / keluar
        $q = $request->input('q');      // search nama/kode/deskripsi

        $query = KategoriKeuangan::query()
            ->when($tipe, fn($qBuilder) => $qBuilder->where('tipe', $tipe))
            ->when($q, function ($qBuilder) use ($q) {
                $qBuilder->where(function ($sub) use ($q) {
                    $sub->where('nama', 'like', "%{$q}%")
                        ->orWhere('kode', 'like', "%{$q}%")
                        ->orWhere('deskripsi', 'like', "%{$q}%");
                });
            })
            ->orderBy('tipe')
            ->orderBy('nama');

        $kategoris = $query->paginate(15)->withQueryString();

        return view('keuangan.kategori.index', [
            'kategoris' => $kategoris,
            'filterTipe' => $tipe,
            'filterSearch' => $q,
        ]);
    }

    /**
     * Simpan kategori baru
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama' => ['required', 'string', 'max:100'],
            'tipe' => ['required', 'in:masuk,keluar'],
            'kode' => ['nullable', 'string', 'max:20'],
            'deskripsi' => ['nullable', 'string', 'max:500'],
            'is_active' => ['nullable', 'boolean'],
        ]);

        $validated['is_active'] = $request->has('is_active');

        KategoriKeuangan::create($validated);

        return redirect()
            ->route('keuangan.kategori.index')
            ->with('success', 'Kategori keuangan berhasil ditambahkan.');
    }

    /**
     * Update kategori
     */
    public function update(Request $request, KategoriKeuangan $kategori)
    {
        $validated = $request->validate([
            'nama' => ['required', 'string', 'max:100'],
            'tipe' => ['required', 'in:masuk,keluar'],
            'kode' => ['nullable', 'string', 'max:20'],
            'deskripsi' => ['nullable', 'string', 'max:500'],
            'is_active' => ['nullable', 'boolean'],
        ]);

        $validated['is_active'] = $request->has('is_active');

        $kategori->update($validated);

        return redirect()
            ->route('keuangan.kategori.index')
            ->with('success', 'Kategori keuangan berhasil diperbarui.');
    }

    /**
     * Soft delete
     */
    public function destroy(KategoriKeuangan $kategori)
    {
        $kategori->delete();

        return redirect()
            ->route('keuangan.kategori.index')
            ->with('success', 'Kategori keuangan berhasil dihapus.');
    }

    /**
     * Restore soft delete
     */
    public function restore($id)
    {
        $kategori = KategoriKeuangan::withTrashed()->findOrFail($id);
        $kategori->restore();

        return redirect()
            ->route('keuangan.kategori.index')
            ->with('success', 'Kategori keuangan berhasil dipulihkan.');
    }
}
