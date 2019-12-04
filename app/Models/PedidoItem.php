<?php

namespace App\Models;

use App\Interfaces\Relationships\PedidoItemToPedidoRelationshipInterface;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class PedidoItem extends Model implements PedidoItemToPedidoRelationshipInterface
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

    public function __construct(array $attributes = [])
    {
        $this->connection = currentLojaBaseDados();

        parent::__construct($attributes);
    }

    public function pedido():HasOne
    {
        return $this->hasOne(Pedido::class);
    }

    public function scopePedidos($query)
    {
        return $query->with('pedido');
    }
}
