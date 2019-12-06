<?php


namespace App\Transformers\V1;


use App\Interfaces\Transformers\PedidoInterface;
use App\Models\Pedido;
use App\Transformers\RetornoTransformer;

class PedidoTransformer extends RetornoTransformer implements PedidoInterface
{
    public function __construct()
    {
        $this->apiVersion = 1;
    }

    public function transform(Pedido ...$pedidos):void
    {
        $retorno = array();

        foreach ($pedidos as $pedido)
        {
            $retorno[] = [
                'codigo' => $pedido->codigo,
                'data_compra' => $pedido->data_compra,
                'nome_comprador' => $pedido->nome_comprador,
                'status' => $pedido->status,
                'valor_frete' => $pedido->valor_frete,
                'lista_itens_pedido' => $pedido->lista_itens_pedido
            ];
        }
        $this->setData($retorno);
    }
}
