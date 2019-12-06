<?php

namespace App\Http\Controllers\Security;

use App\Functions\Security\HashGenerator;
use JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    use HashGenerator;

    public function __construct()
    {
        $this->middleware('auth:api' ,['except' => ['authenticate']]);
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
                return response()->json(['error' => 'invalid_credentials'], 401);
            }
        } catch (JWTException $e)
        {
            // something went wrong whilst attempting to encode the token
            return response()->json(['error' => 'could_not_create_token'], 500);
        }

        // all good so return the token
        return response()->json(compact('token'));
    }

    public function getAuthenticatedUser(\Tymon\JWTAuth\JWTAuth $auth)
    {
        return $auth->parseToken()->getPayload()->toArray();
//        return response()->json(compact());
    }

    public function refreshToken()
    {
        if(!$token = JWTAuth::getToken())
        {
            return response()->json(['error','token_not_send'], 401);
        }

        try
        {
            $token = JWTAuth::refresh();
        }
        catch (Tymon\JWTAuth\Exceptions\TokenInvalidException $e)
        {
            return response()->json(['token_invalid'], $e->getStatusCode());
        }

        return response()->json(compact('token'));
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
            return response()->json(['token_invalid'], $e->getStatusCode());
        }

        return response()->json('logout sucess');
    }
}
