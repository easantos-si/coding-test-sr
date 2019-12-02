<?php


namespace App\Transformers\V1;


use App\Interfaces\Transformers\PedidoItemInterface;
use App\Models\PedidoItem;
use App\Transformers\RetornoTransformer;

class PedidoItemTransformer extends RetornoTransformer implements PedidoItemInterface
{

    public function __construct()
    {
        $this->apiVersion = 1;
    }

    public function transform(PedidoItem ...$pedidos):void
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
