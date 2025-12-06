<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;

// Models
use App\Models\Warga;
use App\Models\User;
use App\Models\KartuKeluarga;
use App\Models\AnggotaKK;
use App\Models\KategoriKeuangan;
use App\Models\MetodePembayaran;
use App\Models\ProfilWilayah;
use App\Models\Kas;
use App\Models\Transaction;
use App\Models\IuranTemplate;
use App\Models\IuranInstance;
use App\Models\Pembayaran;
use App\Models\Kegiatan;
use App\Models\KegiatanWarga;
use App\Models\MutasiWarga;
use App\Models\Notifikasi;

class SIRTRWSeeder extends Seeder
{
    public function run(): void
    {
        $faker = fake('id_ID');

        /**
         * 1. PROFIL WILAYAH
         *    Idempotent: kalau sudah ada nama_rt_rw = "RT 05 / RW 03" → update saja
         */
        $profil = ProfilWilayah::updateOrCreate(
            ['nama_rt_rw' => 'RT 05 / RW 03'],
            [
                'alamat_sekretariat' => 'Jl. Melati No. 8, Kelurahan Sukamaju',
                'kontak' => '0812-3456-7890',
                'logo_path' => null,
                'deskripsi' => 'Sistem Informasi RT 05 / RW 03 untuk pengelolaan data warga, keuangan, dan kegiatan.',
            ]
        );

        /**
         * 2. MASTER KATEGORI KEUANGAN (pakai kode sebagai key unik)
         */
        $kategoriIuran = KategoriKeuangan::updateOrCreate(
            ['kode' => 'IRW'],
            [
                'nama' => 'Iuran Rutin Warga',
                'tipe' => 'masuk',
                'deskripsi' => 'Iuran bulanan rutin untuk kas RT/RW.',
                'is_active' => true,
            ]
        );

        $kategoriSosial = KategoriKeuangan::updateOrCreate(
            ['kode' => 'SOS'],
            [
                'nama' => 'Dana Sosial',
                'tipe' => 'keluar',
                'deskripsi' => 'Pengeluaran dana sosial dan bantuan warga.',
                'is_active' => true,
            ]
        );

        $kategoriKegiatan = KategoriKeuangan::updateOrCreate(
            ['kode' => 'KGN'],
            [
                'nama' => 'Dana Kegiatan',
                'tipe' => 'keluar',
                'deskripsi' => 'Dana untuk kegiatan RT/RW.',
                'is_active' => true,
            ]
        );

        /**
         * 3. METODE PEMBAYARAN (pakai nama sebagai key unik)
         */
        $metodeCash = MetodePembayaran::updateOrCreate(
            ['nama' => 'Cash'],
            [
                'deskripsi' => 'Pembayaran tunai kepada pengurus RT.',
                'is_active' => true,
            ]
        );

        $metodeTransfer = MetodePembayaran::updateOrCreate(
            ['nama' => 'Transfer Bank'],
            [
                'deskripsi' => 'Transfer ke rekening kas RT.',
                'is_active' => true,
            ]
        );

        $metodeEWallet = MetodePembayaran::updateOrCreate(
            ['nama' => 'E-Wallet'],
            [
                'deskripsi' => 'Pembayaran via dompet digital (OVO, Gopay, dll).',
                'is_active' => true,
            ]
        );

        /**
         * 4. DATA WARGA
         *    (masih create, disarankan dipakai di environment fresh / dev)
         */
        $warga = collect();

        for ($i = 0; $i < 10; $i++) {
            $warga->push(Warga::create([
                'nik' => $faker->unique()->numerify('3273##########'),
                'nama' => $faker->name(),
                'alamat' => 'Jl. Melati No. ' . $faker->numberBetween(1, 30),
                'no_rumah' => (string) $faker->numberBetween(1, 30),
                'rt' => '05',
                'rw' => '03',
                'no_hp' => $faker->phoneNumber(),
                'tanggal_lahir' => $faker->dateTimeBetween('-60 years', '-18 years'),
                'status_aktif' => true,
            ]));
        }

        /**
         * 5. USERS (akun login)
         *    Pakai updateOrCreate supaya tidak error duplicate `username`.
         */
        $userAdmin = User::updateOrCreate(
            ['username' => 'admin'],
            [
                'name' => 'Admin RT',
                'email' => 'admin@example.com',
                'password' => Hash::make('password'),
                'role' => 'admin',
                'warga_id' => $warga[0]->id ?? null,
            ]
        );

        $userKetua = User::updateOrCreate(
            ['username' => 'ketua'],
            [
                'name' => 'Ketua RT',
                'email' => 'ketua@example.com',
                'password' => Hash::make('password'),
                'role' => 'pengurus',
                'warga_id' => $warga[1]->id ?? null,
            ]
        );

        $userBendahara = User::updateOrCreate(
            ['username' => 'bendahara'],
            [
                'name' => 'Bendahara RT',
                'email' => 'bendahara@example.com',
                'password' => Hash::make('password'),
                'role' => 'bendahara',
                'warga_id' => $warga[2]->id ?? null,
            ]
        );

        /**
         * 6. KARTU KELUARGA + ANGGOTA KK
         */
        $kk1 = KartuKeluarga::create([
            'no_kk' => '3273' . $faker->numerify('##########'),
            'alamat' => 'Jl. Melati No. 10',
            'rt' => '05',
            'rw' => '03',
            'kepala_keluarga' => $warga[0]->nama,
            'tanggal_dibuat' => Carbon::now()->subYears(5),
        ]);

        $kk2 = KartuKeluarga::create([
            'no_kk' => '3273' . $faker->numerify('##########'),
            'alamat' => 'Jl. Melati No. 12',
            'rt' => '05',
            'rw' => '03',
            'kepala_keluarga' => $warga[3]->nama,
            'tanggal_dibuat' => Carbon::now()->subYears(3),
        ]);

        // Anggota KK1
        AnggotaKK::create([
            'kk_id' => $kk1->id,
            'warga_id' => $warga[0]->id,
            'hubungan' => 'Kepala Keluarga',
        ]);
        AnggotaKK::create([
            'kk_id' => $kk1->id,
            'warga_id' => $warga[1]->id,
            'hubungan' => 'Istri',
        ]);
        AnggotaKK::create([
            'kk_id' => $kk1->id,
            'warga_id' => $warga[2]->id,
            'hubungan' => 'Anak',
        ]);

        // Anggota KK2
        AnggotaKK::create([
            'kk_id' => $kk2->id,
            'warga_id' => $warga[3]->id,
            'hubungan' => 'Kepala Keluarga',
        ]);
        AnggotaKK::create([
            'kk_id' => $kk2->id,
            'warga_id' => $warga[4]->id,
            'hubungan' => 'Istri',
        ]);

        /**
         * 7. KEGIATAN + KEGIATAN_WARGA
         */
        $kerjaBakti = Kegiatan::create([
            'nama' => 'Kerja Bakti Mingguan',
            'jenis' => 'Kerja Bakti',
            'tanggal' => Carbon::now()->addDays(7),
            'waktu' => '07:00',
            'lokasi' => 'Lingkungan RT 05 / RW 03',
            'keterangan' => 'Membersihkan selokan dan lingkungan sekitar.',
            'penanggung_jawab_user_id' => $userKetua->id,
        ]);

        $rapatBulan = Kegiatan::create([
            'nama' => 'Rapat Bulanan Warga',
            'jenis' => 'Rapat',
            'tanggal' => Carbon::now()->addDays(14),
            'waktu' => '20:00',
            'lokasi' => 'Pos Ronda RT 05',
            'keterangan' => 'Laporan kas dan pembahasan kegiatan bulan depan.',
            'penanggung_jawab_user_id' => $userKetua->id,
        ]);

        foreach ($warga->take(5) as $w) {
            KegiatanWarga::create([
                'kegiatan_id' => $kerjaBakti->id,
                'warga_id' => $w->id,
                'role' => 'Peserta',
                'status' => 'diundang',
            ]);
        }

        /**
         * 8. IURAN TEMPLATE + INSTANCE
         */
        $templateIuranBulanan = IuranTemplate::create([
            'nama' => 'Iuran Kebersihan Bulanan',
            'jenis' => 'Bulanan',
            'nominal_default' => 50000,
            'keterangan' => 'Iuran rutin bulanan untuk kas kebersihan lingkungan.',
            'kategori_keuangan_id' => $kategoriIuran->id,
        ]);

        $templateIuranKeamanan = IuranTemplate::create([
            'nama' => 'Iuran Keamanan',
            'jenis' => 'Bulanan',
            'nominal_default' => 30000,
            'keterangan' => 'Iuran untuk operasional keamanan dan ronda.',
            'kategori_keuangan_id' => $kategoriIuran->id,
        ]);

        $instanceJan = IuranInstance::create([
            'template_id' => $templateIuranBulanan->id,
            'periode' => '2025-01',
            'due_date' => '2025-01-10',
            'nominal' => 50000,
            'status' => 'aktif',
        ]);

        $instanceFeb = IuranInstance::create([
            'template_id' => $templateIuranBulanan->id,
            'periode' => '2025-02',
            'due_date' => '2025-02-10',
            'nominal' => 50000,
            'status' => 'aktif',
        ]);

        /**
         * 9. KAS (saldo kas RT)
         */
        $kasMasuk1 = Kas::create([
            'tanggal' => Carbon::now()->subDays(10),
            'tipe' => 'masuk',
            'kategori' => 'Iuran Warga',
            'kategori_id' => $kategoriIuran->id,
            'nominal' => 500000,
            'keterangan' => 'Setoran iuran kebersihan bulan Januari.',
            'recorded_by' => $userBendahara->id,
        ]);

        $kasKeluar1 = Kas::create([
            'tanggal' => Carbon::now()->subDays(5),
            'tipe' => 'keluar',
            'kategori' => 'Pembelian Peralatan',
            'kategori_id' => $kategoriKegiatan->id,
            'nominal' => 200000,
            'keterangan' => 'Pembelian sapu, cangkul, dan kantong sampah.',
            'recorded_by' => $userBendahara->id,
        ]);

        /**
         * 10. TRANSACTION (ledger kas)
         *     type ENUM('in','out') → gunakan 'in' / 'out'
         */
        $saldoAwal = 0;
        $saldo1 = $saldoAwal + 500000;

        Transaction::create([
            'tanggal' => $kasMasuk1->tanggal,
            'type' => 'in',  // ✅ sesuai ENUM
            'kategori' => 'Iuran Warga',
            'kategori_id' => $kategoriIuran->id,
            'reference_table' => 'kas',
            'reference_id' => $kasMasuk1->id,
            'amount' => 500000,
            'balance_after' => $saldo1,
            'recorded_by' => $userBendahara->id,
            'description' => 'Setoran iuran kebersihan Januari.',
        ]);

        $saldo2 = $saldo1 - 200000;

        Transaction::create([
            'tanggal' => $kasKeluar1->tanggal,
            'type' => 'out', // ✅ sesuai ENUM
            'kategori' => 'Dana Kegiatan',
            'kategori_id' => $kategoriKegiatan->id,
            'reference_table' => 'kas',
            'reference_id' => $kasKeluar1->id,
            'amount' => 200000,
            'balance_after' => $saldo2,
            'recorded_by' => $userBendahara->id,
            'description' => 'Pembelian peralatan kerja bakti.',
        ]);

        /**
         * 11. PEMBAYARAN IURAN
         */
        $pembayaran1 = Pembayaran::create([
            'iuran_instance_id' => $instanceJan->id,
            'warga_id' => $warga[0]->id,
            'tanggal_bayar' => Carbon::now()->subDays(12),
            'amount' => 50000,
            'metode' => 'Cash',
            'metode_id' => $metodeCash->id,
            'status_verifikasi' => 'terverifikasi',
            'receipt_no' => 'IRW-2025-01-0001',
            'proof_path' => null,
            'recorded_by' => $userBendahara->id,
        ]);

        $pembayaran2 = Pembayaran::create([
            'iuran_instance_id' => $instanceJan->id,
            'warga_id' => $warga[3]->id,
            'tanggal_bayar' => Carbon::now()->subDays(11),
            'amount' => 50000,
            'metode' => 'Transfer Bank',
            'metode_id' => $metodeTransfer->id,
            'status_verifikasi' => 'menunggu',
            'receipt_no' => 'IRW-2025-01-0002',
            'proof_path' => null,
            'recorded_by' => $userBendahara->id,
        ]);

        /**
         * 12. MUTASI WARGA
         */
        MutasiWarga::create([
            'warga_id' => $warga[5]->id,
            'jenis' => 'masuk',
            'tanggal' => Carbon::now()->subMonths(2),
            'keterangan' => 'Pindah dari RT lain ke RT 05.',
        ]);

        MutasiWarga::create([
            'warga_id' => $warga[6]->id,
            'jenis' => 'keluar',
            'tanggal' => Carbon::now()->subMonths(1),
            'keterangan' => 'Pindah ke luar kota.',
        ]);

        /**
         * 13. NOTIFIKASI
         */
        Notifikasi::create([
            'user_id' => $userKetua->id,
            'judul' => 'Laporan Kas Bulanan',
            'pesan' => 'Laporan kas bulan Januari sudah tersedia.',
            'tipe' => 'info',
            'data' => ['link' => route('keuangan.kas.index')],
            'dibaca_pada' => null,
        ]);

        Notifikasi::create([
            'user_id' => $userBendahara->id,
            'judul' => 'Pembayaran Iuran Menunggu Verifikasi',
            'pesan' => 'Ada pembayaran iuran yang menunggu verifikasi.',
            'tipe' => 'tagihan',
            'data' => ['iuran_instance_id' => $instanceJan->id],
            'dibaca_pada' => null,
        ]);
    }
}
