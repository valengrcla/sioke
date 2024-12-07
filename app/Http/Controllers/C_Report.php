<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Exports\ReportExport;
use Maatwebsite\Excel\Facades\Excel;

class C_Report extends Controller
{
    private function getReportData($tanggalAwal, $tanggalAkhir, $search = null)
    {   
        if ($tanggalAwal && $tanggalAkhir) {
            $tanggalAwal = $tanggalAwal . ' 00:00:00'; 
            $tanggalAkhir = $tanggalAkhir . ' 23:59:59'; 
        }

        $query = DB::table('sales')
            ->leftjoin('customer', 'sales.id_customer', '=', 'customer.id_customer')
            ->join('detail_sales', 'sales.id_nota', '=', 'detail_sales.id_nota')
            ->join('product', 'detail_sales.id_product', '=', 'product.id_product')
            ->join('pengguna', 'sales.id_pengguna', '=', 'pengguna.id_pengguna')
            ->select(
                'sales.id_nota',
                DB::raw('DATE(sales.created_at) as tanggalPenjualan'),
                'customer.nama_customer',
                DB::raw('IFNULL(customer.nama_customer, "Without Member") as nama_customer'),
                DB::raw('GROUP_CONCAT(product.nama_product SEPARATOR ", ") as namaMenu'),
                DB::raw('GROUP_CONCAT(detail_sales.quantity SEPARATOR  ", ") as totalQuantity'),
                DB::raw('GROUP_CONCAT(detail_sales.quantity * product.harga_product SEPARATOR  ", ") as subtotal'),
                'sales.total_harga',
                'pengguna.nama_pengguna'
            )
            ->when($tanggalAwal && $tanggalAkhir, function ($query) use ($tanggalAwal, $tanggalAkhir) {
                return $query->whereBetween('sales.created_at', [$tanggalAwal, $tanggalAkhir]);
            })

            ->when($search, function ($query, $search) {
                return $query->where(function ($q) use ($search) {
                    $q->where('sales.id_nota', 'like', "%{$search}%")
                        ->orWhere('customer.nama_customer', 'like', "%{$search}%")
                        ->orWhere('product.nama_product', 'like', "%{$search}%");
                });
            });
 
        $report = $query->groupBy('sales.id_nota', 'sales.created_at', 'customer.nama_customer', 'sales.total_harga', 'pengguna.nama_pengguna')
                        ->orderBy('sales.created_at', 'DESC')
                        ->get();

        $totalTransaksi = $report->sum('total_harga');
        
        return ['report' => $report, 'totalTransaksi' => $totalTransaksi];
    }

    // Fungsi untuk mendapatkan report berdasarkan filter tanggal dan pencarian
    public function getReport(Request $request)
    {
        $tanggalAwal = $request->get('tanggal_awal');
        $tanggalAkhir = $request->get('tanggal_akhir');
        $search = $request->get('search'); 

        if (empty($tanggalAwal) || empty($tanggalAkhir)) {
            $tanggalAwal = null;
            $tanggalAkhir = null;
        }

        // Memanggil fungsi untuk mendapatkan data report berdasarkan parameter
        $dataReport = $this->getReportData($tanggalAwal, $tanggalAkhir, $search);

        return view('report.index', [
            'report' => $dataReport['report'],
            'totalTransaksi' => $dataReport['totalTransaksi'],
            'tanggalAwal' => $tanggalAwal,
            'tanggalAkhir' => $tanggalAkhir,
            'search' => $search 
        ]);
    }

    // Fungsi untuk mengekspor data report ke file Excel
    public function exportExcel(Request $request)
    {
        $tanggalAwal = $request->get('tanggal_awal');
        $tanggalAkhir = $request->get('tanggal_akhir');
        $search = $request->get('search');

        // Memanggil fungsi untuk mendapatkan data report berdasarkan filter tanggal
        $dataReport = $this->getReportData($tanggalAwal, $tanggalAkhir, $search);
        $reportCollection = collect($dataReport['report']);

        // Mengekspor data ke file Excel
        return Excel::download(new ReportExport($reportCollection), 'report.xlsx');
    }
}
