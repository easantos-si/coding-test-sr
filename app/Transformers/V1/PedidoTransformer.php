<?php


namespace App\Transformers\V1;


use App\Interfaces\Transformers\PedidoInterface;
use App\Models\Pedido;
use App\Transformers\RetornoTransformer;

class PedidoTransformer extends RetornoTransformer implements PedidoInterface
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
