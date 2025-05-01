<?php


use App\Http\Controllers\CRM\Orders\DemonstrativeController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\Settings\Commercial\MarketplaceController;
use Illuminate\Support\Facades\Route;

Route::redirect('/', '/panel/dashboard');

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
});
