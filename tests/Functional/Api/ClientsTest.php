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

        $this->assertSame(200, $response->getStatusCode());
        $this->assertIsArray($response->getContent());
        $this->assertSame($clientId, $response->getContent()['id']);
    }

    public function testGetClientsByExternalId(): void
    {
        $this->skipIf(empty($clientExternalId = getenv('FAKTUROWNIA_CLIENT_EXTERNAL_ID')), 'Missing FAKTUROWNIA_CLIENT_EXTERNAL_ID');

        $response = $this->fakturownia->clients()->getAllByExternalId($clientExternalId);

        $this->assertSame(200, $response->getStatusCode());
        $this->assertIsArray($response->getContent());
        $this->assertCount(1, $response->getContent());
        $this->assertSame($clientExternalId, $response->getContent()[0]['external_id']);
    }
}
