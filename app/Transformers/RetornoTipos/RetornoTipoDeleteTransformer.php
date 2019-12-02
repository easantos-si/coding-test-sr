<?php


namespace App\Transformers\RetornoTipos;


use App\Interfaces\Transformers\RetornoTiposInterface;

class RetornoTipoDeleteTransformer implements RetornoTiposInterface
{
    public function getStatus(): int
    {
        return 200;
    }

    public function getMessage(): string
    {
        return 'Cadastro deletado com sucesso';
    }

}
