<?php

namespace Findologic\PluginPlentymarketsApi\Providers;

use Plenty\Plugin\RouteServiceProvider;
use Plenty\Plugin\Routing\Router;

/**
 * Class FindologicRouteServiceProvider
 * @package Findologic\PluginPlentymarketsApi\Providers
 */
class FindologicRouteServiceProvider extends RouteServiceProvider
{
    public function map(Router $router)
    {
        $router->get('findologic','Findologic\PluginPlentymarketsApi\Controllers\TestController@sayHello');
    }
}