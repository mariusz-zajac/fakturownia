<?php

declare(strict_types=1);

namespace Abb\Fakturownia\Api;

use Abb\Fakturownia\Client;
use Abb\Fakturownia\Exception\ApiException;
use Abb\Fakturownia\Exception\RuntimeException;
use Symfony\Contracts\HttpClient\Exception\HttpExceptionInterface;

abstract class AbstractApi
{
    public function __construct(
        private Client $client,
    ) {
    }

    protected function request(string $method, string $url, array $options = []): Response
    {
        try {
            $response = $this->client->getHttpClient()->request(
                $method,
                $this->client->getBaseUrl() . '/' . $url,
                $options
            );

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

            $message = sprintf('HTTP %d returned from API', $response->getStatusCode());
            $reason = $response->getContent()['message'] ?? null;

            if (is_string($reason)) {
                $message .= ': ' . $reason;
            }

            throw new ApiException($message, $e->getCode(), $response, $e);
        } catch (\Throwable $e) {
            throw new RuntimeException($e->getMessage(), $e->getCode(), $e);
        }
    }

    protected function getApiToken(): string
    {
        return $this->client->getApiToken();
    }
}
