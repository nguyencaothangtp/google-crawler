<?php

namespace App\Http\Middleware;

use Firebase\JWT\ExpiredException;
use Firebase\JWT\JWT;

use Closure;
use Exception;

use Illuminate\Contracts\Auth\Factory as Auth;
use Illuminate\Http\JsonResponse;
use Laravel\Lumen\Http\Request;

use App\Exceptions\TokenException;
use App\User;


class Authenticate
{
    /**
     * The authentication guard factory instance.
     *
     * @var Auth
     */
    protected $auth;

    /**
     * Create a new middleware instance.
     *
     * @param Auth $auth
     * @return void
     */
    public function __construct(Auth $auth)
    {
        $this->auth = $auth;
    }

    /**
     * @param Request|object $request
     * @param Closure $next
     * @return JsonResponse|mixed
     */
    public function handle($request, Closure $next)
    {
        $token = $request->header('Authorization'); // get token from request header
        $token = str_replace('Bearer ', '', $token);

        if (!$token) {
            return response()->json([
                'error' => 'Token not provided.'
            ], 401);
        }

        try {
            $credentials = JWT::decode($token, env('JWT_SECRET'), ['HS256']);
        } catch (ExpiredException $e) {
            throw TokenException::expiredToken();
        } catch (Exception $e) {
            throw TokenException::errorDecoding();
        }

        $user = User::find($credentials->sub);

        // Put the user in the request class so that we can grab it from there
        $request->auth = $user;

        return $next($request);
    }
}
