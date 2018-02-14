<?php

namespace Findologic\Providers;

use Findologic\Services\SearchService;
use Plenty\Plugin\ConfigRepository;
use Plenty\Plugin\ServiceProvider;
use Plenty\Plugin\Events\Dispatcher;

/**
 * Class FindologicServiceProvider
 * @package Findologic\Providers
 */
class FindologicServiceProvider extends ServiceProvider
{
    /**
     * @param Dispatcher $eventDispatcher
     */
    public function boot(Dispatcher $eventDispatcher, ConfigRepository $configRepository, SearchService $searchService)
    {
        if (!$configRepository->get('findologic.enabled', false)) {
            return;
        }

        $eventDispatcher->listen(
            'IO.Search.Options',
            function(\IO\Helper\SearchOptions $searchOptions) use ($searchService) {
                $searchService->handleSearchOptions($searchOptions);
            }
        );

        $eventDispatcher->listen(
            'IO.Search.Query',
            function(\IO\Helper\SearchQuery $searchQuery) use ($searchService) {
                $searchService->handleSearchQuery($searchQuery);
            }
        );
    }
}