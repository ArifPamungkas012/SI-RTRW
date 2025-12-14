@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
  <div class="content">
    <!-- Stats Grid -->
    <div style="display:grid;grid-template-columns:repeat(auto-fit, minmax(240px, 1fr));gap:20px;margin-bottom:24px">

      {{-- Card 1: Warga --}}
      <div
        style="background:white;border-radius:16px;padding:20px;border:1px solid #e2e8f0;box-shadow:0 4px 6px -1px rgba(0,0,0,0.05)">
        <div style="display:flex;justify-content:space-between;align-items:start;margin-bottom:16px">
          <div
            style="width:48px;height:48px;border-radius:12px;background:#eff6ff;color:#2563eb;display:flex;align-items:center;justify-content:center">
            <i data-lucide="users" style="width:24px;height:24px"></i>
          </div>
          @if($wargaBaruBulanIni > 0)
            <span
              style="font-size:11px;font-weight:600;color:#166534;background:#dcfce7;padding:4px 10px;border-radius:99px">
              +{{ $wargaBaruBulanIni }} baru
            </span>
          @endif
        </div>
        <div style="font-size:14px;color:#64748b;margin-bottom:4px">Total Warga</div>
        <div style="font-size:24px;font-weight:700;color:#0f172a">{{ $totalWarga }}</div>
        <div style="margin-top:8px;font-size:12px;color:#94a3b8">
          {{ $kkCount }} Kartu Keluarga terdaftar
        </div>
      </div>

      {{-- Card 2: Keuangan --}}
      <div
        style="background:white;border-radius:16px;padding:20px;border:1px solid #e2e8f0;box-shadow:0 4px 6px -1px rgba(0,0,0,0.05)">
        <div style="display:flex;justify-content:space-between;align-items:start;margin-bottom:16px">
          <div
            style="width:48px;height:48px;border-radius:12px;background:#ecfdf5;color:#059669;display:flex;align-items:center;justify-content:center">
            <i data-lucide="wallet" style="width:24px;height:24px"></i>
          </div>
          @if($mutasiBulanIni != 0)
            <span
              style="font-size:11px;font-weight:600;{{ $mutasiBulanIni > 0 ? 'color:#166534;background:#dcfce7' : 'color:#991b1b;background:#fee2e2' }};padding:4px 10px;border-radius:99px">
              {{ $mutasiBulanIni > 0 ? '+' : '' }}{{ number_format($mutasiBulanIni / 1000, 0) }}k bln ini
            </span>
          @endif
        </div>
        <div style="font-size:14px;color:#64748b;margin-bottom:4px">Saldo Kas RT</div>
        <div style="font-size:24px;font-weight:700;color:#0f172a">Rp {{ number_format($saldoKas, 0, ',', '.') }}</div>
        <div style="margin-top:8px;font-size:12px;color:#94a3b8">
          Update terakhir hari ini
        </div>
      </div>

      {{-- Card 3: Kegiatan --}}
      <div
        style="background:white;border-radius:16px;padding:20px;border:1px solid #e2e8f0;box-shadow:0 4px 6px -1px rgba(0,0,0,0.05)">
        <div style="display:flex;justify-content:space-between;align-items:start;margin-bottom:16px">
          <div
            style="width:48px;height:48px;border-radius:12px;background:#f5f3ff;color:#7c3aed;display:flex;align-items:center;justify-content:center">
            <i data-lucide="calendar" style="width:24px;height:24px"></i>
          </div>
          <span
            style="font-size:11px;font-weight:600;color:#7c3aed;background:#f3e8ff;padding:4px 10px;border-radius:99px">
            {{ $activeEvents }} aktif
          </span>
        </div>
        <div style="font-size:14px;color:#64748b;margin-bottom:4px">Agenda Kegiatan</div>
        <div style="font-size:24px;font-weight:700;color:#0f172a">{{ count($upcomingEvents) }}</div>
        <div style="margin-top:8px;font-size:12px;color:#94a3b8">
          Agenda mendatang
        </div>
      </div>

      {{-- Card 4: Analisa Keuangan --}}
      <div
        style="background:white;border-radius:16px;padding:20px;border:1px solid #e2e8f0;box-shadow:0 4px 6px -1px rgba(0,0,0,0.05)">
        <div style="display:flex;justify-content:space-between;align-items:start;margin-bottom:16px">
          <div
            style="width:48px;height:48px;border-radius:12px;background:#fff7ed;color:#ea580c;display:flex;align-items:center;justify-content:center">
            <i data-lucide="pie-chart" style="width:24px;height:24px"></i>
          </div>
          <!-- Placeholder for future status -->
        </div>
        <div style="font-size:14px;color:#64748b;margin-bottom:4px">Analisa Keuangan</div>
        <div style="font-size:16px;font-weight:700;color:#0f172a">Tahun {{ date('Y') }}</div>
        <div style="margin-top:8px;font-size:12px;color:#94a3b8">
          Grafik pemasukan & pengeluaran
        </div>
      </div>
    </div>

    {{-- Section: Financial Chart --}}
    <div
      style="background:white;border-radius:16px;padding:24px;border:1px solid #e2e8f0;box-shadow:0 4px 6px -1px rgba(0,0,0,0.05);margin-bottom:24px">
      <h3 style="margin:0 0 20px 0;font-size:18px;font-weight:700;color:#0f172a">Statistik Keuangan</h3>
      <div id="financeChart" style="min-height:300px;"></div>
    </div>

    <div style="display:grid;grid-template-columns:repeat(auto-fit, minmax(320px, 1fr));gap:24px;align-items:start">

      {{-- Left: Upcoming Events --}}
      <div>
        <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:16px">
          <h3 style="margin:0;font-size:18px;font-weight:700;color:#0f172a">Kegiatan Mendatang</h3>
          <a href="{{ route('kegiatan.index') }}"
            style="font-size:13px;color:#2563eb;text-decoration:none;font-weight:500">Lihat Semua</a>
        </div>

        @if(count($upcomingEvents) > 0)
          <div style="display:flex;flex-direction:column;gap:12px">
            @foreach($upcomingEvents as $event)
              <div
                style="background:white;border:1px solid #e2e8f0;border-radius:12px;padding:16px;box-shadow:0 2px 4px rgba(0,0,0,0.02);display:flex;gap:16px;align-items:center">
                <div
                  style="width:46px;height:46px;background:#f8fafc;border-radius:10px;display:flex;flex-direction:column;align-items:center;justify-content:center;border:1px solid #e2e8f0;flex-shrink:0">
                  <span
                    style="font-size:10px;color:#ef4444;font-weight:700;text-transform:uppercase">{{ $event->tanggal ? $event->tanggal->format('M') : '-' }}</span>
                  <span
                    style="font-size:16px;color:#0f172a;font-weight:700">{{ $event->tanggal ? $event->tanggal->format('d') : '-' }}</span>
                </div>
                <div style="flex:1">
                  <h4 style="margin:0 0 2px 0;font-size:14px;font-weight:600;color:#0f172a">{{ $event->nama }}</h4>
                  <div style="display:flex;align-items:center;gap:12px;font-size:12px;color:#64748b">
                    <span style="display:flex;align-items:center;gap:4px"><i data-lucide="clock"
                        style="width:12px;height:12px"></i> {{ $event->waktu }}</span>
                    <span style="display:flex;align-items:center;gap:4px"><i data-lucide="map-pin"
                        style="width:12px;height:12px"></i> {{ Str::limit($event->lokasi, 20) }}</span>
                  </div>
                </div>
                <div
                  style="font-size:10px;background:#f0fdf4;color:#166534;padding:4px 8px;border-radius:6px;font-weight:600">
                  Segera
                </div>
              </div>
            @endforeach
          </div>
        @else
          <div
            style="padding:40px;text-align:center;background:white;border-radius:16px;border:1px solid #e2e8f0;color:#94a3b8">
            <i data-lucide="calendar-off" style="width:32px;height:32px;margin-bottom:12px;opacity:0.5"></i>
            <p style="margin:0">Belum ada kegiatan mendatang.</p>
          </div>
        @endif
      </div>

      {{-- Right: Tagihan Iuran --}}
      <div>
        <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:16px">
          <h3 style="margin:0;font-size:18px;font-weight:700;color:#0f172a">Tagihan Iuran</h3>
          <a href="{{ route('keuangan.iuran.instance.index') }}"
            style="font-size:13px;color:#2563eb;text-decoration:none;font-weight:500">Kelola</a>
        </div>

        @if(count($latestIuran) > 0)
          <div style="display:flex;flex-direction:column;gap:12px">
            @foreach($latestIuran as $iuran)
              <div
                style="background:white;border:1px solid #e2e8f0;border-radius:12px;padding:16px;box-shadow:0 2px 4px rgba(0,0,0,0.02)">
                <div style="display:flex;justify-content:space-between;align-items:start;margin-bottom:10px">
                  <div style="display:flex;gap:10px;align-items:center">
                    <div
                      style="width:36px;height:36px;border-radius:8px;background:#fff7ed;color:#ea580c;display:flex;align-items:center;justify-content:center">
                      <i data-lucide="receipt" style="width:18px;height:18px"></i>
                    </div>
                    <div>
                      <div style="font-size:14px;font-weight:600;color:#0f172a">{{ $iuran['title'] }}</div>
                      <div style="font-size:12px;color:#64748b">Jatuh tempo: {{ $iuran['due_date'] }}</div>
                    </div>
                  </div>
                  <span
                    style="font-size:11px;font-weight:600;background:#f1f5f9;color:#475569;padding:2px 8px;border-radius:6px">
                    {{ $iuran['status'] == 'open' ? 'Aktif' : 'Tutup' }}
                  </span>
                </div>

                {{-- Progress Bar --}}
                <div style="margin-bottom:6px;display:flex;justify-content:space-between;font-size:12px;color:#64748b">
                  <span>Terkumpul: <strong>{{ $iuran['paid'] }}</strong> / {{ $iuran['total'] }} warga</span>
                  <span style="font-weight:600;color:#0f172a">{{ $iuran['percentage'] }}%</span>
                </div>
                <div style="width:100%;height:6px;background:#f1f5f9;border-radius:99px;overflow:hidden">
                  <div
                    style="width:{{ $iuran['percentage'] }}%;height:100%;background:#{{ $iuran['percentage'] >= 100 ? '166534' : 'ea580c' }};border-radius:99px">
                  </div>
                </div>
              </div>
            @endforeach
          </div>
        @else
          <div
            style="padding:40px;text-align:center;background:white;border-radius:16px;border:1px solid #e2e8f0;color:#94a3b8">
            <i data-lucide="check-circle-2" style="width:32px;height:32px;margin-bottom:12px;opacity:0.5"></i>
            <p style="margin:0">Tidak ada tagihan aktif.</p>
          </div>
        @endif
      </div>
    </div>

  </div>
@endsection

@push('scripts')
  <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
  <script>
    document.addEventListener('DOMContentLoaded', function () {
      const incomeData = @json(array_values($monthlyIncome));
      const expenseData = @json(array_values($monthlyExpense));

      var options = {
        series: [{
          name: 'Pemasukan',
          data: incomeData
        }, {
          name: 'Pengeluaran',
          data: expenseData
        }],
        chart: {
          type: 'bar',
          height: 320,
          toolbar: { show: false },
          fontFamily: 'Inter, sans-serif'
        },
        colors: ['#10b981', '#ef4444'],
        plotOptions: {
          bar: {
            horizontal: false,
            columnWidth: '50%',
            borderRadius: 4
          },
        },
        dataLabels: {
          enabled: false
        },
        stroke: {
          show: true,
          width: 2,
          colors: ['transparent']
        },
        xaxis: {
          categories: ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agt', 'Sep', 'Okt', 'Nov', 'Des'],
          axisBorder: { show: false },
          axisTicks: { show: false }
        },
        yaxis: {
          labels: {
            formatter: function (val) {
              return val >= 1000 ? (val / 1000).toFixed(0) + 'k' : val;
            }
          }
        },
        fill: {
          opacity: 1
        },
        tooltip: {
          y: {
            formatter: function (val) {
              return "Rp " + new Intl.NumberFormat('id-ID').format(val)
            }
          }
        },
        legend: {
          position: 'top',
          horizontalAlign: 'right'
        },
        grid: {
          borderColor: '#f1f5f9'
        }
      };

      var chart = new ApexCharts(document.querySelector("#financeChart"), options);
      chart.render();
    });
  </script>
@endpush