<?php


namespace App\Services;

use App\Functions\PedidoItems\PedidoItemsExtracaoDados;
use App\Models\Pedido;

class DeletarItensPeloPedidoService
{
    use PedidoItemsExtracaoDados;

    public function __construct(Pedido $pedido)
    {
        $this->pedido = $pedido;
    }

    public function deletar()
    {
        $itensPedido = $this->pedido->PedidoProdutos()->first()->pedidoItem;

        foreach ($itensPedido as $item)
        {
            $item->delete();
        }

        $this->anexarListaItensPedido();
    }
}
