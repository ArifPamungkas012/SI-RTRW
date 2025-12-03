<?php

namespace App\Http\Controllers\Keuangan;

use App\Http\Controllers\Controller;
use App\Models\IuranTemplate;
use Illuminate\Http\Request;

class IuranTemplateController extends Controller
{
    public function index(Request $request)
    {
        $q = $request->q;

        $templates = IuranTemplate::when($q, function ($query) use ($q) {
            $query->where('nama', 'like', "%$q%")
                ->orWhere('jenis', 'like', "%$q%");
        })
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('Keuangan.template.index', compact('templates'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'jenis' => 'required|string|max:100',
            'nominal_default' => 'required|numeric|min:0',
            'keterangan' => 'nullable|string',
        ]);

        IuranTemplate::create($request->all());

        return back()->with('success', 'Template iuran berhasil ditambahkan.');
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'jenis' => 'required|string|max:100',
            'nominal_default' => 'required|numeric|min:0',
            'keterangan' => 'nullable|string',
        ]);

        $template = IuranTemplate::findOrFail($id);
        $template->update($request->all());

        return back()->with('success', 'Template iuran berhasil diperbarui.');
    }

    public function destroy($id)
    {
        IuranTemplate::findOrFail($id)->delete();
        return back()->with('success', 'Template berhasil dihapus.');
    }

    public function restore($id)
    {
        IuranTemplate::withTrashed()->findOrFail($id)->restore();
        return back()->with('success', 'Template berhasil dipulihkan.');
    }
}
