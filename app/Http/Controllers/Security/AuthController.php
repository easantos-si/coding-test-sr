<?php

namespace App\Http\Controllers\Security;

use App\Functions\Security\HashGenerator;
use App\Transformers\RetornoTipoAuth\RetornoTipoAuthInvalidCredentialsTransformer;
use App\Transformers\RetornoTipoAuth\RetornoTipoAuthCouldNotCreateTokenTransformer;
use App\Transformers\RetornoTipoAuth\RetornoTipoAuthLoginTransformer;
use App\Transformers\RetornoTipoAuth\RetornoTipoAuthLogoutTransformer;
use App\Transformers\RetornoTipoAuth\RetornoTipoAuthRefreshTokenTransformer;
use App\Transformers\RetornoTipoAuth\RetornoTipoAuthTokenInvalidTransformer;
use App\Transformers\RetornoTipoAuth\RetornoTipoAuthTokenNotSendTransformer;
use Carbon\Carbon;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Repositories\AuthRepository;
use JWTException;
use JWTAuth;
use JWTFactory;

class AuthController extends Controller
{
    use HashGenerator;

    private $authRepository;

    public function __construct(AuthRepository $authRepository)
    {
        $this->authRepository = $authRepository;
        $this->middleware('jwt.verify' ,['except' => ['authenticate']]);
    }

    public function authenticate(Request $request)
    {
        // grab credentials from the request
        $credentials = $request->only('passaport','email', 'password');
        $credentials['password'] = $this->getHashMascaraPasswordLogin($credentials['password']);

        try
        {
            // attempt to verify the credentials and create a token for the user
            if (! $token = JWTAuth::attempt($credentials))
            {
                return $this->authRepository->retorno(new RetornoTipoAuthInvalidCredentialsTransformer());//response()->json(['error' => 'invalid_credentials'], 401);
            }
        } catch (JWTException $e)
        {
            // something went wrong whilst attempting to encode the token
            return $this->authRepository->retorno(new RetornoTipoAuthCouldNotCreateTokenTransformer());//response()->json(['error' => 'could_not_create_token'], 500);
        }

        // all good so return the token
        $this->authRepository->transformer(
            [
                'token' => $token,
                'expires_in' => JWTFactory::getTTL() * 60,
                'datetime' => Carbon::now(),
            ]
        );

        return $this->authRepository->retorno(new RetornoTipoAuthLoginTransformer());//response()->json(compact('token'));
    }

    public function getAuthenticatedUser(\Tymon\JWTAuth\JWTAuth $auth)
    {
        //Temporário... apenas para ocultar dados sensiveis da conexão
        $dados = $auth->parseToken()->getPayload()->toArray();

        return response()->json([
            'data'=>[
                    'Loja'=> $dados['loja_nome'],
                    'Usuário'=> $dados['user_name'],
                    'Ativo'=> $dados['loja_ativo'],
                ]
        ],200);
    }

    public function refreshToken()
    {
        if(!$token = JWTAuth::getToken())
        {
            return $this->authRepository->retorno(new RetornoTipoAuthTokenNotSendTransformer());//response()->json(['error','token_not_send'], 401);
        }

        try
        {
            $token = JWTAuth::refresh();
        }
        catch (Tymon\JWTAuth\Exceptions\TokenInvalidException $e)
        {
            return $this->authRepository->retorno(new RetornoTipoAuthTokenInvalidTransformer());//$this->authRepository->retorno(new RetornoTipoAuthTokenInvalid());//response()->json(['token_invalid'], $e->getStatusCode());
        }

        $this->authRepository->transformer(
            [
                'token' => $token,
                'expires_in' => JWTFactory::getTTL() * 60,
                'datetime' => Carbon::now(),
            ]
        );
        return $this->authRepository->retorno(new RetornoTipoAuthRefreshTokenTransformer());//response()->json(compact('token'));
    }

    public function logoutToken()
    {
        if (!$token = JWTAuth::getToken()) {
            return response()->json(['error', 'token_not_send'], 401);
        }

        try
        {
            $token = JWTAuth::invalidate($token);
        }
        catch (Tymon\JWTAuth\Exceptions\TokenInvalidException $e)
        {
            return $this->authRepository->retorno(new RetornoTipoAuthTokenInvalidTransformer());//response()->json(['token_invalid'], $e->getStatusCode());
        }

        return $this->authRepository->retorno(new RetornoTipoAuthLogoutTransformer());//response()->json('logout sucess');
    }
}
