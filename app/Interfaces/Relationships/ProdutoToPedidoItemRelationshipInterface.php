<?php


namespace App\Interfaces\Relationships;


use Illuminate\Database\Eloquent\Relations\HasMany;

interface ProdutoToPedidoItemRelationshipInterface
{
    public function pedidoItems():HasMany;
    public function scopePedidoItem($query);
}
