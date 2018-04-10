<?php

namespace Findologic\Api;

use Findologic\Constants\Plugin;
use Findologic\Api\Request\Request;
use Plenty\Modules\Plugin\Libs\Contracts\LibraryCallContract;
use Plenty\Plugin\Log\Loggable;
use Plenty\Log\Contracts\LoggerContract;

/**
 * Class Client
 * @package Findologic\Api
 */
class Client
{
    use Loggable;

    const DEFAULT_CONNECTION_TIME_OUT = 5;

    const DEFAULT_TIME_OUT = 10;

    /**
     * @var LoggerContract
     */
    protected $logger;

    /**
     * @var LibraryCallContract
     */
    protected $libraryCallContract;

    public function __construct(LibraryCallContract $libraryCallContract)
    {
        $this->logger = $this->getLogger(Plugin::PLUGIN_IDENTIFIER);
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