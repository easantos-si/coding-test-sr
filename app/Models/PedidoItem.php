<?php

namespace App\Models;

use App\Interfaces\Relationships\PedidoItemToPedidoRelationshipInterface;
use App\Interfaces\Relationships\PedidoItemToProdutoRelationshipInterface;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * App\Models\PedidoItem
 *
 * @property int $id
 * @property int $pedido_id
 * @property int $produto_id
 * @property string $produto
 * @property int $quantidade
 * @property float $preco
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Pedido $pedidos
 * @property-read \App\Models\Produto $produtos
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\PedidoItem newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\PedidoItem newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\PedidoItem pedidoItemPedido()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\PedidoItem pedidoItemPedidoCodigoPedido($codigoPedido)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\PedidoItem pedidosItemsProduto()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\PedidoItem pedidosItemsProdutoCodigoProduto($codigoProduto)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\PedidoItem query()
 * @mixin \Eloquent
 */
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
