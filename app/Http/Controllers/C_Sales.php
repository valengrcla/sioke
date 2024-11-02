<?php

namespace App\Http\Controllers;

use App\Models\Customer;
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
        // Mencari data Sales berdasarkan id_sales
        $sales = Sales::findOrFail($id_nota);
        // $customer = Customer::findOrFail($sales->id_customer);
        // dd($sales, $customer);
        // Mengarahkan ke tampilan detail dengan data sales
        return view("sales.detail", compact('sales'));
    }
}
 