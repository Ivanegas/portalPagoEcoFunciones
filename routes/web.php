<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\CustomerController;

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

//muestra pagina de login
Route::get('/', function () { return view('login'); });
// envia datos del login para ver si usuario existe
Route::post('/login', [LoginController::class, 'login'])-> name('login');
// muestra pagina principal
Route::get('/home', [CustomerController::class, 'home']) -> name('home');
//muestra listado de facturas en sus diferentes estados
Route::get('/invoices', [CustomerController::class, 'invoices'])-> name('invoices');
//formulario oculto
Route::post('/payInvoices', [CustomerController::class, 'payInvoices'])-> name('payInvoices');
//realiza el pago al banco y crm
Route::post('/pay', [CustomerController::class, 'pay'])-> name('pay');
//descarga de factura en formato pdf
Route::get('/pdfinvoices', [CustomerController::class, 'download'])->name('pdfinvoices');
//muestra perfil del usuario
Route::get('/profile', [CustomerController::class, 'profile'])-> name('profile');
//cerrar sesión
Route::get('/logout', [LoginController::class, 'logout']) -> name('logout');

