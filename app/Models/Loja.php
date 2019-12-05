<?php

namespace App\Models;

use Illuminate\Auth\Authenticatable;
use Illuminate\Auth\MustVerifyEmail;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\Access\Authorizable;

class Loja extends Model implements AuthenticatableContract, AuthorizableContract, CanResetPasswordContract
{
    use Authenticatable, Authorizable, CanResetPassword, MustVerifyEmail;

    protected $fillable = [
        'name',
        'password',
        'base_dados_nome',
        'ativo',
        'remember_token',
        'passport',
        'hash_loja',
    ];

    protected $hidden = [
        'password',
        'remember_token',
        'passport',
        'hash_loja',
    ];

    protected $casts = [
        'created_ar' => 'datetime',
        'updated_at' => 'datetime',
    ];
}
