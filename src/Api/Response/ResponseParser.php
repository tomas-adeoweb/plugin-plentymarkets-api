<?php

namespace Findologic\Api\Response;

use Findologic\Constants\Plugin;
use Plenty\Plugin\Log\LoggerFactory;

/**
 * Class ResponseParser
 * @package Findologic\Api\Response
 */
class ResponseParser
{
    /**
     * @var \Plenty\Log\Contracts\LoggerContract
     */
    protected $logger;

    public function __construct(LoggerFactory $loggerFactory)
    {
        $this->logger = $loggerFactory->getLogger(Plugin::PLUGIN_NAMESPACE, Plugin::PLUGIN_IDENTIFIER);
    }

    /**
     * @param $responseData
     * @return Response
     */
    public function parse($responseData)
    {
        $response = pluginApp(Response::class);

        try {
            $data = simplexml_load_string($responseData);
        } catch (\Exception $e) {
            //TODO: logging
        }

        return $response;
    }
}