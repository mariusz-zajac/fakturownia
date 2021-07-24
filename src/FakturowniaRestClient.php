<?php

namespace Abb\Fakturownia;

use Abb\Fakturownia\Exception\RequestErrorException;

/**
 * Fakturownia REST Client
 */
class FakturowniaRestClient implements RestClientInterface
{

    /**
     * @var resource
     */
    protected $curl;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->curl = curl_init();
    }

    /**
     * Destructor
     */
    public function __destruct()
    {
        if (is_resource($this->curl)) {
            curl_close($this->curl);
        }
    }

    /**
     * @inheritDoc
     */
    public function get(string $url, array $params = []): ResponseInterface
    {
        return $this->request('GET', $url, $params);
    }

    /**
     * @inheritDoc
     */
    public function post(string $url, array $params = []): ResponseInterface
    {
        return $this->request('POST', $url, $params);
    }

    /**
     * @inheritDoc
     */
    public function put(string $url, array $params = []): ResponseInterface
    {
        return $this->request('PUT', $url, $params);
    }

    /**
     * @inheritDoc
     */
    public function delete(string $url, array $params = []): ResponseInterface
    {
        return $this->request('DELETE', $url, $params);
    }

    /**
     * Send an HTTP request
     *
     * @param string $method HTTP method
     * @param string $url    URL
     * @param array  $params Parameters
     *
     * @return ResponseInterface
     *
     * @throws RequestErrorException
     */
    protected function request(string $method, string $url, array $params = []): ResponseInterface
    {
        curl_setopt_array($this->curl, [
            CURLOPT_HTTPHEADER => [
                'Accept: application/json',
                'Content-Type: application/json'
            ],
            CURLOPT_HEADER => false,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_CUSTOMREQUEST => $method,
        ]);

        if ($params) {
            if ('GET' === $method) {
                $url = $url . '?' . http_build_query($params);
            } else {
                curl_setopt($this->curl, CURLOPT_POSTFIELDS, json_encode($params));
            }
        }

        curl_setopt($this->curl, CURLOPT_URL, $url);

        $result = curl_exec($this->curl);

        if (false === $result) {
            throw new RequestErrorException(curl_error($this->curl), curl_errno($this->curl));
        }

        $code = curl_getinfo($this->curl, CURLINFO_RESPONSE_CODE);
        $contentType = curl_getinfo($this->curl, CURLINFO_CONTENT_TYPE);

        curl_reset($this->curl);

        if (false !== strpos($contentType, 'application/pdf')) {
            $params = ['content' => $result];
        } else {
            $params = (array) json_decode($result, true);
        }

        return new FakturowniaResponse($code, $params);
    }
}
