<?php

namespace Dskripchenko\LaravelApiUser\Middlewares;

use Dskripchenko\LaravelApi\Exceptions\ApiException;
use Dskripchenko\LaravelApi\Middlewares\ApiMiddleware;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

/**
 * Class OnlyAuth
 * @package Dskripchenko\LaravelApiUser\Middlewares
 */
class OnlyAuth extends ApiMiddleware
{
    /**
     * @param Request $request
     * @param \Closure $next
     * @return mixed
     * @throws ApiException
     */
    public function run(Request $request, \Closure $next)
    {
        if (!Auth::user()) {
            throw new ApiException('unauthorized', 'Unauthorized');
        }

        return $next($request);
    }
}
