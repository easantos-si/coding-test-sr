<?php


namespace App\Transformers\V1;


use App\Interfaces\Transformers\LojaInterface;
use App\Models\Loja;
use App\Transformers\RetornoTransformer;

class LojaTransformer extends RetornoTransformer implements LojaInterface
{

    public function __construct()
    {
        $this->apiVersion = 1;
    }

    public function transform(Loja ...$lojas):void
    {
        $retorno = array();

        foreach ($lojas as $loja)
        {
            $retorno[] = [
                'id' => $loja->id,
                'nome' => $loja->nome,
                'ativo' => $loja->ativo,
            ];
        }
        $this->setData($retorno);
    }
}
