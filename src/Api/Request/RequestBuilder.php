<?php

namespace Findologic\PluginPlentymarketsApi\Api\Request;

use Findologic\PluginPlentymarketsApi\Constants\Plugin;
use Plenty\Plugin\ConfigRepository;
use Plenty\Plugin\Log\LoggerFactory;

/**
 * Class RequestBuilder
 * @package Findologic\Api\Request
 */
class RequestBuilder
{
    /**
     * @var ConfigRepository
     */
    protected $configRepository;

    /**
     * @var \Plenty\Log\Contracts\LoggerContract
     */
    protected $logger;

    public function __construct(ConfigRepository $configRepository, LoggerFactory $loggerFactory)
    {
        $this->configRepository = $configRepository;
        $this->logger = $loggerFactory->getLogger(Plugin::PLUGIN_NAMESPACE, Plugin::PLUGIN_IDENTIFIER);
    }

    /**
     * @param Request $request
     * @param null $searchQuery
     * @return mixed|null
     */
    public function build($request, $searchQuery = null)
    {
        /** @var Request $request */
        $request = pluginApp(Request::class);

        $request = $this->setDefaultValues($request);

        return $request;
    }

    /**
     * @param Request $request
     * @return mixed
     */
    public function setDefaultValues($request)
    {
        $request->setUrl($this->configRepository->get(Plugin::CONFIG_URL));
        $request->setParam('outputAdapter', Plugin::API_OUTPUT_ADAPTER);
        $request->setParam('shopkey', $this->configRepository->get(Plugin::CONFIG_SHOPKEY));

        return $request;
    }
}