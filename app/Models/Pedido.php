<?php

namespace App\Models;

use App\Interfaces\Relationships\PedidoToPedidoItemRelationshipInterface;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

/**
 * App\Models\Pedido
 *
 * @property int $id
 * @property string $codigo
 * @property \Illuminate\Support\Carbon $data_compra
 * @property string $nome_comprador
 * @property string $status
 * @property float $valor_frete
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\PedidoItem $pedidoItems
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Pedido newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Pedido newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Pedido pedidoItem()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Pedido pedidoItemsProdutos($codigoProduto)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Pedido query()
 * @mixin \Eloquent
 */
class Pedido extends Model implements PedidoToPedidoItemRelationshipInterface
{

    /**
     * @var array
     */
    protected $fillable = [
        'codigo',
        'data_compra',
        'nome_comprador',
        'status',
        'valor_frete',
    ];

    /**
     * @var array
     */
    protected $dates = [
        'created_at',
        'updated_at',
        'data_compra',
    ];

    /**
     * @return HasOne
     */
    public function pedidoItems():HasOne
    {
        return $this->hasOne(PedidoItem::class);
    }

    /**
     * @param $query
     * @return mixed
     */
    public function scopePedidoItem($query)
    {
        return $query->with('pedidoItems');
    }

    /**
     * @param $query
     * @param string $codigoProduto
     */
    public function scopePedidoItemsProdutos($query, string $codigoProduto)
    {
        $query->with(['pedidoItems' =>function($query) use($codigoProduto){
            $query->where('produto', '=', $codigoProduto);
        }]);
    }

    /**
     * @param string $antigo
     * @param string $novo
     */
    public function atualizarCodigoPedidoItems(string $antigo, string $novo):void
    {
        $itensPedido = $this->pedidoItems()->first()->pedidoItem;

        if($itensPedido)
        {
            foreach ($itensPedido->where('codigo', antigo) as $item)
            {
                $item->codigo = $novo;
                $item->update();
            }
        }
    }
}
