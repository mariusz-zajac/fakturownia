<?php

declare(strict_types=1);

namespace Abb\Fakturownia\Tests\Unit\Api;

use Abb\Fakturownia\Api\WarehouseActions;
use Abb\Fakturownia\Tests\Unit\AbstractTestCase;

final class WarehouseActionsTest extends AbstractTestCase
{
    public function testGetAllWarehouseActions(): void
    {
        $requestParams = [
            'page' => 1,
            'per_page' => 10,
            'warehouse_id' => 2,
        ];

        $expectedResponseData = [
            [
                'id' => 123,
                'name' => 'Action 1',
            ],
        ];

        $mockResponse = $this->createJsonMockResponse($expectedResponseData, ['http_code' => 200]);
        $fakturownia = $this->getFakturowniaStub($mockResponse);

        $response = (new WarehouseActions($fakturownia))->getAll($requestParams);

        $this->assertSame('GET', $mockResponse->getRequestMethod());
        $this->assertSame(
            'https://foo.fakturownia.pl/warehouse_actions.json?page=1&per_page=10&warehouse_id=2&api_token=bar',
            $mockResponse->getRequestUrl()
        );
        $this->assertSame($expectedResponseData, $response);
    }
}
