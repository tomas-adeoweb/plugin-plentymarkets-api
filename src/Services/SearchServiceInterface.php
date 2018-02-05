<?php

namespace Findologic\Services;

use Plenty\Plugin\Http\Request;

/**
 * Interface SearchServiceInterface
 * @package Findologic\Services
 */
interface SearchServiceInterface
{
    /**
     * @param Request $request
     * @return array
     */
    public function getSearchResults($request);
}