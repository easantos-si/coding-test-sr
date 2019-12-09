<?php

namespace App\Http\Controllers;

use App\Repositories\PedidosValidateRepository;
use App\Repositories\PedidoRepository;
use App\Transformers\RetornoTipos\RetornoTipoDeleteTransformer;
use App\Transformers\RetornoTipos\RetornoTipoGetTransformer;
use App\Transformers\RetornoTipos\RetornoTipoPostTransformer;
use App\Transformers\RetornoTipos\RetornoTipoPutTransformer;
use App\Transformers\RetornoTiposErrors\RetornoTipoErroUnprocessableEntityTransformer;
use Illuminate\Http\Request;

class PedidoController extends Controller
{
    public function index(PedidoRepository $pedidoRepository)
    {

        $pedidoRepository->transformers(...
            $pedidoRepository->pedidos()
        );
        return $pedidoRepository->retorno(new RetornoTipoGetTransformer());
    }

    public function show(PedidoRepository $pedidoRepository, string $codigo)
    {
        $pedidoRepository->transformer(
            $pedidoRepository->pedido($codigo)
        );
        return $pedidoRepository->retorno(new RetornoTipoGetTransformer());
    }

    public function store(PedidoRepository $pedidoRepository, PedidosValidateRepository $pedidosValidateRepository, Request $request)
    {

        if(!$pedidosValidateRepository->validarPedido($request->all()))
        {
            return $pedidosValidateRepository->retorno(new RetornoTipoErroUnprocessableEntityTransformer);
        }

        $pedidoRepository->transformer(
            $pedidoRepository->criar($request->all())
        );
        return $pedidoRepository->retorno(new RetornoTipoPostTransformer());
    }

    public function update(PedidoRepository $pedidoRepository, PedidosValidateRepository $pedidosValidateRepository, string $codigo, Request $request)
    {
        if(!$pedidosValidateRepository->validarPedido($request->all()))
        {
            return $pedidosValidateRepository->retorno(new RetornoTipoErroUnprocessableEntityTransformer);
        }

        $pedidoRepository->transformer(
            $pedidoRepository->atualizar(
                $pedidoRepository->pedido($codigo),
                $request->all()
            )
        );
        return $pedidoRepository->retorno(new RetornoTipoPutTransformer());
    }

    public function destroy(PedidoRepository $pedidoRepository, string $codigo)
    {
        $pedidoRepository->transformer(
            $pedidoRepository->deletar(
                $pedidoRepository->pedido($codigo)
            )
        );
        return $pedidoRepository->retorno(new RetornoTipoDeleteTransformer());
    }
}
