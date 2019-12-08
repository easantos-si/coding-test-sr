<?php

namespace App\Http\Controllers;

use JWTAuth;
use App\Repositories\ProdutoRepository;
use App\Transformers\RetornoTipos\RetornoTipoDeleteTransformer;
use App\Transformers\RetornoTipos\RetornoTipoGetTransformer;
use App\Transformers\RetornoTipos\RetornoTipoPostTransformer;
use App\Transformers\RetornoTipos\RetornoTipoPutTransformer;
use Illuminate\Http\Request;

class ProdutoController extends Controller
{
    public function index(ProdutoRepository $produtoRepository)
    {
        $produtoRepository->transformers(...
            $produtoRepository->produtos()
        );
        return  $produtoRepository->retorno(new RetornoTipoGetTransformer());
    }

    public function show(ProdutoRepository $produtoRepository, string $codigo)
    {
        $produtoRepository->transformer(
            $produtoRepository->produto($codigo)
        );
        return $produtoRepository->retorno(new RetornoTipoGetTransformer());
    }

    public function store(ProdutoRepository $produtoRepository, Request $request)
    {
        $produtoRepository->transformer(
            $produtoRepository->criar($request->all())
        );
        return $produtoRepository->retorno(new RetornoTipoPostTransformer());
    }

    public function update(ProdutoRepository $produtoRepository, string $codigo, Request $request)
    {
        $produtoRepository->transformer(
            $produtoRepository->atualizar(
                $produtoRepository->produto(
                    $codigo),
                $request->all()
            )
        );
        return $produtoRepository->retorno(new RetornoTipoPutTransformer);
    }

    public function destroy(ProdutoRepository $produtoRepository, string $codigo)
    {
        $produtoRepository->transformer(
            $produtoRepository->deletar(
                $produtoRepository->produto($codigo))
        );
        return $produtoRepository->retorno(new RetornoTipoDeleteTransformer());
    }
}
