<?php

namespace Findologic\Api\Request;

/**
 * Class Request
 * @package Findologic\Api\Request
 */
class Request
{
    protected $url;

    protected $headers = [];

    protected $params = [];

    /**
     * @return mixed
     */
    public function getUrl()
    {
        return $this->url;
    }

    /**
     * @param mixed $url
     * @return Request
     */
    public function setUrl($url)
    {
        $this->url = $url;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getHeaders()
    {
        return $this->headers;
    }

    /**
     * @param mixed $headers
     * @return Request
     */
    public function setHeaders($headers)
    {
        $this->headers = $headers;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getParams()
    {
        return $this->params;
    }

    /**
     * @param mixed $params
     * @return Request
     */
    public function setParams($params)
    {
        $this->params = $params;

        return $this;
    }
}