<?php


namespace App\Transformers\V1;


use App\Interfaces\Transformers\ProdutoInterface;
use App\Models\Produto;
use App\Transformers\RetornoTransformer;

class ProdutoTransformer extends RetornoTransformer implements ProdutoInterface
{

    public function transform(Produto $produto): array
    {
        $this->data = [

        ];
    }
}
