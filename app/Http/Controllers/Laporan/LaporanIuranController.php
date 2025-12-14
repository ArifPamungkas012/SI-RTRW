<?php

namespace App\Http\Controllers\Laporan;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Pembayaran;
use PDF;

class LaporanIuranController extends Controller
{
    public function index(Request $request)
    {
        $startDate = $request->query('start_date');
        $endDate = $request->query('end_date');
        $status = $request->query('status');
        $perPage = $request->query('per_page', 15);

        $query = Pembayaran::query()
            ->with(['warga', 'instance.template', 'metodePembayaran', 'pencatat'])
            ->orderByDesc('tanggal_bayar');

        if ($startDate) {
            $query->whereDate('tanggal_bayar', '>=', $startDate);
        }

        if ($endDate) {
            $query->whereDate('tanggal_bayar', '<=', $endDate);
        }

        if ($status) {
            $query->where('status_verifikasi', $status);
        }

        $payments = $query->paginate($perPage)->withQueryString();

        return view('laporan.iuran.index', compact('payments', 'startDate', 'endDate', 'status'));
    }

    public function exportPdf(Request $request)
    {
        $startDate = $request->query('start_date');
        $endDate = $request->query('end_date');
        $status = $request->query('status');

        $query = Pembayaran::query()
            ->with(['warga', 'instance.template', 'metodePembayaran', 'pencatat'])
            ->orderByDesc('tanggal_bayar');

        if ($startDate) {
            $query->whereDate('tanggal_bayar', '>=', $startDate);
        }

        if ($endDate) {
            $query->whereDate('tanggal_bayar', '<=', $endDate);
        }

        if ($status) {
            $query->where('status_verifikasi', $status);
        }

        $payments = $query->get();
        $filters = $request->only(['start_date', 'end_date', 'status']);

        $pdf = PDF::loadView('laporan.iuran.pdf', compact('payments', 'filters'))
            ->setPaper('a4', 'landscape'); // Landscape might be better for table with many columns

        return $pdf->download('laporan-iuran-' . now()->format('Ymd_His') . '.pdf');
    }

    public function exportExcel(Request $request)
    {
        return redirect()->back()->with('error', 'Export Excel belum tersedia.');
    }
}
