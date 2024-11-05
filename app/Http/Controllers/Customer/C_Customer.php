<?php

namespace App\Http\Controllers\Customer;

use Illuminate\Http\Request;
use App\Models\Customer;
use App\Http\Controllers\Controller;

class C_Customer extends Controller
{
    public function index()
    {
        $customer=Customer::all();
        return view("customer/index", compact('customer'));
    }
}
 