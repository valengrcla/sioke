<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Customer;

class C_Customer extends Controller
{
    public function index()
    {
        $customer=Customer::all();
        return view("customer/index", compact('customer'));
    }
}
 