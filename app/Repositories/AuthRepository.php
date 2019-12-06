<?php


namespace App\Repositories;

use App\Interfaces\Transformers\RetornoTiposInterface;
use App\Transformers\AuthTransformer;

class AuthRepository
{
    private $authTransformer;

    public function __construct(AuthTransformer $authTransformer)
    {
        $this->authTransformer = $authTransformer;
    }

    public function transformer(array $data)
    {
        $this->authTransformer->transform($data);
    }

    public function retorno(RetornoTiposInterface $retornoTipo):array
    {
        return $this->authTransformer->retorno($retornoTipo);
    }
}
