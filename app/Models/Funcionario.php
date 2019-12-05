<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;


class Funcionario extends Model
{

    private $loja;

    protected $fillable = [
        'name',
        'email',
        'email_verified_at',
        'password',
        'ativo',
        'remember_token',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'created_ar' => 'datetime',
        'updated_at' => 'datetime',
    ];

//    public function __construct(array $attributes = [])
//    {
//        $this->connection = currentLojaBaseDados();
//
//        parent::__construct($attributes);
//    }

    public function setLoja(Loja $loja):void
    {
        $this->loja = $loja;
    }
    public function getLoja():Loja
    {
        return $this->loja;
    }
}
