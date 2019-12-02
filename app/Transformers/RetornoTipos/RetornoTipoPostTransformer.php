<?php


namespace App\Transformers\RetornoTipos;


use App\Interfaces\Transformers\RetornoTiposInterface;

class RetornoTipoPostTransformer implements RetornoTiposInterface
{
    public function getStatus(): int
    {
        return 201;
    }

    public function getMessage(): string
    {
        return 'Cadastro efetuado com sucesso';
    }

}
