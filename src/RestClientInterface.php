<?php

namespace Abb\Fakturownia;

use Abb\Fakturownia\Exception\RequestErrorException;

/**
 * Rest Client Interface
 */
interface RestClientInterface
{

    /**
     * Send an HTTP GET request
     *
     * @param string $url    URL
     * @param array  $params Parameters
     *
     * @return ResponseInterface
     *
     * @throws RequestErrorException
     */
    public function get($url, array $params = []);

    /**
     * Send an HTTP POST request
     *
     * @param string $url    URL
     * @param array  $params Parameters
     *
     * @return ResponseInterface
     *
     * @throws RequestErrorException
     */
    public function post($url, array $params = []);

    /**
     * Send an HTTP PUT request
     *
     * @param string $url    URL
     * @param array  $params Parameters
     *
     * @return ResponseInterface
     *
     * @throws RequestErrorException
     */
    public function put($url, array $params = []);

    /**
     * Send an HTTP DELETE request
     *
     * @param string $url    URL
     * @param array  $params Parameters
     *
     * @return ResponseInterface
     *
     * @throws RequestErrorException
     */
    public function delete($url, array $params = []);
}
