<?php

namespace App\Http\Middleware;

use App\Protections\V1\ProdutoProtection;
use App\Transformers\ValidateTranformer;
use Closure;


class ProdutoProtectionMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $produtoProtection = new ProdutoProtection($request->method(), new ValidateTranformer());

        if($produtoProtection->validar($request->all()))
        {
            return $next($request);
        }

        $produtoProtection->transformer();
        return $produtoProtection->retorno();
    }
}
