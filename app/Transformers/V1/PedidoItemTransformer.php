<?php


namespace App\Transformers\V1;


use App\Interfaces\Transformers\PedidoItemInterface;
use App\Models\Pedido;
use App\Transformers\RetornoTransformer;

class PedidoItemTransformer extends RetornoTransformer implements PedidoItemInterface
{

    public function __construct()
    {
        $this->apiVersion = 1;
    }

    public function transform(Pedido $pedido):void
    {
        $retorno = array();

        foreach ($pedido->pedidoItem as $pedidoItem)
        {
            $retorno[] = [
                'pedido' => $pedido->codigo,
                'produto' => $pedidoItem->produto,
                'quantidade' => $pedidoItem->quantidade,
                'preco' => $pedidoItem->preco,
            ];
        }
        $this->setData($retorno);
    }
}
