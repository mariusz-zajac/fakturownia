<?php

declare(strict_types=1);

namespace Abb\Fakturownia;

final class Config
{
    public function __construct(
        private string $subdomain,
        private string $apiToken,
    ) {
    }

    public function getSubdomain(): string
    {
        return $this->subdomain;
    }

    public function getApiToken(): string
    {
        return $this->apiToken;
    }
}
