<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\VendaController;
use App\Http\Controllers\ProdutoController;
use App\Models\Produto;

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

Route::get('/', [VendaController::class, 'index'])->middleware('auth');

Route::get('/produtos', [ProdutoController::class, 'create'])->middleware('auth');

Route::post('/produtos', [ProdutoController::class, 'store'])->middleware('auth');

Route::delete('/produto/{id}', [ProdutoController::class, 'destroy'])->middleware('auth');

Route::post('/venda', [VendaController::class, 'store'])->middleware('auth');

Route::get('/relatorio/{selectIndex?}', [VendaController::class, 'getRelatorio'])->middleware('auth');

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified'
])->group(function () {
    Route::get('/dashboard', [VendaController::class, 'dashboard'])->name('dashboard');
});
