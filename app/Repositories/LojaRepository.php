<?php


namespace App\Repositories;

use App\Factories\LojaTransformerFactory;
use App\Interfaces\Transformers\LojaInterface;
use App\Models\Loja;

class LojaRepository
{
    private $loja;
    private $lojaTransformer;

    public function __construct(Loja $loja)
    {
        $this->loja = $loja;

        $this->lojaTransformer = LojaTransformerFactory::getInstance( currentVersionApi());
    }

    public function getTodasLojas()
    {
        $this->lojaTransformer->transform($this->loja);

        return $this->lojaTransformer->retorno();
    }
}
