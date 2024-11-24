<?php

declare(strict_types=1);

namespace Abb\Fakturownia;

use Abb\Fakturownia\Exception\RequestException;
use Abb\Fakturownia\Exception\RuntimeException;
use Symfony\Contracts\HttpClient\Exception\HttpExceptionInterface;
use Symfony\Contracts\HttpClient\HttpClientInterface;

final class ApiClient
{
    public function __construct(
        private HttpClientInterface $client,
        private array $defaultHeaders = [],
    ) {
    }

    /**
     * @throws RequestException
     * @throws RuntimeException
     */
    public function request(
        string $method,
        string $url,
        array|string|null $body = null,
        array $query = [],
        array $headers = [],
    ): Response {
        try {
            $options = [];

            if (null !== $body) {
                if (is_array($body)) {
                    $options['json'] = $body;
                } else {
                    $options['body'] = $body;
                }
            }

            if (!empty($query)) {
                $options['query'] = $query;
            }

            $options['headers'] = array_merge($this->defaultHeaders, $headers);

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

            throw new RequestException($this->getErrorMessage($response), $e->getCode(), $response, $e);
        } catch (\Throwable $e) {
            throw new RuntimeException($e->getMessage(), $e->getCode(), $e);
        }
    }

    private function getErrorMessage(Response $response): string
    {
        try {
            $message = $response->getContent()['message'] ?? $response->getContent()['error'] ?? null;
        } catch (\JsonException) {
            $message = null;
        }

        if (is_string($message) && $message !== '') {
            return $message;
        }

        if ($response->getStatusCode() === 400 || $response->getStatusCode() === 422) {
            return 'Invalid data';
        }

        return sprintf('HTTP %d returned from API', $response->getStatusCode());
    }
}
