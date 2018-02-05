<?php

namespace Findologic\Services;

/**
 * Class SearchService
 * @package Findologic\Services
 */
class SearchService implements SearchServiceInterface
{
    /**
     * @inheritdoc
     */
    public function getSearchResults($request)
    {
        return $request->all();
    }
}