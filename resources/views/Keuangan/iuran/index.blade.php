{{-- resources/views/Keuangan/iuran/index.blade.php --}}
@extends('layouts.app')

@section('title', 'Daftar Iuran Periode')

@section('content')
    <div class="content">

        {{-- HEADER --}}
        <div style="display:flex;align-items:center;justify-content:space-between;gap:16px;margin-bottom:20px">
            <div>
                <h1 style="margin:0;font-size:22px;font-weight:700;color:#0f172a;">Daftar Iuran Per Periode</h1>
                <p style="margin:6px 0 0 0;font-size:13px;color:rgba(15,23,42,0.6)">
                    Kelola iuran yang di-generate dari template untuk setiap periode.
                </p>
            </div>

            <div style="display:flex;align-items:center;gap:12px">
                {{-- FILTER & SEARCH --}}
                <form method="GET" action="{{ route('iuran.instance.index') }}"
                    style="display:flex;align-items:center;gap:8px">

                    <div style="position:relative">
                        <input name="q" value="{{ request('q') }}" placeholder="Cari nama template..." style="padding:8px 12px 8px 32px;border-radius:10px;border:1px solid rgba(148,163,184,0.7);
                                       font-size:13px;min-width:200px;outline:none;transition:border-color .18s ease"
                            onfocus="this.style.borderColor='#10b981'"
                            onblur="this.style.borderColor='rgba(148,163,184,0.7)'">
                        <i data-lucide="search" style="width:16px;height:16px;color:#94a3b8;position:absolute;left:10px;top:50%;
                                      transform:translateY(-50%);"></i>
                    </div>

                    <input type="month" name="periode" value="{{ request('periode') }}" style="padding:8px 10px;border-radius:10px;border:1px solid rgba(148,163,184,0.7);
                                      font-size:13px;outline:none;">

                    <select name="status" style="padding:8px 10px;border-radius:10px;border:1px solid rgba(148,163,184,0.7);
                                       font-size:13px;outline:none;background:white;">
                        <option value="">Semua status</option>
                        <option value="draft" {{ request('status') == 'draft' ? 'selected' : '' }}>Draft</option>
                        <option value="aktif" {{ request('status') == 'aktif' ? 'selected' : '' }}>Aktif</option>
                        <option value="ditutup" {{ request('status') == 'ditutup' ? 'selected' : '' }}>Ditutup</option>
                    </select>

                    <button type="submit" style="padding:8px 14px;border-radius:10px;border:none;background:#0f172a;
                                       color:white;font-size:13px;font-weight:500;cursor:pointer;">
                        Filter
                    </button>
                </form>

                {{-- Button Tambah Iuran Periode (Modal) --}}
                <button id="openCreateInstanceModal" style="display:inline-flex;align-items:center;gap:6px;padding:8px 14px;border-radius:10px;
                                   background:linear-gradient(135deg,#10b981,#059669);color:white;font-size:13px;
                                   font-weight:500;border:none;cursor:pointer;
                                   box-shadow:0 10px 25px rgba(16,185,129,0.35);">
                    <i data-lucide="plus" style="width:16px;height:16px;"></i>
                    Tambah Iuran Periode
                </button>
            </div>
        </div>

        {{-- FLASH --}}
        @if(session('success'))
            <div style="margin-bottom:18px;padding:10px 14px;border-radius:12px;
                                    background:#ecfdf5;border:1px solid #bbf7d0;color:#166534;
                                    display:flex;align-items:center;gap:8px;font-size:13px;">
                <i data-lucide="check-circle" style="width:18px;height:18px;"></i>
                {{ session('success') }}
            </div>
        @endif

        {{-- CARD TABLE --}}
        <div style="background:#fff;border-radius:12px;border:1px solid rgba(2,6,23,0.04);
                        box-shadow:0 6px 20px rgba(2,6,23,0.03);overflow:hidden;">
            <div style="overflow-x:auto;">
                <table style="width:100%;border-collapse:collapse;font-size:13px;">
                    <thead style="background:#f8fafc;border-bottom:1px solid rgba(148,163,184,0.4);color:#475569;">
                        <tr>
                            <th style="padding:12px 18px;text-align:left;">#</th>
                            <th style="padding:12px 18px;text-align:left;">Periode</th>
                            <th style="padding:12px 18px;text-align:left;">Template</th>
                            <th style="padding:12px 18px;text-align:left;">Nominal</th>
                            <th style="padding:12px 18px;text-align:left;">Jatuh Tempo</th>
                            <th style="padding:12px 18px;text-align:left;">Status</th>
                            <th style="padding:12px 18px;text-align:left;">Pembayaran</th>
                            <th style="padding:12px 18px;text-align:center;">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($instances as $index => $inst)
                                        <tr style="border-bottom:1px solid #f1f5f9;transition:background .15s;"
                                            onmouseover="this.style.background='#f9fafb'" onmouseout="this.style.background='transparent'">
                                            <td style="padding:10px 18px;color:#6b7280;">
                                                {{ $instances->firstItem() + $index }}
                                            </td>
                                            <td style="padding:10px 18px;color:#0f172a;font-weight:600;">
                                                {{ $inst->periode }}
                                            </td>
                                            <td style="padding:10px 18px;color:#0f172a;">
                                                {{ $inst->template->nama ?? '-' }}
                                            </td>
                                            <td style="padding:10px 18px;color:#0f172a;">
                                                Rp {{ number_format($inst->nominal, 0, ',', '.') }}
                                            </td>
                                            <td style="padding:10px 18px;color:#475569;">
                                                {{ $inst->due_date ?? '-' }}
                                            </td>
                                            <td style="padding:10px 18px;">
                                                @php
                                                    $status = $inst->status;
                                                    $bg = '#e5e7eb';
                                                    $color = '#374151';
                                                    if ($status === 'aktif') {
                                                        $bg = '#dcfce7';
                                                        $color = '#166534';
                                                    } elseif ($status === 'ditutup') {
                                                        $bg = '#fee2e2';
                                                        $color = '#991b1b';
                                                    } elseif ($status === 'draft') {
                                                        $bg = '#e0f2fe';
                                                        $color = '#075985';
                                                    }
                                                @endphp
                            <span
                                                    style="display:inline-flex;align-items:center;padding:3px 9px;border-radius:999px;
                                                                         background:{{ $bg }};color:{{ $color }};font-size:11px;font-weight:600;">
                                                    {{ ucfirst($status) }}
                                                </span>
                                            </td>
                                            <td style="padding:10px 18px;color:#6b7280;">
                                                {{ $inst->pembayaran->count() }} pembayaran
                                            </td>
                                            <td style="padding:10px 18px;text-align:center;">
                                                {{-- Contoh aksi: ubah status jadi ditutup --}}
                                                <form action="{{ route('iuran.instance.update', $inst->id) }}" method="POST"
                                                    style="display:inline;">
                                                    @csrf
                                                    @method('PUT')
                                                    <input type="hidden" name="status" value="ditutup">
                                                    <button type="submit"
                                                        style="padding:6px 10px;border-radius:8px;background:#fef3c7;border:none;
                                                                               color:#92400e;font-size:12px;cursor:pointer;margin-right:4px;">
                                                        Tutup
                                                    </button>
                                                </form>

                                                <form action="{{ route('iuran.instance.destroy', $inst->id) }}" method="POST"
                                                    onsubmit="return confirm('Hapus iuran periode ini?')" style="display:inline;">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" style="padding:6px 10px;border-radius:8px;background:#fee2e2;border:none;
                                                                               color:#b91c1c;font-size:12px;cursor:pointer;">
                                                        Hapus
                                                    </button>
                                                </form>
                                            </td>
                                        </tr>
                        @empty
                            <tr>
                                <td colspan="8" style="padding:40px 18px;text-align:center;color:#6b7280;">
                                    <div style="display:flex;flex-direction:column;align-items:center;gap:8px;">
                                        <i data-lucide="wallet" style="width:32px;height:32px;color:#cbd5e1;"></i>
                                        <p style="margin:0;">Belum ada data iuran periode.</p>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        {{-- PAGINATION --}}
        <div style="margin-top:18px;">
            {{ $instances->withQueryString()->links() }}
        </div>
    </div>

    {{-- ========================= --}}
    {{-- MODAL TAMBAH --}}
    {{-- ========================= --}}
    <div id="createInstanceModal" class="hidden" style="position:fixed;inset:0;z-index:999;background:rgba(15,23,42,0.45);
                    backdrop-filter:blur(4px);display:flex;align-items:center;justify-content:center;">
        <div style="background:#ffffff;border-radius:16px;width:100%;max-width:620px;
                        max-height:90vh;overflow:auto;padding:22px 24px;box-shadow:0 24px 60px rgba(15,23,42,0.35);">

            {{-- HEADER --}}
            <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:16px;">
                <div>
                    <h2 style="margin:0;font-size:18px;font-weight:700;color:#0f172a;">Tambah Iuran Periode</h2>
                    <p style="margin:4px 0 0 0;font-size:13px;color:#64748b;">
                        Pilih template dan tentukan periode iuran.
                    </p>
                </div>
                <button type="button" id="closeCreateInstanceModal" style="width:32px;height:32px;border-radius:10px;border:none;background:#f1f5f9;
                                   display:flex;align-items:center;justify-content:center;cursor:pointer;">
                    <i data-lucide="x" style="width:18px;height:18px;color:#475569;"></i>
                </button>
            </div>

            {{-- FORM --}}
            <form action="{{ route('iuran.instance.store') }}" method="POST">
                @csrf

                <div style="display:flex;flex-direction:column;gap:14px;">

                    <div>
                        <label style="font-size:13px;font-weight:600;color:#0f172a;margin-bottom:4px;display:block;">
                            Template Iuran <span style="color:#ef4444">*</span>
                        </label>
                        <select name="template_id" id="templateSelect" style="width:100%;padding:8px 12px;border-radius:10px;border:1px solid #e2e8f0;
                                           font-size:13px;outline:none;background:white;">
                            <option value="">— Pilih Template —</option>
                            @foreach($templates as $t)
                                <option value="{{ $t->id }}" data-nominal="{{ $t->nominal_default }}">
                                    {{ $t->nama }} ({{ $t->jenis }})
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label style="font-size:13px;font-weight:600;color:#0f172a;margin-bottom:4px;display:block;">
                            Periode <span style="color:#ef4444">*</span>
                        </label>
                        <input type="month" name="periode" required style="width:100%;padding:8px 12px;border-radius:10px;border:1px solid #e2e8f0;
                                          font-size:13px;outline:none;">
                    </div>

                    <div>
                        <label style="font-size:13px;font-weight:600;color:#0f172a;margin-bottom:4px;display:block;">
                            Jatuh Tempo <span style="color:#ef4444">*</span>
                        </label>
                        <input type="date" name="due_date" required style="width:100%;padding:8px 12px;border-radius:10px;border:1px solid #e2e8f0;
                                          font-size:13px;outline:none;">
                    </div>

                    <div>
                        <label style="font-size:13px;font-weight:600;color:#0f172a;margin-bottom:4px;display:block;">
                            Nominal <span style="color:#ef4444">*</span>
                        </label>
                        <input type="number" name="nominal" id="nominalInput" required style="width:100%;padding:8px 12px;border-radius:10px;border:1px solid #e2e8f0;
                                          font-size:13px;outline:none;">
                        <p style="margin-top:4px;font-size:11px;color:#6b7280;">
                            Nominal default akan terisi otomatis berdasarkan template, namun bisa diubah jika perlu.
                        </p>
                    </div>

                    <div>
                        <label style="font-size:13px;font-weight:600;color:#0f172a;margin-bottom:4px;display:block;">
                            Status Awal
                        </label>
                        <select name="status" style="width:100%;padding:8px 12px;border-radius:10px;border:1px solid #e2e8f0;
                                           font-size:13px;outline:none;background:white;">
                            <option value="draft">Draft</option>
                            <option value="aktif">Aktif</option>
                        </select>
                    </div>
                </div>

                {{-- FOOTER --}}
                <div style="margin-top:18px;padding-top:14px;border-top:1px solid #e5e7eb;
                                display:flex;justify-content:flex-end;gap:10px;">
                    <button type="button" id="closeCreateInstanceModal2" style="padding:8px 14px;border-radius:10px;border:1px solid #e2e8f0;
                                       background:white;color:#475569;font-size:13px;cursor:pointer;">
                        Batal
                    </button>
                    <button type="submit" style="padding:9px 18px;border-radius:10px;border:none;background:#0f172a;
                                       color:white;font-size:13px;font-weight:600;cursor:pointer;
                                       box-shadow:0 8px 20px rgba(15,23,42,0.35);">
                        Simpan Iuran Periode
                    </button>
                </div>
            </form>
        </div>
    </div>

    {{-- SCRIPT MODAL & AUTO NOMINAL --}}
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const modal = document.getElementById('createInstanceModal');
            const openBtn = document.getElementById('openCreateInstanceModal');
            const closeBtns = [
                document.getElementById('closeCreateInstanceModal'),
                document.getElementById('closeCreateInstanceModal2')
            ];
            const templateSelect = document.getElementById('templateSelect');
            const nominalInput = document.getElementById('nominalInput');

            if (openBtn) {
                openBtn.addEventListener('click', () => modal.classList.remove('hidden'));
            }
            closeBtns.forEach(btn => {
                if (btn) btn.addEventListener('click', () => modal.classList.add('hidden'));
            });
            modal.addEventListener('click', e => {
                if (e.target === modal) modal.classList.add('hidden');
            });

            if (templateSelect && nominalInput) {
                templateSelect.addEventListener('change', function () {
                    const selected = this.options[this.selectedIndex];
                    const nominal = selected.getAttribute('data-nominal');
                    if (nominal) {
                        nominalInput.value = nominal;
                    }
                });
            }
        });
    </script>

@endsection