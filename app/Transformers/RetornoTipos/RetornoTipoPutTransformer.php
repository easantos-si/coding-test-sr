<?php


namespace App\Transformers\RetornoTipos;


use App\Interfaces\Transformers\RetornoTiposInterface;

class RetornoTipoPutTransformer implements RetornoTiposInterface
{
    public function getStatus(): int
    {
        return 200;
    }

    public function getMessage(): string
    {
        return 'Cadastro atualizado com sucesso';
    }

}
