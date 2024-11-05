<?php
 
namespace App\Http\Controllers;
 
use Illuminate\Http\Request;
use App\Models\Sales;
use Carbon\Carbon;
 
 
class C_Dashboard extends Controller
{
    public function index() {
        $totalPendapatan = \App\Models\Sales::sum('total_harga');
        $totalSales = \App\Models\Sales::count();
        $totalProduct = \App\Models\Product::count();
        $totalCustomer = \App\Models\Customer::count();
        
        $lastSales = Sales::orderBy('created_at', 'desc')->take(5)->get();

        $salesData = Sales::selectRaw('MONTH(created_at) as month, SUM(total_harga) as total_sales')
        ->whereYear('created_at', Carbon::now()->year) // Ambil data untuk tahun berjalan
        ->groupBy('month')
        ->orderBy('month')
        ->pluck('total_sales', 'month'); // Ambil nilai bulan dan total penjualan di bulan tersebut

    // Pastikan array terisi 12 bulan, isi dengan 0 jika bulan tidak ada penjualan
        $monthlySales = [];
        for ($i = 1; $i <= 12; $i++) {
            $monthlySales[] = $salesData->get($i, 0); // Isi 0 jika tidak ada data di bulan tersebut
        }
        // return view('dashboard');
        return view('dashboard', compact('totalPendapatan', 'totalSales', 'totalProduct', 'totalCustomer', 'monthlySales', 'lastSales'));
    }
}