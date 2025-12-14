<?php

namespace App\Http\Controllers\Laporan;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Warga;
use App\Exports\WargaExport;
use Maatwebsite\Excel\Facades\Excel;
use PDF;

class LaporanWargaController extends Controller
{
    public function index(Request $request)
    {
        $q = $request->query('q');
        $rt = $request->query('rt');
        $rw = $request->query('rw');
        $status = $request->query('status');
        $perPage = $request->query('per_page', 15);

        $query = Warga::query()->orderBy('nama');

        if ($q) {
            $query->where(function ($s) use ($q) {
                $s->where('nama', 'like', "%{$q}%")
                    ->orWhere('nik', 'like', "%{$q}%");
            });
        }

        if ($rt !== null && $rt !== '')
            $query->where('rt', $rt);
        if ($rw !== null && $rw !== '')
            $query->where('rw', $rw);
        if ($status === '1' || $status === '0')
            $query->where('status_aktif', $status);

        $wargas = $query->paginate($perPage)->withQueryString();

        $rts = Warga::select('rt')->whereNotNull('rt')->distinct()->pluck('rt');
        $rws = Warga::select('rw')->whereNotNull('rw')->distinct()->pluck('rw');

        return view('laporan.warga.index', compact('wargas', 'rts', 'rws', 'q', 'rt', 'rw', 'status'));
    }

    public function exportPdf(Request $request)
    {
        $query = Warga::query()->orderBy('nama');

        if ($q = $request->query('q')) {
            $query->where(function ($s) use ($q) {
                $s->where('nama', 'like', "%{$q}%")
                    ->orWhere('nik', 'like', "%{$q}%");
            });
        }

        if ($rt = $request->query('rt'))
            $query->where('rt', $rt);
        if ($rw = $request->query('rw'))
            $query->where('rw', $rw);
        if (($st = $request->query('status')) === '1' || $st === '0')
            $query->where('status_aktif', $st);

        $wargas = $query->get();

        $filters = $request->only(['q', 'rt', 'rw', 'status']);

        $pdf = PDF::loadView('laporan.warga.pdf', compact('wargas', 'filters'))
            ->setPaper('a4', 'portrait');

        return $pdf->download('laporan-warga-' . now()->format('Ymd_His') . '.pdf');
    }

    public function exportExcel(Request $request)
    {
        $filters = $request->only(['q', 'rt', 'rw', 'status']);
        return Excel::download(new WargaExport($filters), 'laporan-warga-' . now()->format('Ymd_His') . '.xlsx');
    }
}
