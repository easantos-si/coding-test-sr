<?php


namespace App\Interfaces\Relationships;


use Illuminate\Database\Eloquent\Relations\HasOne;

interface PedidoItemToProdutoRelationshipInterface
{
    public function produto():HasOne;
    public function scopePedidosItemsProduto($query);
}
