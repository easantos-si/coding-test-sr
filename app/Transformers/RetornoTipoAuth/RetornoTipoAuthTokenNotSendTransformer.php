<?php


namespace App\Transformers\RetornoTipoAuth;


use App\Interfaces\Transformers\RetornoTiposInterface;

class RetornoTipoAuthTokenNotSendTransformer implements RetornoTiposInterface
{
    public function getStatus(): int
    {
        return 400;
    }

    public function getMessage(): string
    {
        return 'Não autenticado - token não enviado';
    }
}
