<?php

declare(strict_types=1);

namespace Abb\Fakturownia\Tests\Functional;

use Abb\Fakturownia\Config;
use Abb\Fakturownia\Fakturownia;
use PHPUnit\Framework\TestCase;

abstract class AbstractTestCase extends TestCase
{
    protected Config $config;

    protected Fakturownia $fakturownia;

    protected function setUp(): void
    {
        if (empty(getenv('FAKTUROWNIA_SUBDOMAIN')) || empty(getenv('FAKTUROWNIA_TOKEN'))) {
            self::markTestSkipped('Environment variables required to run functional tests are missing');
        }

        $this->config = new Config(
            getenv('FAKTUROWNIA_SUBDOMAIN'),
            getenv('FAKTUROWNIA_TOKEN'),
        );

        $this->fakturownia = new Fakturownia($this->config);
    }

    protected function skipIf(bool $condition, string $message = ''): void
    {
        if ($condition) {
            self::markTestSkipped($message);
        }
    }
}
