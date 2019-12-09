<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Model;
use App\Interfaces\Relationships\ProdutoToPedidoItemRelationshipInterface;

class Produto extends Model implements ProdutoToPedidoItemRelationshipInterface
{
    protected $fillable = [
        'codigo',
        'nome',
        'descricao',
        'quantidade_estoque',
        'preco',
        'atributos',
    ];

    protected $casts = [
        'atributos' => 'json',
    ];

    protected $dates = [
        'created_at',
        'updated_at',
    ];

    public function pedidoItems():HasMany
    {
        return $this->hasMany(PedidoItem::class,'produto_id');
    }

    public function scopePedidoItem($query)
    {
        return $query->with('pedidoItems');
    }
}
