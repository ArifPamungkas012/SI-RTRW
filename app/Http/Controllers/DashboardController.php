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
        $totalWarga     = Warga::count();
        $kkCount        = KartuKeluarga::count();

        // kegiatan aktif (misalnya status = 'active')
        $activeEvents   = Kegiatan::where('status', 'active')->count();

        // kegiatan mendatang (tanggal >= hari ini)
        $upcomingEvents = Kegiatan::whereDate('tanggal', '>=', now())
                            ->orderBy('tanggal', 'asc')
                            ->limit(5)
                            ->get()
                            ->map(function ($item) {
                                return [
                                    'title' => $item->nama,
                                    'date'  => $item->tanggal?->format('d M Y'),
                                    'time'  => $item->waktu,
                                    'place' => $item->lokasi,
                                ];
                            });

        return view('dashboard.index', [
            'totalWarga'      => $totalWarga,
            'kkCount'         => $kkCount,
            'activeEvents'    => $activeEvents,
            'upcomingEvents'  => $upcomingEvents,
        ]);
    }
}
