<?php

declare(strict_types=1);

namespace Abb\Fakturownia;

use Abb\Fakturownia\Exception\ApiException;
use Abb\Fakturownia\Exception\RuntimeException;
use Symfony\Contracts\HttpClient\Exception\HttpExceptionInterface;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class ApiClient
{
    public function __construct(
        protected HttpClientInterface $client,
    ) {
    }

    /**
     * @throws ApiException
     * @throws RuntimeException
     *
     * @see HttpClientInterface::OPTIONS_DEFAULTS for available options
     */
    public function request(string $method, string $url, array $options = []): Response
    {
        try {
            $response = $this->client->request($method, $url, $options);

            return new Response(
                $response->getContent(),
                $response->getHeaders(),
                $response->getStatusCode(),
            );
        } catch (HttpExceptionInterface $e) {
            $response = new Response(
                $e->getResponse()->getContent(false),
                $e->getResponse()->getHeaders(false),
                $e->getResponse()->getStatusCode(),
            );

            throw new ApiException($this->getErrorMessage($response), $e->getCode(), $response, $e);
        } catch (\Throwable $e) {
            throw new RuntimeException($e->getMessage(), $e->getCode(), $e);
        }
    }

    protected function getErrorMessage(Response $response): string
    {
        try {
            $reason = $response->getContent()['message'] ?? $response->getContent()['error'] ?? null;
        } catch (\JsonException) {
            $reason = null;
        }

        if (is_string($reason) && $reason !== '') {
            return $reason;
        }

        if ($response->getStatusCode() === 400 || $response->getStatusCode() === 422) {
            return 'Invalid data';
        }

        return 'Unknown error';
    }
}
