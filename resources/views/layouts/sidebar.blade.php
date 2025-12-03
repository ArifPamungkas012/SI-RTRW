<aside id="sidebar" class="sidebar-open">
  <div class="sb-header">
    <div class="sb-header-inner" style="display:flex;align-items:center;gap:12px">
      <div class="sb-logo">SI</div>
      <div class="sidebar-label sb-title">
        <p>RT 05 / RW 03</p>
      </div>
    </div>
  </div>

  <nav class="sb-nav" role="navigation">
    <div class="menu-item {{ request()->routeIs('dashboard') ? 'active' : '' }}" data-menu="dashboard"
      data-has-submenu="false" type="button" data-href="{{ route('dashboard') }}">
      <div class="icon"><i data-lucide="layout-dashboard" class="w-5 h-5"></i></div>
      <div class="label sidebar-label" data-href="{{ route('dashboard') }}">Dashboard</div>
    </div>

    <div>
      <div class="menu-item {{ request()->routeIs('datawarga.*') ? 'active' : '' }}" data-menu="warga"
        data-has-submenu="true" data-submenu="submenu-warga" type="button" data-href="">
        <div class="icon"><i data-lucide="users" class="w-5 h-5"></i></div>
        <div class="label sidebar-label">Data Warga</div>
      </div>
      <div id="submenu-warga" class="sidebar-submenu hidden">
        <div class="submenu-item {{ request()->routeIs('datawarga.warga.index') ? 'active' : '' }}"
          data-menu="daftar-warga" data-href="{{ route('datawarga.warga.index') }}">Daftar Warga
        </div>
        <div class="submenu-item {{ request()->routeIs('datawarga.kk.index') ? 'active' : '' }}"
          data-menu="kartu-keluarga" data-href="{{ route('datawarga.kk.index') }}">Kartu
          Keluarga</div>
      </div>
    </div>

    <div>
      <div class="menu-item {{ request()->routeIs('keuangan.*') ? 'active' : '' }}" data-menu="keuangan"
        data-has-submenu="true" data-submenu="submenu-keuangan" type="button" data-href="">
        <div class="icon"><i data-lucide="wallet" class="w-5 h-5"></i></div>
        <div class="label sidebar-label">Keuangan</div>
      </div>
      <div id="submenu-keuangan" class="sidebar-submenu hidden">
        <div class="submenu-item" data-menu="iuran-warga" data-href="#">Iuran Warga</div>
        <div class="submenu-item" data-menu="kas-rt" data-href="#">Kas RT/RW</div>
        <div class="submenu-item" data-menu="pengeluaran" data-href="#">Pengeluaran</div>
        <div class="submenu-item" data-menu="laporan-keuangan" data-href="#">Laporan Keuangan</div>
      </div>
    </div>

    <div>
      <div class="menu-item {{ request()->routeIs('kegiatan.*') ? 'active' : '' }}" data-menu="kegiatan"
        data-has-submenu="true" data-submenu="submenu-kegiatan" type="button" data-href="">
        <div class="icon"><i data-lucide="calendar" class="w-5 h-5"></i></div>
        <div class="label sidebar-label">Kegiatan</div>
      </div>
      <div id="submenu-kegiatan" class="sidebar-submenu hidden">
        <div class="submenu-item {{ request()->routeIs('kegiatan.index') ? 'active' : '' }}" data-menu="daftar-kegiatan"
          data-href="{{ route('kegiatan.index') }}">Daftar Kegiatan</div>
        <div class="submenu-item {{ request()->routeIs('#') ? 'active' : '' }}" data-menu="tambah-kegiatan"
          data-href="#">Tambah Kegiatan</div>
        <div class="submenu-item {{ request()->routeIs('#') ? 'active' : '' }}" data-menu="riwayat-kegiatan"
          data-href="#">Riwayat Kegiatan</div>
      </div>
    </div>

    <div>
      <div class="menu-item {{ request()->routeIs('surat.*') ? 'active' : '' }}" data-menu="surat"
        data-has-submenu="true" data-submenu="submenu-surat" type="button" data-href="">
        <div class="icon"><i data-lucide="file-text" class="w-5 h-5"></i></div>
        <div class="label sidebar-label">Surat</div>
      </div>
      <div id="submenu-surat" class="sidebar-submenu hidden">
        <div class="submenu-item" data-menu="surat-masuk" data-href="#">Surat Masuk</div>
        <div class="submenu-item" data-menu="surat-keluar" data-href="#">Surat Keluar</div>
        <div class="submenu-item" data-menu="template-surat" data-href="#">Template Surat</div>
      </div>
    </div>

    <div>
      <div class="menu-item {{ request()->routeIs('laporan.*') ? 'active' : '' }}" data-menu="laporan"
        data-has-submenu="true" data-submenu="submenu-laporan" type="button" data-href="">
        <div class="icon"><i data-lucide="bar-chart-3" class="w-5 h-5"></i></div>
        <div class="label sidebar-label">Laporan</div>
      </div>
      <div id="submenu-laporan" class="sidebar-submenu hidden">
        <div class="submenu-item" data-menu="laporan-warga" data-href="#">Laporan Warga</div>
        <div class="submenu-item" data-menu="laporan-keuangan-detail" data-href="#">Laporan Keuangan</div>
        <div class="submenu-item" data-menu="laporan-kegiatan" data-href="#">Laporan Kegiatan</div>
      </div>
    </div>

    <div class="menu-item mt-2 {{ request()->routeIs('account.settings*') ? 'active' : '' }}" data-menu="pengaturan"
      data-has-submenu="false" data-href="{{ route('account.settings') }}">
      <div class="icon"><i data-lucide="settings" class="w-5 h-5"></i></div>
      <div class="label sidebar-label">Pengaturan</div>
    </div>
  </nav>

  <div class="sb-footer sidebar-label">
    <div style="display:flex;gap:10px;align-items:center;">
      <div
        style="width:40px;height:34px;border-radius:8px;background:#f1f5f9;display:flex;align-items:center;justify-content:center;color:#0f172a;font-weight:600">
        v</div>
      <div>
        <div style="font-size:13px;font-weight:600;color:#0f172a">Versi Sistem</div>
        <div style="font-size:12px;color:rgba(2,6,23,0.45)">v1.0.0 — 2025</div>
      </div>
    </div>
  </div>
</aside>

<script>
  document.addEventListener('DOMContentLoaded', function () {
    // Klik pada menu-item (termasuk yang awalnya button/div) akan navigasi bila ada data-href
    document.querySelectorAll('.menu-item, .submenu-item').forEach(function (el) {
      el.addEventListener('click', function (e) {
        // jika elemen memiliki submenu (toggle), biarkan toggle bekerja dulu
        const hasSub = el.getAttribute('data-has-submenu');
        const submenuId = el.getAttribute('data-submenu');

        if (hasSub === 'true' && submenuId) {
          // biarkan script toggle submenu (jika ada) — tidak melakukan navigasi
          // jika kamu ingin menu parent juga clickable, ganti logika ini
          return;
        }

        const href = el.getAttribute('data-href');
        if (href && href !== '#') {
          // support target _blank jika diperlukan
          window.location.href = href;
        }
      });
    });

    // juga aktifkan klik pada submenu-item untuk navigasi (submenu ones are divs here)
    document.querySelectorAll('.submenu-item').forEach(function (si) {
      si.addEventListener('click', function (e) {
        const href = si.getAttribute('data-href');
        if (href && href !== '#') {
          window.location.href = href;
        }
      });
    });

    // keep existing submenu toggle logic if present elsewhere in your code
    // (this script intentionally does not alter styles or classes)
  });
</script>