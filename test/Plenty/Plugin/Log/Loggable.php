<?php

namespace Plenty\Plugin\Log;

/**
 * Loggable trait
 * @package Plenty\Plugin\Log
 * @PluginTrait()
 */
trait Loggable
{
    protected $logger;

    /**
     * @param $logger
     * @return $this
     */
    public function setLogger($logger)
    {
        $this->logger = $logger;

        return $this;
    }

    /**
     * @return bool
     */
    public function getLogger($identifier)
    {
        return $this->logger;
    }
}