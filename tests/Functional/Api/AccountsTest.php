<?php

declare(strict_types=1);

namespace Abb\Fakturownia\Tests\Functional\Api;

use Abb\Fakturownia\Exception\ApiException;
use Abb\Fakturownia\Tests\Functional\AbstractTestCase;

final class AccountsTest extends AbstractTestCase
{
    public function testGetAccount(): void
    {
        $response = $this->fakturownia->accounts()->getOne();

        $this->assertIsArray($response);
        $this->assertSame($this->config->getSubdomain(), $response['prefix']);
    }

    public function testUnableToUnlinkNonExistentAccounts(): void
    {
        try {
            $this->fakturownia->accounts()->unlink(['abc']);
            $this->fail(ApiException::class . ' should be thrown');
        } catch (ApiException $e) {
            $this->assertSame('Brak kont do odłączenia', $e->getMessage());
            $this->assertSame(422, $e->getCode());
            $this->assertIsArray($e->getDetails());
            $this->assertSame(['abc'], $e->getDetails()['result']['not_unlinked']);
        }
    }
}
