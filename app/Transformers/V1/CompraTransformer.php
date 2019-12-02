<?php


namespace App\Transformers\V1;


use App\Interfaces\Transformers\CompraInterface;
use App\Models\Pedido;
use App\Transformers\RetornoTransformer;

class CompraTransformer extends RetornoTransformer implements CompraInterface
{

    public function __construct()
    {
        $this->apiVersion = 1;
    }

    public function transform(Pedido ...$pedidos):void
    {
        $retorno = array();

        foreach ($pedidos as $pedido)
        {
            $retorno[] = [

            ];
        }
        $this->setData($retorno);
    }
}
