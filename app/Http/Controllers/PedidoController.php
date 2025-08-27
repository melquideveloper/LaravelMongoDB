<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pedido;
use Illuminate\Support\Facades\DB;
use App\Models\Usuario;

class PedidoController extends Controller
{
    public function criar(Request $request)
    {
        $request->validate([
            'usuario_email' => 'required|string',
            'descricao' => 'required|string',
            'valor' => 'required|numeric',
            'data_pedido' => 'required|date',
        ]);

        // Buscar o usuário pelo campo usuario_uid
        $usuario = Usuario::where('email', $request->usuario_email)->first();

        if (!$usuario) {
            return response()->json(['error' => 'Usuário não encontrado.'], 404);
        }

        // Criar o pedido com os dados do usuário referenciado
        $pedido = Pedido::create([
            'usuario_uid' => $usuario->usuario_uid,
            'descricao' => $request->descricao,
            'valor' => $request->valor,
            'data_pedido' => $request->data_pedido,
        ]);

        return response()->json($pedido, 201);
    }



    public function listarComUsuario()
    {
        $pedidos = DB::collection('pedidos')->raw(function ($collection) {
            return $collection->aggregate([
                [
                    '$lookup' => [
                        'from' => 'usuarios',
                        'localField' => 'usuario_uid',       // campo em pedidos
                        'foreignField' => 'usuario_uid',     // campo em usuarios
                        'as' => 'usuario'
                    ]
                ],
                [
                    '$unwind' => '$usuario'
                ]
            ]);
        });

        return response()->json(iterator_to_array($pedidos));
    }
}
