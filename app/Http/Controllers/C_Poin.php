<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Poin;
use App\Models\Penukaran;
use App\Models\Customer;
use App\Models\Product;

class C_Poin extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');  
        
        $poin = Poin::when($search, function($query, $search) {
            return $query->where('id_poin', 'like', "%{$search}%")
                         ->orWhereHas('customer', function($query) use ($search) {
                             $query->where('nama_customer', 'like', "%{$search}%");
                         })
                         ->orWhere('aktivitas', 'like', "%{$search}%");
        })
        ->orderBy('created_at', 'desc')
        ->get();
        
        return view("poin.index", compact('poin'));
    }

    public function create()
    {
        $customer = Customer::all(); // Ambil semua customer
        $product = Product::all();   // Ambil semua produk

        return view('poin.create', compact('customer', 'product'));
    }

    public function store(Request $request)
    {
        // dd($request);
        // Validasi inputan
        $request->validate([
            'id_customer' => 'required|exists:customer,id_customer',
            // 'jumlah_poin' => 'required|integer|min:1',
            'product' => 'required|array',
            'product.*.id_product' => 'required|exists:product,id_product',
            'product.*.quantity' => 'required|integer|min:1',
        ]);

        // Hitung total penukaran poin
        $total_penukaran = 0;
        foreach ($request->product as $product) {
            $harga_poin_product = Product::find($product['id_product'])->harga_poinproduct;
            $total_penukaran += $harga_poin_product * $product['quantity'];
        }

        // Periksa apakah customer punya cukup poin
        $customer = Customer::find($request->id_customer);
        if ($customer->total_poincustomer < $total_penukaran) {
            return redirect()->back()->withErrors('Customer tidak memiliki cukup poin untuk transaksi ini.');
        }

        // Deduct poin dari customer
        $customer->total_poincustomer -= $total_penukaran;
        $customer->save();

        Poin::create([
            'id_customer' => $request->id_customer,
            'aktivitas' => 'penukaran',
            'poin' => $total_penukaran,  
        ]);

        Penukaran::create([
            'id_customer' => $request->id_customer,
            'poin' => $total_penukaran,
        ]);

        return redirect()->route('poin.index')->with('success', 'Poin transaction berhasil dibuat!');
    }
}
