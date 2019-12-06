<?php


namespace App\Transformers\RetornoTiposErrors;

use App\Interfaces\Transformers\RetornoTiposInterface;

class RetornoTipoErroUnprocessableEntityTransformer implements RetornoTiposInterface
{
    public function getStatus(): int
    {
        return 422;
    }

    public function getMessage(): string
    {
        return 'A requisição foi recebida com sucesso, porém contém parâmetros inválidos.';
    }
}
