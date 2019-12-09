<?php


namespace App\Interfaces\Transformers;


use App\Models\PedidoItem;

interface PedidoItemInterface
{
    public function transform(PedidoItem ...$pedidoItems):void;
}
