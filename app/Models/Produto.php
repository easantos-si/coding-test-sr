<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Model;
use App\Interfaces\Relationships\ProdutoToPedidoItemRelationshipInterface;

/**
 * App\Models\Produto
 *
 * @property int $id
 * @property string $codigo
 * @property string $nome
 * @property string|null $descricao
 * @property int $quantidade_estoque
 * @property float $preco
 * @property array $atributos
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\PedidoItem[] $pedidoItems
 * @property-read int|null $pedido_items_count
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Produto newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Produto newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Produto pedidoItem()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Produto query()
 * @mixin \Eloquent
 */
class Produto extends Model implements ProdutoToPedidoItemRelationshipInterface
{
    /**
     * @var array
     */
    protected $fillable = [
        'codigo',
        'nome',
        'descricao',
        'quantidade_estoque',
        'preco',
        'atributos',
    ];

    /**
     * @var array
     */
    protected $casts = [
        'atributos' => 'json',
    ];

    /**
     * @var array
     */
    protected $dates = [
        'created_at',
        'updated_at',
    ];

    /**
     * @return HasMany
     */
    public function pedidoItems():HasMany
    {
        return $this->hasMany(PedidoItem::class,'produto_id');
    }

    /**
     * @param $query
     * @return mixed
     */
    public function scopePedidoItem($query)
    {
        return $query->with('pedidoItems');
    }
}
