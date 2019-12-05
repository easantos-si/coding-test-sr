<?php


namespace App\Services;

use App\Functions\PedidoItems\PedidoItemsExtracaoDados;
use App\Models\Pedido;
use App\Repositories\PedidoItemRepository;

class CriarItensPeloPedidoService
{
    use PedidoItemsExtracaoDados;

    private $pedidoItemRepository;
    private $parametros;

    public function __construct(Pedido $pedido, PedidoItemRepository $pedidoItemRepository, array $parametros)
    {
        $this->pedido = $pedido;
        $this->pedidoItemRepository = $pedidoItemRepository;
        $this->parametros = $parametros;
    }

    public function criar()
    {
        $this->pedidoItemRepository->criarPeloPedido(
            $this->pedido,
            $this->extrairListaPedidoArray($this->parametros)
        );

        $this->anexarListaItensPedido();
    }
    public function extrairListaPedidoArray(array $parametros):array
    {
        return $parametros['lista_itens_pedido'] ?? array();
    }

}
