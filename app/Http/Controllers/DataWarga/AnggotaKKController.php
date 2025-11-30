<?php

namespace App\Http\Controllers\DataWarga;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\AnggotaKK;
use App\Models\KartuKeluarga;
use App\Models\Warga;

class AnggotaKKController extends Controller
{
    /**
     * Tambah anggota ke KK
     */
    public function store(Request $request, $kkId)
    {
        $kk = KartuKeluarga::findOrFail($kkId);

        $data = $request->validate([
            'warga_id' => 'required|exists:warga,id',
            'hubungan' => 'nullable|string|max:100',
        ]);

        // hindari duplikasi anggota
        $exists = AnggotaKK::where('kk_id', $kk->id)
            ->where('warga_id', $data['warga_id'])
            ->exists();

        if ($exists) {
            return back()->with('warning', 'Warga sudah terdaftar dalam KK ini.');
        }

        AnggotaKK::create([
            'kk_id' => $kk->id,
            'warga_id' => $data['warga_id'],
            'hubungan' => $data['hubungan'] ?? null,
        ]);

        return back()->with('success', 'Anggota berhasil ditambahkan.');
    }

    /**
     * Hapus anggota dari KK
     */
    public function destroy($kkId, $anggotaId)
    {
        $anggota = AnggotaKK::where('kk_id', $kkId)->where('id', $anggotaId)->firstOrFail();
        $anggota->delete();
        return back()->with('success', 'Anggota dihapus dari KK.');
    }
}
