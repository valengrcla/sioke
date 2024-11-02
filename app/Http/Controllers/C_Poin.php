<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Poin;

class C_Poin extends Controller
{
    public function index()
    {
        $poin=Poin::all();
        // dd($poin);
        return view("poin/index", compact('poin'));
    }
}
