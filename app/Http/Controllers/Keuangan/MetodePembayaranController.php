<?php

namespace App\Http\Controllers\Keuangan;

use App\Http\Controllers\Controller;
use App\Models\MetodePembayaran;
use Illuminate\Http\Request;

class MetodePembayaranController extends Controller
{
    /**
     * List metode pembayaran
     */
    public function index(Request $request)
    {
        $q = $request->input('q');
        $active = $request->input('active'); // 1 / 0 / null

        $query = MetodePembayaran::query()
            ->when($q, function ($qb) use ($q) {
                $qb->where('nama', 'like', "%{$q}%")
                    ->orWhere('deskripsi', 'like', "%{$q}%");
            })
            ->when(
                $active !== null && $active !== '',
                fn($qb) => $qb->where('is_active', (bool) $active)
            )
            ->orderBy('is_active', 'desc')
            ->orderBy('nama');

        $metodes = $query->paginate(15)->withQueryString();

        return view('keuangan.metode.index', [
            'metodes' => $metodes,
            'filterSearch' => $q,
            'filterActive' => $active,
        ]);
    }

    /**
     * Simpan metode baru
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama' => ['required', 'string', 'max:100'],
            'deskripsi' => ['nullable', 'string', 'max:500'],
            'is_active' => ['nullable', 'boolean'],
        ]);

        $validated['is_active'] = $request->has('is_active');

        MetodePembayaran::create($validated);

        return redirect()
            ->route('keuangan.metode.index')
            ->with('success', 'Metode pembayaran berhasil ditambahkan.');
    }

    /**
     * Update metode
     */
    public function update(Request $request, MetodePembayaran $metode)
    {
        $validated = $request->validate([
            'nama' => ['required', 'string', 'max:100'],
            'deskripsi' => ['nullable', 'string', 'max:500'],
            'is_active' => ['nullable', 'boolean'],
        ]);

        $validated['is_active'] = $request->has('is_active');

        $metode->update($validated);

        return redirect()
            ->route('keuangan.metode.index')
            ->with('success', 'Metode pembayaran berhasil diperbarui.');
    }

    /**
     * Soft delete
     */
    public function destroy(MetodePembayaran $metode)
    {
        $metode->delete();

        return redirect()
            ->route('keuangan.metode.index')
            ->with('success', 'Metode pembayaran berhasil dihapus.');
    }

    /**
     * Restore soft delete
     */
    public function restore($id)
    {
        $metode = MetodePembayaran::withTrashed()->findOrFail($id);
        $metode->restore();

        return redirect()
            ->route('keuangan.metode.index')
            ->with('success', 'Metode pembayaran berhasil dipulihkan.');
    }
}
