<?php


namespace App\Repositories;

use App\Factories\ProdutoTransformerFactory;
use App\Models\Pedido;
use App\Models\Produto;
use App\Transformers\RetornoTipos\RetornoTipoDeleteTransformer;
use App\Transformers\RetornoTipos\RetornoTipoGetTransformer;
use App\Transformers\RetornoTipos\RetornoTipoPostTransformer;
use App\Transformers\RetornoTipos\RetornoTipoPutTransformer;
use Illuminate\Http\Request;

class ProdutoRepository
{
    private $produto;
    private $produtoTransformer;

    public function __construct(Produto $produto)
    {//, int $lojaId
        $this->produto = $produto;
        //$this->produto->setConnection( getLojaBaseDados(1));
        $this->produtoTransformer = ProdutoTransformerFactory::getInstance( currentVersionApi());
    }

    public function produtos()
    {
        $this->produtoTransformer->transform(...$this->produto->all()->flatten(1)->values()->all());
        return $this->produtoTransformer->retorno(new RetornoTipoGetTransformer());
    }

    public function produto(int $codigo)
    {
        $this->produtoTransformer->transform($this->produto->whereCodigo($codigo)->first());
        return $this->produtoTransformer->retorno(new RetornoTipoGetTransformer());
    }

    public function criar(Request $request)
    {
        $this->produtoTransformer->transform($this->produto->create($request->all()));
        return $this->produtoTransformer->retorno(new RetornoTipoPostTransformer());
    }

    public function atualizar(int $codigo, Request $request)
    {
        $produto = $this->produto->whereCodigo($codigo)->first();
        $produto->update($request->all());
        $this->produtoTransformer->transform($produto);
        return $this->produtoTransformer->retorno(new RetornoTipoPutTransformer());
    }

    public function deletar(int $codigo)
    {
        $produto = $this->produto->whereCodigo($codigo)->first();
        $produto->delete();
        $this->produtoTransformer->transform($produto );
        return $this->produtoTransformer->retorno(new RetornoTipoDeleteTransformer());
    }
}
