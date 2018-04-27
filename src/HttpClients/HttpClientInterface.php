<?php

namespace Chekonline\Cashbox\HttpClients;

/**
 * Interface HttpClientInterface.
 */

interface HttpClientInterface
{
    /**
     * @param string $certPath
     * @param string $keyPath
     * @param string $certPassword
     * @param string $url
     * @param string $method
     * @param array $headers
     * @param array $options
     * @param int $timeOut
     *
     * @return mixed
     */
    public function send(
        $certPath,
        $keyPath,
        $certPassword,
        $url,
        $method,
        $headers = array([]),
        $options = array([]),
        $timeOut = 60
    );
}