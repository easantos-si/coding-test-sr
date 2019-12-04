<?php

namespace App\Http\Controllers;

use App\Repositories\PedidoRepository;
use App\Transformers\RetornoTipos\RetornoTipoDeleteTransformer;
use App\Transformers\RetornoTipos\RetornoTipoGetTransformer;
use App\Transformers\RetornoTipos\RetornoTipoPostTransformer;
use App\Transformers\RetornoTipos\RetornoTipoPutTransformer;
use Illuminate\Http\Request;

class PedidoController extends Controller
{
    public function index(PedidoRepository $pedidoRepository, int $lojaId)
    {

        $pedidoRepository->transformers(...
            $pedidoRepository->pedidos()
        );
        return $pedidoRepository->retorno(new RetornoTipoGetTransformer());
    }

    public function show(PedidoRepository $pedidoRepository, int $lojaId, string $codigo)
    {
        $pedidoRepository->transformer(
            $pedidoRepository->pedido($codigo)
        );
        return $pedidoRepository->retorno(new RetornoTipoGetTransformer());
    }

    public function store(PedidoRepository $pedidoRepository, Request $request)
    {
        $pedidoRepository->transformer(
            $pedidoRepository->criar($request->all())
        );
        return $pedidoRepository->retorno(new RetornoTipoPostTransformer());
    }

    public function update(PedidoRepository $pedidoRepository, int $lojaId, string $codigo, Request $request)
    {
        $pedidoRepository->transformer(
            $pedidoRepository->atualizar(
                $pedidoRepository->pedido($codigo),
                $request->all()
            )
        );
        return $pedidoRepository->retorno(new RetornoTipoPutTransformer());
    }

    public function destroy(PedidoRepository $pedidoRepository,int $lojaId, string $codigo)
    {
        $pedidoRepository->transformer(
            $pedidoRepository->deletar(
                $pedidoRepository->pedido($codigo)
            )
        );
        return $pedidoRepository->retorno(new RetornoTipoDeleteTransformer());
    }
}
