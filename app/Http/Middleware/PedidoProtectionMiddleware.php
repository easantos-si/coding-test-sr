<?php

namespace App\Http\Middleware;

use App\Protections\V1\PedidoProtection;
use App\Transformers\ValidateTranformer;
use Closure;

class PedidoProtectionMiddleware
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
        $pedidoProtection = new PedidoProtection($request->method(), new ValidateTranformer());

        if($pedidoProtection->validar($request->all()))
        {
            return $next($request);
        }

        $pedidoProtection->transformer();
        return $pedidoProtection->retorno();
    }
}
