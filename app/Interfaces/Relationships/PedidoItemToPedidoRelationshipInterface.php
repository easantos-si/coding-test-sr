<?php


namespace App\Interfaces\Relationships;


use Illuminate\Database\Eloquent\Relations\HasOne;

interface PedidoItemToPedidoRelationshipInterface
{
    public function pedido():HasOne;
    public function scopePedidos($query);
}
