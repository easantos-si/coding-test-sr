<?php


namespace App\Transformers\RetornoTipoErros;


use App\Interfaces\Transformers\RetornoTiposInterface;

class RetornoTipoErroTooManyRequestsTransformer implements RetornoTiposInterface
{
    public function getStatus(): int
    {
        return 429;
    }

    public function getMessage(): string
    {
        return 'O limite de requisições foi atingido. Verifique o cabeçalho Retry-After para obter o tempo de espera
        (em segundos) necessário para a retentativa.';
    }
}
