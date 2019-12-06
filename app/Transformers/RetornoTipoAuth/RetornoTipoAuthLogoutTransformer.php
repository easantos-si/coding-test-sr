<?php


namespace App\Transformers\RetornoTipoAuth;


use App\Interfaces\Transformers\RetornoTiposInterface;

class RetornoTipoAuthLogoutTransformer implements RetornoTiposInterface
{
    public function getStatus(): int
    {
        return 200;
    }

    public function getMessage(): string
    {
        return 'Não autenticado - logout efetuado com sucesso.';
    }
}
