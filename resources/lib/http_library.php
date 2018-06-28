<?php

use Findologic\Ceres\Constants\Plugin;

/** @var \Findologic\Ceres\Api\Request\Request $request */
$request = SdkRestApi::getParam('request');

$httpRequest = new \HTTP_Request2();

$httpRequest->setUrl($request['url']);
$httpRequest->setAdapter('curl');

$httpRequest->setConfig('connect_timeout', $request['connect_timeout']);
$httpRequest->setConfig('timeout', $request['timeout']);

$response = $httpRequest->send();

return $response->getBody();