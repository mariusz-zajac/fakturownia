<?php

declare(strict_types=1);

namespace Abb\Fakturownia\Api;

use Abb\Fakturownia\Fakturownia;

abstract class AbstractApi
{
    public function __construct(
        protected Fakturownia $fakturownia,
    ) {
    }

    protected function request(string $method, string $url, array $options = []): Response
    {
        return $this->fakturownia->getApiClient()->request($method, $this->fakturownia->getBaseUrl() . '/' . $url, $options);
    }

    protected function getApiToken(): string
    {
        return $this->fakturownia->getApiToken();
    }
}
