<?php


namespace App\Interfaces\Transformers;


use App\Models\Pedido;

interface PedidoItemInterface
{
    public function transform(Pedido $pedidos):void;
}
