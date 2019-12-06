<?php


namespace App\Http\Controllers\Security;

use App\Functions\Security\HashValidator;
use App\Services\CreateConnectionsLojaService;
use Illuminate\Auth\MustVerifyEmail;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Foundation\Auth\Access\Authorizable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Tymon\JWTAuth\Contracts\JWTSubject;

class AuthEntity extends Authenticatable implements AuthenticatableContract, AuthorizableContract, JWTSubject
{
    use  Authorizable,  MustVerifyEmail;

    use HashValidator;

    private $loja;

    private $admin;

    protected $table = 'lojas';

    protected $connection;

    protected $hidden = [
        'id',
        'password',
        'remember_token',
        'passaport',
        'hash_loja',
        'base_dados_nome',
        'created_at',
        'updated_at',
    ];

    public function __construct(array $attributes = [])
    {
        $passaport = currentPassaport();
        $this->admin = $passaport['admin'];

        if(strlen($passaport['key']) > 0)
        {
            $this->loja = $this->isValidHashLoja($passaport['key']);

            if(!$this->loja)
            {
                throw new Tymon\JWTAuth\Exceptions\TokenInvalidException();
            }

            if(!$this->admin)
            {
                $this->connection = $this->loja->base_dados_nome;
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
            'passaport' => $this->loja->passaport,
            'database' => $this->loja->base_dados_nome,
            'table' => $this->table,
            'user_id' => $this->id,
            'user_name' => $this->name,
        ];
    }

    public function getAuthPassword()
    {
        return $this->password;
    }
}
