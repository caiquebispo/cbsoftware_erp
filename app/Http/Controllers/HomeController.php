<?php

namespace App\Http\Controllers;

use App\Models\MGE001;
use Illuminate\Http\Request;

class HomeController
{
    public function index()
    {
        return view('panel.index');
    }
    public function getData(Request $request)
    {

//        return response()->json($mGE001,200);
    }
}
