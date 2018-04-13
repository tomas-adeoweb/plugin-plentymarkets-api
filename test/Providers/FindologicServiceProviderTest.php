<?php

namespace Findologic\Test\Providers;

use Findologic\Providers\FindologicServiceProvider;
use Findologic\Services\SearchService;
use Plenty\Plugin\ConfigRepository;
use Plenty\Plugin\Events\Dispatcher;
use Plenty\Plugin\Http\Request;

/**
 * Class FindologicServiceProviderTest
 * @package Findologic\Test\Providers
 */
class FindologicServiceProviderTest extends \PHPUnit_Framework_TestCase
{
    public function testBootPluginDisabled()
    {
        $configRepositoryMock = $this->getMockBuilder(ConfigRepository::class)->disableOriginalConstructor()->setMethods([])->getMock();
        $configRepositoryMock->expects($this->atLeastOnce())->method('get')->with('Findologic.enabled', false)->willReturn(false);
        $eventDispatcherMock = $this->getMockBuilder(Dispatcher::class)->disableOriginalConstructor()->setMethods([])->getMock();
        $eventDispatcherMock->expects($this->never())->method('listen');
        $requestMock = $this->getMockBuilder(Request::class)->disableOriginalConstructor()->getMock();
        $searchServiceMock = $this->getMockBuilder(SearchService::class)->disableOriginalConstructor()->getMock();

        /** @var FindologicServiceProvider|\PHPUnit_Framework_MockObject_MockObject $serviceProviderMock*/
        $serviceProviderMock = $this->getMockBuilder(FindologicServiceProvider::class)->disableOriginalConstructor()->setMethods(['getLogger'])->getMock();
        $serviceProviderMock->boot($configRepositoryMock, $eventDispatcherMock, $requestMock, $searchServiceMock);
    }

    public function testBootPluginEnabled()
    {
        $configRepositoryMock = $this->getMockBuilder(ConfigRepository::class)->disableOriginalConstructor()->setMethods([])->getMock();
        $configRepositoryMock->expects($this->atLeastOnce())->method('get')->with('Findologic.enabled', false)->willReturn(true);
        $eventDispatcherMock = $this->getMockBuilder(Dispatcher::class)->disableOriginalConstructor()->setMethods([])->getMock();
        $eventDispatcherMock->expects($this->exactly(2))->method('listen');
        $requestMock = $this->getMockBuilder(Request::class)->disableOriginalConstructor()->getMock();
        $searchServiceMock = $this->getMockBuilder(SearchService::class)->disableOriginalConstructor()->getMock();

        /** @var FindologicServiceProvider|\PHPUnit_Framework_MockObject_MockObject $serviceProviderMock*/
        $serviceProviderMock = $this->getMockBuilder(FindologicServiceProvider::class)->disableOriginalConstructor()->setMethods(['getLogger'])->getMock();
        $serviceProviderMock->boot($configRepositoryMock, $eventDispatcherMock, $requestMock, $searchServiceMock);
    }
}