<?php

namespace Findologic\PluginPlentymarketsApi\Providers;

use Findologic\PluginPlentymarketsApi\Constants\Plugin;
use Findologic\PluginPlentymarketsApi\Services\SearchService;
use Ceres\Helper\ExternalSearchOptions;
use Ceres\Helper\ExternalSearch;
use Plenty\Plugin\ConfigRepository;
use Plenty\Plugin\Events\Dispatcher;
use Plenty\Plugin\Http\Request;
use Plenty\Plugin\Log\LoggerFactory;
use Plenty\Log\Contracts\LoggerContract;
use Plenty\Plugin\ServiceProvider;

/**
 * Class FindologicServiceProvider
 * @package Findologic\Providers
 */
class FindologicServiceProvider extends ServiceProvider
{
    /**
     * @var LoggerContract
     */
    protected $logger;

    public function __construct(
        LoggerFactory $loggerFactory
    ) {
        $this->logger = $loggerFactory->getLogger(Plugin::PLUGIN_NAMESPACE, Plugin::PLUGIN_IDENTIFIER);
    }

    /**
     * @param Dispatcher $eventDispatcher
     * @param ConfigRepository $configRepository
     * @param SearchService $searchService
     */
    public function boot(
        ConfigRepository $configRepository,
        Dispatcher $eventDispatcher,
        Request $request,
        SearchService $searchService
    ) {
        if (!$configRepository->get('findologic.enabled', false)) {
            return;
        }

        $eventDispatcher->listen(
            'Ceres.Search.Options',
            function(ExternalSearchOptions $searchOptions) use ($searchService, $request) {
                $searchService->handleSearchOptions($searchOptions, $request);
            }
        );

        $eventDispatcher->listen(
            'Ceres.Search.Query',
            function(ExternalSearch $searchQuery) use ($searchService, $request) {
                $searchService->handleSearchQuery($searchQuery, $request);
            }
        );
    }
}