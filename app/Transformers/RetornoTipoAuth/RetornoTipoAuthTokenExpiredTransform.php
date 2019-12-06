<?php


namespace App\Transformers\RetornoTipoAuth;


use App\Interfaces\Transformers\RetornoTiposInterface;

class RetornoTipoAuthTokenExpiredTransform implements RetornoTiposInterface
{
    public function getStatus(): int
    {
        return 400;
    }

    public function getMessage(): string
    {
        return 'Não autenticado - token expirado';
    }
}
