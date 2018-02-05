<?php

namespace Findologic\Providers;

use Plenty\Plugin\RouteServiceProvider;
use Plenty\Plugin\Routing\Router;

/**
 * Class FindologicRouteServiceProvider
 * @package Findologic\Providers
 */
class FindologicRouteServiceProvider extends RouteServiceProvider
{
    /**
     * @param Router $router
     */
    public function map(Router $router)
    {
        $router->get('search', 'Findologic\Controllers\SearchController@search');
    }
}