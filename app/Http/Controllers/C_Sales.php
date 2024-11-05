<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\Detail_sales;
use App\Models\Product;
use Illuminate\Http\Request;
use App\Models\Sales;

class C_Sales extends Controller
{
    public function index()
    {
        $sales=Sales::all();
        return view("sales/index", compact('sales'));
    }

    public function detail_sales($id_nota)
    {
        $sales = Sales::findOrFail($id_nota);
        $detailSales = Detail_sales::join('product', 'detail_sales.id_product', '=', 'product.id_product')
        ->where('detail_sales.id_nota', $sales->id_nota)->get();
        // dd($detailSales);
        return view("sales.detail", compact('sales', 'detailSales'));
    }
    
}
 