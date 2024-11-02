<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pengguna;

class C_Pengguna extends Controller
{
    public function index()
    {
        $pengguna=Pengguna::all();
        return view("pengguna/index", compact('pengguna'));
    }
}
 