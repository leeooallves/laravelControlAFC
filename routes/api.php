<?php

use App\Http\Controllers\Api\AdminController;
use App\Http\Controllers\Api\ClienteController;
use App\Http\Controllers\Api\FuncionarioController;
use App\Http\Controllers\Api\LoginController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
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

Route::namespace('Api')->group(function () {

    // Routers Admin
    Route::prefix('admin')->middleware([
        'auth:sanctum',
        'is_permission:admin'
    ])->group(function () {

        

        // funcionarios
        Route::get('/funcionarios', [AdminController::class, 'indexFuncionario']);
        Route::get('/funcionario/{id}', [AdminController::class, 'showFuncionario']);
        Route::post('/funcionario', [AdminController::class, 'storeFuncionario']);
        Route::put('/funcionario/{id}', [AdminController::class, 'editFuncionario']);
        Route::delete('/funcionario/{id}', [AdminController::class, 'destroyFuncionario']);


        // clientes
        Route::get('/funcionario/{id}/clientes', [AdminController::class, 'indexCliente']);
        Route::get('/funcionario/{id}/cliente/{client_id}', [AdminController::class, 'showCliente']);
        Route::post('funcionario/{id}/cliente', [AdminController::class, 'storeCliente']);
        Route::put('/funcionario/{id}/cliente/{client_id}', [AdminController::class, 'editCliente']);
        Route::delete('/funcionario/{id}/cliente/{client_id}', [AdminController::class, 'destroyCliente']);


        // admin
        Route::get('/', [AdminController::class, 'index']);
        Route::get('/{id}', [AdminController::class, 'show']);
        Route::post('/', [AdminController::class, 'store']);
        Route::put('/{id}', [AdminController::class, 'edit']);
    });

    // Routers Funcionarios [em desenvolvimento]
    Route::prefix('funcionario')->middleware([
        'auth:sanctum',
        'is_permission:funcionario'
    ])->group(function () {
        Route::get('/', [FuncionarioController::class, 'index']);
        Route::put('/', [FuncionarioController::class, 'edit']);

        Route::get('/clientes', [FuncionarioController::class, 'showClient']);
        Route::get('/cliente/{client_id}', [FuncionarioController::class, 'findClient']);
        Route::post('/cliente', [FuncionarioController::class, 'storeClient']);
        Route::put('/cliente/{client_id}', [FuncionarioController::class, 'editClient']);
        Route::delete('/cliente/{client_id}', [FuncionarioController::class, 'destroyClient']);
    });

    // Routers Cliente [FINALIZADO]
    Route::prefix('cliente')->middleware([
        'auth:sanctum',
        'is_permission:cliente'
    ])->group(function () {
        Route::get('/', [ClienteController::class, 'index']);
        Route::put('/', [ClienteController::class, 'edit']);
    });
});

Route::post('/login', [LoginController::class, 'login']);
// Route::post('/me', [LoginController::class, 'me']);

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
