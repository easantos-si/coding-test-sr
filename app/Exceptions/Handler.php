<?php

namespace App\Exceptions;

use App\Repositories\AuthRepository;
use App\Transformers\AuthTransformer;
use App\Transformers\RetornoTipoAuth\RetornoTipoAuthTokenExpiredTransform;
use App\Transformers\RetornoTipoAuth\RetornoTipoAuthTokenInvalidTransformer;
use App\Transformers\RetornoTipoErros\RetornoTipoErroNotAuthorizedTransformer;
use App\Transformers\RetornoTipoErros\RetornoTipoErroNotFoundTransformer;
use App\Transformers\RetornoTipoErros\RetornoTipoErroUnknownTransformer;
use Exception;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Tymon\JWTAuth\Exceptions\TokenExpiredException;
use Tymon\JWTAuth\Exceptions\TokenInvalidException;
use Tymon\JWTAuth\Exceptions\TokenBlacklistedException;
use Symfony\Component\HttpKernel\Exception\UnauthorizedHttpException;

class Handler extends ExceptionHandler
{
    /**
     * A list of the exception types that are not reported.
     *
     * @var array
     */
    protected $dontReport = [
        AuthorizationException::class,
        HttpException::class,
        ModelNotFoundException::class,
        ValidatesRequests::class,
    ];

    /**
     * A list of the inputs that are never flashed for validation exceptions.
     *
     * @var array
     */
    protected $dontFlash = [
        'password',
        'password_confirmation',
    ];

    /**
     * Report or log an exception.
     *
     * @param  \Exception  $exception
     * @return void
     */
    public function report(Exception $exception)
    {
        parent::report($exception);
    }

    /**
     * Render an exception into an HTTP response.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Exception  $exception
     * @return \Illuminate\Http\Response
     */
    public function render($request, Exception $exception)
    {
        $authRepository = new AuthRepository(new AuthTransformer());

        $authRepository->transformer(
            [
                'error' => $exception->getCode(),
            ]);

        if(config('app.debug') == true) {
            $authRepository->transformer(
                [
                    'app.debug' => 'true',
                    'error' => $exception->getCode(),
                    'message' => $exception->getMessage(),
                    'exception' => $exception,
                ]);
        }

        if($exception instanceof \Symfony\Component\HttpKernel\Exception\NotFoundHttpException)
        {
            if($request->expectsJson())
            {
                return $authRepository->retorno(new RetornoTipoErroNotFoundTransformer());
            }
        }
        if($exception instanceof \Symfony\Component\HttpKernel\Exception\MethodNotAllowedHttpException)
        {
            if($request->expectsJson())
            {
                return $authRepository->retorno(new RetornoTipoErroNotAuthorizedTransformer());
            }
        }

        if ($exception instanceof Tymon\JWTAuth\Exceptions\TokenExpiredException)
        {
            return $authRepository->retorno(new RetornoTipoAuthTokenExpiredTransform());
        }

        if ($exception instanceof Tymon\JWTAuth\Exceptions\TokenInvalidException)
        {
            return $authRepository->retorno(new RetornoTipoAuthTokenInvalidTransformer());
        }

        if ($exception instanceof UnauthorizedHttpException) {
            if ($exception->getPrevious() instanceof TokenExpiredException) {
                return $authRepository->retorno(new RetornoTipoAuthTokenExpiredTransform());
            } else if ($exception->getPrevious() instanceof TokenInvalidException) {
                return $authRepository->retorno(new RetornoTipoAuthTokenInvalidTransformer());
            } else if ($exception->getPrevious() instanceof TokenBlacklistedException) {
                return $authRepository->retorno(new RetornoTipoAuthTokenInvalidTransformer());
            } else {
                return $authRepository->retorno(new RetornoTipoErroNotAuthorizedTransformer());
            }
        }

        //return $authRepository->retorno(new RetornoTipoErroUnknownTransformer());

        return parent::render($request, $exception);
    }
}
