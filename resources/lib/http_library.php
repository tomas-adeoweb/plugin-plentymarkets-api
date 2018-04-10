<?php

use Findologic\Constants\Plugin;

/** @var \Findologic\Api\Request\Request $request */
$request = SdkRestApi::getParam('request');
$httpRequest = new \HTTP_Request2();

$httpRequest->setUrl($request->getRequestUrl());
$httpRequest->setAdapter('curl');

$httpRequest->setConfig('connect_timeout', $request->getConfiguration(Plugin::API_CONFIGURATION_KEY_CONNECTION_TIME_OUT) ?? self::DEFAULT_CONNECTION_TIME_OUT);
$httpRequest->setConfig('timeout',$request->getConfiguration(Plugin::API_CONFIGURATION_KEY_TIME_OUT) ?? self::DEFAULT_CONNECTION_TIME_OUT);

return $httpRequest->send()->getBody();
