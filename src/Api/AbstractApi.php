<?php

declare(strict_types=1);

namespace Abb\Fakturownia\Api;

use Abb\Fakturownia\Fakturownia;
use Abb\Fakturownia\Response;

abstract class AbstractApi
{
    public function __construct(
        protected Fakturownia $fakturownia,
    ) {
    }

    protected function request(string $method, string $url, array $options = []): Response
    {
        return $this->fakturownia->request()($method, $this->fakturownia->getBaseUrl() . '/' . $url, $options);
    }

    protected function getApiToken(): string
    {
        return $this->fakturownia->getApiToken();
    }
}
