<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('get_total_price', [\App\Http\Controllers\RefactoringController::class, 'sumPriceForProductTypeLampAndWallet']);
Route::get('get_csv', [\App\Http\Controllers\RefactoringController::class, 'getCsv']);
Route::get('binary_to_decimal', [\App\Http\Controllers\RefactoringController::class, 'binaryToDecimal']);
Route::get('total_score', [\App\Http\Controllers\RefactoringController::class, 'totalScore']);
