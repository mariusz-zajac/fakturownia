<?php

declare(strict_types=1);

namespace Abb\Fakturownia\Tests\Unit\Api;

use Abb\Fakturownia\Api\WarehouseDocuments;
use Abb\Fakturownia\Tests\Unit\AbstractTestCase;
use Symfony\Component\HttpClient\Response\JsonMockResponse;

final class WarehouseDocumentsTest extends AbstractTestCase
{
    public function testGetWarehouseDocumentById(): void
    {
        $expectedResponseData = [
            'id' => 123,
            'kind' => 'mm',
            'number' => null,
            'warehouse_id' => '1',
            'issue_date' => '2017-10-23',
            'department_name' => 'Department1 SA',
            'client_name' => 'Client1 SA',
            'warehouse_actions' => [
                [
                    'product_name' => 'Produkt A1',
                    'purchase_tax' => 23,
                    'purchase_price_net' => 10.23,
                    'quantity' => 1,
                    'warehouse2_id' => 13,
                ],
            ],
        ];

        $mockResponse = new JsonMockResponse($expectedResponseData, ['http_code' => 200]);
        $client = $this->getApiClient($mockResponse);

        $response = (new WarehouseDocuments($client))->get(123);

        $this->assertSame('GET', $mockResponse->getRequestMethod());
        $this->assertSame('https://foo.fakturownia.pl/warehouse_documents/123.json?api_token=bar', $mockResponse->getRequestUrl());
        $this->assertSame($expectedResponseData, $response->getContent());
        $this->assertSame(200, $response->getStatusCode());
    }

    public function testGetAllWarehouseDocuments(): void
    {
        $expectedResponseData = [
            [
                'id' => 123,
                'kind' => 'mm',
                'number' => null,
                'warehouse_id' => '1',
                'issue_date' => '2017-10-23',
                'department_name' => 'Department1 SA',
                'client_name' => 'Client1 SA',
                'warehouse_actions' => [
                    [
                        'product_name' => 'Produkt A1',
                        'purchase_tax' => 23,
                        'purchase_price_net' => 10.23,
                        'quantity' => 1,
                        'warehouse2_id' => 13,
                    ],
                ],
            ],
        ];

        $mockResponse = new JsonMockResponse($expectedResponseData, ['http_code' => 200]);
        $client = $this->getApiClient($mockResponse);

        $response = (new WarehouseDocuments($client))->getAll();

        $this->assertSame('GET', $mockResponse->getRequestMethod());
        $this->assertSame('https://foo.fakturownia.pl/warehouse_documents.json?api_token=bar', $mockResponse->getRequestUrl());
        $this->assertSame($expectedResponseData, $response->getContent());
        $this->assertSame(200, $response->getStatusCode());
    }

    public function testCreateWarehouseDocument(): void
    {
        $warehouseDocumentData = [
            'kind' => 'mm',
            'number' => null,
            'warehouse_id' => '1',
            'issue_date' => '2017-10-23',
            'department_name' => 'Department1 SA',
            'client_name' => 'Client1 SA',
            'warehouse_actions' => [
                [
                    'product_name' => 'Produkt A1',
                    'purchase_tax' => 23,
                    'purchase_price_net' => 10.23,
                    'quantity' => 1,
                    'warehouse2_id' => 13,
                ],
            ],
        ];

        $expectedRequestData = json_encode([
            'warehouse_document' => $warehouseDocumentData,
            'api_token' => 'bar',
        ], JSON_THROW_ON_ERROR);

        $expectedResponseData = [
            'code' => 'success',
        ];

        $mockResponse = new JsonMockResponse($expectedResponseData, ['http_code' => 201]);
        $client = $this->getApiClient($mockResponse);

        $response = (new WarehouseDocuments($client))->create($warehouseDocumentData);

        $this->assertSame('POST', $mockResponse->getRequestMethod());
        $this->assertSame('https://foo.fakturownia.pl/warehouse_documents.json', $mockResponse->getRequestUrl());
        $this->assertSame($expectedRequestData, $mockResponse->getRequestOptions()['body']);
        $this->assertSame($expectedResponseData, $response->getContent());
        $this->assertSame(201, $response->getStatusCode());
    }

    public function testUpdateWarehouseDocument(): void
    {
        $warehouseDocumentData = [
            'kind' => 'mm',
            'number' => null,
            'warehouse_id' => '1',
            'issue_date' => '2017-10-23',
            'department_name' => 'Department1 SA',
            'client_name' => 'Client1 SA',
            'warehouse_actions' => [
                [
                    'product_name' => 'Produkt A1',
                    'purchase_tax' => 23,
                    'purchase_price_net' => 10.23,
                    'quantity' => 1,
                    'warehouse2_id' => 13,
                ],
            ],
        ];

        $expectedRequestData = json_encode([
            'warehouse_document' => $warehouseDocumentData,
            'api_token' => 'bar',
        ], JSON_THROW_ON_ERROR);

        $expectedResponseData = [
            'code' => 'success',
        ];

        $mockResponse = new JsonMockResponse($expectedResponseData, ['http_code' => 200]);
        $client = $this->getApiClient($mockResponse);

        $response = (new WarehouseDocuments($client))->update(123, $warehouseDocumentData);

        $this->assertSame('PUT', $mockResponse->getRequestMethod());
        $this->assertSame('https://foo.fakturownia.pl/warehouse_documents/123.json', $mockResponse->getRequestUrl());
        $this->assertSame($expectedRequestData, $mockResponse->getRequestOptions()['body']);
        $this->assertSame($expectedResponseData, $response->getContent());
        $this->assertSame(200, $response->getStatusCode());
    }

    public function testDeleteWarehouseDocument(): void
    {
        $expectedResponseData = [
            'code' => 'success',
        ];

        $mockResponse = new JsonMockResponse($expectedResponseData, ['http_code' => 200]);
        $client = $this->getApiClient($mockResponse);

        $response = (new WarehouseDocuments($client))->delete(123);

        $this->assertSame('DELETE', $mockResponse->getRequestMethod());
        $this->assertSame('https://foo.fakturownia.pl/warehouse_documents/123.json?api_token=bar', $mockResponse->getRequestUrl());
        $this->assertSame($expectedResponseData, $response->getContent());
        $this->assertSame(200, $response->getStatusCode());
    }
}
