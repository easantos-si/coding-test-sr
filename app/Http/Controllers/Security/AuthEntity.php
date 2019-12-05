<?php


namespace App\Http\Controllers\Security;

use App\Functions\Security\HashValidator;
use App\Services\CreateConnectionsLojaService;
use Illuminate\Auth\MustVerifyEmail;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;
use Illuminate\Foundation\Auth\Access\Authorizable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Tymon\JWTAuth\Contracts\JWTSubject;

class AuthEntity extends Authenticatable implements AuthenticatableContract, AuthorizableContract, CanResetPasswordContract, JWTSubject
{
    use  Authorizable, CanResetPassword, MustVerifyEmail;

    use HashValidator;

    private $loja;

    protected $table = 'lojas';

    protected $connection;

    protected $hidden = [
        'password',
        'remember_token',
        'passport',
        'hash_loja',
    ];

    public function __construct(array $attributes = [])
    {

        $passaport = currentPassaport();

        if(strlen($passaport) > 0)
        {
            $this->loja = $this->isValidHashLoja($passaport);

            if($this->loja)
            {
                $connectionLoja = new CreateConnectionsLojaService($this->loja->base_dados_nome);
                $connectionLoja->newConnection();
                $this->table = 'funcionarios';
                $this->connection = $this->loja->base_dados_nome;
            }
        }

        parent::__construct($attributes);
    }

    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    public function getJWTCustomClaims()
    {
        return [
            'loja_id' => $this->loja->id,
            'loja_nome' => $this->loja->name,
            'loja_ativo' => $this->loja->ativo,
            'passport' => $this->loja->passport,
            'database' => $this->loja->base_dados_nome,
            'table' => $this->table,
        ];
    }

    public function getAuthPassword()
    {
        return $this->password;
    }
}
