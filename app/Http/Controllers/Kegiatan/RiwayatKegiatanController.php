<?php

namespace App\Http\Controllers\Kegiatan;

use App\Http\Controllers\Controller;
use App\Models\Kegiatan;
use Illuminate\Http\Request;
use Carbon\Carbon;

class RiwayatKegiatanController extends Controller
{
    /**
     * Tampilkan riwayat kegiatan (lampau, akan datang, termasuk yang dihapus).
     */
    public function index(Request $request)
    {
        $status = $request->input('status'); // all, past, upcoming, deleted
        $search = $request->input('q');
        $today = Carbon::today()->toDateString();

        $query = Kegiatan::with(['penanggungJawab'])
            ->withTrashed()
            ->when($search, function ($qBuilder) use ($search) {
                $qBuilder->where(function ($sub) use ($search) {
                    $sub->where('nama', 'like', "%{$search}%")
                        ->orWhere('jenis', 'like', "%{$search}%")
                        ->orWhere('lokasi', 'like', "%{$search}%");
                });
            })
            ->when($status === 'past', function ($qBuilder) use ($today) {
                $qBuilder->whereDate('tanggal', '<', $today)
                    ->whereNull('deleted_at');
            })
            ->when($status === 'upcoming', function ($qBuilder) use ($today) {
                $qBuilder->whereDate('tanggal', '>=', $today)
                    ->whereNull('deleted_at');
            })
            ->when($status === 'deleted', function ($qBuilder) {
                $qBuilder->onlyTrashed();
            })
            ->orderByDesc('tanggal')
            ->orderByDesc('id');

        $kegiatans = $query->paginate(15)->withQueryString();

        return view('kegiatan.riwayat.index', [
            'kegiatans' => $kegiatans,
            'filterStatus' => $status,
            'filterSearch' => $search,
            'today' => $today,
        ]);
    }
}
