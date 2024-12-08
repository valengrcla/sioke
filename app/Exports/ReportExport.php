<?php
 
namespace App\Exports;
 
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
 
class ReportExport implements FromView, WithStyles
{
    protected $report;
 
    public function __construct($report)
    {
        $this->report = $report;
    }
 
    public function view(): View
    {
        // Hitung total transaksi dengan menjumlahkan total_harga
        $totalTransaksi = $this->report->sum('total_harga');
       
        // Kirim data laporan dan total transaksi ke view
        return view('report.export', [
            'report' => $this->report,
            'totalTransaksi' => $totalTransaksi,
        ]);
    }
 
    /**
     * Set custom column widths based on data length.
     *
     * @return array
     */
 
    /**
     * Apply styles for the worksheet.
     *
     * @param Worksheet $sheet
     * @return void
     */
    public function styles(Worksheet $sheet)
    {
        // Adjust the header row (bold)
        $sheet->getStyle('A1:H1')->getFont()->setBold(true);
        $sheet->getStyle('A1:H1')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
        ->getStartColor()->setARGB('80C4E9');
        
        $columns = ['A', 'B', 'C', 'D', 'E', 'F', 'G', 'H'];
        foreach ($columns as $col) {
            $sheet->getStyle("$col:$col")
                ->getAlignment()
                ->setHorizontal('center')
                ->setVertical('center');
        }
 
        $lastRow = $sheet->getHighestRow();
        $sheet->getStyle("A1:H$lastRow")
            ->getBorders()
            ->getAllBorders()
            ->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
 
        // Set auto-size for columns (if desired)
        foreach (range('A', 'H') as $col) {
            $sheet->getColumnDimension($col)->setAutoSize(true);
        }

        $sheet->getStyle("A2:A$lastRow")
            ->getAlignment()
            ->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER)
            ->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER);

        $sheet->getStyle("H2:H$lastRow")
            ->getAlignment()
            ->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER)
            ->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER);
    }
}