<?php


namespace App\Transformers\V1;


use App\Interfaces\Transformers\ProdutoInterface;
use App\Models\Produto;
use App\Transformers\RetornoTransformer;

class ProdutoTransformer extends RetornoTransformer implements ProdutoInterface
{
    public function __construct()
    {
        $this->apiVersion = 1;
    }

    public function transform(Produto ...$produtos):void
    {
        $retorno = array();

        foreach ($produtos as $produto)
        {
            $retorno[] = [
                'codigo' => $produto->codigo,
                'nome' => $produto->nome,
                'descricao' => $produto->descricao,
                'preco' => $produto->preco,
                'quantidade_estoque' => $produto->quantidade_estoque,
                'atributos' => $produto->atributos,
            ];
        }
        $this->setData($retorno);
    }
}
