<?php


namespace App\Repositories;

use App\Factories\PedidoItemTransformerFactory;
use App\Interfaces\Relationships\PedidoToPedidoItemRelationshipInterface;
use App\Interfaces\Transformers\RetornoTiposInterface;
use App\Models\Pedido;
use App\Models\PedidoItem;
use App\Models\Produto;
use Illuminate\Support\Facades\DB;

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
        try
        {
            $itemPedido = PedidoItem::on($this->dataAuthRepository->database())->create(
                $this->montarPedidoItem(
                    $pedido,
                    $this->produtoRepository->extrairProdutoItemListaCadastro($listaItemPedidoCadastro),
                    $this->extrairPedidoItemListaCadastro($listaItemPedidoCadastro)
                )
            );

            $this->produtoRepository->atualizarEstoque($this->produtoRepository->produto($itemPedido->produto), $itemPedido->quantidade);
        }
        catch (\Exception $ex)
        {
            DB::rollBack();
        }
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
        $itemPedido = $pedido->pedidoItem->first();

        $quantidadeAnterior = $itemPedido->quantidade;

        try
        {
            $itemPedido->update($listaItemPedidoCadastro);

            $this->produtoRepository->atualizarEstoque($this->produtoRepository->produto($itemPedido->produto), ($itemPedido->quantidade - $quantidadeAnterior));
        }
        catch (\Exception $ex)
        {
            DB::rollBack();
        }

        return $pedido;
    }
    public function deletar(Pedido $pedido):Pedido
    {
        $itemPedido = $pedido->pedidoItem->first();
        try
        {
            $itemPedido->delete();

            $this->produtoRepository->atualizarEstoque($this->produtoRepository->produto($itemPedido->produto), ($itemPedido->quantidade * -1));

            DB::commit();
        }
        catch (\Exception $ex)
        {
            DB::rollBack();
        }
        return $pedido;
    }

    public function pedidoItemProduto(Pedido $pedido, string $codigoProduto):PedidoItem
    {
        return PedidoItem::on($this->dataAuthRepository->database())
            ->pedidosItemsProduto()
            ->pedidoItemPedido()
            ->wherePedidoId($pedido->id)->whereProduto($codigoProduto)->first();
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
