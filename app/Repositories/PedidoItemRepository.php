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

    public function pedidoItens(string $codigoPedido):iterable
    {
        return PedidoItem::on($this->dataAuthRepository->database())
            ->pedidoItemPedido()
            ->pedidoItemPedidoCodigoPedido($codigoPedido)
            ->get()
            ->flatten(1)
            ->values()
            ->all();
    }

    public function pedidoItem(string $codigoPedido, string $codigoProduto):PedidoItem
    {
        return PedidoItem::on($this->dataAuthRepository->database())
            ->pedidoItemPedido()
            ->pedidoItemPedidoCodigoPedido($codigoPedido)
            ->first();
    }

    public function criar(Pedido $pedido, array $listaItemPedidoCadastro):PedidoItem
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

            $itemPedido->load('pedidos','produtos');
            $this->produtoRepository->atualizarEstoque($itemPedido->produtos, $itemPedido->quantidade);
        }
        catch (\Exception $ex)
        {
            DB::rollBack();
            $itemPedido = null;
        }
        return $itemPedido;
    }

    public function criarPeloPedido(Pedido $pedido, array $listaItensPedidoCadastro):Pedido
    {
        foreach ($listaItensPedidoCadastro as $listaItemPedidoCadastro)
        {
            $this->criar($pedido,  $listaItemPedidoCadastro);
        }
        return $pedido;
    }

    public function atualizar(string $codigoPedido, string $codigoProduto, array $listaItemPedidoCadastro):PedidoItem
    {
        $itemPedido = $this->pedidoItem($codigoPedido, $codigoProduto);

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

        return $itemPedido;
    }
    public function deletar(string $codigoPedido, string $codigoProduto):PedidoItem
    {
        $itemPedido = $this->pedidoItem($codigoPedido, $codigoProduto);
        try
        {

            $this->produtoRepository->atualizarEstoque($this->produtoRepository->produto($itemPedido->produto), ($itemPedido->quantidade * -1));

            $itemPedido->delete();

            DB::commit();
        }
        catch (\Exception $ex)
        {
            DB::rollBack();
        }
        return $itemPedido;
    }

    public function pedidoItemProduto(Pedido $pedido, string $codigoProduto):PedidoItem
    {
        return PedidoItem::on($this->dataAuthRepository->database())
            ->pedidosItemsProduto()
            ->pedidoItemPedido()
            ->wherePedidoId($pedido->id)->whereProduto($codigoProduto)->first();
    }

    public function transformer(PedidoItem $pedidoItem):void
    {
        $this->pedidoItemTransformer->transform($pedidoItem);
    }

    public function transformers(PedidoItem... $pedidoItem):void
    {
        $this->pedidoItemTransformer->transform(...$pedidoItem);
    }

    public function retorno(RetornoTiposInterface $retornoTipo)
    {
        return $this->pedidoItemTransformer->retorno($retornoTipo);
    }
}
