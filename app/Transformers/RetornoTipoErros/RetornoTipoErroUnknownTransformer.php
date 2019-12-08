<?php


namespace App\Transformers\RetornoTipoErros;


use App\Interfaces\Transformers\RetornoTiposInterface;

class RetornoTipoErroUnknownTransformer implements RetornoTiposInterface
{
    public function getStatus(): int
    {
        return 500;
    }

    public function getMessage(): string
    {
        return 'Erro desconhecido entre em contato com o administrador';
    }
}
