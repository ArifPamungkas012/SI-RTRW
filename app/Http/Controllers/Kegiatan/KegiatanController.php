<?php

namespace App\Http\Controllers\Kegiatan;


use App\Http\Controllers\Controller;
use App\Models\Kegiatan;
use App\Models\User;
use Illuminate\Http\Request;

class KegiatanController extends Controller
{
    public function index(Request $request)
    {
        $q = $request->q;

        $kegiatans = Kegiatan::when($q, function ($query) use ($q) {
            $query->where('nama', 'like', "%$q%")
                ->orWhere('jenis', 'like', "%$q%");
        })
            ->orderBy('tanggal', 'desc')
            ->paginate(10);

        $users = User::select('id', 'name')->get();

        return view('kegiatan.index', compact('kegiatans', 'users'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'jenis' => 'required|string|max:100',
            'tanggal' => 'required|date',
            'waktu' => 'nullable',
            'lokasi' => 'nullable|string',
            'keterangan' => 'nullable|string',
            'penanggung_jawab_user_id' => 'nullable|exists:users,id'
        ]);

        Kegiatan::create($request->all());

        return back()->with('success', 'Kegiatan berhasil ditambahkan.');
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'jenis' => 'required|string|max:100',
            'tanggal' => 'required|date',
            'waktu' => 'nullable',
            'lokasi' => 'nullable|string',
            'keterangan' => 'nullable|string',
            'penanggung_jawab_user_id' => 'nullable|exists:users,id'
        ]);

        $kegiatan = Kegiatan::findOrFail($id);
        $kegiatan->update($request->all());

        return back()->with('success', 'Data kegiatan diperbarui.');
    }

    public function destroy($id)
    {
        Kegiatan::findOrFail($id)->delete();
        return back()->with('success', 'Kegiatan berhasil dihapus.');
    }

    public function restore($id)
    {
        Kegiatan::withTrashed()->findOrFail($id)->restore();
        return back()->with('success', 'Kegiatan berhasil dipulihkan.');
    }
}
