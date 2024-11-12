<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use Illuminate\Support\Str;

class C_Product extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');
        
        if ($search) {
            $product = Product:: where('nama_product', 'like', '%' . $search . '%')
                        ->orWhere('harga_product', 'like', '%' . $search . '%')
                        ->orderBy('created_at', 'desc')
                        ->get();
        } else {
            $product = Product::orderBy('created_at', 'desc')->get(); 
        }

        return view("product.index", compact('product'));
    }

    public function create()
    {
        return view('product.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_product' => 'required|string|max:100|unique:product,nama_product',
            'harga_product' => 'required|numeric',
            'harga_poinproduct' => 'required|numeric',
            'product_img' => 'nullable|image|mimes:jpeg,png,jpg|max:200',
        ], [
            'nama_product.unique' => 'Nama produk sudah digunakan. Silakan pilih nama lain.',
            'harga_product.numeric' => 'Harga harus dalam angka',
            'harga_poinproduct.numeric' => 'Harga harus dalam angka',
        ]);
        $fotoPath = ''; // Default path jika tidak ada gambar di-upload

        // Cek dan simpan gambar jika di-upload
        if ($request->hasFile('product_img')) {
            $product_img = $request->file('product_img');
            $imageName = $product_img->getClientOriginalName();
            $product_img->move(public_path('images/product'), $imageName);
            $fotoPath = $imageName;
        }

        // Buat data pengguna baru
        Product::create([
            'id_product' => Str::uuid(), 
            'nama_product' => $request->input('nama_product'),
            'harga_product' => $request->input('harga_product'),
            'harga_poinproduct' => $request->input('harga_poinproduct'),
            'product_img' => $fotoPath,
        ]);

        return redirect()->route('product.index')->with('success', 'Product created successfully!');
    }

    public function edit($id_product)
    {
        $product = Product::findOrFail($id_product); // Mengambil product berdasarkan ID

        return view('product.edit', compact('product'));
    }

    public function update(Request $request, $id_product)
    {
        $product = Product::findOrFail($id_product);

        $request->validate([
            'nama_product' => 'required|string|max:100|unique:product,nama_product,' . $product->id_product . ',id_product',
            'harga_product' => 'required|numeric',
            'harga_poinproduct' => 'required|numeric',
            'product_img' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ], [
            'nama_product.unique' => 'Nama produk sudah digunakan. Silakan pilih nama lain.',
            'harga_product.numeric' => 'Harga harus dalam angka',
            'harga_poinproduct.numeric' => 'Harga harus dalam angka',
        ]);
        $product = Product::findOrFail($id_product);

        $product->nama_product = $request->input('nama_product');
        $product->harga_product = $request->input('harga_product');
        $product->harga_poinproduct = $request->input('harga_poinproduct');

        $fotoPath = $product->product_img; // Default path jika tidak ada gambar di-upload

        // Cek dan simpan gambar jika di-upload
        if ($request->hasFile('product_img')) {
            $product_img = $request->file('product_img');
            $imageName = $product_img->getClientOriginalName();
            $product_img->move(public_path('images/product'), $imageName);
            $fotoPath = $imageName;
        }

        $product->update([
            'nama_product' => $request->input('nama_product'),
            'harga_product' => $request->input('harga_product'),
            'harga_poinproduct' => $request->input('harga_poinproduct'),
            'product_img' => $fotoPath,
        ]);

        $product->save();

        return redirect()->route('product.index')->with('success', 'Product updated successfully!');
    }

    public function delete($id_product)
    {
        $product = Product::findOrFail($id_product);  // Jika ID tidak ditemukan, akan mengarah ke 404
        $product->delete();

        return redirect()->route('product.index')->with('success', 'Product deleted successfully!');
    }
}
 