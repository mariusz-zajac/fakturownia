<?php

declare(strict_types=1);

namespace Abb\Fakturownia\Tests\Functional\Api;

use Abb\Fakturownia\Tests\Functional\AbstractTestCase;

final class ClientsTest extends AbstractTestCase
{
    public function testGetClient(): void
    {
        $this->skipIf(empty($clientId = (int) getenv('FAKTUROWNIA_CLIENT_ID')), 'Missing FAKTUROWNIA_CLIENT_ID');

        $response = $this->fakturownia->clients()->getOne($clientId);

        $this->assertIsArray($response);
        $this->assertSame($clientId, $response['id']);
    }

    public function testGetClientsByExternalId(): void
    {
        $this->skipIf(empty($clientExternalId = getenv('FAKTUROWNIA_CLIENT_EXTERNAL_ID')), 'Missing FAKTUROWNIA_CLIENT_EXTERNAL_ID');

        $response = $this->fakturownia->clients()->getAllByExternalId($clientExternalId);

        $this->assertIsArray($response);
        $this->assertCount(1, $response);
        $this->assertSame($clientExternalId, $response[0]['external_id']);
    }
}
