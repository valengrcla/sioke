<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Exports\ReportExport;
use Maatwebsite\Excel\Facades\Excel;

class C_Report extends Controller
{
    private function getReportData($tanggalAwal, $tanggalAkhir)
    {   
        if ($tanggalAwal && $tanggalAkhir) {
            $tanggalAwal = $tanggalAwal . ' 00:00:00'; // Set tanggalAwal ke jam 00:00:00
            $tanggalAkhir = $tanggalAkhir . ' 23:59:59'; // Set tanggalAkhir ke jam 23:59:59
        }

        $report = DB::table('sales')
            ->join('customer', 'sales.id_customer', '=', 'customer.id_customer')
            ->join('detail_sales', 'sales.id_nota', '=', 'detail_sales.id_nota')
            ->join('product', 'detail_sales.id_product', '=', 'product.id_product')
            ->select(
                'sales.id_nota',
                DB::raw('DATE(sales.created_at) as tanggalPenjualan'),
                'customer.nama_customer',
                DB::raw('GROUP_CONCAT(product.nama_product SEPARATOR ", ") as namaMenu'),
                DB::raw('SUM(detail_sales.quantity) as totalQuantity'),
                'sales.total_harga'
            )
            ->when($tanggalAwal && $tanggalAkhir, function ($query) use ($tanggalAwal, $tanggalAkhir) {
                return $query->whereBetween('sales.created_at', [$tanggalAwal, $tanggalAkhir]);
            })
            ->groupBy('sales.id_nota', 'sales.created_at', 'customer.nama_customer', 'sales.total_harga')
            ->orderBy('sales.created_at', 'DESC')
            ->get();

        $totalTransaksi = $report->sum('total_harga');
        
        return ['report' => $report, 'totalTransaksi' => $totalTransaksi];
    }

    public function getReport(Request $request)
    {
        $tanggalAwal = $request->get('tanggal_awal');
        $tanggalAkhir = $request->get('tanggal_akhir');

        if (empty($tanggalAwal) || empty($tanggalAkhir)) {
            $tanggalAwal = null;
            $tanggalAkhir = null;
        }

        $dataReport = $this->getReportData($tanggalAwal, $tanggalAkhir);

        return view('report.index', [
            'report' => $dataReport['report'],
            'totalTransaksi' => $dataReport['totalTransaksi'],
            'tanggalAwal' => $tanggalAwal,
            'tanggalAkhir' => $tanggalAkhir
        ]);
    }

    public function exportExcel(Request $request)
    {
        $tanggalAwal = $request->get('tanggal_awal');
        $tanggalAkhir = $request->get('tanggal_akhir');

        $dataReport = $this->getReportData($tanggalAwal, $tanggalAkhir);
        $reportCollection = collect($dataReport['report']);

        return Excel::download(new ReportExport($reportCollection), 'report.xlsx');
    }
}
