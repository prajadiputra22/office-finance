<?php

namespace App\Exports;

use App\Models\Transaction;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\RichText\RichText;

class CategoryTransactionsExport implements FromCollection, WithHeadings, WithColumnWidths, WithStyles, WithEvents
{
    private $transactions;

    public function __construct(int $categoryId, string $type, ?int $year = null)
    {
        $query = Transaction::with('category')
            ->where('category_id', $categoryId)
            ->where('type', $type)
            ->orderBy('date');
        
        if ($year) {
            $query->whereYear('date', $year);
        }
        
        $this->transactions = $query->get();
    }

    public function collection(): Collection
    {
        return $this->transactions->map(function ($t, $index) {
            $attachmentInfo = '';
            if ($t->attachment) {
                $filePath = storage_path('app/public/' . $t->attachment);
                if (file_exists($filePath)) {
                    $fileName = basename($t->attachment);
                    $fileExtension = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));

                    if (in_array($fileExtension, ['jpg', 'jpeg', 'png', 'gif', 'bmp', 'webp'])) {
                        $attachmentInfo = "🖼️ " . $fileName;
                    } elseif ($fileExtension === 'pdf') {
                        $attachmentInfo = "📄 " . $fileName;
                    } else {
                        $attachmentInfo = "📎 " . $fileName;
                    }
                } else {
                    $attachmentInfo = " File tidak ditemukan";
                }
            } else {
                $attachmentInfo = " Tidak ada lampiran";
            }

            $paymentMethod = match($t->payment) {
                'cash' => 'Tunai',
                'transfer' => 'Transfer',
                'giro' => 'Giro',
                default => ucfirst($t->payment ?? '-')
            };

            return [
                $index + 1,
                optional($t->date)->format('Y-m-d'),
                $t->type,
                optional($t->category)->category_name,
                $t->description,
                (float) $t->amount,
                $paymentMethod,
                $t->no_factur,
                optional($t->date_factur)->format('Y-m-d'),
                $attachmentInfo,
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
            'Metode Pembayaran',
            'No Faktur',
            'Tanggal Faktur',
            'Lampiran'
        ];
    }

    public function columnWidths(): array
    {
        return [
            'A' => 5,
            'B' => 12,
            'C' => 12,
            'D' => 20,
            'E' => 30,
            'F' => 15,
            'G' => 18,
            'H' => 15,
            'I' => 12,
            'J' => 25,
        ];
    }

    public function styles(Worksheet $sheet)
    {
        return [
            1 => [
                'font' => ['bold' => true, 'size' => 11],
                'alignment' => [
                    'horizontal' => Alignment::HORIZONTAL_CENTER,
                    'vertical' => Alignment::VERTICAL_CENTER,
                ],
                'fill' => [
                    'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                    'startColor' => ['argb' => 'FFE6E6FA']
                ]
            ],
            'J:J' => [
                'alignment' => [
                    'horizontal' => Alignment::HORIZONTAL_LEFT,
                    'vertical' => Alignment::VERTICAL_CENTER,
                ],
                'wrapText' => true,
            ],
        ];
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function(AfterSheet $event) {
                $sheet = $event->sheet->getDelegate();

                $row = 2;
                foreach ($this->transactions as $transaction) {
                    if ($transaction->attachment) {
                        $attachmentPath = storage_path('app/public/' . $transaction->attachment);
                        if (file_exists($attachmentPath)) {
                            $fileUrl = asset('storage/' . $transaction->attachment);
                            $sheet->getCell('J' . $row)->getHyperlink()->setUrl($fileUrl);
                            $sheet->getStyle('J' . $row)->getFont()
                                ->setUnderline(true)
                                ->getColor()->setARGB('FF0000FF');

                            $fileName = basename($transaction->attachment);
                            $richText = new RichText();
                            $richText->createText('Klik untuk membuka: ' . $fileName);
                            $sheet->getComment('J' . $row)
                                ->setAuthor('System')
                                ->setText($richText);
                        } else {
                            $sheet->getStyle('J' . $row)->getFont()
                                ->getColor()->setARGB('FFFF0000');
                        }
                    }
                    $row++;
                }

                $sheet->freezePane('A2');
                $sheet->setAutoFilter('A1:J1');
                $sheet->getDefaultRowDimension()->setRowHeight(18);

                $highestRow = $sheet->getHighestRow();
                $sheet->getStyle('A1:J' . $highestRow)->getBorders()->getAllBorders()
                    ->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
            },
        ];
    }
}