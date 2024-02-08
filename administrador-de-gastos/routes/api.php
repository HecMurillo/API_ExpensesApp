<?php

use App\Http\Controllers\Api\DateController;
use App\Http\Controllers\Api\ExpenseController;
use App\Http\Controllers\Api\PurchaseController;
use App\Http\Controllers\Api\ReasonController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('/Reasons', [ReasonController::class, 'list']);
Route::get('/Reasons/{id}', [ReasonController::class, 'item']);
Route::post('/Reasons/Create', [ReasonController::class, 'create']);
Route::post('/Reasons/Update', [ReasonController::class, 'update']);

Route::get('/Dates', [DateController::class, 'list']);
Route::get('/Dates/{id}', [DateController::class, 'item']);
Route::post('/Dates/Create', [DateController::class, 'create']);
Route::post('/Dates/Update', [DateController::class, 'update']);

Route::get('/Purchases', [PurchaseController::class, 'list']);
Route::get('/Purchases/{id}', [PurchaseController::class, 'item']);
Route::post('/Purchases/Create', [PurchaseController::class, 'create']);
Route::post('/Purchases/Update', [PurchaseController::class, 'update']);

Route::get('/Expenses', [ExpenseController::class, 'list']);
Route::get('/Expenses/{id}', [ExpenseController::class, 'item']);
Route::post('/Expenses/Create', [ExpenseController::class, 'create']);
Route::post('/Expenses/Update', [ExpenseController::class, 'update']);

