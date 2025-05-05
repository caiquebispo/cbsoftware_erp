<?php


use App\Http\Controllers\CRM\Budgets\DemonstrativeController as DemonstrativeBudgetsController;
use App\Http\Controllers\CRM\Orders\DemonstrativeController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\Settings\Commercial\MarketplaceController;
use Illuminate\Support\Facades\Route;


Route::redirect('/', '/panel/dashboard');

Route::get('/debug', function (){

    return \App\Models\GMP033::query()->whereBetween('GMP033_Data_Emissao', ['2025-05-01','2025-05-01'])->first();
});

Route::controller(HomeController::class)->group(function (){

    Route::get('/panel/dashboard', 'index')->name('dashboard');
});

//Marketplaces - IPV
Route::controller(MarketplaceController::class)->group(function (){
    Route::get('/panel/settings/commercial/marketplaces', 'index')->name('marketplaces.index');
    Route::get('/panel/settings/commercial/marketplaces/openModalCreateNewRule', 'openModalCreateNewRule');
    Route::post('/panel/settings/commercial/marketplaces/storeModalCreateNewRule', 'storeModalCreateNewRule');
});

Route::controller(DemonstrativeController::class)->group(function (){

    Route::get('/panel/crm/orders/demonstrative', 'index')->name('demonstrative.index');
    Route::get('/panel/crm/orders/demonstrative/getDataIndicators', 'getDataIndicators');
    Route::get('/panel/crm/orders/demonstrative/getDataChart', 'getDataChart');
    Route::get('/panel/crm/orders/demonstrative/getDataTable', 'getDataTable');
});

Route::controller(DemonstrativeBudgetsController::class)->group(function (){

    Route::get('/panel/crm/budgets/demonstrative', 'index')->name('demonstrative-budget.index');

});
