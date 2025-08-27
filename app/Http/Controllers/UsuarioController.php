<?php

namespace App\Http\Controllers;

use App\Models\Usuario;

use Illuminate\Http\Request;


use Illuminate\Support\Facades\DB;
use MongoDB\Operation\FindOneAndUpdate;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class UsuarioController extends Controller
{
    // Lista todos os usuários
    public function index()
    {
        $usuarios = Usuario::all();
        return response()->json($usuarios);
    }

    // Cria um usuário de exemplo
    public function criarUsuario()
    {
        $usuario = Usuario::create([
            'usuario_uid' => (string) Str::uuid(),
            'nome' => 'João da Silva',
            'email' => 'joao@example.com',
            'idade' => 30
        ]);
    
        return response()->json($usuario);
    }

    public function buscar(Request $request)
    {
        $query = Usuario::query();

        if ($request->filled('nome')) {
            $query->whereRaw([
                'nome' => [
                    '$regex' => $request->nome,
                    '$options' => 'i' //ignora maiúsculas/minúsculas
                ]
            ]);
        }

        if ($request->filled('idade_min')) {
            $query->where('idade', '>=', (int) $request->idade_min);
        }

        $resultados = $query->get();

        return response()->json($resultados);
    }

    public function atualizar(Request $request, $id)
    {

        $usuario = Usuario::find($id);

        if (!$usuario) {
            return response()->json(['error' => 'Usuário não encontrado'], 404);
        }

        // Validação rápida (pode ser expandida com FormRequest)
        $validator = Validator::make($request->all(), [
            'nome' => 'nullable|string',
            'email' => 'nullable|email',
            'idade' => 'nullable|integer|min:0'
        ]);



        if ($validator->fails()) {
            return response()->json(['erros' => $validator->errors()], 422);
        }

        $usuario->update($request->only(['nome', 'email', 'idade']));

        return response()->json(['mensagem' => 'Usuário atualizado com sucesso', 'usuario' => $usuario], 200);
    }

    //Atualizar um usuario
    public function updateUsuario($id = 0)
    {
        // Buscar
        // $usuario = Usuario::where('nome', '=', 'Teste')->get();
        // $usuario = Usuario::find($id); 
        $usuario = Usuario::where('nome', '=', 'Teste')->first();

        // Atualizar único
        if ($usuario) {
            $usuario->idade = 35;
            $usuario->save();
        }

        //Ou até fazer um update em massa (sem carregar os modelos):
        // Usuario::where('nome', '=', 'Teste')->update(['idade' => 35]);

    }

    public function deleteUsuario($id)
    {
        $usuario = Usuario::find($id);

        if (!$usuario) {
            return response()->json(['erro' => 'Usuário não encontrado'], 404);
        }

        $usuario->delete();

        return response()->json(['success' => 'Usuário deletado'], 200);
    }

    private function getNextSequence($collection = 'usuarios')
    {
        return DB::getMongoDB()->counters->findOneAndUpdate(
            ['_id' => $collection],
            ['$inc' => ['seq' => 1]],
            ['upsert' => true, 'returnDocument' => FindOneAndUpdate::RETURN_DOCUMENT_AFTER]
        )['seq'];
    }
}
