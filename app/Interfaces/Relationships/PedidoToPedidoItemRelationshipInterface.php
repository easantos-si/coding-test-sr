<?php


namespace App\Interfaces\Relationships;


use App\Models\Pedido;
use Illuminate\Database\Eloquent\Relations\HasMany;

interface PedidoToPedidoItemRelationshipInterface
{
    public function pedidoItem(): HasMany;
    public function scopePedidoItems($query);
}
