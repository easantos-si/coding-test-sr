<?php

namespace App\Http\Middleware;

use App\Repositories\AuthRepository;
use App\Transformers\AuthTransformer;
use App\Transformers\RetornoTipoAuth\RetornoTipoAuthTokenExpiredTransform;
use App\Transformers\RetornoTipoAuth\RetornoTipoAuthTokenInvalidTransformer;
use App\Transformers\RetornoTipoAuth\RetornoTipoAuthTokenNotSendTransformer;
use Closure;
use JWTAuth;
use Exception;
use Tymon\JWTAuth\Http\Middleware\BaseMiddleware;

class JwtMiddleware extends BaseMiddleware
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
        $authRepository = new AuthRepository(new AuthTransformer());

        try {
            $user = JWTAuth::parseToken()->authenticate();
        } catch (Exception $e) {
            if ($e instanceof \Tymon\JWTAuth\Exceptions\TokenInvalidException){
                return response()->json($authRepository->retorno(new RetornoTipoAuthTokenInvalidTransformer()));
            }else if ($e instanceof \Tymon\JWTAuth\Exceptions\TokenExpiredException){
                return response()->json($authRepository->retorno(new RetornoTipoAuthTokenExpiredTransform()));
            }else{
                return response()->json($authRepository->retorno(new RetornoTipoAuthTokenNotSendTransformer()));
            }
        }

        return $next($request);
    }
}
