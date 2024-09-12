<?php

declare(strict_types=1);

namespace Abb\Fakturownia\Tests\Functional\Api;

use Abb\Fakturownia\Exception\ApiException;
use Abb\Fakturownia\Tests\Functional\AbstractTestCase;

final class AccountsTest extends AbstractTestCase
{
    public function testGetAccount(): void
    {
        $response = $this->fakturownia->accounts()->get();

        $this->assertSame(200, $response->getStatusCode());
        $this->assertIsArray($response->getContent());
        $this->assertSame($this->options['subdomain'], $response->getContent()['prefix']);
    }

    public function testUnableToUnlinkNonExistentAccounts(): void
    {
        try {
            $this->fakturownia->accounts()->unlink(['abc']);
            $this->fail('ApiException should be thrown');
        } catch (ApiException $e) {
            $this->assertSame('Brak kont do odłączenia', $e->getMessage());
            $this->assertSame(422, $e->getCode());
            $this->assertIsArray($e->getResponse()->getContent());
            $this->assertSame(['abc'], $e->getResponse()->getContent()['result']['not_unlinked']);
        }
    }
}
