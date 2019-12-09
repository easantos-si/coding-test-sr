<?php


namespace App\Interfaces\Relationships;


use Illuminate\Database\Eloquent\Relations\BelongsTo;

interface PedidoItemToPedidoRelationshipInterface
{
    public function pedidos():BelongsTo;
    public function scopePedidoItemPedido($query);
}
