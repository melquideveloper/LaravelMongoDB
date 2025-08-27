<?php

use Illuminate\Support\Facades\Route;
use App\Models\Usuario;
use MongoDB\BSON\ObjectId;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\UsuarioController;

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

Route::get('/', function () {
    return view('welcome');
});

Route::get('/usuarios', [UsuarioController::class, 'index']);
Route::get('/usuarios/buscar', [UsuarioController::class, 'buscar']);
Route::put('/usuarios/{id}', [UsuarioController::class, 'atualizar']);
