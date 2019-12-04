<?php

namespace App\Models;

use App\Interfaces\Relationships\PedidoToPedidoItemRelationshipInterface;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

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

    protected $connection;

    public function __construct(array $attributes = [])
    {
        $this->connection = currentLojaBaseDados();

        parent::__construct($attributes);
    }

    public function pedidoItem():HasMany
    {
        return $this->hasMany(PedidoItem::class,'pedido_id');
    }

    public function scopePedidoItems($query)
    {
        return $query->with('pedidoItem');
    }

    public function atualizarCodigoPedidoItems(string $antigo, string $novo):void
    {
        foreach ( $this->with(['pedidoItem' => function($query) use($antigo)
            {
               $query->where('pedido',$antigo);
            }]
        )->first()->pedidoItem as $item)
        {
            $item->codigo = $novo;
            $item->update();
        }
    }

    public function deletarTodosPedidoItems():void
    {
        foreach ( $this->pedidoItems()->first()->pedidoItem as $item)
        {
            $item->delete();
        }
    }
}
