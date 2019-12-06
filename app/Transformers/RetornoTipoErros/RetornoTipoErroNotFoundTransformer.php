<?php


namespace App\Transformers\RetornoTipoErros;


use App\Interfaces\Transformers\RetornoTiposInterface;

class RetornoTipoErroNotFoundTransformer implements RetornoTiposInterface
{
    public function getStatus(): int
    {
        return 404;
    }

    public function getMessage(): string
    {
        return 'O recurso solicitado ou o endpoint não foi encontrado.';
    }
}
