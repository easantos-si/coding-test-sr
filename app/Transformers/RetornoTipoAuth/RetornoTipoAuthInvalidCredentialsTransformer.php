<?php


namespace App\Transformers\RetornoTipoAuth;


use App\Interfaces\Transformers\RetornoTiposInterface;

class RetornoTipoAuthInvalidCredentialsTransformer implements RetornoTiposInterface
{
    public function getStatus(): int
    {
        return 401;
    }

    public function getMessage(): string
    {
        return 'Não autenticado - os dados de autenticação estão incorretos.';
    }
}
