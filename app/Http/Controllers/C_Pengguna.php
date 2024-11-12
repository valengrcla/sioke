<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pengguna;
use App\Models\Role;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;

class C_Pengguna extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');

        if ($search) {
            $pengguna = Pengguna::where('nama_pengguna', 'like', '%' . $search . '%')
                                ->orWhere('username', 'like', '%' . $search . '%')
                                ->orderBy('created_at', 'desc')
                                ->get();
        } else {
            $pengguna = Pengguna::orderBy('created_at', 'desc')->get(); 
        }

        return view("pengguna.index", compact('pengguna'));
    }

    public function create()
    {
        $role = Role::all(); // Ambil semua role dari database
        return view('pengguna.create', compact('role'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_pengguna' => 'required|string|max:100',
            'username' => 'required|string|unique:pengguna,username', // Pastikan username unik
            'password' => 'required|string|min:8', // Panjang minimal password
            'id_role' => 'required|exists:role,id_role', // Pastikan role ada di database
            'user_img' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ], [
            'username.unique' => 'Username sudah digunakan. Silakan pilih username lain.',
            'id_role.required' => 'Silakan pilih role untuk pengguna.',
        ]);

        $fotoPath = ''; // Default path jika tidak ada gambar di-upload

        // Cek dan simpan gambar jika di-upload
        if ($request->hasFile('user_img')) {
            $user_img = $request->file('user_img');
            $imageName = $user_img->getClientOriginalName();
            $user_img->move(public_path('images/pengguna'), $imageName);
            $fotoPath = $imageName;
        }

        // Buat data pengguna baru
        Pengguna::create([
            'id_pengguna' => Str::uuid(), // Menggunakan UUID sebagai id_pengguna
            'nama_pengguna' => $request->input('nama_pengguna'),
            'username' => $request->input('username'),
            'password' => Hash::make($request->input('password')), // Hash password untuk keamanan
            'user_img' => $fotoPath,
            'id_role' => $request->input('id_role'), // Role yang dipilih
        ]);

        return redirect()->route('pengguna.index')->with('success', 'User created successfully!');
    }
    
    public function edit($id_pengguna)
    {
        $pengguna = Pengguna::findOrFail($id_pengguna); // Mengambil pengguna berdasarkan ID
        $role = Role::all(); // Ambil semua role dari database untuk dropdown

        return view('pengguna.edit', compact('pengguna', 'role'));
    }

    public function update(Request $request, $id_pengguna)
    {
        $request->validate([
            'nama_pengguna' => 'required|string|max:100',
            'username' => 'required|string|unique:pengguna,username,'. $id_pengguna . ',id_pengguna', // Pastikan username unik
            'password' => 'nullable|string|min:8', // Panjang minimal password
            'id_role' => 'required|exists:role,id_role', // Pastikan role ada di database
            'user_img' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ], [
            'username.unique' => 'Username sudah digunakan. Silakan pilih username lain.',
        ]);
        
        $pengguna = Pengguna::findOrFail($id_pengguna);

        $pengguna->nama_pengguna = $request->input('nama_pengguna');
        $pengguna->username = $request->input('username');
        $pengguna->id_role = $request->input('id_role');

        // Check if password field is filled
        if ($request->filled('password')) {
            $pengguna->password = Hash::make($request->input('password'));
        }

        $fotoPath = $pengguna->user_img; // Default path jika tidak ada gambar di-upload

        // Cek dan simpan gambar jika di-upload
        if ($request->hasFile('user_img')) {
            $user_img = $request->file('user_img');
            $imageName = $user_img->getClientOriginalName();
            $user_img->move(public_path('images/pengguna'), $imageName);
            $fotoPath = $imageName;
        }

        $pengguna->update([
            // 'id_pengguna' => Str::uuid(), // Menggunakan UUID sebagai id_pengguna
            'nama_pengguna' => $request->input('nama_pengguna'),
            'username' => $request->input('username'),
            'password' => Hash::make($request->input('password')), // Hash password untuk keamanan
            'user_img' => $fotoPath,
            'id_role' => $request->input('id_role'), // Role yang dipilih
        ]);

        $pengguna->save();

        return redirect()->route('pengguna.index')->with('success', 'User updated successfully');
    }

    public function delete($id_pengguna)
    {
        $pengguna = Pengguna::findOrFail($id_pengguna);  // Jika ID tidak ditemukan, akan mengarah ke 404
        $pengguna->delete();

        return redirect()->route('pengguna.index')->with('success', 'User deleted successfully!');
    }

}
 