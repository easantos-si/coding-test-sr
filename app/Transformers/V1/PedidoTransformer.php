<?php


namespace App\Transformers\V1;


use App\Interfaces\Transformers\PedidoInterface;
use App\Models\Pedido;
use App\Transformers\RetornoTransformer;

class PedidoTransformer extends RetornoTransformer implements PedidoInterface
{

    public function transform(Pedido $pedido): array
    {
        $this->data = [

        ];
    }
}
