<aside id="sidebar" class="sidebar-open">
  <div class="sb-header">
    <div style="display:flex;align-items:center;gap:12px">
      <div class="sb-logo">A</div>
      <div class="sidebar-label sb-title">
        <h1>SI RT/RW</h1>
        <p>RT 05 / RW 03</p>
      </div>
    </div>
  </div>

  <nav class="sb-nav" role="navigation">
    <div class="menu-item active" data-menu="dashboard" data-has-submenu="false" type="button">
      <div class="icon"><i data-lucide="layout-dashboard" class="w-5 h-5"></i></div>
      <div class="label sidebar-label">Dashboard</div>
    </div>

    <div>
      <div class="menu-item" data-menu="warga" data-has-submenu="true" data-submenu="submenu-warga" type="button">
        <div class="icon"><i data-lucide="users" class="w-5 h-5"></i></div>
        <div class="label sidebar-label">Data Warga</div>
      </div>
      <div id="submenu-warga" class="sidebar-submenu hidden">
        <div class="submenu-item" data-menu="daftar-warga">Daftar Warga</div>
        <div class="submenu-item" data-menu="tambah-warga">Tambah Warga</div>
        <div class="submenu-item" data-menu="kartu-keluarga">Kartu Keluarga</div>
      </div>
    </div>

    <div>
      <div class="menu-item" data-menu="keuangan" data-has-submenu="true" data-submenu="submenu-keuangan">
        <div class="icon"><i data-lucide="wallet" class="w-5 h-5"></i></div>
        <div class="label sidebar-label">Keuangan</div>
      </div>
      <div id="submenu-keuangan" class="sidebar-submenu hidden">
        <div class="submenu-item" data-menu="iuran-warga">Iuran Warga</div>
        <div class="submenu-item" data-menu="kas-rt">Kas RT/RW</div>
        <div class="submenu-item" data-menu="pengeluaran">Pengeluaran</div>
        <div class="submenu-item" data-menu="laporan-keuangan">Laporan Keuangan</div>
      </div>
    </div>

    <div>
      <div class="menu-item" data-menu="kegiatan" data-has-submenu="true" data-submenu="submenu-kegiatan">
        <div class="icon"><i data-lucide="calendar" class="w-5 h-5"></i></div>
        <div class="label sidebar-label">Kegiatan</div>
      </div>
      <div id="submenu-kegiatan" class="sidebar-submenu hidden">
        <div class="submenu-item" data-menu="daftar-kegiatan">Daftar Kegiatan</div>
        <div class="submenu-item" data-menu="tambah-kegiatan">Tambah Kegiatan</div>
        <div class="submenu-item" data-menu="riwayat-kegiatan">Riwayat Kegiatan</div>
      </div>
    </div>

    <div>
      <div class="menu-item" data-menu="surat" data-has-submenu="true" data-submenu="submenu-surat">
        <div class="icon"><i data-lucide="file-text" class="w-5 h-5"></i></div>
        <div class="label sidebar-label">Surat</div>
      </div>
      <div id="submenu-surat" class="sidebar-submenu hidden">
        <div class="submenu-item" data-menu="surat-masuk">Surat Masuk</div>
        <div class="submenu-item" data-menu="surat-keluar">Surat Keluar</div>
        <div class="submenu-item" data-menu="template-surat">Template Surat</div>
      </div>
    </div>

    <div>
      <div class="menu-item" data-menu="laporan" data-has-submenu="true" data-submenu="submenu-laporan">
        <div class="icon"><i data-lucide="bar-chart-3" class="w-5 h-5"></i></div>
        <div class="label sidebar-label">Laporan</div>
      </div>
      <div id="submenu-laporan" class="sidebar-submenu hidden">
        <div class="submenu-item" data-menu="laporan-warga">Laporan Warga</div>
        <div class="submenu-item" data-menu="laporan-keuangan-detail">Laporan Keuangan</div>
        <div class="submenu-item" data-menu="laporan-kegiatan">Laporan Kegiatan</div>
      </div>
    </div>

    <div class="menu-item mt-2" data-menu="pengaturan" data-has-submenu="false">
      <div class="icon"><i data-lucide="settings" class="w-5 h-5"></i></div>
      <div class="label sidebar-label">Pengaturan</div>
    </div>
  </nav>

  <div class="sb-footer sidebar-label">
    <div style="display:flex;gap:10px;align-items:center;">
      <div style="width:40px;height:34px;border-radius:8px;background:#f1f5f9;display:flex;align-items:center;justify-content:center;color:#0f172a;font-weight:600">v</div>
      <div>
        <div style="font-size:13px;font-weight:600;color:#0f172a">Versi Sistem</div>
        <div style="font-size:12px;color:rgba(2,6,23,0.45)">v1.0.0 — 2025</div>
      </div>
    </div>
  </div>
</aside>
