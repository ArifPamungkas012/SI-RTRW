<?php

namespace App\Http\Controllers\DataWarga;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\KartuKeluarga;
use App\Models\AnggotaKK;
use App\Models\Warga;
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

        // daftar warga aktif untuk dropdown "Anggota KK" di modal tambah KK
        $wargas = Warga::where('status_aktif', 1)
            ->orderBy('nama')
            ->get();

        return view('datawarga.kk.index', compact('kks', 'q', 'wargas'));
    }

    public function create()
    {
        return view('datawarga.kk.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            // field KK
            'no_kk' => ['required', 'string', 'max:50', 'unique:kartu_keluarga,no_kk'],
            'alamat' => 'nullable|string',
            'rt' => 'nullable|string|max:10',
            'rw' => 'nullable|string|max:10',
            'kepala_keluarga' => 'nullable|string|max:191',
            'tanggal_dibuat' => 'nullable|date',

            // field anggota (banyak baris)
            'anggota' => ['nullable', 'array'],
            'anggota.*.warga_id' => ['nullable', 'exists:warga,id'],
            'anggota.*.hubungan' => ['nullable', 'string', 'max:50'],
        ]);

        // ambil hanya field KK
        $kkData = collect($validated)->only([
            'no_kk',
            'alamat',
            'rt',
            'rw',
            'kepala_keluarga',
            'tanggal_dibuat',
        ])->toArray();

        // BUAT KK
        $kk = KartuKeluarga::create($kkData);

        // BUAT BANYAK ANGGOTA (jika ada)
        if (!empty($validated['anggota'])) {
            foreach ($validated['anggota'] as $row) {
                if (!empty($row['warga_id'])) {
                    AnggotaKK::create([
                        'kk_id' => $kk->id,
                        'warga_id' => $row['warga_id'],
                        'hubungan' => $row['hubungan'] ?: null,
                    ]);
                }
            }
        }

        return redirect()->route('datawarga.kk.show', $kk->id)
            ->with('success', 'Kartu Keluarga berhasil dibuat.');
    }


    public function show(KartuKeluarga $kk)
    {
        $kk->load('anggota.warga');
        return view('datawarga.kk.show', compact('kk'));
    }

    public function detail(KartuKeluarga $kk)
    {
        $kk->load('anggota.warga');

        return response()->json([
            'id' => $kk->id,
            'no_kk' => $kk->no_kk,
            'kepala_keluarga' => $kk->kepala_keluarga,
            'alamat' => $kk->alamat,
            'rt' => $kk->rt,
            'rw' => $kk->rw,
            'tanggal_dibuat' => $kk->tanggal_dibuat?->format('Y-m-d'),
            'jumlah_anggota' => $kk->anggota->count(),

            'anggota' => $kk->anggota->map(function ($a, $idx) {
                return [
                    'no' => $idx + 1,
                    'id' => $a->id,
                    'nama' => $a->warga->nama ?? null,
                    'nik' => $a->warga->nik ?? null,
                    'hubungan' => $a->hubungan ?? null,
                    'keterangan' => $a->keterangan ?? null,
                ];
            })->values(),
        ]);
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
