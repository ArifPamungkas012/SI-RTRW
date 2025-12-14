<?php

namespace App\Http\Controllers;

use App\Models\Warga;
use App\Models\KartuKeluarga;
use App\Models\Kegiatan;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $totalWarga = Warga::count();
        $kkCount = KartuKeluarga::count();

        // Financial Data
        $kasMasuk = \App\Models\Kas::where('tipe', 'masuk')->sum('nominal');
        $kasKeluar = \App\Models\Kas::where('tipe', 'keluar')->sum('nominal');
        $saldoKas = $kasMasuk - $kasKeluar;

        // Financial Change this Month
        $monthMasuk = \App\Models\Kas::where('tipe', 'masuk')
            ->whereMonth('tanggal', now()->month)
            ->whereYear('tanggal', now()->year)
            ->sum('nominal');
        $monthKeluar = \App\Models\Kas::where('tipe', 'keluar')
            ->whereMonth('tanggal', now()->month)
            ->whereYear('tanggal', now()->year)
            ->sum('nominal');
        $mutasiBulanIni = $monthMasuk - $monthKeluar;

        // Warga growth this month (simple approximation: created_at)
        $wargaBaruBulanIni = Warga::whereMonth('created_at', now()->month)
            ->whereYear('created_at', now()->year)
            ->count();

        // Chart Data (Monthly Income/Expense for Current Year)
        $monthlyIncome = array_fill(1, 12, 0);
        $monthlyExpense = array_fill(1, 12, 0);

        $kasData = \App\Models\Kas::selectRaw('MONTH(tanggal) as month, tipe, SUM(nominal) as total')
            ->whereYear('tanggal', now()->year)
            ->groupBy('month', 'tipe')
            ->get();

        foreach ($kasData as $data) {
            if ($data->tipe == 'masuk') {
                $monthlyIncome[$data->month] = $data->total;
            } else {
                $monthlyExpense[$data->month] = $data->total;
            }
        }

        // Iuran Progress Data (Latest 3 Instances)
        $latestIuran = \App\Models\IuranInstance::withCount('pembayaran')
            ->orderBy('id', 'desc')
            ->take(3)
            ->get()
            ->map(function ($item) use ($totalWarga) {
                return [
                    'id' => $item->id,
                    'title' => $item->template ? $item->template->nama : $item->periode,
                    'periode' => $item->periode,
                    'due_date' => $item->due_date ? $item->due_date->format('d M Y') : '-',
                    'paid' => $item->pembayaran_count,
                    'total' => $totalWarga, // Assuming all warga are targets
                    'percentage' => $totalWarga > 0 ? round(($item->pembayaran_count / $totalWarga) * 100) : 0,
                    'status' => $item->status
                ];
            });

        // kegiatan aktif (misalnya status = 'active')
        $activeEvents = Kegiatan::where('status', 'active')->count();

        // kegiatan mendatang (tanggal >= hari ini)
        $upcomingEvents = Kegiatan::whereDate('tanggal', '>=', now())
            ->orderBy('tanggal', 'asc')
            ->take(6)
            ->get();

        return view('dashboard.index', compact(
            'totalWarga',
            'kkCount',
            'saldoKas',
            'mutasiBulanIni',
            'wargaBaruBulanIni',
            'activeEvents',
            'upcomingEvents',
            'monthlyIncome',
            'monthlyExpense',
            'latestIuran'
        ));
    }
}
