@extends('layouts.app')

@section('title', 'Template Iuran')

@section('content')
    <div class="content">

        {{-- HEADER --}}
        <div style="display:flex;align-items:center;justify-content:space-between;gap:16px;margin-bottom:20px">
            <div>
                <h1 style="margin:0;font-size:22px;font-weight:700;color:#0f172a;">Template Iuran</h1>
                <p style="margin:6px 0 0 0;font-size:13px;color:rgba(15,23,42,0.6)">
                    Kelola daftar template iuran untuk digunakan pada penagihan rutin.
                </p>
            </div>

            <div style="display:flex;align-items:center;gap:12px">

                {{-- Search --}}
                <form method="GET" action="{{ route('keuangan.iuran.template.index') }}"
                    style="display:flex;align-items:center;gap:8px">
                    <div style="position:relative">
                        <input name="q" value="{{ request('q') }}" placeholder="Cari template..." style="padding:8px 12px 8px 32px;border-radius:10px;
                                                       border:1px solid rgba(148,163,184,0.7);font-size:13px;min-width:220px;
                                                       outline:none;transition:.18s;"
                            onfocus="this.style.borderColor='#10b981'"
                            onblur="this.style.borderColor='rgba(148,163,184,0.7)'">
                        <i data-lucide="search" style="width:16px;height:16px;color:#94a3b8;position:absolute;
                                                       left:10px;top:50%;transform:translateY(-50%)"></i>
                    </div>

                    <button type="submit" style="padding:8px 14px;border-radius:10px;background:#0f172a;color:white;
                                                       border:none;font-size:13px;font-weight:500;cursor:pointer;">
                        Cari
                    </button>
                </form>

                {{-- Button Modal --}}
                <button id="openModal" style="display:flex;align-items:center;gap:6px;padding:8px 14px;border-radius:10px;
                                               background:linear-gradient(135deg,#10b981,#059669);color:white;font-size:13px;
                                               font-weight:500;cursor:pointer;border:none;">
                    <i data-lucide="plus" style="width:16px;height:16px;"></i>
                    Tambah Template
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

        {{-- TABLE --}}
        <div style="background:white;border-radius:12px;border:1px solid rgba(2,6,23,0.04);
                                        box-shadow:0 6px 20px rgba(2,6,23,0.03);overflow:hidden;">
            <table style="width:100%;font-size:13px;border-collapse:collapse;">
                <thead style="background:#f8fafc;border-bottom:1px solid rgba(148,163,184,0.4);">
                    <tr>
                        <th style="padding:12px 18px;text-align:left;">No</th>
                        <th style="padding:12px 18px;text-align:left;">Nama</th>
                        <th style="padding:12px 18px;text-align:left;">Jenis</th>
                        <th style="padding:12px 18px;text-align:left;">Nominal Default</th>
                        <th style="padding:12px 18px;text-align:left;">Keterangan</th>
                        <th style="padding:12px 18px;text-align:center;">Aksi</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse($templates as $i => $t)
                        <tr style="border-bottom:1px solid #f1f5f9;transition:.15s"
                            onmouseover="this.style.background='#f9fafb'" onmouseout="this.style.background='transparent'">

                            <td style="padding:10px 18px;color:#6b7280;">
                                {{ $templates->firstItem() + $i }}
                            </td>

                            <td style="padding:10px 18px;font-weight:600;color:#0f172a;">
                                {{ $t->nama }}
                            </td>

                            <td style="padding:10px 18px;color:#475569;">
                                {{ $t->jenis }}
                            </td>

                            <td style="padding:10px 18px;color:#0f172a;">
                                Rp {{ number_format($t->nominal_default, 0, ',', '.') }}
                            </td>

                            <td style="padding:10px 18px;color:#6b7280;">
                                {{ $t->keterangan ?? '-' }}
                            </td>

                            <td style="padding:10px 18px;text-align:center;">
                                <form action="{{ route('keuangan.iuran.template.destroy', $t->id) }}" method="POST"
                                    onsubmit="return confirm('Hapus template ini?')" style="display:inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button
                                        style="padding:6px 10px;border-radius:8px;background:#fef2f2;border:none;
                                                                                           color:#b91c1c;font-size:12px;cursor:pointer;">
                                        <i data-lucide="trash-2" style="width:14px;height:14px;margin-right:4px;"></i>
                                        Hapus
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" style="padding:40px;text-align:center;color:#6b7280;">
                                <i data-lucide="file" style="width:32px;height:32px;color:#cbd5e1;"></i>
                                <p>Tidak ada data template.</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- PAGINATION --}}
        <div style="margin-top:18px;">
            {{ $templates->links() }}
        </div>
    </div>


    {{-- ============================= --}}
    {{-- MODAL TAMBAH DATA --}}
    {{-- ============================= --}}

    <div id="modal" class="hidden" style="position:fixed;inset:0;background:rgba(15,23,42,0.45);
                                   backdrop-filter:blur(4px);display:flex;align-items:center;
                                   justify-content:center;z-index:999;">

        <div style="background:white;padding:22px 24px;border-radius:16px;
                                        max-width:620px;width:100%;max-height:90vh;overflow:auto;
                                        box-shadow:0 24px 60px rgba(15,23,42,0.35);">

            {{-- HEADER --}}
            <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:16px;">
                <div>
                    <h2 style="font-size:18px;font-weight:700;color:#0f172a;margin:0;">Tambah Template Iuran</h2>
                    <p style="margin:4px 0 0;color:#64748b;font-size:13px;">Isi data berikut.</p>
                </div>

                <button id="closeModal"
                    style="width:32px;height:32px;border-radius:10px;background:#f1f5f9;
                                                   border:none;cursor:pointer;display:flex;align-items:center;justify-content:center;">
                    <i data-lucide="x" style="width:18px;height:18px;color:#475569;"></i>
                </button>
            </div>

            <form action="{{ route('keuangan.iuran.template.store') }}" method="POST">
                @csrf

                <div style="display:flex;flex-direction:column;gap:14px;">

                    <div>
                        <label style="font-size:13px;font-weight:600;">Nama Template *</label>
                        <input name="nama" required style="width:100%;padding:8px 12px;border-radius:10px;
                                                       border:1px solid #e2e8f0;">
                    </div>

                    <div>
                        <label style="font-size:13px;font-weight:600;">Jenis *</label>
                        <input name="jenis" required style="width:100%;padding:8px 12px;border-radius:10px;
                                                       border:1px solid #e2e8f0;">
                    </div>

                    <div>
                        <label style="font-size:13px;font-weight:600;">Nominal Default *</label>
                        <input type="number" name="nominal_default" required style="width:100%;padding:8px 12px;border-radius:10px;
                                                       border:1px solid #e2e8f0;">
                    </div>

                    <div>
                        <label style="font-size:13px;font-weight:600;">Keterangan</label>
                        <textarea name="keterangan" rows="3" style="width:100%;padding:8px 12px;border-radius:10px;
                                                       border:1px solid #e2e8f0;resize:vertical;"></textarea>
                    </div>
                </div>

                {{-- FOOTER --}}
                <div style="margin-top:20px;display:flex;justify-content:flex-end;gap:10px;">
                    <button id="closeModal2" style="padding:8px 14px;border-radius:10px;border:1px solid #e2e8f0;
                                                   background:white;color:#475569;font-size:13px;">
                        Batal
                    </button>

                    <button type="submit" style="padding:9px 16px;border-radius:10px;background:#0f172a;color:white;
                                                   border:none;font-size:13px;font-weight:600;">
                        Simpan Template
                    </button>
                </div>

            </form>
        </div>
    </div>

    {{-- JS --}}
    <script>
        const modal = document.getElementById('modal');
        document.getElementById('openModal').onclick = () => modal.classList.remove('hidden');
        document.getElementById('closeModal').onclick = () => modal.classList.add('hidden');
        document.getElementById('closeModal2').onclick = () => modal.classList.add('hidden');
        modal.addEventListener('click', e => { if (e.target === modal) modal.classList.add('hidden'); });
    </script>

@endsection