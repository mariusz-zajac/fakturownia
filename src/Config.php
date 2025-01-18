<?php

declare(strict_types=1);

namespace Abb\Fakturownia;

final class Config
{
    private string $subdomain;

    private string $apiToken;

    public function __construct(string $subdomain, string $apiToken)
    {
        $this->subdomain = $subdomain;
        $this->apiToken = $apiToken;
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
