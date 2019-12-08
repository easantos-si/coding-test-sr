<?php


namespace App\Repositories;

use App\Factories\PedidoItemTransformerFactory;
use App\Interfaces\Relationships\PedidoToPedidoItemRelationshipInterface;
use App\Interfaces\Transformers\RetornoTiposInterface;
use App\Models\Pedido;
use App\Models\PedidoItem;
use App\Models\Produto;

class PedidoItemRepository
{

    private $dataAuthRepository;
    private $pedidoItemTransformer;
    private $produtoRepository;

    public function __construct(DataAuthRepository $dataAuthRepository, ProdutoRepository $produtoRepository)
    {
        $this->dataAuthRepository = $dataAuthRepository;
        $this->dataAuthRepository->newConnection();
        $this->pedidoItemTransformer = pedidoItemTransformerFactory::getInstance( currentVersionApi());
        $this->produtoRepository = $produtoRepository;
    }

    public function extrairPedidoItemListaCadastro(array $listaItemPedidoCadastro):array
    {
        return [
            'quantidade' => $listaItemPedidoCadastro['quantidade'],
            'preco' => $listaItemPedidoCadastro['preco'],
        ];
    }

    public function montarPedidoItem(Pedido $pedido, Produto $produto, array $itemPedidoDados):array
    {
        return array_merge(
            [
                'pedido_id' => $pedido->id,
                'produto_id' => $produto->id,
                'produto' => $produto->codigo,
            ],
            $itemPedidoDados
        );
    }

    public function pedidoItens(Pedido $pedido):Pedido
    {
        return $pedido->pedidoProdutos()->get()->first();
    }

    public function pedidoItem(Pedido $pedido, string $codigoProduto):Pedido
    {
        return $pedido->pedidoProduto($codigoProduto)->get()->first();
    }

    public function criar(Pedido $pedido, array $listaItemPedidoCadastro):Pedido
    {
        PedidoItem::on($this->dataAuthRepository->database())->create(
            $this->montarPedidoItem(
                $pedido,
                $this->produtoRepository->extrairProdutoItemListaCadastro($listaItemPedidoCadastro),
                $this->extrairPedidoItemListaCadastro($listaItemPedidoCadastro)
            )
        );
        return $pedido;
    }

    public function criarPeloPedido(Pedido $pedido, array $listaItensPedidoCadastro):Pedido
    {
        foreach ($listaItensPedidoCadastro as $listaItemPedidoCadastro)
        {
            $this->criar($pedido,  $listaItemPedidoCadastro);
        }
        return $pedido;
    }

    public function atualizar(Pedido $pedido, array $listaItemPedidoCadastro):Pedido
    {
        $pedido->pedidoItem->first()->update($listaItemPedidoCadastro);
        return $pedido;
    }
    public function deletar(Pedido $pedido):Pedido
    {
        $pedido->pedidoItem->first()->delete();
        return $pedido;
    }

    public function transformer(Pedido $pedido):void
    {
        $this->pedidoItemTransformer->transform($pedido);
    }

    public function transformers(Pedido... $pedidos):void
    {
        $this->pedidoItemTransformer->transform(...$pedidos);
    }

    public function retorno(RetornoTiposInterface $retornoTipo)
    {
        return $this->pedidoItemTransformer->retorno($retornoTipo);
    }
}
