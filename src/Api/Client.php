<?php

namespace Findologic\PluginPlentymarketsApi\Api;

use Findologic\PluginPlentymarketsApi\Constants\Plugin;
use Findologic\PluginPlentymarketsApi\Api\Request\Request;
use Plenty\Modules\Plugin\Libs\Contracts\LibraryCallContract;
use Plenty\Plugin\Log\LoggerFactory;
use HTTP_Request2;

/**
 * Class Client
 * @package Findologic\Api
 */
class Client
{
    const DEFAULT_CONNECTION_TIME_OUT = 5;

    const DEFAULT_TIME_OUT = 10;

    /**
     * @var LoggerFactory
     */
    protected $logger;

    /**
     * @var LibraryCallContract
     */
    protected $libraryCallContract;

    public function __construct(LoggerFactory $loggerFactory, LibraryCallContract $libraryCallContract)
    {
        $this->logger = $loggerFactory->getLogger(Plugin::PLUGIN_NAMESPACE, Plugin::PLUGIN_IDENTIFIER);
        $this->libraryCallContract = $libraryCallContract;
    }

    /**
     * @param Request $request
     * @return string|bool
     */
    public function call(Request $request)
    {
        $response = false;

        try {
            $response = $this->libraryCallContract->call(
                'Findologic::http_library',
                ['request' => $request]
            );
        } catch (\Exception $e) {
            $this->logger->warning('Exception while handling search query.');
            $this->logger->logException($e);
            return $response;
        }

        return (string)$response;
    }
}