<?php

namespace Chekonline\Cashbox\HttpClients;

/**
 * Interface HttpClientInterface.
 */

interface HttpClientInterface
{
	/**
	 * @param 			$certPath
	 * @param 			$keyPath
	 * @param 			$certPassword
	 * @param            $url
	 * @param            $method
	 * @param array      $headers
	 * @param array      $options
	 * @param int        $timeOut
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