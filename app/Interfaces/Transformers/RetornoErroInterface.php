<?php


namespace App\Interfaces\Transformers;


interface RetornoErroInterface
{
    public function retorno(RetornoTiposErroInterface $retornoTipo):array;
}
