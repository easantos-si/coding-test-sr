<?php


namespace App\Transformers\RetornoTipoErros;


use App\Interfaces\Transformers\RetornoTiposInterface;

class RetornoTipoBadRequestTransformer implements RetornoTiposInterface
{
    public function getStatus(): int
    {
        return 400;
    }

    public function getMessage(): string
    {
        return 'Não foi possível interpretar a requisição.';
    }
}
