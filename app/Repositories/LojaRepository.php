<?php


namespace App\Repositories;

use App\Factories\LojaTransformerFactory;
use App\Models\Loja;
use App\Transformers\RetornoTipos\RetornoTipoGetTransformer;

class LojaRepository
{
    private $loja;
    private $lojaTransformer;

    public function __construct(Loja $loja)
    {
        $this->loja = $loja;

        $this->lojaTransformer = LojaTransformerFactory::getInstance( currentVersionApi());
    }

    public function lojas()
    {
        $this->lojaTransformer->transform(...$this->loja->all()->flatten(1)->values()->all());
        return $this->lojaTransformer->retorno(new RetornoTipoGetTransformer());
    }
    public function loja(int $id)
    {
        $this->lojaTransformer->transform($this->loja->find($id));
        return $this->lojaTransformer->retorno(new RetornoTipoGetTransformer());
    }
}
