<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Api\DashboardController;
use App\Http\Controllers\Api\CustomerController;

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

Route::middleware(['auth:api'])->group(function () {
    // Ejemplo de ruta protegida
    Route::get('/user', function (Request $request) {
        return $request->user();
    });
    Route::post('/logout', [\App\Http\Controllers\Api\AuthController::class, 'logout']);
    
    // Otras rutas protegidas...
    
    // Dashboard Routes
    Route::get('/dashboard/customers-count', [DashboardController::class, 'activeCustomers']);
    Route::get('/dashboard/latest-customers', [DashboardController::class, 'latestCustomers']);

    Route::apiResource('users', UserController::class);
    Route::apiResource('customers', CustomerController::class);
});

// Ruta para iniciar sesión y obtener el token JWT
Route::post('/login', [\App\Http\Controllers\Api\AuthController::class, 'login']);
