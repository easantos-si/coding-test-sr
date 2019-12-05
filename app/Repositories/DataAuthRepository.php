<?php


namespace App\Repositories;

use App\Functions\Connections\LojaConnection;
use App\Interfaces\ConnectionLoja;
use App\Interfaces\DataAuthInterface;
use App\Services\CreateConnectionsLojaService;

class DataAuthRepository extends CreateConnectionsLojaService implements DataAuthInterface, ConnectionLoja
{
    use LojaConnection;

    private $dataAuth = array();

    public function __construct(\Tymon\JWTAuth\JWTAuth $auth)
    {
        $this->dataAuth = $auth->parseToken()->getPayload()->toArray();

        parent::__construct($this->database());
    }

    public function lojaId(): int
    {
        return $this->getData('loja_id');
    }

    public function lojaNome(): string
    {
        return $this->getData('loja_nome');
    }

    public function lojaAtivo(): bool
    {
        return $this->getData('loja_ativo');
    }

    public function passport(): string
    {
        return $this->getData('passport');
    }

    public function database(): string
    {
        return $this->getData('database');
    }

    public function table(): string
    {
        return $this->getData('table');
    }

    private function getData(string $key)
    {
        if(isset($this->dataAuth[$key]))
        {
            return $this->dataAuth[$key];
        }
        return '';
    }
}
