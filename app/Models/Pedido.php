<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
// use Illuminate\Database\Eloquent\Model;
use MongoDB\Laravel\Eloquent\Model;

class Pedido extends Model
{
    use HasFactory;

    protected $connection = 'mongodb'; 
    protected $collection = 'pedidos';

    protected $primaryKey = '_id';
    protected $keyType = 'string';
    public $incrementing = false;

    protected $fillable = [
        'usuario_uid',  // ID do usuário dono do pedido
        'descricao',
        'valor',
        'data_pedido',
    ];
}
