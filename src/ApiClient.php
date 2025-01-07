<?php

declare(strict_types=1);

namespace Abb\Fakturownia;

use Abb\Fakturownia\Exception\ApiException;
use Abb\Fakturownia\Exception\RuntimeException;
use Nyholm\Psr7\Request;
use Psr\Http\Client\ClientInterface;

final class ApiClient
{
    private ClientInterface $httpClient;

    private array $defaultHeaders;

    private ?Response $lastResponse = null;

    public function __construct(ClientInterface $httpClient, array $defaultHeaders = [])
    {
        $this->httpClient = $httpClient;
        $this->defaultHeaders = $defaultHeaders;
    }

    /**
     * @param array{headers?: array, body?: array|string, query?: array} $options
     *
     * @throws ApiException
     * @throws RuntimeException
     */
    public function request(string $method, string $url, array $options = []): Response
    {
        $this->lastResponse = null;

        try {
            $headers = array_merge($this->defaultHeaders, $options['headers'] ?? []);
            $body = null;

            if (isset($options['body'])) {
                $body = $options['body'];

                if (is_array($body)) {
                    $body = json_encode($body, JSON_THROW_ON_ERROR | \JSON_PRESERVE_ZERO_FRACTION);
                    $headers['Accept'] ??= 'application/json';
                    $headers['Content-Type'] ??= 'application/json';
                }
            }

            if (!empty($options['query'])) {
                $url .= (str_contains($url, '?') ? '&' : '?') . http_build_query($options['query']);
            }

            $httpResponse = $this->httpClient->sendRequest(new Request($method, $url, $headers, $body));

            $this->lastResponse = $response = new Response(
                $httpResponse->getStatusCode(),
                $httpResponse->getHeaders(),
                (string) $httpResponse->getBody(),
            );
        } catch (\Throwable $e) {
            throw new RuntimeException($e->getMessage(), $e->getCode(), $e);
        }

        if ($response->getStatusCode() >= 400) {
            throw new ApiException(
                $this->getErrorMessage($response),
                $response->getStatusCode(),
                $this->getErrorDetails($response),
            );
        }

        return $response;
    }

    public function getLastResponse(): ?Response
    {
        return $this->lastResponse;
    }

    private function getErrorMessage(Response $response): string
    {
        try {
            $message = $response->toArray()['message'] ?? $response->toArray()['error'] ?? null;
        } catch (\JsonException $e) {
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

    private function getErrorDetails(Response $response): array
    {
        try {
            $details = $response->toArray();
        } catch (\JsonException $e) {
            $details = [];
        }

        return $details;
    }
}
