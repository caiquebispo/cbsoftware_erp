<?php

namespace App\Http\Controllers\Settings\Commercial;

use App\Http\Controllers\Controller;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;

class MarketplaceController extends Controller
{
    public function openModalCreateNewRule()
    {
        $channels = [];

        $view = view('panel.settings.commercial.marketplaces.modals.createNewRule',
            compact('channels'))
            ->render();

        return response()
            ->json(['view' => $view], 200);
    }
    public function index(): View
    {
        return view('panel.settings.commercial.marketplaces.index');
    }
}
