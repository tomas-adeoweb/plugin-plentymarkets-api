<?php

namespace Findologic\Controllers;

use Findologic\Services\SearchService;
use Plenty\Plugin\Controller;
use Plenty\Plugin\Http\Request;
use Plenty\Plugin\Templates\Twig;

/**
 * Class SearchController
 * @package Findologic\Controllers
 */
class SearchController extends Controller
{
    /**
     * @var SearchService
     */
    protected $searchService;

    public function __construct(SearchService $searchService)
    {
        $this->searchService = $searchService;
    }

    /**
     * @param Twig $twig
     * @return string
     */
    public function search(Request $request, Twig $twig): string
    {
        return $twig->render('Findologic::content.search', ['results' => $this->searchService->getSearchResults($request)]);
    }
}