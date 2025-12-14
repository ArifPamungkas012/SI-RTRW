<?php

namespace App\Http\Controllers\Laporan;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Kegiatan;
use PDF;

class LaporanKegiatanController extends Controller
{
    public function index(Request $request)
    {
        $startDate = $request->query('start_date');
        $endDate = $request->query('end_date');
        $jenis = $request->query('jenis');
        $perPage = $request->query('per_page', 15);

        $query = Kegiatan::query()->with('penanggungJawab')->orderByDesc('tanggal');

        if ($startDate) {
            $query->whereDate('tanggal', '>=', $startDate);
        }

        if ($endDate) {
            $query->whereDate('tanggal', '<=', $endDate);
        }

        if ($jenis) {
            $query->where('jenis', 'like', "%{$jenis}%");
        }

        $activities = $query->paginate($perPage)->withQueryString();

        // Get distinct types for filter dropdown if needed, or free text. 
        // For simplicity and performance, we might just let user type or use existing distinct values.
        $types = Kegiatan::select('jenis')->distinct()->pluck('jenis');

        return view('laporan.kegiatan.index', compact('activities', 'startDate', 'endDate', 'jenis', 'types'));
    }

    public function exportPdf(Request $request)
    {
        $startDate = $request->query('start_date');
        $endDate = $request->query('end_date');
        $jenis = $request->query('jenis');

        $query = Kegiatan::query()->with('penanggungJawab')->orderByDesc('tanggal');

        if ($startDate) {
            $query->whereDate('tanggal', '>=', $startDate);
        }

        if ($endDate) {
            $query->whereDate('tanggal', '<=', $endDate);
        }

        if ($jenis) {
            $query->where('jenis', 'like', "%{$jenis}%");
        }

        $activities = $query->get();
        $filters = $request->only(['start_date', 'end_date', 'jenis']);

        $pdf = PDF::loadView('laporan.kegiatan.pdf', compact('activities', 'filters'))
            ->setPaper('a4', 'portrait');

        return $pdf->download('laporan-kegiatan-' . now()->format('Ymd_His') . '.pdf');
    }

    public function exportExcel(Request $request)
    {
        return redirect()->back()->with('error', 'Export Excel belum tersedia.');
    }
}
