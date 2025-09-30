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

            // Format payment method untuk lebih readable
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
            'A' => 5,   // No
            'B' => 12,  // Tanggal
            'C' => 12,  // Jenis
            'D' => 20,  // Kategori
            'E' => 30,  // Keterangan
            'F' => 15,  // Nominal
            'G' => 18,  // Metode Pembayaran (new)
            'H' => 15,  // No Faktur
            'I' => 12,  // Tanggal Faktur
            'J' => 25,  // Lampiran
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
                            // Buat URL yang dapat diakses
                            $fileUrl = asset('storage/' . $transaction->attachment);
                            
                            // Tambahkan hyperlink ke cell
                            $sheet->getCell('J' . $row)->getHyperlink()->setUrl($fileUrl);
                            
                            // Style hyperlink
                            $sheet->getStyle('J' . $row)->getFont()
                                ->setUnderline(true)
                                ->getColor()->setARGB('FF0000FF');
                                
                            // Tambahkan tooltip
                            $fileName = basename($transaction->attachment);
                            $sheet->getComment('J' . $row)
                                ->setAuthor('System')
                                ->getText()->createTextRun('Klik untuk membuka: ' . $fileName);
                        } else {
                            // Style file yang tidak ditemukan
                            $sheet->getStyle('J' . $row)->getFont()
                                ->getColor()->setARGB('FFFF0000');
                        }
                    }
                    $row++;
                }
                
                // Freeze header row
                $sheet->freezePane('A2');
                
                // auto filter
                $sheet->setAutoFilter('A1:J1');
                
                // Set row height
                $sheet->getDefaultRowDimension()->setRowHeight(18);
                
                // Add borders
                $highestRow = $sheet->getHighestRow();
                $sheet->getStyle('A1:J' . $highestRow)->getBorders()->getAllBorders()
                    ->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
            },
        ];
    }
}