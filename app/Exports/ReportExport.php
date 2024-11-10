<?php

namespace App\Exports;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithTitle;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class ReportExport implements FromView, WithColumnWidths, WithStyles
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
            'totalTransaksi' => $totalTransaksi, // Mengirim total transaksi ke view
        ]);
    }

    /**
     * Set custom column widths based on data length.
     *
     * @return array
     */
    public function columnWidths(): array
    {
        return [
            'A' => 15, // ID Nota
            'B' => 20, // Tanggal Penjualan
            'C' => 25, // Nama Customer
            'D' => 30, // Menu
            'E' => 15, // Total Quantity
            'F' => 20, // Total Harga
        ];
    }

    /**
     * Apply styles for the worksheet.
     *
     * @param Worksheet $sheet
     * @return void
     */
    public function styles(Worksheet $sheet)
    {
        // Adjust the header row (bold)
        $sheet->getStyle('A1:F1')->getFont()->setBold(true);

        // Set auto-size for columns (if desired)
        foreach (range('A', 'F') as $col) {
            $sheet->getColumnDimension($col)->setAutoSize(true);
        }
    }
}
