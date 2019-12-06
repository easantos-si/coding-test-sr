<?php


namespace App\Transformers\RetornoTipoAuth;


use App\Interfaces\Transformers\RetornoTiposInterface;

class RetornoTipoAuthCouldNotCreateTokenTransformer implements RetornoTiposInterface
{
    public function getStatus(): int
    {
        return 400;
    }

    public function getMessage(): string
    {
        return 'Não autenticado - erro durante o processo de autenticação';
    }
}
