<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\FinanceController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);


Route::group(['middleware'=>['auth:sanctum']], function() {
    Route::get('/finance', [FinanceController::class, 'getAll']);
    Route::get('/finance/{id}', [FinanceController::class, 'getEntry']);
    Route::post('/finance', [FinanceController::class, 'placeEntry']);
    Route::post('/finance/update/', [FinanceController::class, 'updateEntry']);
    Route::post('/finance/delete/', [FinanceController::class, 'deleteEntry']);
    Route::post('/logout', [AuthController::class, 'logout']);
});

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
