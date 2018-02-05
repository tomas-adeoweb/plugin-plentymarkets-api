<?php

namespace Findologic\Services;

use Findologic\Api\Request\RequestBuilder;
use Findologic\Api\Response\ResponseParser;
use Findologic\Api\Client;

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

    /**
     * @inheritdoc
     */
    public function getSearchResults($request)
    {
        $responseData = $this->client->call($this->requestBuilder->build($request));

        return $this->responseParser->parse($responseData);
    }
}