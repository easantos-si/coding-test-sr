<?php


namespace App\Interfaces\Transformers;


interface RetornoInterface extends RetornoDadosInterface
{
    public function retorno(RetornoTiposInterface $retornoTipo);
}
