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

    public function transform(PedidoItem ...$pedidoItems):void
    {
        $retorno = array();

        foreach ($pedidoItems as $pedidoItem)
        {
            $retorno[] = [
                'pedido' => $pedidoItem->pedidos->codigo,
                'produto' => $pedidoItem->produto,
                'quantidade' => $pedidoItem->quantidade,
                'preco' => $pedidoItem->preco,
            ];
        }
        $this->setData($retorno);
    }
}
