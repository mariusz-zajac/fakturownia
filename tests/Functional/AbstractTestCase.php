<?php

declare(strict_types=1);

namespace Abb\Fakturownia\Tests\Functional;

use Abb\Fakturownia\Fakturownia;
use PHPUnit\Framework\TestCase;

abstract class AbstractTestCase extends TestCase
{
    protected array $options = [];

    protected Fakturownia $fakturownia;

    protected function setUp(): void
    {
        if (empty(getenv('FAKTUROWNIA_SUBDOMAIN')) || empty(getenv('FAKTUROWNIA_TOKEN'))) {
            self::markTestSkipped('Environment variables required to run functional tests are missing');
        }

        $this->options = [
            'subdomain' => getenv('FAKTUROWNIA_SUBDOMAIN'),
            'api_token' => getenv('FAKTUROWNIA_TOKEN'),
        ];

        $this->fakturownia = new Fakturownia($this->options);
    }

    protected function skipIf(bool $condition, string $message = ''): void
    {
        if ($condition) {
            self::markTestSkipped($message);
        }
    }
}
