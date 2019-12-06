<?php


namespace App\Transformers\RetornoTipoErros;


use App\Interfaces\Transformers\RetornoTiposInterface;

class RetornoTipoErroUnknownTransformer implements RetornoTiposInterface
{
    private $status;

    public  function setStatus(int $status):RetornoTipoErroUnknownTransformer
    {
        $this->status = $status;
        return $this;
    }

    public function getStatus(): int
    {
        return $this->status;
    }

    public function getMessage(): string
    {
        return 'Erro desconhecido entre em contato com o administrador';
    }
}
