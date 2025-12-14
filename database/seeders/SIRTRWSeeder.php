<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;
use Faker\Factory as Faker;


// Models
use App\Models\{
    Role,
    Warga,
    User,
    KartuKeluarga,
    AnggotaKK,
    KategoriKeuangan,
    MetodePembayaran,
    ProfilWilayah,
    Kas,
    Transaction,
    IuranTemplate,
    IuranInstance,
    Pembayaran,
    Kegiatan,
    KegiatanWarga,
    MutasiWarga,
    Notifikasi
};

class SIRTRWSeeder extends Seeder
{
    public function run(): void
    {
        $faker = Faker::create('id_ID');

        /* ===========================================================
         * 1. PROFIL WILAYAH
         * =========================================================== */
        $profil = ProfilWilayah::updateOrCreate(
            ['nama_rt_rw' => 'RT 05 / RW 03'],
            [
                'alamat_sekretariat' => 'Jl. Melati No. 8, Kelurahan Sukamaju',
                'kontak' => '0812-3456-7890',
                'logo_path' => null,
                'deskripsi' => 'Wilayah RT 05 / RW 03 – data dummy otomatis.'
            ]
        );

        /* ===========================================================
         * 2. ROLES
         * =========================================================== */
        $roleAdmin = Role::firstOrCreate(['name' => 'admin'], ['label' => 'Administrator', 'description' => 'Akses penuh sistem']);
        $roleKetua = Role::firstOrCreate(['name' => 'ketua_rt'], ['label' => 'Ketua RT', 'description' => 'Akses manajemen warga dan laporan']);
        $roleBendahara = Role::firstOrCreate(['name' => 'bendahara'], ['label' => 'Bendahara', 'description' => 'Akses manajemen keuangan']);
        $roleWarga = Role::firstOrCreate(['name' => 'warga'], ['label' => 'Warga', 'description' => 'Akses terbatas warga']);
        // Optional: Sekretaris if needed
        $roleSekretaris = Role::firstOrCreate(['name' => 'sekretaris'], ['label' => 'Sekretaris', 'description' => 'Akses surat menyurat']);

        /* ===========================================================
         * 3. MASTER KATEGORI KEUANGAN
         * =========================================================== */
        $kategori = [
            ['IRW', 'Iuran Rutin Warga', 'masuk'],
            ['SOS', 'Dana Sosial', 'keluar'],
            ['KGN', 'Dana Kegiatan', 'keluar'],
            ['DAR', 'Donasi Darurat', 'masuk'],
            ['PJM', 'Pinjaman Warga', 'keluar'],
        ];

        $kategoriMap = [];
        foreach ($kategori as $k) {
            $kategoriMap[$k[0]] = KategoriKeuangan::updateOrCreate(
                ['kode' => $k[0]],
                ['nama' => $k[1], 'tipe' => $k[2], 'is_active' => 1]
            );
        }

        /* ===========================================================
         * 4. METODE PEMBAYARAN
         * =========================================================== */
        $metodes = ['Cash', 'Transfer Bank', 'E-Wallet', 'QRIS', 'VA Bank BCA'];
        $metodeMap = [];
        foreach ($metodes as $m) {
            $metodeMap[$m] = MetodePembayaran::updateOrCreate(
                ['nama' => $m],
                ['deskripsi' => "Pembayaran via $m", 'is_active' => 1]
            );
        }

        /* ===========================================================
         * 5. DATA WARGA (40 ORANG)
         * =========================================================== */
        $warga = collect();
        // Create specific warga for users first to ensure consistency
        $wargaAdmin = Warga::create([
            'nik' => $faker->unique()->numerify('3273##########'),
            'nama' => 'Bapak Admin',
            'alamat' => 'Jl. Melati No. 1',
            'no_rumah' => '1',
            'rt' => '05',
            'rw' => '03',
            // 'jenis_kelamin' => 'Laki-laki',
            // 'status_pernikahan' => 'Menikah',
            // 'tempat_lahir' => 'Bandung',
            'tanggal_lahir' => '1980-01-01',
            'no_hp' => $faker->phoneNumber(),
            'status_aktif' => 1
        ]);
        $warga->push($wargaAdmin);

        $wargaKetua = Warga::create([
            'nik' => $faker->unique()->numerify('3273##########'),
            'nama' => 'Bapak Ketua RT',
            'alamat' => 'Jl. Melati No. 2',
            'no_rumah' => '2',
            'rt' => '05',
            'rw' => '03',
            // 'jenis_kelamin' => 'Laki-laki',
            // 'status_pernikahan' => 'Menikah',
            // 'tempat_lahir' => 'Jakarta',
            'tanggal_lahir' => '1975-05-15',
            'no_hp' => $faker->phoneNumber(),
            'status_aktif' => 1
        ]);
        $warga->push($wargaKetua);

        $wargaBendahara = Warga::create([
            'nik' => $faker->unique()->numerify('3273##########'),
            'nama' => 'Ibu Bendahara',
            'alamat' => 'Jl. Melati No. 3',
            'no_rumah' => '3',
            'rt' => '05',
            'rw' => '03',
            // 'jenis_kelamin' => 'Perempuan',
            // 'status_pernikahan' => 'Menikah',
            // 'tempat_lahir' => 'Surabaya',
            'tanggal_lahir' => '1985-08-20',
            'no_hp' => $faker->phoneNumber(),
            'status_aktif' => 1
        ]);
        $warga->push($wargaBendahara);

        // Random Warga
        for ($i = 0; $i < 37; $i++) {
            $warga->push(Warga::create([
                'nik' => $faker->unique()->numerify('3273##########'),
                'nama' => $faker->name(),
                'alamat' => 'Jl. Melati No. ' . $faker->numberBetween(4, 50),
                'no_rumah' => (string) $faker->numberBetween(4, 50),
                'rt' => '05',
                'rw' => '03',
                // 'jenis_kelamin' => $faker->randomElement(['Laki-laki', 'Perempuan']),
                // 'status_pernikahan' => $faker->randomElement(['Belum Menikah', 'Menikah', 'Cerai']),
                // 'tempat_lahir' => $faker->city(),
                'tanggal_lahir' => $faker->dateTimeBetween('-60 years', '-17 years'),
                'no_hp' => $faker->phoneNumber(),
                'status_aktif' => 1
            ]));
        }

        /* ===========================================================
         * 6. USERS
         * =========================================================== */
        $userAdmin = User::updateOrCreate(
            ['username' => 'admin'],
            [
                'name' => 'Administrator',
                'email' => 'admin@example.com',
                'password' => Hash::make('password'),
                'role_id' => $roleAdmin->id,
                'warga_id' => $wargaAdmin->id,
            ]
        );

        $userKetua = User::updateOrCreate(
            ['username' => 'ketua'],
            [
                'name' => 'Ketua RT',
                'email' => 'ketua@example.com',
                'password' => Hash::make('password'),
                'role_id' => $roleKetua->id,
                'warga_id' => $wargaKetua->id,
            ]
        );

        $userBendahara = User::updateOrCreate(
            ['username' => 'bendahara'],
            [
                'name' => 'Bendahara RT',
                'email' => 'bendahara@example.com',
                'password' => Hash::make('password'),
                'role_id' => $roleBendahara->id,
                'warga_id' => $wargaBendahara->id,
            ]
        );

        // Dummy user warga (some of them)
        foreach ($warga->slice(3, 5) as $w) {
            User::create([
                'username' => strtolower(str_replace(' ', '', $w->nama)),
                'name' => $w->nama,
                'email' => strtolower(str_replace(' ', '.', $w->nama)) . '@example.com',
                'password' => Hash::make('password'),
                'role_id' => $roleWarga->id,
                'warga_id' => $w->id,
            ]);
        }

        /* ===========================================================
         * 7. KARTU KELUARGA (15 KK)
         * =========================================================== */
        $kkList = collect();
        // Create KK for Admin, Ketua, Bendahara first
        $keyPeople = [$wargaAdmin, $wargaKetua, $wargaBendahara];
        foreach ($keyPeople as $kp) {
            $kk = KartuKeluarga::create([
                'no_kk' => '3273' . $faker->numerify('##########'),
                'alamat' => $kp->alamat,
                'rt' => '05',
                'rw' => '03',
                'kepala_keluarga' => $kp->nama,
                'tanggal_dibuat' => Carbon::now()->subYears(rand(1, 5)),
            ]);
            $kkList->push($kk);

            // Link Warga to KK as Kepala Keluarga
            AnggotaKK::create(['kk_id' => $kk->id, 'warga_id' => $kp->id, 'hubungan' => 'Kepala Keluarga']);
        }

        // Random KKs
        for ($i = 0; $i < 12; $i++) {
            $remainingWarga = $warga->whereNotIn('id', AnggotaKK::pluck('warga_id'))->values();
            if ($remainingWarga->isEmpty())
                break;

            $head = $remainingWarga->first();

            $kk = KartuKeluarga::create([
                'no_kk' => '3273' . $faker->numerify('##########'),
                'alamat' => $head->alamat,
                'rt' => '05',
                'rw' => '03',
                'kepala_keluarga' => $head->nama,
                'tanggal_dibuat' => Carbon::now()->subYears(rand(1, 10)),
            ]);
            $kkList->push($kk);

            // Add head
            AnggotaKK::create(['kk_id' => $kk->id, 'warga_id' => $head->id, 'hubungan' => 'Kepala Keluarga']);

            // Add members
            $members = $remainingWarga->slice(1, rand(1, 3));
            foreach ($members as $m) {
                AnggotaKK::create(['kk_id' => $kk->id, 'warga_id' => $m->id, 'hubungan' => $faker->randomElement(['Istri', 'Anak', 'Famili Lain'])]);
            }
        }

        /* ===========================================================
         * 8. KEGIATAN (20 kegiatan)
         * =========================================================== */
        $kegiatanList = collect();

        for ($i = 0; $i < 20; $i++) {
            $k = Kegiatan::create([
                'nama' => $faker->randomElement(['Kerja Bakti', 'Ronda Malam', 'Rapat Bulanan', 'Senam Warga'])
                    . ' #' . ($i + 1),
                'jenis' => $faker->randomElement(['Rapat', 'Kerja Bakti', 'Sosial']),
                'tanggal' => Carbon::now()->addDays(rand(1, 60)),
                'waktu' => $faker->time(),
                'lokasi' => 'Posko RW',
                'keterangan' => 'Kegiatan rutin warga',
                'penanggung_jawab_user_id' => $userKetua->id,
            ]);
            $kegiatanList->push($k);

            // Undang 10 warga acak
            foreach ($warga->random(10) as $w) {
                KegiatanWarga::create([
                    'kegiatan_id' => $k->id,
                    'warga_id' => $w->id,
                    'role' => 'Peserta',
                    'status' => $faker->randomElement(['diundang', 'hadir', 'tidak hadir']),
                ]);
            }
        }

        /* ===========================================================
         * 9. IURAN TEMPLATE (6 template)
         * =========================================================== */
        $templates = collect();
        $templateNames = [
            ['Iuran Kebersihan', 50000],
            ['Iuran Keamanan', 30000],
            ['Iuran Jalan', 40000],
            ['Iuran Sosial', 20000],
            ['Sumbangan Kegiatan', 25000],
            ['Iuran Lampu Jalan', 15000],
        ];

        foreach ($templateNames as $t) {
            $templates->push(IuranTemplate::create([
                'nama' => $t[0],
                'jenis' => 'Bulanan',
                'nominal_default' => $t[1],
                'kategori_keuangan_id' => $kategoriMap['IRW']->id
            ]));
        }

        /* ===========================================================
         * 10. IURAN INSTANCES (12 bulan × 6 template)
         * =========================================================== */
        $instances = collect();
        foreach ($templates as $template) {
            for ($m = 1; $m <= 12; $m++) {
                $periode = "2025-" . str_pad($m, 2, '0', STR_PAD_LEFT);

                $instances->push(IuranInstance::create([
                    'template_id' => $template->id,
                    'periode' => $periode,
                    'due_date' => "$periode-10",
                    'nominal' => $template->nominal_default,
                    'status' => 'aktif',
                ]));
            }
        }

        /* ===========================================================
         * 11. KAS (50 entri)
         * =========================================================== */
        $saldo = 0;

        for ($i = 0; $i < 50; $i++) {
            $isMasuk = rand(0, 1);
            $nominal = rand(10000, 200000);
            $saldo = $isMasuk ? $saldo + $nominal : $saldo - $nominal;

            $kas = Kas::create([
                'tanggal' => Carbon::now()->subDays(rand(1, 120)),
                'tipe' => $isMasuk ? 'masuk' : 'keluar',
                'kategori' => $faker->randomElement(['Iuran Warga', 'Dana Sosial', 'Kegiatan']),
                'kategori_id' => $kategoriMap['IRW']->id, // Simplified
                'nominal' => $nominal,
                'keterangan' => $faker->sentence(),
                'recorded_by' => $userBendahara->id,
            ]);

            Transaction::create([
                'tanggal' => $kas->tanggal,
                'type' => $isMasuk ? 'in' : 'out',
                'kategori' => $kas->kategori,
                'kategori_id' => $kas->kategori_id,
                'reference_table' => 'kas',
                'reference_id' => $kas->id,
                'amount' => $nominal,
                'balance_after' => $saldo,
                'recorded_by' => $userBendahara->id,
                'description' => $kas->keterangan
            ]);
        }

        /* ===========================================================
         * 12. PEMBAYARAN IURAN (150 entri acak)
         * =========================================================== */
        for ($i = 0; $i < 150; $i++) {
            $inst = $instances->random();
            $wr = $warga->random();
            $metode = $metodeMap[array_rand($metodeMap)];

            Pembayaran::create([
                'iuran_instance_id' => $inst->id,
                'warga_id' => $wr->id,
                'tanggal_bayar' => Carbon::now()->subDays(rand(1, 100)),
                'amount' => $inst->nominal,
                'metode' => $metode->nama,
                'metode_id' => $metode->id,
                'status_verifikasi' => $faker->randomElement(['menunggu', 'terverifikasi']),
                'receipt_no' => 'IR-' . $faker->numerify('########'),
                'proof_path' => null,
                'recorded_by' => $userBendahara->id,
            ]);
        }

        /* ===========================================================
         * 13. MUTASI WARGA (20 entri)
         * =========================================================== */
        for ($i = 0; $i < 20; $i++) {
            MutasiWarga::create([
                'warga_id' => $warga->random()->id,
                'jenis' => $faker->randomElement(['masuk', 'keluar']),
                'tanggal' => Carbon::now()->subDays(rand(10, 300)),
                'keterangan' => $faker->sentence(),
            ]);
        }

        /* ===========================================================
         * 14. NOTIFIKASI (30 notifikasi acak)
         * =========================================================== */
        $usersForNotif = [$userAdmin->id, $userKetua->id, $userBendahara->id];
        for ($i = 0; $i < 30; $i++) {
            Notifikasi::create([
                'user_id' => $faker->randomElement($usersForNotif),
                'judul' => $faker->sentence(3),
                'pesan' => $faker->sentence(8),
                'tipe' => $faker->randomElement(['info', 'tagihan', 'sistem']),
                'data' => json_encode(['foo' => 'bar']), // Need json string for text/json column
                'dibaca_pada' => rand(0, 1) ? Carbon::now() : null,
            ]);
        }

        /* ===========================================================
         * 15. SURPLUS DATA (JAN-JUL)
         * =========================================================== */
        // Guaranteed surplus for Jan - Jul
        // We use $kategoriMap from section 3 and $userBendahara from section 6
        for ($m = 1; $m <= 7; $m++) {
            // Create a fixed date: 10th of each month in 2025
            $dateIn = Carbon::create(2025, $m, 10);
            $dateOut = Carbon::create(2025, $m, 15);

            // 1. Income (Large) ~ 15-20jt
            $nominalIn = rand(15000000, 20000000);

            // Perbarui saldo (running balance simulation or just placeholder)
            if (!isset($saldo))
                $saldo = 0;
            $saldo += $nominalIn;

            $kasIn = Kas::create([
                'tanggal' => $dateIn,
                'tipe' => 'masuk',
                'kategori' => 'Donasi Surplus',
                'kategori_id' => $kategoriMap['DAR']->id ?? 1, // Fallback if key missing
                'nominal' => $nominalIn,
                'keterangan' => 'Donasi Warga Bulanan (Surplus)',
                'recorded_by' => $userBendahara->id,
            ]);

            Transaction::create([
                'tanggal' => $kasIn->tanggal,
                'type' => 'in',
                'kategori' => $kasIn->kategori,
                'kategori_id' => $kasIn->kategori_id,
                'reference_table' => 'kas',
                'reference_id' => $kasIn->id,
                'amount' => $nominalIn,
                'balance_after' => $saldo,
                'recorded_by' => $userBendahara->id,
                'description' => $kasIn->keterangan
            ]);

            // 2. Expense (Small) ~ 3-5jt
            $nominalOut = rand(3000000, 5000000);
            $saldo -= $nominalOut;

            $kasOut = Kas::create([
                'tanggal' => $dateOut,
                'tipe' => 'keluar',
                'kategori' => 'Operasional Rutin',
                'kategori_id' => $kategoriMap['KGN']->id ?? 2, // Fallback
                'nominal' => $nominalOut,
                'keterangan' => 'Biaya Operasional & Kegiatan Bulanan',
                'recorded_by' => $userBendahara->id,
            ]);

            Transaction::create([
                'tanggal' => $kasOut->tanggal,
                'type' => 'out',
                'kategori' => $kasOut->kategori,
                'kategori_id' => $kasOut->kategori_id,
                'reference_table' => 'kas',
                'reference_id' => $kasOut->id,
                'amount' => $nominalOut,
                'balance_after' => $saldo,
                'recorded_by' => $userBendahara->id,
                'description' => $kasOut->keterangan
            ]);
        }
    }
}
