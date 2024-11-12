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

    protected function request(string $method, string $urlPath, array $options = []): Response
    {
        $url = sprintf('https://%s.fakturownia.pl/%s', $this->fakturownia->getConfig()->getSubdomain(), $urlPath);

        return $this->fakturownia->getApiClient()->request($method, $url, $options);
    }

    protected function getApiToken(): string
    {
        return $this->fakturownia->getConfig()->getApiToken();
    }
}
