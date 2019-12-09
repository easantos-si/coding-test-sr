<?php


namespace App\Services;

use App\Functions\PedidoItems\PedidoItemsExtracaoDados;
use App\Models\Pedido;
use App\Repositories\DataAuthRepository;
use App\Repositories\PedidoItemRepository;
use App\Repositories\ProdutoRepository;

class DeletarItensPeloPedidoService
{
    use PedidoItemsExtracaoDados;

    private $authRepository;

    public function __construct(Pedido $pedido, DataAuthRepository $authRepository)
    {
        $this->pedido = $pedido;
        $this->authRepository = $authRepository;
    }

    public function deletar()
    {
        $itensPedido = $this->pedido->PedidoProdutos()->first()->pedidoItem;
        $pedidoItemRepository = new PedidoItemRepository($this->authRepository,
            new ProdutoRepository($this->authRepository)
        );

        foreach ($itensPedido as $item)
        {
            $pedidoItemRepository->deletar($this->pedido->codigo, $item->produto);
        }

        $this->anexarListaItensPedido();
    }
}
