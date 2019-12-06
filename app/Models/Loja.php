<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Loja extends Model
{

    protected $fillable = [
        'name',
        'password',
        'base_dados_nome',
        'ativo',
        'remember_token',
        'passaport',
        'hash_loja',
    ];

    protected $hidden = [
        'password',
        'remember_token',
        'passaport',
        'hash_loja',
    ];

    protected $casts = [
        'created_ar' => 'datetime',
        'updated_at' => 'datetime',
    ];
}
