<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Customer;
use Illuminate\Support\Str;

class C_Customer extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');

        if ($search) {
            $customer = Customer:: where('nama_customer', 'like', '%' . $search . '%')
                            ->orWhere('email_customer', 'like', '%' . $search . '%')
                            ->orWhere('nohp_customer', 'like', '%' . $search . '%')
                            ->orderBy('created_at', 'desc')
                            ->get();
        } else {
            $customer = Customer::orderBy('created_at', 'desc')->get(); 
        }

        return view("customer.index", compact('customer'));
    }

    public function create()
    {
        return view('customer.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_customer' => 'required|string|max:100',
            'email_customer' => 'required|email|unique:customer,email_customer',
            'nohp_customer' => 'required|string|max:13|unique:customer,nohp_customer',
            'customer_img' => 'nullable|image|mimes:jpeg,png,jpg|max:200',
        ]);
        $fotoPath = ''; // Default path jika tidak ada gambar di-upload

        // Cek dan simpan gambar jika di-upload
        if ($request->hasFile('customer_img')) {
            $customer_img = $request->file('customer_img');
            $imageName = $customer_img->getClientOriginalName();
            $customer_img->move(public_path('images/customer'), $imageName);
            $fotoPath = $imageName;
        }

        // Buat data pengguna baru
        Customer::create([
            'id_customer' => Str::uuid(), // Menggunakan UUID sebagai id_pengguna
            'nama_customer' => $request->input('nama_customer'),
            'email_customer' => $request->input('email_customer'),
            'nohp_customer' => $request->input('nohp_customer'),
            'customer_img' => $fotoPath,
            'totalpoin_customer' => 0,
            
        ]);

        return redirect()->route('customer.index')->with('success', 'Customer created successfully!');
    }

    // public function addPoints($points)
    // {
    //     $this->increment('totalpoin_customer', $points);
    // }

    public function edit($id_customer)
    {
        $customer = Customer::findOrFail($id_customer); // Mengambil pengguna berdasarkan ID

        return view('customer.edit', compact('customer'));
    }

    public function update(Request $request, $id_customer)
    {
        $request->validate([
            'nama_customer' => 'required|string|max:100',
            'email_customer' => 'required|string|unique:customer,email_customer,'. $id_customer. ',id_customer',
            'nohp_customer' => 'required|string|unique:customer,nohp_customer,'. $id_customer. ',id_customer',// Panjang minimal password
            'customer_img' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);
        $customer = Customer::findOrFail($id_customer);

        $customer->nama_customer = $request->input('nama_customer');
        $customer->email_customer = $request->input('email_customer');
        $customer->nohp_customer = $request->input('nohp_customer');

        $fotoPath = $customer->customer_img; // Default path jika tidak ada gambar di-upload

        // Cek dan simpan gambar jika di-upload
        if ($request->hasFile('customer_img')) {
            $customer_img = $request->file('customer_img');
            $imageName = $customer_img->getClientOriginalName();
            $customer_img->move(public_path('images/customer'), $imageName);
            $fotoPath = $imageName;
        }

        $customer->update([
            'nama_customer' => $request->input('nama_customer'),
            'email_customer' => $request->input('email_customer'),
            'nohp_customer' => $request->input('nohp_customer'),
            'customer_img' => $fotoPath,
        ]);

        $customer->save();

        return redirect()->route('customer.index')->with('success', 'Customer updated successfully!');
    }

    public function delete($id_customer)
    {
        $customer = Customer::findOrFail($id_customer);  // Jika ID tidak ditemukan, akan mengarah ke 404
        $customer->delete();

        return redirect()->route('customer.index')->with('success', 'Customer deleted successfully!');
    }

}
 