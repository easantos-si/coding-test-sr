<?php

namespace App\Models;

use App\Interfaces\Relationships\PedidoToPedidoItemRelationshipInterface;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Pedido extends Model implements PedidoToPedidoItemRelationshipInterface
{
    protected $fillable = [
        'codigo',
        'data_compra',
        'nome_comprador',
        'status',
        'valor_frete',
    ];

    protected $dates = [
        'created_at',
        'updated_at',
        'data_compra',
    ];

    public function pedidoItems():HasOne
    {
        return $this->hasOne(PedidoItem::class);
    }

    public function scopePedidoItem($query)
    {
        return $query->with('pedidoItems');
    }

    public function scopePedidoItemsProdutos($query, string $codigoProduto)
    {
        $query->with(['pedidoItems' =>function($query) use($codigoProduto){
            $query->where('produto', '=', $codigoProduto);
        }]);
    }

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
