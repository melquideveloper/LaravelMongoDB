<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UsuarioController;
use App\Http\Controllers\PedidoController;

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

Route::put('/usuarios/{id}', [UsuarioController::class, 'atualizar']);
Route::delete('/usuarios/{id}', [UsuarioController::class, 'deleteUsuario']);
Route::post('/pedidos', [PedidoController::class, 'criar']);
Route::get('/pedidos-com-usuario', [PedidoController::class, 'listarComUsuario']);