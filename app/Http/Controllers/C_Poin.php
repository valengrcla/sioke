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
        ->paginate(10); 
        
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
            'product' => 'required|array',
            'product.*.id_product' => 'required|exists:product,id_product',
            'product.*.quantity' => 'required|integer|min:1',
        ]);

        // dd($request->all());

        // Hitung total penukaran poin
        $total_penukaran = 0;
        foreach ($request->product as $product) {
            $harga_poinproduct = Product::find($product['id_product'])->harga_poinproduct;
            $total_penukaran += $harga_poinproduct * $product['quantity'];
        }

        // Periksa apakah customer punya cukup poin
        $customer = Customer::find($request->id_customer);
        if ($customer->totalpoin_customer < $total_penukaran) {
            return redirect()->back()->withErrors('Customer tidak memiliki cukup poin untuk transaksi ini.');
        }

        // Deduct poin dari customer
        $customer->totalpoin_customer -= $total_penukaran;
        $customer->save();

        $id_penukaran = null;
        foreach ($request->product as $product) {
            $harga_poinproduct = Product::find($product['id_product'])->harga_poinproduct;
            $quantity = $product['quantity'];
            $total_poin_product = $harga_poinproduct * $quantity;

            // Buat entri Penukaran
            $penukaran = Penukaran::create([
                'id_customer' => $request->id_customer,
                'id_product' => $product['id_product'],
                'quantity' => $quantity,
                'total_penukaranpoin' => $total_poin_product,
            ]);

            // Ambil id_penukaran dari penukaran yang baru dibuat
            $id_penukaran = $penukaran->id_penukaran;
        }

        // Setelah Penukaran berhasil dibuat, buat entri Poin
        Poin::create([
            'id_customer' => $request->id_customer,
            'aktivitas' => 'penukaran',
            'poin' => $total_penukaran,
            'id_penukaran' => $id_penukaran,  // Memasukkan id_penukaran yang baru dibuat
        ]);

        return redirect()->route('poin.index')->with('success', 'Poin transaction berhasil dibuat!');
    }
}
