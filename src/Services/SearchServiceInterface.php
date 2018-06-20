<?php

namespace Findologic\Ceres\Services;

use Plenty\Plugin\Http\Request;

/**
 * Interface SearchServiceInterface
 * @package Findologic\Ceres\Services
 */
interface SearchServiceInterface
{
    /**
     * @param $searchOptions
     * @param $request
     */
    public function handleSearchOptions($searchOptions, $request);

    /**
     * @param $searchOptions
     * @param $request
     */
    public function handleSearchQuery($searchQuery, $request);
}