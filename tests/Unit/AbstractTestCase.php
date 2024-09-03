<?php

declare(strict_types=1);

namespace Abb\Fakturownia\Tests\Unit;

use Abb\Fakturownia\Client;
use PHPUnit\Framework\TestCase;
use Symfony\Component\HttpClient\MockHttpClient;
use Symfony\Contracts\HttpClient\ResponseInterface;

abstract class AbstractTestCase extends TestCase
{
    protected array $apiClientOptions = [
        'subdomain' => 'foo',
        'api_token' => 'bar',
    ];

    protected function getApiClient(callable|iterable|ResponseInterface|null $mockResponse = null): Client
    {
        $httpClient = new MockHttpClient($mockResponse);

        return new Client($this->apiClientOptions, $httpClient);
    }
}
