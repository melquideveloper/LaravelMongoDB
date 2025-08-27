<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UsuarioController;
use App\Http\Controllers\PedidoController;
use Illuminate\Support\Facades\Redis;
use App\Jobs\ProcessarPedidoJob;

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
Route::post('/pedidos/criar', [PedidoController::class, 'criar']);
Route::get('/pedidos-com-usuario', [PedidoController::class, 'listarComUsuario']);
Route::post('/usuarios/criar', [UsuarioController::class, 'criarUsuario']);

Route::get('/redis-test', function () {
    Redis::set('chave_de_teste', 'Olá Redis!');
    $valor = Redis::get('chave_de_teste');

    return response()->json(['valor' => $valor]);
});
Route::get('/redis-all', function () {
    $chaves = Redis::keys('*');

    foreach ($chaves as $chave) {
        $valor = Redis::get($chave);
        echo "Chave: $chave | Valor: $valor" . PHP_EOL;
    }
});

Route::post('/disparar-job', function () {
    $dados = [
        'descricao' => 'Pedido de teclado gamer',
        'valor' => 420.00,
        'cliente' => 'joao@example.com'
    ];

    ProcessarPedidoJob::dispatch($dados);

    return response()->json(['status' => 'Job enviado para a fila']);
});
