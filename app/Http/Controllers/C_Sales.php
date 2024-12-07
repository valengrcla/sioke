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
use Illuminate\Support\Facades\Auth;
 
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
        ->whereMonth('created_at', date('m')) 
        ->whereYear('created_at', date('Y')) 
        ->orderBy('created_at', 'desc')
        ->paginate(9); 
 
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
        $customer = Customer::all(); 
        $pengguna = Pengguna::all(); 
        $product = Product::all();   
 
        return view("sales.create", compact('customer', 'pengguna', 'product'));
    }
 
    public function store(Request $request)
    {
        $request->validate([
            'id_pengguna' => 'required|exists:pengguna,id_pengguna',
            'id_customer' => 'nullable|exists:customer,id_customer', 
            'product' => 'required|array',
            'product.*.id_product' => 'required|exists:product,id_product',
            'product.*.quantity' => 'required|integer|min:1',
            'total_harga' => 'required|numeric',
            'bayar' => 'required|numeric',
        ]);

        $total_pembayaran = $request->bayar;
        $total_kembali = $total_pembayaran - $request->total_harga;

        $currentUser = Auth::user();
        if (!$currentUser) {
            return back()->with('error', 'Anda harus login untuk melakukan transaksi.');
        }

        // Ambil id_customer (NULL jika tidak ada)
        $customerId = $request->id_customer;
        // Tetapkan gambar default untuk "Without Member"
        $customerImg = 'default-profile.png'; // Default image
        if (!is_null($customerId)) {
            $customer = Customer::find($customerId);
            $customerImg = $customer->customer_img ?? $customerImg; 
        }
 
        $sales = Sales::create([
            'id_pengguna' => $request->id_pengguna,
            'id_customer' => $customerId,
            'total_harga' => $request->total_harga,
            'total_pembayaran' => $total_pembayaran,  
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
        // Tambahkan poin jika customer ID tidak NULL
        if (!is_null($customerId)) {
            $customer = Customer::findOrFail($customerId);
            $customer->increment('totalpoin_customer', 1);

            Poin::create([
                'id_customer' => $customerId,
                'aktivitas' => 'penambahan',
                'poin' => 1,
                'id_nota' => $sales->id_nota,
            ]);
        }

        // Simpan gambar default untuk sales di dashboard
        $sales->customer_img = $customerImg;

        return redirect()->route('sales.index')->with('success', 'Sales created successfully!');
    }
   
}