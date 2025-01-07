<?php

declare(strict_types=1);

namespace Abb\Fakturownia\Tests\Unit;

use Abb\Fakturownia\Config;
use Abb\Fakturownia\Fakturownia;
use PHPUnit\Framework\TestCase;
use Symfony\Component\HttpClient\MockHttpClient;
use Symfony\Component\HttpClient\Psr18Client;
use Symfony\Component\HttpClient\Response\MockResponse;
use Symfony\Contracts\HttpClient\ResponseInterface;

abstract class AbstractTestCase extends TestCase
{
    /**
     * @param callable|callable[]|ResponseInterface|ResponseInterface[]|iterable|null $mockResponse
     */
    protected function getFakturowniaStub($mockResponse = null): Fakturownia
    {
        $config = new Config('foo', 'bar');
        $httpClient = new Psr18Client(new MockHttpClient($mockResponse));

        return new Fakturownia($config, $httpClient);
    }

    protected function createJsonMockResponse(array $body = [], array $info = []): MockResponse
    {
        try {
            $json = json_encode($body, \JSON_THROW_ON_ERROR | \JSON_PRESERVE_ZERO_FRACTION);
        } catch (\JsonException $e) {
            throw new \InvalidArgumentException('JSON encoding failed: ' . $e->getMessage(), $e->getCode(), $e);
        }

        $info['response_headers']['content-type'] ??= 'application/json';

        return $this->createMockResponse($json, $info);
    }

    /**
     * @param string|string[]|iterable $body
     */
    protected function createMockResponse($body = [], array $info = []): MockResponse
    {
        return new MockResponse($body, $info);
    }
}
