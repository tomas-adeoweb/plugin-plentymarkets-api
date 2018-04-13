<?php

namespace Findologic\Test\Services;

use Findologic\Api\Client;
use Findologic\Api\Request\Request;
use Findologic\Api\Request\RequestBuilder;
use Findologic\Api\Response\Response;
use Findologic\Api\Response\ResponseParser;
use Findologic\Constants\Plugin;
use Findologic\Exception\AliveException;
use Findologic\Services\SearchService;
use Ceres\Helper\ExternalSearch;
use Plenty\Log\Contracts\LoggerContract;
use Plenty\Plugin\Http\Request as HttpRequest;
use Plenty\Plugin\Log\LoggerFactory;

/**
 * Class SearchServiceTest
 * @package Findologic\Test\Services
 */
class SearchServiceTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var Client|\PHPUnit_Framework_MockObject_MockObject
     */
    protected $client;

    /**
     * @var RequestBuilder|\PHPUnit_Framework_MockObject_MockObject
     */
    protected $requestBuilder;

    /**
     * @var ResponseParser|\PHPUnit_Framework_MockObject_MockObject
     */
    protected $responseParser;

    /**
     * @var LoggerFactory|\PHPUnit_Framework_MockObject_MockObject
     */
    protected $loggerFactory;

    /**
     * @var LoggerContract|\PHPUnit_Framework_MockObject_MockObject
     */
    protected $logger;

    public function setUp()
    {
        $this->client = $this->getMockBuilder(Client::class)->disableOriginalConstructor()->setMethods([])->getMock();
        $this->requestBuilder = $this->getMockBuilder(RequestBuilder::class)->disableOriginalConstructor()->setMethods([])->getMock();
        $this->responseParser = $this->getMockBuilder(ResponseParser::class)->disableOriginalConstructor()->setMethods([])->getMock();
        $this->logger = $this->getMockBuilder(LoggerContract::class)->disableOriginalConstructor()->setMethods([])->getMock();
        $this->loggerFactory = $this->getMockBuilder(LoggerFactory::class)->disableOriginalConstructor()->setMethods([])->getMock();
        $this->loggerFactory->expects($this->any())->method('getLogger')->willReturn($this->logger);
    }

    public function testHandleSearchQueryAliveException()
    {
        $requestMock = $this->getMockBuilder(Request::class)->disableOriginalConstructor()->setMethods([])->getMock();
        $this->requestBuilder->expects($this->once())->method('buildAliveRequest')->willReturn($requestMock);
        $this->requestBuilder->expects($this->never())->method('build');

        $this->client->expects($this->once())->method('call')->willReturn('Test');

        $searchServiceMock = $this->getSearchServiceMock();
        $searchQueryMock = $this->getMockBuilder(ExternalSearch::class)->disableOriginalConstructor()->setMethods([])->getMock();
        $requestMock = $this->getMockBuilder(HttpRequest::class)->disableOriginalConstructor()->setMethods([])->getMock();

        $searchServiceMock->handleSearchQuery($searchQueryMock, $requestMock);
    }

    public function testHandleSearchQueryException()
    {
        $this->client->expects($this->once())->method('call')->willThrowException(new \Exception('Test'));
        $this->requestBuilder->expects($this->never())->method('build');
        $requestMock = $this->getMockBuilder(Request::class)->disableOriginalConstructor()->setMethods([])->getMock();
        $this->requestBuilder->expects($this->once())->method('buildAliveRequest')->willReturn($requestMock);

        $searchServiceMock = $this->getSearchServiceMock();
        $searchQueryMock = $this->getMockBuilder(ExternalSearch::class)->disableOriginalConstructor()->setMethods([])->getMock();
        $requestMock = $this->getMockBuilder(HttpRequest::class)->disableOriginalConstructor()->setMethods([])->getMock();

        $searchServiceMock->handleSearchQuery($searchQueryMock, $requestMock);
    }

    public function testHandleSearchQuery()
    {
        $requestMock = $this->getMockBuilder(Request::class)->disableOriginalConstructor()->setMethods([])->getMock();
        $this->requestBuilder->expects($this->once())->method('buildAliveRequest')->willReturn($requestMock);
        $this->requestBuilder->expects($this->any())->method('build')->willReturn($requestMock);
        $this->client->expects($this->any())->method('call')->willReturn(Plugin::API_ALIVE_RESPONSE_BODY);

        $responseMock = $this->getMockBuilder(Response::class)->disableOriginalConstructor()->setMethods([])->getMock();
        $responseMock->expects($this->once())->method('getProductsIds')->willReturn([1, 2, 3]);
        $this->responseParser->expects($this->once())->method('parse')->willReturn($responseMock);

        $searchServiceMock = $this->getSearchServiceMock();
        $searchQueryMock = $this->getMockBuilder(ExternalSearch::class)->disableOriginalConstructor()->setMethods([])->getMock();
        $searchQueryMock->expects($this->once())->method('setResults');
        $requestMock = $this->getMockBuilder(HttpRequest::class)->disableOriginalConstructor()->setMethods([])->getMock();

        $searchServiceMock->handleSearchQuery($searchQueryMock, $requestMock);
    }

    /**
     * @param array|null $methods
     * @return SearchService|\PHPUnit_Framework_MockObject_MockObject
     */
    protected function getSearchServiceMock($methods = null)
    {
        $searchServiceMock = $this->getMockBuilder(SearchService::class)
            ->setConstructorArgs([
                'client' => $this->client,
                'requestBuilder' => $this->requestBuilder,
                'responseParser' => $this->responseParser
            ])
            ->setMethods($methods)
            ->getMock();

        $searchServiceMock->setLogger($this->logger);

        return $searchServiceMock;
    }
}