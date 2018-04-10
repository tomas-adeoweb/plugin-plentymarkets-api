<?php

namespace Findologic\PluginPlentymarketsApi\Controllers;

use Plenty\Plugin\Controller;
use Plenty\Plugin\Templates\Twig;

/**
 * Class TestController
 * @package Findologic\PluginPlentymarketsApi\Controllers
 */
class TestController extends Controller
{
    public function sayHello(Twig $twig):string
    {
        return $twig->render('Findologic::content.hello');
    }
}