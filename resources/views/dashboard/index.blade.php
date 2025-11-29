@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
<div class="content">
  <!-- Stats grid (the important part we tuned) -->
  <div class="stats-grid" id="statsGrid">
    <div class="stat-card">
      <div style="display:flex;justify-content:space-between;align-items:start;margin-bottom:12px">
        <div style="display:flex;gap:12px;align-items:center">
          <div style="width:52px;height:52px;border-radius:10px;background:linear-gradient(135deg,#3b82f6,#2563eb);display:flex;align-items:center;justify-content:center;color:white">
            <i data-lucide="users" class="w-6 h-6"></i>
          </div>
          <div>
            <div style="font-size:11px;color:#64748b">Total Warga</div>
            <div style="font-size:16px;font-weight:700;color:#0f172a">248</div>
          </div>
        </div>
        <div style="font-size:10px;color:var(--accent);background:#ecfdf5;padding:8px;border-radius:999px">+5 baru</div>
      </div>
      <div style="font-size:11px;color:#94a3b8">85 Kartu Keluarga</div>
    </div>

    <div class="stat-card">
      <div style="display:flex;justify-content:space-between;align-items:start;margin-bottom:12px">
        <div style="display:flex;gap:12px;align-items:center">
          <div style="width:52px;height:52px;border-radius:10px;background:linear-gradient(135deg,#10b981,#059669);display:flex;align-items:center;justify-content:center;color:white">
            <i data-lucide="dollar-sign" class="w-6 h-6"></i>
          </div>
          <div>
            <div style="font-size:11px;color:#64748b">Kas RT/RW</div>
            <div style="font-size:16px;font-weight:700;color:#0f172a">15.5 Jt</div>
          </div>
        </div>
        <div style="font-size:10px;color:var(--accent);background:#ecfdf5;padding:8px;border-radius:999px">+ 2.5 Jt</div>
      </div>
      <div style="font-size:11px;color:#94a3b8">Saldo bulan ini</div>
    </div>

    <div class="stat-card">
      <div style="display:flex;justify-content:space-between;align-items:start;margin-bottom:12px">
        <div style="display:flex;gap:12px;align-items:center">
          <div style="width:52px;height:52px;border-radius:10px;background:linear-gradient(135deg,#7c3aed,#6d28d9);display:flex;align-items:center;justify-content:center;color:white">
            <i data-lucide="calendar" class="w-6 h-6"></i>
          </div>
          <div>
            <div style="font-size:11px;color:#64748b">Kegiatan Aktif</div>
            <div style="font-size:16px;font-weight:700;color:#0f172a">3</div>
          </div>
        </div>
        <div style="font-size:10px;color:#7c3aed;background:#faf5ff;padding:8px;border-radius:999px">2↑</div>
      </div>
      <div style="font-size:11px;color:#94a3b8">Kegiatan minggu ini</div>
    </div>

    <div class="stat-card">
      <div style="display:flex;justify-content:space-between;align-items:start;margin-bottom:12px">
        <div style="display:flex;gap:12px;align-items:center">
          <div style="width:52px;height:52px;border-radius:10px;background:linear-gradient(135deg,#fb923c,#f97316);display:flex;align-items:center;justify-content:center;color:white">
            <i data-lucide="check-circle" class="w-6 h-6"></i>
          </div>
          <div>
            <div style="font-size:11px;color:#64748b">Iuran Masuk</div>
            <div style="font-size:16px;font-weight:700;color:#0f172a">89%</div>
          </div>
        </div>
        <div style="font-size:10px;color:var(--accent);background:#ecfdf5;padding:8px;border-radius:999px">215/248</div>
      </div>
      <div style="font-size:11px;color:#94a3b8">Warga sudah bayar</div>
    </div>
  </div>

  <!-- remaining content kept concise -->
  <div style="height:16px"></div>
  <div class="card">
    <div style="background:#fff;border-radius:12px;padding:18px;border:1px solid rgba(2,6,23,0.04);box-shadow:0 6px 20px rgba(2,6,23,0.03)">
      <h3 style="margin:0 0 10px 0;font-size:16px;color:#0f172a">Kegiatan Mendatang</h3>
      <div style="display:flex;gap:12px;flex-wrap:wrap">
        <div style="flex:1;min-width:220px;background:#fafafa;padding:12px;border-radius:10px;border:1px solid rgba(2,6,23,0.03)">
          <div style="font-weight:700;color:#0f172a">Gotong Royong</div>
          <div style="font-size:13px;color:rgba(2,6,23,0.6);margin-top:6px">15 Nov 2025 • 07:00 WIB • Balai RT</div>
        </div>
        <div style="flex:1;min-width:220px;background:#fafafa;padding:12px;border-radius:10px;border:1px solid rgba(2,6,23,0.03)">
          <div style="font-weight:700;color:#0f172a">Pengajian Rutin</div>
          <div style="font-size:13px;color:rgba(2,6,23,0.6);margin-top:6px">17 Nov 2025 • 19:30 WIB • Mushola</div>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection
