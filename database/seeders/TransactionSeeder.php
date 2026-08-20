<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class TransactionSeeder extends Seeder
{
    /**
     * Seeder ini menghasilkan data transaksi harian (5-7 transaksi/hari)
     * untuk periode Februari 2025 - Juni 2026, mencakup transaksi income
     * dan expenditure, dengan sebagian transaksi memiliki faktur
     * (date_factur, no_factur) dan sebagian tidak.
     *
     * - Jika payment = 'giro', date_maturity (tanggal cair) SELALU diisi,
     *   terlepas dari ada/tidaknya faktur, karena dipakai oleh
     *   scopeGiroPending()/scopeGiroCleared() di model Transaction.
     * - date_maturity giro dibatasi tidak melewati Carbon::now(), supaya
     *   semua transaksi giro yang di-seed sudah cleared (tidak ada yang pending).
     * - Selain giro, date_maturity dibiarkan null.
     *
     * Catatan:
     * - category_id income: 1-4 (Perusahaan A, B, C, D)
     * - category_id expenditure: 5-8 (Kas Kecil, Kas Besar, Hutang Perusahaan, Gaji)
     *   Sesuai data yang di-seed oleh CategorySeeder.
     */
    public function run(): void
    {
        $incomeCategories = [1, 2, 3, 4];
        $expenditureCategories = [5, 6, 7, 8];
        $paymentMethods = ['cash', 'transfer', 'giro'];

        $incomeDescriptions = [
            'Pendapatan penjualan produk',
            'Pembayaran piutang customer',
            'Pendapatan jasa konsultasi',
            'Setoran modal',
            'Pendapatan sewa ruangan',
            'Pendapatan komisi',
            null,
            null,
        ];

        $expenditureDescriptions = [
            'Pembelian ATK',
            'Pembayaran gaji karyawan',
            'Biaya listrik dan air',
            'Biaya internet dan telepon',
            'Pembelian peralatan kantor',
            'Biaya transportasi',
            'Biaya konsumsi rapat',
            'Pembayaran supplier',
            'Biaya maintenance',
            'Pajak dan retribusi',
            null,
            null,
        ];

        $startDate = Carbon::create(2025, 2, 1);
        $endDate = Carbon::create(2026, 6, 30);

        $batch = [];
        $batchSize = 500;

        for ($date = $startDate->copy(); $date->lte($endDate); $date->addDay()) {
            $dailyCount = rand(5, 7);

            for ($i = 0; $i < $dailyCount; $i++) {
                // Sedikit lebih banyak expenditure daripada income, mirip pola kas kantor
                $type = (rand(1, 100) <= 45) ? 'income' : 'expenditure';

                if ($type === 'income') {
                    $categoryId = $incomeCategories[array_rand($incomeCategories)];
                    $amount = rand(20, 300) * 1000000; // 20jt - 300jt
                    $description = $incomeDescriptions[array_rand($incomeDescriptions)];
                } else {
                    $categoryId = $expenditureCategories[array_rand($expenditureCategories)];
                    $amount = rand(1, 200) * 1000000; // 1jt - 200jt
                    $description = $expenditureDescriptions[array_rand($expenditureDescriptions)];
                }

                $payment = $paymentMethods[array_rand($paymentMethods)];

                // ~30% transaksi punya faktur (date_factur & no_factur), lepas dari metode pembayaran
                $hasFactur = rand(1, 100) <= 30;

                $dateFactur = null;
                $noFactur = null;

                if ($hasFactur) {
                    $dateFactur = $date->copy()->subDays(rand(0, 5));
                    $noFactur = rand(1000, 999999);
                }

                // Kalau metode pembayarannya giro, tanggal cair (date_maturity) wajib diisi
                // dan tidak boleh melewati hari ini, supaya semua giro sudah cleared (tidak ada yang pending)
                $dateMaturity = null;
                if ($payment === 'giro') {
                    $dateMaturity = $date->copy()->addDays(rand(7, 30));
                    if ($dateMaturity->gt(Carbon::now())) {
                        $dateMaturity = Carbon::now()->copy();
                    }
                }

                // Tanggal entry biasanya menyusul beberapa hari setelah tanggal transaksi
                $dateEntry = $date->copy()->addDays(rand(0, 3));
                if ($dateEntry->gt($endDate)) {
                    $dateEntry = $date->copy();
                }

                // ~15% transaksi punya lampiran
                $attachment = (rand(1, 100) <= 15)
                    ? 'attachments/' . bin2hex(random_bytes(10)) . '.png'
                    : null;

                $createdAt = $dateEntry->copy()->setTime(rand(7, 17), rand(0, 59), rand(0, 59));
                $updatedAt = $createdAt->copy()->addMinutes(rand(0, 120));

                $batch[] = [
                    'type' => $type,
                    'category_id' => $categoryId,
                    'amount' => number_format($amount, 2, '.', ''),
                    'payment' => $payment,
                    'date_entry' => $dateEntry->toDateString(),
                    'description' => $description,
                    'date_factur' => $dateFactur?->toDateString(),
                    'date_maturity' => $dateMaturity?->toDateString(),
                    'no_factur' => $noFactur,
                    'date' => $date->toDateString(),
                    'attachment' => $attachment,
                    'created_at' => $createdAt,
                    'updated_at' => $updatedAt,
                ];

                if (count($batch) >= $batchSize) {
                    DB::table('transactions')->insert($batch);
                    $batch = [];
                }
            }
        }

        if (!empty($batch)) {
            DB::table('transactions')->insert($batch);
        }
    }
}