<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pedido;
use Illuminate\Support\Facades\DB;

class PedidoController extends Controller
{
    public function criar(Request $request)
    {
        $request->validate([
            'usuario_id' => 'required|string',
            'descricao' => 'required|string',
            'valor' => 'required|numeric',
            'data_pedido' => 'required|date',
        ]);

        // dd($request->all());

        $pedido = Pedido::create($request->all());

        return response()->json($pedido, 201);
    }

    public function listarComUsuario()
    {
        $pedidos = DB::collection('pedidos')->raw(function ($collection) {
            return $collection->aggregate([
                [
                    '$lookup' => [
                        'from' => 'usuarios',
                        'localField' => 'usuario_id',
                        'foreignField' => '_id',
                        'as' => 'usuario'
                    ]
                ],
                [
                    '$unwind' => '$usuario'  // para desestruturar o array usuario
                ]
            ]);
        });

        return response()->json(iterator_to_array($pedidos));
    }
}
