<?php


namespace App\Services;

use App\Functions\PedidoItems\PedidoItemsExtracaoDados;
use App\Functions\PedidoItems\PedidoItensExtracaoDadosListaPedidos;
use App\Models\Pedido;
use App\Repositories\PedidoItemRepository;

class CriarItensPeloPedidoService
{
    use PedidoItemsExtracaoDados, PedidoItensExtracaoDadosListaPedidos;

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
            $this->extrairListaItensPedidoCadastro($this->parametros)
        );

        $this->anexarListaItensPedido();
    }
}
