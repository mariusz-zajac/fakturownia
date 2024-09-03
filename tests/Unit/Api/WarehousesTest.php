<?php

declare(strict_types=1);

namespace Abb\Fakturownia\Tests\Unit\Api;

use Abb\Fakturownia\Api\Warehouses;
use Abb\Fakturownia\Tests\Unit\AbstractTestCase;
use Symfony\Component\HttpClient\Response\JsonMockResponse;

final class WarehousesTest extends AbstractTestCase
{
    public function testGetWarehouseById(): void
    {
        $expectedResponseData = [
            'id' => 123,
            'name' => 'My warehouse',
            'kind' => null,
            'description' => 'My warehouse description',
        ];

        $mockResponse = new JsonMockResponse($expectedResponseData, ['http_code' => 200]);
        $client = $this->getApiClient($mockResponse);

        $response = (new Warehouses($client))->get(123);

        $this->assertSame('GET', $mockResponse->getRequestMethod());
        $this->assertSame('https://foo.fakturownia.pl/warehouses/123.json?api_token=bar', $mockResponse->getRequestUrl());
        $this->assertSame($expectedResponseData, $response->getContent());
        $this->assertSame(200, $response->getStatusCode());
    }

    public function testGetAllWarehouses(): void
    {
        $expectedResponseData = [
            [
                'id' => 123,
                'name' => 'My warehouse',
                'kind' => null,
                'description' => 'My warehouse description',
            ],
        ];

        $mockResponse = new JsonMockResponse($expectedResponseData, ['http_code' => 200]);
        $client = $this->getApiClient($mockResponse);

        $response = (new Warehouses($client))->getAll();

        $this->assertSame('GET', $mockResponse->getRequestMethod());
        $this->assertSame('https://foo.fakturownia.pl/warehouses.json?api_token=bar', $mockResponse->getRequestUrl());
        $this->assertSame($expectedResponseData, $response->getContent());
        $this->assertSame(200, $response->getStatusCode());
    }

    public function testCreateWarehouse(): void
    {
        $warehouseData = [
            'name' => 'My warehouse',
            'kind' => null,
            'description' => 'My warehouse description',
        ];

        $expectedRequestData = json_encode([
            'warehouse' => $warehouseData,
            'api_token' => 'bar',
        ], JSON_THROW_ON_ERROR);

        $expectedResponseData = [
            'code' => 'success',
        ];

        $mockResponse = new JsonMockResponse($expectedResponseData, ['http_code' => 201]);
        $client = $this->getApiClient($mockResponse);

        $response = (new Warehouses($client))->create($warehouseData);

        $this->assertSame('POST', $mockResponse->getRequestMethod());
        $this->assertSame('https://foo.fakturownia.pl/warehouses.json', $mockResponse->getRequestUrl());
        $this->assertSame($expectedRequestData, $mockResponse->getRequestOptions()['body']);
        $this->assertSame($expectedResponseData, $response->getContent());
        $this->assertSame(201, $response->getStatusCode());
    }

    public function testUpdateWarehouse(): void
    {
        $warehouseData = [
            'name' => 'My warehouse',
            'kind' => null,
            'description' => 'My warehouse description',
        ];

        $expectedRequestData = json_encode([
            'warehouse' => $warehouseData,
            'api_token' => 'bar',
        ], JSON_THROW_ON_ERROR);

        $expectedResponseData = [
            'code' => 'success',
        ];

        $mockResponse = new JsonMockResponse($expectedResponseData, ['http_code' => 200]);
        $client = $this->getApiClient($mockResponse);

        $response = (new Warehouses($client))->update(123, $warehouseData);

        $this->assertSame('PUT', $mockResponse->getRequestMethod());
        $this->assertSame('https://foo.fakturownia.pl/warehouses/123.json', $mockResponse->getRequestUrl());
        $this->assertSame($expectedRequestData, $mockResponse->getRequestOptions()['body']);
        $this->assertSame($expectedResponseData, $response->getContent());
        $this->assertSame(200, $response->getStatusCode());
    }

    public function testDeleteWarehouse(): void
    {
        $expectedResponseData = [
            'code' => 'success',
        ];

        $mockResponse = new JsonMockResponse($expectedResponseData, ['http_code' => 200]);
        $client = $this->getApiClient($mockResponse);

        $response = (new Warehouses($client))->delete(123);

        $this->assertSame('DELETE', $mockResponse->getRequestMethod());
        $this->assertSame('https://foo.fakturownia.pl/warehouses/123.json?api_token=bar', $mockResponse->getRequestUrl());
        $this->assertSame($expectedResponseData, $response->getContent());
        $this->assertSame(200, $response->getStatusCode());
    }
}
