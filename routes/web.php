<?php

use Illuminate\Support\Facades\Route;
use App\Models\Usuario;
use MongoDB\BSON\ObjectId;
use Illuminate\Support\Facades\DB;

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

    // Inserir
    // $usuario = Usuario::create([
    //     'nome' => 'Teste',
    //     'email' => 'teste@email.com',
    //     'idade' => 25,
    // ]);

    // Usuario::create([
    //     'nome' => 'João',
    //     'idade' => 30
    // ]);

    // $usuario = Usuario::create([
    //     // '_id' => new ObjectId(),
    //     'nome' => 'Teste2',
    //     'email' => 'teste2@email.com',
    //     'idade' => 40,
    // ]);

    $usuario = Usuario::create([
        '_id' => getNextSequence('usuarios'),
        'nome' => 'Teste4',
        'email' => 'teste4@email.com',
        'idade' => 30,
    ]);

    // Buscar
    // $usuario = Usuario::where('nome', '=', 'Teste')->get();
    // $usuario = Usuario::find($id); //todos
    // $usuario = Usuario::where('nome', '=', 'Teste')->first(); //único

    // Atualizar único
    // if ($usuario) {
    //     $usuario->idade = 35;
    //     $usuario->save();
    // }

    //Ou até fazer um update em massa (sem carregar os modelos):
    // Usuario::where('nome', '=', 'Teste')->update(['idade' => 35]);

    // Deletar
    // $usuario->delete();

    return $usuario;
});


function getNextSequence($collection = 'usuarios')
{
    return DB::getMongoDB()->counters->findOneAndUpdate(
        ['_id' => $collection],
        ['$inc' => ['seq' => 1]],
        ['upsert' => true, 'returnDocument' => MongoDB\Operation\FindOneAndUpdate::RETURN_DOCUMENT_AFTER]
    )['seq'];
}
