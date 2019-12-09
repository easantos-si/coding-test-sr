<?php


namespace App\Interfaces\Relationships;


use App\Models\Pedido;
use Illuminate\Database\Eloquent\Relations\HasOne;

interface PedidoToPedidoItemRelationshipInterface
{
    public function pedidoItems(): HasOne;
    public function scopePedidoItem($query);
    public function scopePedidoItemsProdutos($query, string $codigoProduto);
}
