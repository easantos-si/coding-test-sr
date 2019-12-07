<?php


namespace App\Interfaces\Transformers;


interface ValidacaoParametrosErrosInterface
{
    public function getCodigoErro():int;
    public function getDescricaoErro():string;
    public function getCategoriaErro():string;
}
