<?php

namespace App\Http\Controllers\CRM\Orders;

use App\Http\Controllers\Controller;
use App\Services\CRM\Orders\DemonstrativeService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Contracts\View\View;

class DemonstrativeController extends Controller
{
    public function getDataIndicators(Request $request): JsonResponse
    {
        try {

           $indicators = (new DemonstrativeService())
               ->getDataIndicators(...$request->all());

           $view = view('panel.crm.orders.demonstrative.partials.indicators',compact('indicators'))->render();

           return response()->json(['view' => $view], 200);

        } catch (\Exception $e) {

            return response()->json([
                'Error' => false,
                'message' => 'Erro interno, favor entrar em contato com nosso suporte',
            ], 500);
        }
    }
    public function getDataChart(Request $request): JsonResponse
    {
        try {

           $dataChart = (new DemonstrativeService())->getDataChart(...$request->all());
           return response()->json(['data' => $dataChart], 200);

        } catch (\Exception $e) {
            
            return response()->json([
                'Error' => false,
                'message' => 'Erro interno, favor entrar em contato com nosso suporte',
            ], 500);
        }
    }
    public function index(): View
    {
        return view('panel.crm.orders.demonstrative.index');
    }
}
