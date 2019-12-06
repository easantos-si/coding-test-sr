<?php


namespace App\Transformers\RetornoTipoErros;


use App\Interfaces\Transformers\RetornoTiposInterface;

class RetornoTipoErroInternalServerErrorTransformer implements RetornoTiposInterface
{
    public function getStatus(): int
    {
        return 500;
    }

    public function getMessage(): string
    {
        return 'Ocorreu uma falha na plataforma.';
    }
}
