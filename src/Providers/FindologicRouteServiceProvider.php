<?php

namespace Findologic\Ceres\Providers;

use Plenty\Plugin\RouteServiceProvider;
use Plenty\Plugin\Routing\Router;

/**
 * Class FindologicRouteServiceProvider
 * @package Findologic\Ceres\Providers
 */
class FindologicRouteServiceProvider extends RouteServiceProvider
{
    public function map(Router $router)
    {
        $router->get('findologic','Findologic\Controllers\TestController@sayHello');
    }
}