<?php


namespace App\Functions\PedidoItems;


trait PedidoItensExtracaoDadosListaPedidos
{
    public function extrairListaItensPedidoCadastro(array $listeItemsPedidoCadastro):array
    {
        return $listeItemsPedidoCadastro['lista_itens_pedido'] ?? array();
    }
}
