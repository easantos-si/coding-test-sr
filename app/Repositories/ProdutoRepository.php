<?php


namespace App\Repositories;

use App\Factories\ProdutoTransformerFactory;
use App\Interfaces\Transformers\RetornoTiposInterface;
use App\Models\Produto;

class ProdutoRepository
{
    private $dataAuthRepository;
    private $produtoTransformer;

    public function __construct(DataAuthRepository $dataAuthRepository)
    {
        $this->produtoTransformer = ProdutoTransformerFactory::getInstance( currentVersionApi());
        $this->dataAuthRepository = $dataAuthRepository;
        $this->dataAuthRepository->newConnection();
    }

    public function produtos():iterable
    {
        return Produto::on($this->dataAuthRepository->database())->get()
            ->flatten(1)
            ->values()->all();
    }

    public function produto(string $codigo):Produto
    {
        return Produto::on($this->dataAuthRepository->database())
            ->whereCodigo($codigo)->first();
    }

    public function criar(array $parametros):Produto
    {
        return Produto::on($this->dataAuthRepository->database())
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
