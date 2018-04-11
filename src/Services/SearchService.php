<?php

namespace Findologic\Services;

use Findologic\Api\Request\RequestBuilder;
use Findologic\Api\Response\ResponseParser;
use Findologic\Api\Client;
use Findologic\Constants\Plugin;
use Findologic\Exception\AliveException;
use Plenty\Plugin\Http\Request as HttpRequest;
use Plenty\Plugin\Log\Loggable;
use Plenty\Log\Contracts\LoggerContract;

/**
 * Class SearchService
 * @package Findologic\Services
 */
class SearchService implements SearchServiceInterface
{
    use Loggable;

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

    /**
     * @var LoggerContract
     */
    protected $logger;

    public function __construct(
        Client $client,
        RequestBuilder $requestBuilder,
        ResponseParser $responseParser
    ) {
        $this->client = $client;
        $this->requestBuilder = $requestBuilder;
        $this->responseParser = $responseParser;
        $this->logger = $this->getLogger(Plugin::PLUGIN_IDENTIFIER);
    }

    /**
     * @param $searchQuery
     * @param HttpRequest $request
     */
    public function handleSearchQuery($searchQuery, $request)
    {
        try {
            $this->aliveTest();

            $this->logger->critical('Findologic search.');

            $apiRequest = $this->requestBuilder->build($request, $searchQuery);
            $results = $this->responseParser->parse($this->client->call($apiRequest));
            $productsIds = $results->getProductsIds();

            if (!empty($productsIds) && is_array($productsIds)) {
                $this->logger->critical('Set search results.');

                $searchQuery->setResults($productsIds);
            }

            //TODO: how to handle no results ?
        } catch (AliveException $e) {
            $this->logger->error('Findologic server did not responded to alive request. ' . $e->getMessage());
        } catch (\Exception $e) {
            $this->logger->error('Exception while handling search query.');
            $this->logger->logException($e);
        }
    }

    public function handleSearchOptions($searchOptions, $request)
    {
        $this->logger->critical('Findologic handleSearchOptions.');
    }

    /**
     * @throws AliveException
     */
    protected function aliveTest()
    {
        $request = $this->requestBuilder->buildAliveRequest();
        $response = $this->client->call($request);
        $response[] = 'Test';

        $this->logger->critical('Alive test.', $response);

        if ($response != Plugin::API_ALIVE_RESPONSE_BODY) {
            throw new AliveException('Server is not alive!');
        }
    }
}