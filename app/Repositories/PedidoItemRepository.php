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

    private function extrairPedidoItemLista(array $parametros):array
    {
        return [
            'quantidade' => $parametros['quantidade'],
            'preco' => $parametros['preco'],
        ];
    }

    private function montarPedidoItem(Pedido $pedido, Produto $produto, array $itemPedidoDados):array
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

    public function criar(Pedido $pedido, array $parametros):Pedido
    {
        $pedido->pedidoItem[] = PedidoItem::on($this->dataAuthRepository->database())->create(
            $this->montarPedidoItem(
                $pedido,
                $this->produtoRepository->extrairProdutoArray($parametros),
                $this->extrairPedidoItemLista($parametros)
            )
        );

        return $pedido;
    }

    public function criarPeloPedido(Pedido $pedido, array $listaItensPedido):Pedido
    {
        foreach ($listaItensPedido as $listaItemPedido)
        {
            $this->criar($pedido,  $listaItemPedido);
        }

        return $pedido;
    }

    public function atualizar(Pedido $pedido, array $parametros):Pedido
    {
        $pedido->pedidoItem->first()->update($parametros);
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

    public function retorno(RetornoTiposInterface $retornoTipo):array
    {
        return $this->pedidoItemTransformer->retorno($retornoTipo);
    }
}
