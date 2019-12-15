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

    public function atualizarEstoque(Produto $produto, $quantidade):Produto
    {
        $produto->quantidade_estoque -= $quantidade;
        $produto->update();
        return $produto;
    }
    public function todosProdutosExiste(array $codigoProdutos):bool
    {
        return  (Produto::on($this->dataAuthRepository->database())
            ->whereIn('codigo',$codigoProdutos)
            ->count() == count($codigoProdutos));
    }

    public function todosProdutosExisteDisponibilidadeEstoque(array $codigoProdutosQuantidades):bool
    {
        return Produto::on($this->dataAuthRepository->database())->where(function($query) use ($codigoProdutosQuantidades){
            foreach ($codigoProdutosQuantidades as  $produtos)
            {//dd($produtos);
                $query->orWhere('codigo', '=', $produtos['codigo'])->where('quantidade_estoque','>','0')->whereRaw("(quantidade_estoque - {$produtos['quantidade']}) >= 0");
            }
        })->count() == count($codigoProdutosQuantidades);
    }

    public function extrairProdutoItemListaCadastro(array $listaItemPedidoCadastro):Produto
    {
        return $this->produto($listaItemPedidoCadastro['produto']);
    }

    public function extrairCodigoProdutoListaItemPedidoCadastro(array $listaItemPedidoCadastro):string
    {
        return $listaItemPedidoCadastro['produto'];
    }

    public function extrairCodigoProdutoQuantidadeListaItemPedidoCadastro(array $listaItemPedidoCadastro):array
    {
        return [
            'codigo' => $listaItemPedidoCadastro['produto'],
            'quantidade' =>  $listaItemPedidoCadastro['quantidade']
        ];
    }

    public function extrairCodigoProdutosListaItensPedidoCadastro(array $listaItensPedidoCadastro):array
    {
        $codigoPedidos = array();
        foreach ($listaItensPedidoCadastro as $listaItemPedidoCadastro)
        {
            $codigoPedidos[] = $this->extrairCodigoProdutoListaItemPedidoCadastro($listaItemPedidoCadastro);
        }
        return $codigoPedidos;
    }

    public function extrairCodigoProdutosQuantidadeListaItensPedidoCadastro(array $listaItensPedidoCadastro):array
    {
        $codigoPedidos = array();
        foreach ($listaItensPedidoCadastro as $listaItemPedidoCadastro)
        {
            $codigoPedidos[] = $this->extrairCodigoProdutoQuantidadeListaItemPedidoCadastro($listaItemPedidoCadastro);
        }
        return $codigoPedidos;
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
