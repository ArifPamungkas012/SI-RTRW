<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;

// Models
use App\Models\{
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
        $faker = fake('id_ID');

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
         * 2. MASTER KATEGORI KEUANGAN
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
         * 3. METODE PEMBAYARAN
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
         * 4. DATA WARGA (40 ORANG)
         * =========================================================== */
        $warga = collect();
        for ($i = 0; $i < 40; $i++) {
            $warga->push(Warga::create([
                'nik' => $faker->unique()->numerify('3273##########'),
                'nama' => $faker->name(),
                'alamat' => 'Jl. Melati No. ' . $faker->numberBetween(1, 40),
                'no_rumah' => (string) $faker->numberBetween(1, 40),
                'rt' => '05',
                'rw' => '03',
                'no_hp' => $faker->phoneNumber(),
                'tanggal_lahir' => $faker->dateTimeBetween('-70 years', '-17 years'),
                'status_aktif' => 1
            ]));
        }

        /* ===========================================================
         * 5. USERS (admin, ketua, bendahara)
         * =========================================================== */
        $userAdmin = User::updateOrCreate(
            ['username' => 'admin'],
            [
                'name' => 'Admin RT',
                'email' => 'admin@example.com',
                'password' => Hash::make('password'),
                'role' => 'admin',
                'warga_id' => $warga[0]->id,
            ]
        );

        $userKetua = User::updateOrCreate(
            ['username' => 'ketua'],
            [
                'name' => 'Ketua RT',
                'email' => 'ketua@example.com',
                'password' => Hash::make('password'),
                'role' => 'pengurus',
                'warga_id' => $warga[1]->id,
            ]
        );

        $userBendahara = User::updateOrCreate(
            ['username' => 'bendahara'],
            [
                'name' => 'Bendahara RT',
                'email' => 'bendahara@example.com',
                'password' => Hash::make('password'),
                'role' => 'bendahara',
                'warga_id' => $warga[2]->id,
            ]
        );

        /* ===========================================================
         * 6. KARTU KELUARGA (15 KK)
         * =========================================================== */
        $kkList = collect();
        for ($i = 0; $i < 15; $i++) {
            $kk = KartuKeluarga::create([
                'no_kk' => '3273' . $faker->numerify('##########'),
                'alamat' => 'Jl. Melati No. ' . $faker->numberBetween(1, 40),
                'rt' => '05',
                'rw' => '03',
                'kepala_keluarga' => $warga[$i]->nama,
                'tanggal_dibuat' => Carbon::now()->subYears(rand(1, 10)),
            ]);
            $kkList->push($kk);

            // Set 2–4 anggota per KK
            $jumlahAnggota = rand(2, 4);
            for ($j = 0; $j < $jumlahAnggota; $j++) {
                AnggotaKK::create([
                    'kk_id' => $kk->id,
                    'warga_id' => $warga->random()->id,
                    'hubungan' => $j == 0 ? 'Kepala Keluarga' : $faker->randomElement(['Istri', 'Anak', 'Saudara']),
                ]);
            }
        }

        /* ===========================================================
         * 7. KEGIATAN (20 kegiatan)
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
         * 8. IURAN TEMPLATE (6 template)
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
         * 9. IURAN INSTANCES (12 bulan × 6 template)
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
         * 10. KAS (50 entri)
         * =========================================================== */
        $kasList = collect();
        $saldo = 0;

        for ($i = 0; $i < 50; $i++) {
            $isMasuk = rand(0, 1);
            $nominal = rand(10000, 200000);
            $saldo = $isMasuk ? $saldo + $nominal : $saldo - $nominal;

            $kas = Kas::create([
                'tanggal' => Carbon::now()->subDays(rand(1, 120)),
                'tipe' => $isMasuk ? 'masuk' : 'keluar',
                'kategori' => $faker->randomElement(['Iuran Warga', 'Dana Sosial', 'Kegiatan']),
                'kategori_id' => $kategoriMap['IRW']->id,
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
         * 11. PEMBAYARAN IURAN (150 entri acak)
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
         * 12. MUTASI WARGA (20 entri)
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
         * 13. NOTIFIKASI (30 notifikasi acak)
         * =========================================================== */
        for ($i = 0; $i < 30; $i++) {
            Notifikasi::create([
                'user_id' => $faker->randomElement([$userAdmin->id, $userKetua->id, $userBendahara->id]),
                'judul' => $faker->sentence(3),
                'pesan' => $faker->sentence(8),
                'tipe' => $faker->randomElement(['info', 'tagihan', 'sistem']),
                'data' => [],
                'dibaca_pada' => rand(0, 1) ? Carbon::now() : null,
            ]);
        }
    }
}
