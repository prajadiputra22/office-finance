<?php

namespace App\Exports;

use App\Models\Transaction;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class TransactionsExport implements FromCollection, WithHeadings
{
    public function collection(): Collection
    {
        $transactions = Transaction::with('category')->orderBy('date')->get()->values(); // ensure sequential keys

        return $transactions->map(function ($t, $index) {
            return [
                $index + 1,
                optional($t->date)->format('Y-m-d'),
                $t->type,
                optional($t->category)->category_name,
                $t->description,
                (float) $t->amount,
                $t->no_factur,
                optional($t->date_factur)->format('Y-m-d'),
            ];
        });
    }

    public function headings(): array
    {
        return [
            'No',
            'Tanggal',
            'Jenis',
            'Kategori',
            'Keterangan',
            'Nominal',
            'No Faktur',
            'Tanggal Faktur',
        ];
    }
}

