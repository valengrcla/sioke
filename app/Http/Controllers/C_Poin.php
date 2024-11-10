<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Poin;

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
        })->get();
        
        return view("poin.index", compact('poin'));
    }
}
