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

    private $pedido;
    private $pedidoItem;
    private $pedidoItemTransformer;
    private $produtoRepository;

    public function __construct(Pedido $pedido,ProdutoRepository $produtoRepository, PedidoItem $pedidoItem)
    {
        $this->pedido = $pedido;
        $this->pedidoItemTransformer = pedidoItemTransformerFactory::getInstance( currentVersionApi());
        $this->produtoRepository = $produtoRepository;
        $this->pedidoItem = $pedidoItem;

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

    public function pedidoItens(string $codigo):Pedido
    {
        return $this->pedido->pedidoItems()->whereCodigo($codigo)->first();
    }

    public function pedidoItem(string $codigo, string $produto):Pedido
    {
        return $this->pedido->with(['pedidoItem' => function($query) use($produto)
            {
                $query->where('produto', $produto);
            }]
        )->whereCodigo($codigo)->first();
    }

    public function criar(Pedido $pedido, array $parametros):Pedido
    {
        $this->pedidoItem->create(
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

//    public function pedidoItemsTransformer(string $pedido):array
//    {
//        $this->pedidoItemTransformer->transform(self::getPedido($pedido));
//        return $this->pedidoItemTransformer->retorno(new RetornoTipoGetTransformer());
//    }
//
//    public function pedidoItemTransformer(string $pedido, string $produto):array
//    {
//        $this->pedidoItemTransformer->transform(self::getPedido($pedido, $produto));
//        return $this->pedidoItemTransformer->retorno(new RetornoTipoGetTransformer());
//    }
//
//    public function criarTransformer(Request $request):array
//    {
//        $pedido = self::getPedido($request->get('pedido'));
//        $pedidoItemDados = [
//            'pedido_id' => $pedido->id,
//            'produto_id' => Produto::whereCodigo($request->get('produto'))->first()->id,
//            'produto' => $request->get('produto'),
//            'quantidade' => $request->get('quantidade'),
//            'preco' => $request->get('preco'),
//        ];
//        $this->pedidoItemTransformer->transform($this->pedidoItem->create($pedidoItemDados));
//        return $this->pedidoItemTransformer->retorno(new RetornoTipoPostTransformer());
//    }
//
//    public function atualizarTransformer(string $pedido, string $produto, Request $request):array
//    {
//        $pedidoItem = self::getPedido($pedido)->pedidoItems->where('produto',$produto)->first();
//        $pedidoItem->update($request->all());
//        $this->pedidoItemTransformer->transform($pedidoItem);
//        return $this->pedidoItemTransformer->retorno(new RetornoTipoPutTransformer());
//    }
//
//    public function deletarTransformer(string $pedido, string $produto):array
//    {
//        $pedidoItem = self::getPedido($pedido)->pedidoItems->where('produto',$produto)->first();
//        $pedidoItem->delete();
//        $this->pedidoItemTransformer->transform($pedidoItem );
//        return $this->pedidoItemTransformer->retorno(new RetornoTipoDeleteTransformer());
//    }
}
