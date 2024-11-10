<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\Detail_sales;
use App\Models\Product;
use App\Models\Pengguna;
use Illuminate\Http\Request;
use App\Models\Sales;

class C_Sales extends Controller
{
    public function index(Request $request)
{
    $search = $request->input('search');

    $sales = Sales::when($search, function ($query, $search) {
        return $query->where('id_nota', 'like', '%' . $search . '%')
                     ->orWhereHas('customer', function ($query) use ($search) {
                         $query->where('nama_customer', 'like', '%' . $search . '%');
                     })
                     ->orWhereHas('pengguna', function ($query) use ($search) {
                         $query->where('nama_pengguna', 'like', '%' . $search . '%');
                     });
    })->get();

    return view("sales.index", compact('sales'));
}

    public function detail_sales($id_nota)
    {
        $sales = Sales::findOrFail($id_nota);
        $detailSales = Detail_sales::join('product', 'detail_sales.id_product', '=', 'product.id_product')
        ->where('detail_sales.id_nota', $sales->id_nota)->get();
        return view("sales.detail", compact('sales', 'detailSales'));
    }

    public function create()
    {
        $customer = Customer::all(); // Retrieve all customers
        $pengguna = Pengguna::all(); // Retrieve all users (or staff)
        $product = Product::all();   // Retrieve all products

        return view("sales.create", compact('customer', 'pengguna', 'product'));
    }

    public function store(Request $request)
    {
        // Validate the input data
        $request->validate([
            'id_pengguna' => 'required|exists:pengguna,id_pengguna',
            'id_customer' => 'required|exists:customer,id_customer',
            'product' => 'required|array',
            'product.*.id_product' => 'required|exists:product,id_product',
            'product.*.quantity' => 'required|integer|min:1',
            'total_harga' => 'required|numeric',
            'bayar' => 'required|numeric|min:' . $request->total_harga,
        ]);

        // Create Sales entry
        $sales = Sales::create([
            'id_pengguna' => $request->id_pengguna,
            'id_customer' => $request->id_customer,
            'total_harga' => $request->total_harga,
            'bayar' => $request->bayar,
        ]);

        // Create Detail Sales entries for each product
        foreach ($request->product as $product) {
            Detail_sales::create([
                'id_nota' => $sales->id_nota,
                'id_product' => $product['id_product'],
                'quantity' => $product['quantity'],
                'harga' => Product::find($product['id_product'])->harga_product, // Assuming `harga_product` is the product price
            ]);
        }

        return redirect()->route('sales.index')->with('success', 'Sales created successfully!');
    }
    
}
 