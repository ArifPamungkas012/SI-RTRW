<?php

namespace App\Http\Controllers\Laporan;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\MutasiWarga;
use PDF;

class LaporanMutasiWargaController extends Controller
{
    public function index(Request $request)
    {
        $startDate = $request->query('start_date');
        $endDate = $request->query('end_date');
        $jenis = $request->query('jenis');
        $perPage = $request->query('per_page', 15);

        $query = MutasiWarga::query()
            ->with('warga')
            ->orderByDesc('tanggal')
            ->orderByDesc('id');

        if ($startDate) {
            $query->whereDate('tanggal', '>=', $startDate);
        }

        if ($endDate) {
            $query->whereDate('tanggal', '<=', $endDate);
        }

        if ($jenis) {
            $query->where('jenis', $jenis);
        }

        $mutations = $query->paginate($perPage)->withQueryString();

        return view('laporan.mutasi.index', compact('mutations', 'startDate', 'endDate', 'jenis'));
    }

    public function exportPdf(Request $request)
    {
        $startDate = $request->query('start_date');
        $endDate = $request->query('end_date');
        $jenis = $request->query('jenis');

        $query = MutasiWarga::query()
            ->with('warga')
            ->orderByDesc('tanggal')
            ->orderByDesc('id');

        if ($startDate) {
            $query->whereDate('tanggal', '>=', $startDate);
        }

        if ($endDate) {
            $query->whereDate('tanggal', '<=', $endDate);
        }

        if ($jenis) {
            $query->where('jenis', $jenis);
        }

        $mutations = $query->get();
        $filters = $request->only(['start_date', 'end_date', 'jenis']);

        $pdf = PDF::loadView('laporan.mutasi.pdf', compact('mutations', 'filters'))
            ->setPaper('a4', 'portrait');

        return $pdf->download('laporan-mutasi-' . now()->format('Ymd_His') . '.pdf');
    }

    public function exportExcel(Request $request)
    {
        return redirect()->back()->with('error', 'Export Excel belum tersedia.');
    }
}
