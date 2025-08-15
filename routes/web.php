<?php

use Illuminate\Support\Facades\Route;
use App\Models\Usuario;

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


Route::get('/teste', function () {

    // $usuario = Usuario::create([
    //     'nome' => 'Teste',
    //     'email' => 'teste@email.com',
    //     'idade' => 25,
    // ]);

    // Inserir
    // Usuario::create([
    //     'nome' => 'João',
    //     'idade' => 30
    // ]);

    // Buscar
    $usuario = Usuario::where('nome', '=', 'Teste')->get();
    // dd($usuarios);

    // Atualizar
    // $usuario = Usuario::find($id);
    $usuario->idade = 35;
    $usuario->save();

    // Deletar
    // $usuario->delete();

    return $usuario;
});
