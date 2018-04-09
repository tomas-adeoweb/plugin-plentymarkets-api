<?php

namespace Findologic\PluginPlentymarketsApi\Api\Request;

use Ceres\Helper\ExternalSearch;
use Findologic\PluginPlentymarketsApi\Constants\Plugin;
use Findologic\PluginPlentymarketsApi\Api\Client;
use Plenty\Plugin\ConfigRepository;
use Plenty\Plugin\Http\Request as HttpRequest;
use Plenty\Plugin\Log\Loggable;
use Plenty\Log\Contracts\LoggerContract;

/**
 * Class RequestBuilder
 * @package Findologic\Api\Request
 */
class RequestBuilder
{
    use Loggable;

    /**
     * @var ConfigRepository
     */
    protected $configRepository;

    /**
     * @var LoggerContract
     */
    protected $logger;

    /**
     * @var Request|bool $request
     */
    protected $request;

    public function __construct(ConfigRepository $configRepository)
    {
        $this->configRepository = $configRepository;
        $this->logger = $this->getLogger(Plugin::PLUGIN_IDENTIFIER);
    }

    /**
     * @param HttpRequest $httpRequest
     * @param ExternalSearch|null $searchQuery
     * @return bool|Request
     */
    public function build($httpRequest, $searchQuery = null)
    {
        $request = $this->createRequestObject();
        $request = $this->setDefaultValues($request);
        $request = $this->setSearchParams($request, $httpRequest, $searchQuery);

        return $request;
    }

    /**
     * @return bool|Request
     */
    public function buildAliveRequest()
    {
        $request = $this->createRequestObject();

        $request->setUrl($this->getCleanShopUrl('alive'))->setParam('shopkey', $this->configRepository->get(Plugin::CONFIG_SHOPKEY));
        $request->setConfiguration(Plugin::API_CONFIGURATION_KEY_TIME_OUT, 1);

        return $request;
    }

    /**
     * @return Request
     */
    public function createRequestObject()
    {
        return pluginApp(Request::class);
    }

    /**
     * @param string $type
     * @return string
     */
    public function getCleanShopUrl($type = 'request')
    {
        $url = ltrim($this->configRepository->get(Plugin::CONFIG_URL), '/') . '/';

        if ($type == 'alive') {
            $url .= 'alivetest.php';
        } else {
            $url .= 'index.php';
        }

        return $url;
    }

    /**
     * @param Request $request
     * @return Request
     */
    public function setDefaultValues($request)
    {
        $request->setUrl($this->getCleanShopUrl());
        $request->setParam('outputAdapter', Plugin::API_OUTPUT_ADAPTER);
        $request->setParam('shopkey', $this->configRepository->get(Plugin::CONFIG_SHOPKEY));
        $request->setConfiguration(Plugin::API_CONFIGURATION_KEY_CONNECTION_TIME_OUT, Client::DEFAULT_CONNECTION_TIME_OUT);

        return $request;
    }

    /**
     * @param Request $request
     * @param HttpRequest $httpRequest
     * @param ExternalSearch $searchQuery
     * @return Request
     */
    public function setSearchParams($request, $httpRequest, $searchQuery)
    {
        if ($searchQuery->searchString) {
            $request->setParam('query', $searchQuery->searchString);
        }

        $parameters = $httpRequest->all();

        if (isset($parameters[Plugin::API_PARAMETER_ATTRIBUTES])) {
            $attributes = $parameters[Plugin::API_PARAMETER_ATTRIBUTES];
            foreach ($attributes as $key => $value) {
                $request->setAttributeParam($key, $value);
            }
        }

        if (isset($parameters[Plugin::API_PARAMETER_SORT_ORDER]) && in_array($parameters[Plugin::API_PARAMETER_SORT_ORDER], Plugin::API_SORT_ORDER_AVAILABLE_OPTIONS)) {
            $request->setParam(Plugin::API_PARAMETER_SORT_ORDER, $parameters[Plugin::API_PARAMETER_SORT_ORDER]);
        }

        $request = $this->setPagination($request, $parameters);

        return $request;
    }

    /**
     * @param Request $request
     * @param array $parameters
     * @return Request
     */
    protected function setPagination($request, $parameters)
    {
        $pageSize = $parameters[Plugin::API_PARAMETER_PAGINATION_ITEMS_PER_PAGE] ?? 0;

        if (intval($pageSize) > 0) {
            $request->setParam(Plugin::API_PARAMETER_PAGINATION_ITEMS_PER_PAGE, $pageSize);
        }

        $paginationStart = $parameters[Plugin::API_PARAMETER_PAGINATION_START] ?? 0;

        if (intval($paginationStart) > 0) {
            $request->setParam(Plugin::API_PARAMETER_PAGINATION_START, $paginationStart);
        }

        return $request;
    }
}