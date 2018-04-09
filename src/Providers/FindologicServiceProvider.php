<?php

namespace Findologic\PluginPlentymarketsApi\Providers;

use Findologic\PluginPlentymarketsApi\Constants\Plugin;
use Findologic\PluginPlentymarketsApi\Services\SearchService;
use Ceres\Helper\ExternalSearchOptions;
use Ceres\Helper\ExternalSearch;
use Plenty\Plugin\ConfigRepository;
use Plenty\Plugin\Events\Dispatcher;
use Plenty\Plugin\Http\Request;
use Plenty\Plugin\ServiceProvider;
use Plenty\Plugin\Log\Loggable;
use Plenty\Log\Contracts\LoggerContract;

/**
 * Class FindologicServiceProvider
 * @package Findologic\Providers
 */
class FindologicServiceProvider extends ServiceProvider
{
    use Loggable;

    /**
     * @var LoggerContract
     */
    protected $logger = false;

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
/*        if (!$configRepository->get('findologic.enabled', false)) {
            return;
        }*/
        $this->getLoggerObject()->warning('Register findologic observers');

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

    /**
     * @return LoggerContract
     */
    protected function getLoggerObject()
    {
        if (!$this->logger) {
            $this->logger = $this->getLogger(Plugin::PLUGIN_IDENTIFIER);
        }

        return $this->logger;
    }
}