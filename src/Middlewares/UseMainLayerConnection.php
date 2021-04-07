<?php

namespace Dskripchenko\LaravelApiUser\Middlewares;

use Dskripchenko\LaravelApi\Middlewares\ApiMiddleware;
use Dskripchenko\Schemify\Facades\LayerItemConnector;
use Illuminate\Http\Request;

/**
 * Class UseMainLayerConnection
 * @package Dskripchenko\LaravelApiUser\Middlewares
 */
class UseMainLayerConnection extends ApiMiddleware
{
    /**
     * @param Request $request
     * @param \Closure $next
     * @return mixed
     */
    public function run(Request $request, \Closure $next)
    {
        LayerItemConnector::getLayerItemByName('main')->refreshConnection();

        return $next($request);
    }
}
