<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Auth\Middleware\Authenticate as Middleware;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class Authenticate extends Middleware
{
    /**
     * Handle an unauthenticated user.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  mixed  ...$guards
     * @return mixed
     *
     * @throws \Illuminate\Auth\AuthenticationException
     */
    public function handle($request, Closure $next, ...$guards)
    {
        $this->authenticate($request, $guards);

        return $next($request);
    }

    /**
     * Handle an unauthenticated user.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  array  $guards
     * @return void
     *
     * @throws \Illuminate\Auth\AuthenticationException
     */
    protected function authenticate($request, array $guards)
    {
        if ($this->authenticateViaToken($request, $guards)) {
            return;
        }

        $this->unauthenticated($request, $guards);
    }

    /**
     * Authenticate the request via API token.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  array  $guards
     * @return bool
     */
    protected function authenticateViaToken($request, array $guards)
    {
        if ($request->bearerToken()) {
            return $this->authenticateWithBearerToken($request, $guards);
        }

        return false;
    }

    /**
     * Authenticate the request via bearer token.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  array  $guards
     * @return bool
     */
    protected function authenticateWithBearerToken($request, array $guards)
    {
        foreach ($guards as $guard) {
            if ($this->auth->guard($guard)->check()) {
                return true;
            }
        }

        return false;
    }

    /**
     * Handle an unauthenticated user.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  array  $guards
     * @return void
     *
     * @throws \Illuminate\Auth\AuthenticationException
     */
    protected function unauthenticated($request, array $guards)
    {
        abort(response()->json([
            'code'=> 401,
            'error' => 'Unauthenticated'], Response::HTTP_UNAUTHORIZED));
    }
}
