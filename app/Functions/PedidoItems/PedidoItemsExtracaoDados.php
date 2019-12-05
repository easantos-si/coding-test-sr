<?php


namespace App\Functions\PedidoItems;


trait PedidoItemsExtracaoDados
{
    private $pedido;

    private function anexarListaItensPedido():void
    {
        $lista_itens_pedido = array();

        foreach ($this->pedido->pedidoItem as $pedidoItem)
        {
            $lista_itens_pedido[] = [
                'produto' => $pedidoItem->produto,
                'quantidade' => $pedidoItem->quantidade,
                'preco' => $pedidoItem->preco,
            ];
        }

        $this->pedido->lista_itens_pedido = $lista_itens_pedido;
    }
}
