<?php

declare(strict_types=1);

namespace Abb\Fakturownia;

use Abb\Fakturownia\Exception\ApiException;
use Abb\Fakturownia\Exception\RuntimeException;
use Nyholm\Psr7\Request;
use Psr\Http\Client\ClientInterface;
use Psr\Http\Message\ResponseInterface;

final class ApiClient
{
    private ?ResponseInterface $lastResponse = null;

    public function __construct(
        private ClientInterface $client,
        private array $defaultHeaders = [],
    ) {
    }

    /**
     * @throws ApiException
     * @throws RuntimeException
     */
    public function request(
        string $method,
        string $url,
        array|string|null $body = null,
        array $query = [],
        array $headers = [],
    ): Response {
        $this->lastResponse = null;

        try {
            $headers = array_merge($this->defaultHeaders, $headers);

            if (is_array($body)) {
                $body = json_encode($body, JSON_THROW_ON_ERROR | \JSON_PRESERVE_ZERO_FRACTION);
                $headers['Accept'] ??= 'application/json';
                $headers['Content-Type'] ??= 'application/json';
            }

            if (!empty($query)) {
                $url .= (str_contains($url, '?') ? '&' : '?') . http_build_query($query);
            }

            $this->lastResponse = $this->client->sendRequest(new Request($method, $url, $headers, $body));

            $response = new Response(
                (string) $this->lastResponse->getBody(),
                $this->lastResponse->getStatusCode(),
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

    public function getLastResponse(): ?ResponseInterface
    {
        return $this->lastResponse;
    }

    private function getErrorMessage(Response $response): string
    {
        try {
            $message = $response->toArray()['message'] ?? $response->toArray()['error'] ?? null;
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

    private function getErrorDetails(Response $response): array
    {
        try {
            $details = $response->toArray();
        } catch (\JsonException) {
            $details = [];
        }

        return $details;
    }
}
