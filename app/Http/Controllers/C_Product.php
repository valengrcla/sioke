<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;

class C_Product extends Controller
{
    public function index()
    {
        $product=Product::all();
        return view("product/index", compact('product'));
    }
}
 