<?php

namespace App\Http\Controllers\DataWarga;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\KartuKeluarga;
use App\Models\AnggotaKK;
use Illuminate\Validation\Rule;

class KartuKeluargaController extends Controller
{
    public function index(Request $request)
    {
        $q = $request->query('q');
        $perPage = $request->query('per_page', 15);

        $query = KartuKeluarga::query()->latest();

        if ($q) {
            $query->where('no_kk', 'like', "%{$q}%")
                ->orWhere('kepala_keluarga', 'like', "%{$q}%")
                ->orWhere('alamat', 'like', "%{$q}%");
        }

        $kks = $query->paginate($perPage)->withQueryString();
        return view('datawarga.kk.index', compact('kks', 'q'));
    }

    public function create()
    {
        return view('datawarga.kk.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'no_kk' => ['required', 'string', 'max:50', 'unique:kartu_keluarga,no_kk'],
            'alamat' => 'nullable|string',
            'rt' => 'nullable|string|max:10',
            'rw' => 'nullable|string|max:10',
            'kepala_keluarga' => 'nullable|string|max:191',
            'tanggal_dibuat' => 'nullable|date',
        ]);

        $kk = KartuKeluarga::create($data);

        return redirect()->route('datawarga.kk.show', $kk->id)
            ->with('success', 'Kartu Keluarga berhasil dibuat.');
    }

    public function show(KartuKeluarga $kk)
    {
        $kk->load('anggota.warga');
        return view('datawarga.kk.show', compact('kk'));
    }

    public function edit(KartuKeluarga $kk)
    {
        return view('datawarga.kk.edit', compact('kk'));
    }

    public function update(Request $request, KartuKeluarga $kk)
    {
        $data = $request->validate([
            'no_kk' => ['required', 'string', 'max:50', Rule::unique('kartu_keluarga', 'no_kk')->ignore($kk->id)],
            'alamat' => 'nullable|string',
            'rt' => 'nullable|string|max:10',
            'rw' => 'nullable|string|max:10',
            'kepala_keluarga' => 'nullable|string|max:191',
            'tanggal_dibuat' => 'nullable|date',
        ]);

        $kk->update($data);

        return redirect()->route('datawarga.kk.show', $kk->id)
            ->with('success', 'Data KK diperbarui.');
    }

    public function destroy(KartuKeluarga $kk)
    {
        $kk->delete();
        return redirect()->route('datawarga.kk.index')->with('success', 'KK dihapus.');
    }
}
