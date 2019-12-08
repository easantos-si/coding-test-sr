<?php


namespace App\Interfaces\Relationships;


use Illuminate\Database\Eloquent\Relations\HasMany;

interface ProdutoToPedidoItemRelationshipInterface
{
    public function pedidoItem():HasMany;
    public function scopePedidosItens($query);
}
