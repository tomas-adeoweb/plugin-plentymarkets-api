<?php

namespace Findologic\Api\Request;

use Plenty\Plugin\Http\Request as RequestData;

/**
 * Class RequestBuilder
 * @package Findologic\Api\Request
 */
class RequestBuilder
{
    public function build(RequestData $request)
    {
        $request = new Request();

        return $request;
    }
}