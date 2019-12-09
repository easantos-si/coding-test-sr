<?php


namespace App\Interfaces\Relationships;


use Illuminate\Database\Eloquent\Relations\BelongsTo;

interface PedidoItemToProdutoRelationshipInterface
{
    public function produtos():BelongsTo;
    public function scopePedidosItemsProduto($query);
}
