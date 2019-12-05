<?php

namespace App\Models;

use App\Repositories\DataAuthRepository;
use Illuminate\Support\Facades\Auth;

use Illuminate\Database\Eloquent\Model;

class Produto extends Model
{
    protected $fillable = [
        'codigo',
        'nome',
        'descricao',
        'quantidade_estoque',
        'preco',
        'atributos',
    ];

    protected $casts = [
        'atributos' => 'json',
    ];

    protected $dates = [
        'created_at',
        'updated_at',
    ];
}
