<?php


namespace App\Interfaces\Transformers;


use App\Models\Produto;

interface ProdutoInterface
{
    public function transform(Produto ...$produtos):void;
}
