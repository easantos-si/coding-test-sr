<?php

namespace App\Models;

use App\Interfaces\Relationships\PedidoItemToPedidoRelationshipInterface;
use App\Interfaces\Relationships\PedidoItemToProdutoRelationshipInterface;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

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

    public function pedidos():BelongsTo
    {
        return $this->BelongsTo(Pedido::class, 'pedido_id');
    }

    public function scopePedidoItemPedido($query)
    {
        return $query->with('pedidos');
    }

    public function scopePedidoItemPedidoCodigoPedido($query, string $codigoPedido)
    {
        $query->whereHas('pedidos', function($query) use($codigoPedido){
            $query->where('codigo', '=', $codigoPedido);
        });
    }

    public function produtos():BelongsTo
    {
        return $this->belongsTo(Produto::class,'produto_id');
    }

    public function scopePedidosItemsProduto($query)
    {
        return $query->with('produtos');
    }

    public function scopePedidosItemsProdutoCodigoProduto($query, string $codigoProduto)
    {
        $query->with(['produtos' =>function($query) use($codigoProduto){
            $query->where('codigo', '=', $codigoProduto);
        }]);
    }
}
