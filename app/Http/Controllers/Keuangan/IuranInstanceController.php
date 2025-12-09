<?php

namespace App\Http\Controllers\Keuangan;

use App\Http\Controllers\Controller;
use App\Models\IuranInstance;
use App\Models\IuranTemplate;
use Illuminate\Http\Request;

class IuranInstanceController extends Controller
{
    public function index(Request $request)
    {
        $q = $request->q;
        $status = $request->status;
        $periode = $request->periode;

        $instances = IuranInstance::with(['template', 'pembayaran'])
            ->when($q, function ($query) use ($q) {
                $query->whereHas('template', function ($q2) use ($q) {
                    $q2->where('nama', 'like', "%{$q}%")
                        ->orWhere('jenis', 'like', "%{$q}%");
                });
            })
            ->when($status, function ($query) use ($status) {
                $query->where('status', $status);
            })
            ->when($periode, function ($query) use ($periode) {
                $query->where('periode', $periode);
            })
            ->orderBy('periode', 'desc')
            ->orderBy('due_date', 'asc')
            ->paginate(10)
            ->appends($request->only(['q', 'status', 'periode'])); // supaya paginasi tetap bawa filter

        $templates = IuranTemplate::orderBy('nama')->get();

        // ⛔ sebelumnya: view('Keuangan.iuran.index')
        // ✅ sesuaikan dengan folder Blade: resources/views/keuangan/iuran/instance/index.blade.php
        return view('keuangan.iuran.index', compact(
            'instances',
            'templates',
            'q',
            'status',
            'periode'
        ));

    }

    public function store(Request $request)
    {
        $request->validate([
            'template_id' => 'required|exists:iuran_templates,id',
            'periode' => 'required|string|max:20', // contoh: 2025-01
            'due_date' => 'required|date',
            'nominal' => 'required|numeric|min:0',
            'status' => 'required|string|max:50',
        ]);

        IuranInstance::create($request->only([
            'template_id',
            'periode',
            'due_date',
            'nominal',
            'status',
        ]));

        return back()->with('success', 'Iuran periode baru berhasil dibuat.');
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|string|max:50',
            'nominal' => 'nullable|numeric|min:0',
        ]);

        $instance = IuranInstance::findOrFail($id);

        $data = $request->only(['status', 'nominal']);
        // buang nilai null supaya tidak menimpa dengan null
        $data = array_filter($data, fn($v) => !is_null($v));

        $instance->update($data);

        return back()->with('success', 'Data iuran berhasil diperbarui.');
    }

    public function destroy($id)
    {
        IuranInstance::findOrFail($id)->delete();

        return back()->with('success', 'Iuran periode ini telah dihapus.');
    }

    public function restore($id)
    {
        IuranInstance::withTrashed()->findOrFail($id)->restore();

        return back()->with('success', 'Iuran periode ini telah dipulihkan.');
    }
}
