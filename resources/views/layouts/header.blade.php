<header class="app-header">
  <div class="header-left">
    <button id="sidebarToggle" aria-label="Toggle sidebar">
      <div id="headerSidebarToggle"><i data-lucide="menu" class="w-5 h-5"></i></div>
    </button>
    <div>
      <div style="display:flex;align-items:center;gap:10px">
        <h2 style="margin:0;font-size:20px;font-weight:700;color:#0f172a">@yield('title', 'Dashboard')</h2>
        <span style="font-size:12px;color:rgba(2,6,23,0.45);background:#f1f5f9;padding:6px 10px;border-radius:999px">RT 05 / RW 03</span>
      </div>
      <div style="font-size:13px;color:rgba(2,6,23,0.6);margin-top:6px;display:flex;align-items:center;gap:8px;">
        <i data-lucide="map-pin" class="w-4 h-4"></i> Kelurahan Kebayoran, Jakarta Selatan
      </div>
    </div>
  </div>

  <div style="display:flex;align-items:center;gap:12px;">
    <button style="background:white;border:1px solid rgba(2,6,23,0.04);padding:8px;border-radius:8px;display:inline-flex;align-items:center;justify-content:center">
      <i data-lucide="bell" class="w-5 h-5"></i>
      <span style="background:#ef4444;color:white;font-size:11px;padding:2px 6px;border-radius:999px;margin-left:-8px;margin-top:-12px;display:inline-block">3</span>
    </button>

    <div style="display:flex;align-items:center;gap:10px;background:#fff;padding:6px;border-radius:10px;border:1px solid rgba(2,6,23,0.04)">
      <div style="width:36px;height:36px;border-radius:8px;background:linear-gradient(135deg,var(--accent),#059669);display:flex;align-items:center;justify-content:center;color:white;font-weight:700">A</div>
      <div style="font-size:13px">
        <div style="font-weight:600;color:#0f172a">Bapak Ahmad</div>
        <div style="font-size:12px;color:rgba(2,6,23,0.5)">Ketua RT 05</div>
      </div>
    </div>
  </div>
</header>
