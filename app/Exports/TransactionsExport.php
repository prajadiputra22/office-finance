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

class TransactionsExport implements FromCollection, WithHeadings, WithColumnWidths, WithStyles, WithEvents
{
    private $transactions;
    
    public function __construct()
    {
        $this->transactions = Transaction::with('category')->orderBy('date')->get();
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
                    $attachmentInfo = "❌ File tidak ditemukan";
                }
            } else {
                $attachmentInfo = "➖ Tidak ada lampiran";
            }

            return [
                $index + 1,
                optional($t->date)->format('Y-m-d'),
                $t->type,
                optional($t->category)->category_name,
                $t->description,
                (float) $t->amount,
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
            'No Faktur',
            'Tanggal Faktur',
            'Lampiran'
        ];
    }

    public function columnWidths(): array
    {
        return [
            'A' => 5,   // No
            'B' => 12,  // Tanggal
            'C' => 12,  // Jenis
            'D' => 20,  // Kategori
            'E' => 30,  // Keterangan
            'F' => 15,  // Nominal
            'G' => 15,  // No Faktur
            'H' => 12,  // Tanggal Faktur
            'I' => 25,  // Lampiran
        ];
    }

    public function styles(Worksheet $sheet)
    {
        return [
            // Style header
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
            // Style untuk kolom lampiran
            'I:I' => [
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
                            // Buat URL yang dapat diakses
                            $fileUrl = asset('storage/' . $transaction->attachment);
                            
                            // Tambahkan hyperlink ke cell
                            $sheet->getCell('I' . $row)->getHyperlink()->setUrl($fileUrl);
                            
                            // Style hyperlink
                            $sheet->getStyle('I' . $row)->getFont()
                                ->setUnderline(true)
                                ->getColor()->setARGB('FF0000FF');
                                
                            // Tambahkan tooltip
                            $fileName = basename($transaction->attachment);
                            $sheet->getComment('I' . $row)
                                ->setAuthor('System')
                                ->getText()->createTextRun('Klik untuk membuka: ' . $fileName);
                        } else {
                            // Style untuk file yang tidak ditemukan
                            $sheet->getStyle('I' . $row)->getFont()
                                ->getColor()->setARGB('FFFF0000');
                        }
                    }
                    $row++;
                }
                
                // Freeze header row agar tetap terlihat saat scroll
                $sheet->freezePane('A2');
                
                // Tambahkan auto filter untuk memudahkan pencarian
                $sheet->setAutoFilter('A1:I1');
                
                // Set row height yang konsisten
                $sheet->getDefaultRowDimension()->setRowHeight(18);
                
                $highestRow = $sheet->getHighestRow();
                $sheet->getStyle('A1:I' . $highestRow)->getBorders()->getAllBorders()
                    ->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
            },
        ];
    }
}