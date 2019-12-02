<?php

namespace App\Http\Controllers;

use App\Repositories\ProdutoRepository;
use Illuminate\Http\Request;

class ProdutoController extends Controller
{
    public function index(ProdutoRepository $produtoRepository, int $lojaId)
    {
        return $produtoRepository->produtos();
    }

    public function show(ProdutoRepository $produtoRepository, int $lojaId, int $codigo)
    {
        return $produtoRepository->produto($codigo);
    }

    public function store(ProdutoRepository $produtoRepository,Request $request)
    {
        return $produtoRepository->criar($request);
    }

    public function update(ProdutoRepository $produtoRepository, int $lojaId, int $codigo, Request $request)
    {
        return $produtoRepository->atualizar($codigo, $request);
    }

    public function destroy(ProdutoRepository $produtoRepository,int $lojaId, int $codigo)
    {
        return $produtoRepository->deletar($codigo);
    }
}
