<?php

namespace Findologic\Providers;

use Plenty\Plugin\ServiceProvider;

/**
 * Class FindologicServiceProvider
 * @package Findologic\Providers
 */
class FindologicServiceProvider extends ServiceProvider
{
    /**
     * Register the service provider.
     */
    public function register()
    {
        $this->getApplication()->register(FindologicServiceProvider::class);
    }
}