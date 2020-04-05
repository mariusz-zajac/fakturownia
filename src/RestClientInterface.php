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
    public function get(string $url, array $params = []): ResponseInterface;

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
    public function post(string $url, array $params = []): ResponseInterface;

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
    public function put(string $url, array $params = []): ResponseInterface;

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
    public function delete(string $url, array $params = []): ResponseInterface;
}
