<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\FinanceController;

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

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth'])->name('dashboard');

Route::get('/test', function () {
    return 'Test';
});

Route::get('/finance', [FinanceController::class, 'test']);

Route::get('/finance/{id}', function ($id) {
    return 'Test' . $id;
});

Route::post('/finance', function () {
    return 'Test';
});

Route::post('/finance/update/', function () {
    return 'Test';
});

Route::post('/finance/delete/', function () {
    return 'Test';
});

require __DIR__.'/auth.php';
