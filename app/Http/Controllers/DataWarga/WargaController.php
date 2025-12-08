<?php

namespace App\Http\Controllers\DataWarga;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Warga;
use Illuminate\Validation\Rule;

class WargaController extends Controller
{
    public function index(Request $request)
    {
        // optional: support search & pagination
        $q = $request->query('q');
        $perPage = $request->query('per_page', 15);

        $query = Warga::query()->latest();

        if ($q) {
            $query->where(function ($s) use ($q) {
                $s->where('nama', 'like', "%{$q}%")
                    ->orWhere('nik', 'like', "%{$q}%")
                    ->orWhere('no_hp', 'like', "%{$q}%")
                    ->orWhere('alamat', 'like', "%{$q}%");
            });
        }

        $wargas = $query->paginate($perPage)->withQueryString();

        return view('datawarga.warga.index', compact('wargas', 'q'));
    }

    // JSON endpoint untuk AJAX datatable
    public function indexJson(Request $request)
    {
        $q = $request->query('q');
        $query = Warga::query()->latest();

        if ($q) {
            $query->where('nama', 'like', "%{$q}%")
                ->orWhere('nik', 'like', "%{$q}%");
        }

        $data = $query->paginate($request->get('per_page', 15));
        return response()->json($data);
    }

    public function create()
    {
        return view('datawarga.warga.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'nik' => ['required', 'digits_between:8,20', 'unique:warga,nik'],
            'nama' => 'required|string|max:191',
            'alamat' => 'nullable|string',
            'no_rumah' => 'nullable|string|max:50',
            'rt' => 'nullable|string|max:10',
            'rw' => 'nullable|string|max:10',
            'no_hp' => 'nullable|string|max:30',
            'tanggal_lahir' => 'nullable|date',
            'status_aktif' => ['nullable', Rule::in([0, 1])],
        ]);

        $warga = Warga::create($data);

        return redirect()->route('datawarga.warga.index')
            ->with('success', "Warga \"{$warga->nama}\" berhasil ditambahkan.");
    }

    public function show(Warga $warga)
    {
        $warga->load('anggotaKK', 'pembayaran', 'userAccount');
        return view('datawarga.warga.show', compact('warga'));
    }

    public function detail(Warga $warga)
    {
        // load relasi yang dibutuhkan
        $warga->load('anggotaKK', 'pembayaran', 'userAccount');

        return response()->json([
            'id' => $warga->id,
            'nik' => $warga->nik,
            'nama' => $warga->nama,
            'alamat' => $warga->alamat,
            'no_rumah' => $warga->no_rumah,
            'rt' => $warga->rt,
            'rw' => $warga->rw,
            'no_hp' => $warga->no_hp,
            'tanggal_lahir' => $warga->tanggal_lahir?->format('Y-m-d'),
            'status_aktif' => (bool) $warga->status_aktif,

            'relasi' => [
                'jumlah_anggota_kk' => $warga->anggotaKK->count(),
                'total_pembayaran' => $warga->pembayaran->count(),
                'user' => $warga->userAccount?->only(['id', 'name', 'email']),
            ],
        ]);
    }


    public function edit(Warga $warga)
    {
        return view('datawarga.warga.edit', compact('warga'));
    }

    public function update(Request $request, Warga $warga)
    {
        $data = $request->validate([
            'nik' => ['required', 'digits_between:8,20', Rule::unique('warga', 'nik')->ignore($warga->id)],
            'nama' => 'required|string|max:191',
            'alamat' => 'nullable|string',
            'no_rumah' => 'nullable|string|max:50',
            'rt' => 'nullable|string|max:10',
            'rw' => 'nullable|string|max:10',
            'no_hp' => 'nullable|string|max:30',
            'tanggal_lahir' => 'nullable|date',
            'status_aktif' => ['nullable', Rule::in([0, 1])],
        ]);

        $warga->update($data);

        return redirect()->route('datawarga.warga.index')
            ->with('success', "Data warga \"{$warga->nama}\" berhasil diperbarui.");
    }

    public function destroy(Warga $warga)
    {
        $warga->delete(); // soft delete
        return redirect()->route('datawarga.warga.index')->with('success', 'Warga telah dihapus.');
    }

    // restore soft-deleted
    public function restore($id)
    {
        $warga = Warga::withTrashed()->findOrFail($id);
        $warga->restore();
        return redirect()->route('datawarga.warga.index')->with('success', 'Warga dipulihkan.');
    }

}
