<?php


namespace App\Transformers\RetornoTipoErros;


use App\Interfaces\Transformers\RetornoTiposInterface;

class RetornoTipoErroNotAuthorizedTransformer implements RetornoTiposInterface
{
    public function getStatus(): int
    {
        return 403;
    }

    public function getMessage(): string
    {
        return 'Acesso não autorizado';
    }
}
