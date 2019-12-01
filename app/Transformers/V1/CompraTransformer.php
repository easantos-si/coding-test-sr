<?php


namespace App\Transformers\V1;


use App\Interfaces\Transformers\CompraInterface;
use App\Models\Pedido;
use App\Transformers\RetornoTransformer;

class CompraTransformer extends RetornoTransformer implements CompraInterface
{

    public function transform(Pedido $pedido): array
    {
        $this->data = [

        ];
    }
}
