<?php


namespace App\Interfaces;


interface DataAuthInterface
{
    public function lojaId():int;
    public function lojaNome():string;
    public function lojaAtivo():bool;
    public function passport():string;
    public function database():string;
    public function table():string;

}
//        'loja_id' => $this->loja->id,
//            'loja_nome' => $this->loja->name,
//            'loja_ativo' => $this->loja->ativo,
//            'passport' => $this->loja->passport,
//            'database' => $this->loja->base_dados_nome,
//            'table' => $this->table,
