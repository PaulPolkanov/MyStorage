<?php

use App\Http\Controllers\IndexController;
use App\Http\Middleware\CheckRequest;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/
Route::controller( IndexController::class )->group(function(){
    Route::get('/', 'indexAction')->name('home');
    Route::post('/date', 'dateAction');
});