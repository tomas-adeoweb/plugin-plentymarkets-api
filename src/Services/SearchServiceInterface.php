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
     * @param $searchOptions
     */
    public function handleSearchOptions($searchOptions);

    /**
     * @param $searchQuery
     */
    public function handleSearchQuery($searchQuery);
}