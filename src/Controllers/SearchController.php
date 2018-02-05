<?php

namespace Findologic\Controllers;

use Plenty\Plugin\Controller;
use Plenty\Plugin\Templates\Twig;

/**
 * Class SearchController
 * @package Findologic\Controllers
 */
class SearchController extends Controller
{
    /**
     * @param Twig $twig
     * @return string
     */
    public function sayHello(Twig $twig): string
    {
        return $twig->render('Findologic::content.search');
    }
}