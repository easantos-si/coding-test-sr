<?php

namespace App\Http\Middleware;

use App\Protections\V1\PedidoItemProtection;
use App\Transformers\ValidateTranformer;
use Closure;

class PedidoItemProtectionMiddleware
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
        $pedidoItemProtection = new PedidoItemProtection($request->method(), new ValidateTranformer());

        if($pedidoItemProtection->validar($request->all()))
        {
            return $next($request);
        }

        $pedidoItemProtection->transformer();
        return $pedidoItemProtection->retorno();
    }
}
