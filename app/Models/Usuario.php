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
    protected $casts = [
        '_id' => 'objectid',
    ];

    //ID STRING
    // protected $keyType = 'string';
    // Se quiser ObjectId mesmo:
    // public $incrementing = false;

    //ID_INCRERMENT
    public $incrementing = true;
    protected $keyType = 'int';

    protected $fillable = [
        'nome',
        'email',
        'idade',
    ];

   
}
