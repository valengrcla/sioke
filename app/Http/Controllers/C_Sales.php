<?php
 
namespace App\Http\Controllers;
 
use App\Models\Customer;
use App\Models\Detail_sales;
use App\Models\Product;
use App\Models\Pengguna;
use App\Models\Poin;
use Illuminate\Http\Request;
use App\Models\Sales;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Log;
 
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
        })
        ->orderBy('created_at', 'desc')
        ->get();
 
        return view("sales.index", compact('sales'));
    }
 
    public function detail_sales($id_nota)
    {
        // Mengambil sales berdasarkan ID Nota dengan memuat relasi 'detail_sales' dan 'product'
        $sales = Sales::with('detail_sales.product')->findOrFail($id_nota);
 
        return view("sales.detail", compact('sales'));
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
 
        $total_pembayaran = $request->bayar;
        $total_kembali = $total_pembayaran - $request->total_harga;
 
        $sales = Sales::create([
            // 'id_nota' => $id_nota,
            'id_pengguna' => $request->id_pengguna,
            'id_customer' => $request->id_customer,
            'total_harga' => $request->total_harga,
            'total_pembayaran' => $total_pembayaran,  // Isi dengan nilai bayar
            'total_kembali' => $total_kembali,
        ]);
        $sales->refresh();
                // Cek apakah ID Nota berhasil di-generate dan disimpan
        if (!$sales || empty($sales->id_nota)) {
            Log::error('Gagal menyimpan Sales atau UUID tidak valid.');
            return back()->with('error', 'Gagal menyimpan data sales.');
        }

        // Create Detail Sales entries for each product
        foreach ($request->product as $product) {
            $productModel = Product::findOrFail($product['id_product']);
            $harga_product = $productModel->harga_product;
            $subtotal = $harga_product * $product['quantity'];
 
            Detail_sales::create([
                'id_nota' => $sales->id_nota,
                'id_product' => $product['id_product'],
                'quantity' => $product['quantity'],
                'harga' => $harga_product,
                'subtotal' => $subtotal,
            ]);
        }

        // Tambahkan poin ke customer terkait
        $customer = Customer::findOrFail($request->id_customer); // Ambil data customer terkait
        $customer->increment('totalpoin_customer', 1); // Tambah 1 poin
        
        Poin::create([
            'id_customer' => $customer->id_customer,
            'aktivitas' => 'penambahan',
            'poin' => 1,
            'id_nota' => $sales->id_nota,
        ]);
 
        return redirect()->route('sales.index')->with('success', 'Sales created successfully!');
    }
   
}