<?php

namespace App\Models;

use App\Interfaces\Relationships\PedidoItemToPedidoRelationshipInterface;
use App\Interfaces\Relationships\PedidoItemToProdutoRelationshipInterface;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class PedidoItem extends Model implements PedidoItemToPedidoRelationshipInterface, PedidoItemToProdutoRelationshipInterface
{
    protected $fillable = [
        'pedido_id',
        'produto_id',
        'produto',
        'quantidade',
        'preco',
    ];

    protected $dates = [
        'created_at',
        'updated_at',
    ];
    protected $connection;

    public function pedido():HasOne
    {
        return $this->hasOne(Pedido::class,'id' ,'pedido_id');
    }

    public function scopePedidoItemPedido($query)
    {
        return $query->with('pedido');
    }

    public function produto():HasOne
    {
        return $this->hasOne(Produto::class,'id', 'produto_id');
    }

    public function scopePedidosItemsProduto($query)
    {
        return $query->with('produto');
    }
}
