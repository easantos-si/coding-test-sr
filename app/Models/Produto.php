<?php

namespace App\Models;

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

    protected $connection;

    public function __construct(array $attributes = [])
    {
        $this->connection = currentLojaBaseDados();

        parent::__construct($attributes);
    }
}
