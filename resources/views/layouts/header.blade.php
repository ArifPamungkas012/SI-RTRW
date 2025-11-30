<header class="app-header">
  <div class="header-left">
    <button id="sidebarToggle" aria-label="Toggle sidebar">
      <div id="headerSidebarToggle"><i data-lucide="menu" class="w-5 h-5"></i></div>
    </button>

    <div>
      <div style="display:flex;align-items:center;gap:10px">
        <h2 style="margin:0;font-size:20px;font-weight:700;color:#0f172a">@yield('title', 'Dashboard')</h2>
        <span style="font-size:12px;color:rgba(2,6,23,0.45);background:#f1f5f9;padding:6px 10px;border-radius:999px">RT
          05 / RW 03</span>
      </div>
      <div style="font-size:13px;color:rgba(2,6,23,0.6);margin-top:6px;display:flex;align-items:center;gap:8px;">
        <i data-lucide="map-pin" class="w-4 h-4"></i> Kelurahan Kebayoran, Jakarta Selatan
      </div>
    </div>
  </div>

  <div style="display:flex;align-items:center;gap:12px;">
    <button
      style="background:white;border:1px solid rgba(2,6,23,0.04);padding:8px;border-radius:8px;display:inline-flex;align-items:center;justify-content:center">
      <i data-lucide="bell" class="w-5 h-5"></i>
      <span
        style="background:#ef4444;color:white;font-size:11px;padding:2px 6px;border-radius:999px;margin-left:-8px;margin-top:-12px;display:inline-block">3</span>
    </button>

    {{-- User card with dropdown --}}
    <div
      style="position:relative;display:flex;align-items:center;gap:10px;background:#fff;padding:6px;border-radius:10px;border:1px solid rgba(2,6,23,0.04)">
      <div
        style="width:36px;height:36px;border-radius:8px;background:linear-gradient(135deg,var(--accent),#059669);display:flex;align-items:center;justify-content:center;color:white;font-weight:700">
        {{-- Initial dari nama --}}
        {{ strtoupper(substr(Auth::user()->name ?? 'U', 0, 1)) }}
      </div>

      <div style="font-size:13px;display:flex;align-items:center;gap:8px;">
        <div>
          <div style="font-weight:600;color:#0f172a">{{ Auth::user()->name ?? 'Nama Pengguna' }}</div>
          <div style="font-size:12px;color:rgba(2,6,23,0.5)">{{ Auth::user()->role ?? 'Warga' }}</div>
        </div>

        {{-- Dropdown toggle --}}
        <div style="position:relative;">
          <button id="userDropdownToggle" aria-expanded="false" aria-haspopup="true"
            style="background:transparent;border:0;padding:6px;border-radius:8px;cursor:pointer">
            <i data-lucide="chevron-down" class="w-4 h-4"></i>
          </button>

          {{-- Dropdown menu (default hidden) --}}
          <div id="userDropdownMenu"
            style="display:none;position:absolute;right:0;top:36px;min-width:180px;background:white;border:1px solid rgba(2,6,23,0.08);box-shadow:0 6px 18px rgba(2,6,23,0.08);border-radius:8px;padding:6px;z-index:50">
            <a href="{{ route('account.profile') }}"
              style="display:flex;gap:8px;align-items:center;padding:8px;border-radius:6px;text-decoration:none;color:#0f172a">
              <i data-lucide="user" class="w-4 h-4"></i>
              <span>Profil</span>
            </a>

            <a href="{{ route('account.settings') }}"
              style="display:flex;gap:8px;align-items:center;padding:8px;border-radius:6px;text-decoration:none;color:#0f172a">
              <i data-lucide="settings" class="w-4 h-4"></i>
              <span>Pengaturan</span>
            </a>

            <div style="height:1px;background:rgba(2,6,23,0.04);margin:6px 0;border-radius:2px"></div>

            {{-- Logout melalui form POST --}}
            <form id="logoutForm" action="{{ route('logout') }}" method="POST" style="margin:0">
              @csrf
              <button type="submit"
                style="width:100%;display:flex;gap:8px;align-items:center;padding:8px;border-radius:6px;border:0;background:transparent;cursor:pointer;color:#ef4444;">
                <i data-lucide="log-out" class="w-4 h-4"></i>
                <span>Keluar</span>
              </button>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
</header>

{{-- Minimal JS to toggle dropdown --}}
<script>
  document.addEventListener('click', function (e) {
    const toggle = document.getElementById('userDropdownToggle');
    const menu = document.getElementById('userDropdownMenu');
    if (!toggle || !menu) return;

    // Toggle when click on toggle
    if (toggle.contains(e.target)) {
      const isOpen = menu.style.display === 'block';
      menu.style.display = isOpen ? 'none' : 'block';
      toggle.setAttribute('aria-expanded', !isOpen);
      return;
    }

    // Close when click outside
    if (!menu.contains(e.target)) {
      menu.style.display = 'none';
      toggle.setAttribute('aria-expanded', false);
    }
  });

  // Initialize lucide icons if using lucide.js
  if (window.lucide) {
    window.lucide.createIcons();
  }
</script>