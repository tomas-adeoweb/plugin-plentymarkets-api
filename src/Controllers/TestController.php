<?php

namespace Findologic\Ceres\Controllers;

use Findologic\Constants\Plugin;
use Plenty\Plugin\Controller;
use Plenty\Plugin\Templates\Twig;
use Plenty\Plugin\Log\Loggable;

/**
 * Class TestController
 * @package Findologic\Ceres\Controllers
 */
class TestController extends Controller
{
    use Loggable;

    public function sayHello(Twig $twig):string
    {
        return $twig->render('Findologic::content.hello');
    }
}