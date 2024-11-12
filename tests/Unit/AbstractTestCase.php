<?php

declare(strict_types=1);

namespace Abb\Fakturownia\Tests\Unit;

use Abb\Fakturownia\Config;
use Abb\Fakturownia\Fakturownia;
use PHPUnit\Framework\TestCase;
use Symfony\Component\HttpClient\MockHttpClient;
use Symfony\Contracts\HttpClient\ResponseInterface;

abstract class AbstractTestCase extends TestCase
{
    protected function getFakturowniaStub(callable|iterable|ResponseInterface|null $mockResponse = null): Fakturownia
    {
        $config = new Config(
            subdomain: 'foo',
            apiToken: 'bar',
        );
        $httpClient = new MockHttpClient($mockResponse);

        return new Fakturownia($config, $httpClient);
    }
}
