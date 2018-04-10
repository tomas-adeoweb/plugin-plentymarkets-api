<?php

namespace Findologic\Controllers;

use Findologic\Constants\Plugin;
use Plenty\Plugin\Controller;
use Plenty\Plugin\Templates\Twig;
use Plenty\Plugin\Log\Loggable;

/**
 * Class TestController
 * @package Findologic\Controllers
 */
class TestController extends Controller
{
    use Loggable;

    public function sayHello(Twig $twig):string
    {
        $this->getLogger(Plugin::PLUGIN_IDENTIFIER)->critical('Test Findologic');

        return $twig->render('Findologic::content.hello');
    }
}