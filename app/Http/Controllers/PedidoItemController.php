<?php

namespace App\Http\Controllers;

use App\Repositories\PedidoItemRepository;
use App\Repositories\PedidoRepository;
use App\Transformers\RetornoTipos\RetornoTipoDeleteTransformer;
use App\Transformers\RetornoTipos\RetornoTipoGetTransformer;
use App\Transformers\RetornoTipos\RetornoTipoPostTransformer;
use App\Transformers\RetornoTipos\RetornoTipoPutTransformer;
use Illuminate\Http\Request;

class PedidoItemController extends Controller
{
    public function index(PedidoItemRepository $pedidoItemRepository, int $lojaId, string $pedido)
    {
        $pedidoItemRepository->transformer(
            $pedidoItemRepository->pedidoItens($pedido)
        );
        return $pedidoItemRepository->retorno(new RetornoTipoGetTransformer());
    }

    public function show(PedidoItemRepository $pedidoItemRepository, int $lojaId, string $pedido, string $produto)
    {
        $pedidoItemRepository->transformer(
            $pedidoItemRepository->pedidoItem($pedido,$produto)
        );
        return $pedidoItemRepository->retorno(new RetornoTipoGetTransformer());
    }

    public function store(PedidoItemRepository $pedidoItemRepository, PedidoRepository $pedidoRepository, Request $request)
    {
        $pedidoItemRepository->transformer(
            $pedidoItemRepository->criar(
                $pedidoRepository->extrairPedidoArray($request->all()),
                $request->all()
            )
        );
        return $pedidoItemRepository->retorno(new RetornoTipoPostTransformer());
    }

    public function update(PedidoItemRepository $pedidoItemRepository, int $lojaId, string $pedido, string $produto, Request $request)
    {
        $pedidoItemRepository->transformer(
            $pedidoItemRepository->atualizar(
                $pedidoItemRepository->pedidoItem($pedido,$produto),
                $request->all()
            )
        );
        return $pedidoItemRepository->retorno(new RetornoTipoPutTransformer());
    }

    public function destroy(PedidoItemRepository $pedidoItemRepository,int $lojaId, string $pedido, string $produto)
    {
        $pedidoItemRepository->transformer(
            $pedidoItemRepository->deletar(
                $pedidoItemRepository->pedidoItem($pedido,$produto)
            )
        );
        return $pedidoItemRepository->retorno(new RetornoTipoDeleteTransformer());
    }
}
