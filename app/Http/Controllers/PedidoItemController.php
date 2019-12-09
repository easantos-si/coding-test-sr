<?php

namespace App\Http\Controllers;

use App\Repositories\PedidoItemRepository;
use App\Repositories\PedidoRepository;
use App\Repositories\PedidoItemsValidateRepository;
use App\Transformers\RetornoTipos\RetornoTipoDeleteTransformer;
use App\Transformers\RetornoTipos\RetornoTipoGetTransformer;
use App\Transformers\RetornoTipos\RetornoTipoPostTransformer;
use App\Transformers\RetornoTipos\RetornoTipoPutTransformer;
use App\Transformers\RetornoTiposErrors\RetornoTipoErroUnprocessableEntityTransformer;
use Illuminate\Http\Request;

class PedidoItemController extends Controller
{
    public function index(PedidoItemRepository $pedidoItemRepository, string $codigoPedido)
    {
        $pedidoItemRepository->transformers(...
            $pedidoItemRepository->pedidoItens($codigoPedido)
        );
        return $pedidoItemRepository->retorno(new RetornoTipoGetTransformer());
    }

    public function show(PedidoItemRepository $pedidoItemRepository, string $codigoPedido, string $codigoProduto)
    {
        $pedidoItemRepository->transformer(
            $pedidoItemRepository->pedidoItem($codigoPedido, $codigoProduto)
        );
        return $pedidoItemRepository->retorno(new RetornoTipoGetTransformer());
    }

    public function store(PedidoItemRepository $pedidoItemRepository, PedidoRepository $pedidoRepository, PedidoItemsValidateRepository $pedidosItemValidateRepository, string $codigoPedido, Request $request)
    {
        if(!$pedidosItemValidateRepository->validarPedidoItem($request->all()))
        {
            return $pedidosItemValidateRepository->retorno(new RetornoTipoErroUnprocessableEntityTransformer);
        }

        $pedidoItemRepository->transformer(
            $pedidoItemRepository->criar(
                $pedidoRepository->pedido($codigoPedido),
                $request->all()
            )
        );
        return $pedidoItemRepository->retorno(new RetornoTipoPostTransformer());
    }

    public function update(PedidoItemRepository $pedidoItemRepository, PedidoItemsValidateRepository $pedidosItemValidateRepository, string $codigoPedido, string $codigoProduto, Request $request)
    {
        if(!$pedidosItemValidateRepository->validarPedidoItem($request->all()))
        {
            return $pedidosItemValidateRepository->retorno(new RetornoTipoErroUnprocessableEntityTransformer);
        }

        $pedidoItemRepository->transformer(
            $pedidoItemRepository->atualizar(
                $codigoPedido,
                $codigoProduto,
                $request->all()
            )
        );
        return $pedidoItemRepository->retorno(new RetornoTipoPutTransformer());
    }

    public function destroy(PedidoItemRepository $pedidoItemRepository , string $codigoPedido, string $codigoProduto)
    {
        $pedidoItemRepository->transformer(
            $pedidoItemRepository->deletar(
                $codigoPedido,
                $codigoProduto)
        );
        return $pedidoItemRepository->retorno(new RetornoTipoDeleteTransformer());
    }
}
