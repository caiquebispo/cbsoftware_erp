<?php


use App\Http\Controllers\HomeController;
use App\Http\Controllers\Settings\Commercial\MarketplaceController;
use Illuminate\Support\Facades\Route;

Route::controller(HomeController::class)->group(function (){

    Route::get('/panel/dashboard', 'index')->name('dashboard');
});

//Marketplaces - IPV
Route::controller(MarketplaceController::class)->group(function (){

    Route::get('/panel/settings/commercial/marketplaces', 'index')->name('marketplaces.index');
    Route::get('/panel/settings/commercial/marketplaces/openModalCreateNewRule', 'openModalCreateNewRule');
    Route::post('/panel/settings/commercial/marketplaces/storeModalCreateNewRule', 'storeModalCreateNewRule');
});
