<?php


namespace App\Interfaces\Transformers;


use App\Models\Pedido;

interface PedidoInterface
{
    public function transform(Pedido $pedido);
}
