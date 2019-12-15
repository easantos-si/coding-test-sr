<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Funcionario
 *
 * @property int $id
 * @property string $name
 * @property string $email
 * @property \Illuminate\Support\Carbon|null $email_verified_at
 * @property string $password
 * @property int $ativo
 * @property string|null $remember_token
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Funcionario newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Funcionario newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Funcionario query()
 * @mixin \Eloquent
 */
class Funcionario extends Model
{

    /**
     * @var
     */
    private $loja;

    /**
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
        'email_verified_at',
        'password',
        'ativo',
        'remember_token',
    ];

    /**
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'created_ar' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * @param Loja $loja
     */
    public function setLoja(Loja $loja):void
    {
        $this->loja = $loja;
    }

    /**
     * @return Loja
     */
    public function getLoja():Loja
    {
        return $this->loja;
    }
}
