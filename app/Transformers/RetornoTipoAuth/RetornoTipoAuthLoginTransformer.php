<?php


namespace App\Transformers\RetornoTipoAuth;


use App\Interfaces\Transformers\RetornoTiposInterface;

class RetornoTipoAuthLoginTransformer implements RetornoTiposInterface
{
    public function getStatus(): int
    {
        return 200;
    }

    public function getMessage(): string
    {
        return 'Autenticado - login efetuado com sucesso.';
    }
}
