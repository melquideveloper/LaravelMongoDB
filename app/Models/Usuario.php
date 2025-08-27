<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
// use Illuminate\Database\Eloquent\Model;
use MongoDB\Laravel\Eloquent\Model;


class Usuario extends Model
{
    protected $connection = 'mongodb';
    protected $collection = 'usuarios';
    protected $primaryKey = '_id';   

    //ID_STRING
    protected $keyType = 'string';  
    public $incrementing = false;

    //ID_INCRERMENT
    // public $incrementing = true;
    // protected $keyType = 'int';

    protected $fillable = ['usuario_uid', 'nome', 'email', 'idade'];

   
}
