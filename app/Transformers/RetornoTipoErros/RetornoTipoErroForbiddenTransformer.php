<?php


namespace App\Transformers\RetornoTipoErros;


use App\Interfaces\Transformers\RetornoTiposInterface;

class RetornoTipoErroForbiddenTransformer implements RetornoTiposInterface
{
    public function getStatus(): int
    {
        return 403;
    }

    public function getMessage(): string
    {
        return 'Uma conexão sem criptografia foi iniciada.';
    }
}
