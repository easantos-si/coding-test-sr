<?php


namespace App\Transformers\V1;


use App\Interfaces\Transformers\PedidoItemInterface;
use App\Models\PedidoItem;
use App\Transformers\RetornoTransformer;

class PedidoItemTransformer extends RetornoTransformer implements PedidoItemInterface
{

    public function transform(PedidoItem $pedido): array
    {
        $this->data = [

        ];
    }
}
