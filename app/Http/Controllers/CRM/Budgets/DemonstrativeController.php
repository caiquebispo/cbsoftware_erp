<?php

namespace App\Http\Controllers\CRM\Budgets;

use App\Http\Controllers\Controller;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;

class DemonstrativeController extends Controller
{
    public function index(): View
    {
        return view('panel.crm.budgets.demonstrative.index');
    }
}
