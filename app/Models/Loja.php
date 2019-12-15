<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Loja
 *
 * @package App\Models
 * @property int $id
 * @property string $name
 * @property string $password
 * @property string $base_dados_nome
 * @property int $ativo
 * @property string|null $remember_token
 * @property string $passaport
 * @property string|null $hash_loja
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Loja newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Loja newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Loja query()
 * @mixin \Eloquent
 */
class Loja extends Model
{

    /**
     * @var array
     */
    protected $fillable = [
        'name',
        'password',
        'base_dados_nome',
        'ativo',
        'remember_token',
        'passaport',
        'hash_loja',
    ];

    /**
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
        'passaport',
        'hash_loja',
    ];

    /**
     * @var array
     */
    protected $casts = [
        'created_ar' => 'datetime',
        'updated_at' => 'datetime',
    ];
}
