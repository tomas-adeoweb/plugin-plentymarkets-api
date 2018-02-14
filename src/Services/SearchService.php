<?php

namespace Findologic\PluginPlentymarketsApi\Services;

use Findologic\PluginPlentymarketsApi\Api\Request\RequestBuilder;
use Findologic\PluginPlentymarketsApi\Api\Response\ResponseParser;
use Findologic\PluginPlentymarketsApi\Api\Client;

/**
 * Class SearchService
 * @package Findologic\Services
 */
class SearchService implements SearchServiceInterface
{
    /**
     * @var Client
     */
    protected $client;

    /**
     * @var RequestBuilder
     */
    protected $requestBuilder;

    /**
     * @var ResponseParser
     */
    protected $responseParser;

    public function __construct(
        Client $client,
        RequestBuilder $requestBuilder,
        ResponseParser $responseParser
    ) {
        $this->client = $client;
        $this->requestBuilder = $requestBuilder;
        $this->responseParser = $responseParser;
    }

    public function handleSearchQuery($searchQuery, $request)
    {
        $apiRequest = $this->requestBuilder->build($request, $searchQuery);
        $results = $this->responseParser->parse($this->client->call($apiRequest));
        $searchQuery->setSearchResults($results->getProductsIds());
    }

    public function handleSearchOptions($searchOptions, $request)
    {
        // TODO: Implement handleSearchOptions() method.
    }
}