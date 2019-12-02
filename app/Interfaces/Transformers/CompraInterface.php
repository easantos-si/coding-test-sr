<?php


namespace App\Interfaces\Transformers;


use App\Models\Pedido;

interface CompraInterface
{
    public function transform(Pedido ...$pedido):void;
}
