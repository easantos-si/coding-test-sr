<?php


namespace App\Repositories;

use App\Factories\ProdutoTransformerFactory;
use App\Interfaces\Transformers\RetornoTiposInterface;
use App\Models\Produto;

class ProdutoRepository
{
    private $produto;
    private $produtoTransformer;

    public function __construct(Produto $produto)
    {
        $this->produto = $produto;
        $this->produtoTransformer = ProdutoTransformerFactory::getInstance( currentVersionApi());
    }

    public function produtos():iterable
    {
        return $this->produto->all()
            ->flatten(1)
            ->values()->all();
    }

    public function produto(string $codigo):Produto
    {
        return $this->produto
            ->whereCodigo($codigo)->first();
    }

    public function criar(array $parametros):Produto
    {
        return $this->produto
            ->create($parametros);
    }

    public function atualizar(Produto $produto, array $parametros):Produto
    {
        $produto->update($parametros);
        return $produto;
    }
    public function deletar(Produto $produto):Produto
    {
        $produto->delete();
        return $produto;
    }

    public function extrairProdutoArray(array $parametros):Produto
    {
        return $this->produto($parametros['produto']);
    }

    public function transformer(Produto $produto):void
    {
        $this->produtoTransformer->transform($produto);
    }

    public function transformers(Produto... $produtos):void
    {
        $this->produtoTransformer->transform(...$produtos);
    }

    public function retorno(RetornoTiposInterface $retornoTipo)
    {
        return $this->produtoTransformer->retorno($retornoTipo);
    }
}
