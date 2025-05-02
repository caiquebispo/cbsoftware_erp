<?php

namespace App\Http\Controllers\CRM\Orders;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Contracts\View\View;

class DemonstrativeController extends Controller
{
    public function index(): View
    {
        return view('panel.crm.orders.demonstrative.index');
    }
}
