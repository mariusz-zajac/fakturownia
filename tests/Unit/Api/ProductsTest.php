<?php

declare(strict_types=1);

namespace Abb\Fakturownia\Tests\Unit\Api;

use Abb\Fakturownia\Api\Products;
use Abb\Fakturownia\Tests\Unit\AbstractTestCase;
use Symfony\Component\HttpClient\Response\JsonMockResponse;

final class ProductsTest extends AbstractTestCase
{
    public function testGetProductById(): void
    {
        $expectedResponseData = [
            'id' => 123,
            'name' => 'ProductAA',
            'code' => 'A001',
            'price_net' => 100,
            'tax' => 23,
        ];

        $mockResponse = new JsonMockResponse($expectedResponseData, ['http_code' => 200]);
        $fakturownia = $this->getFakturowniaStub($mockResponse);

        $response = (new Products($fakturownia))->get(123);

        $this->assertSame('GET', $mockResponse->getRequestMethod());
        $this->assertSame('https://foo.fakturownia.pl/products/123.json?api_token=bar', $mockResponse->getRequestUrl());
        $this->assertSame($expectedResponseData, $response->getContent());
        $this->assertSame(200, $response->getStatusCode());
    }

    public function testGetProductWithStocks(): void
    {
        $expectedResponseData = [
            'id' => 123,
            'name' => 'ProductAA',
            'code' => 'A001',
            'price_net' => 100,
            'tax' => 23,
        ];

        $mockResponse = new JsonMockResponse($expectedResponseData, ['http_code' => 200]);
        $fakturownia = $this->getFakturowniaStub($mockResponse);

        $response = (new Products($fakturownia))->get(123, 555);

        $this->assertSame('GET', $mockResponse->getRequestMethod());
        $this->assertSame('https://foo.fakturownia.pl/products/123.json?api_token=bar&warehouse_id=555', $mockResponse->getRequestUrl());
        $this->assertSame($expectedResponseData, $response->getContent());
        $this->assertSame(200, $response->getStatusCode());
    }

    public function testGetAllProducts(): void
    {
        $expectedResponseData = [
            [
                'id' => 123,
                'name' => 'ProductAA',
                'code' => 'A001',
                'price_net' => 100,
                'tax' => 23,
            ],
        ];

        $mockResponse = new JsonMockResponse($expectedResponseData, ['http_code' => 200]);
        $fakturownia = $this->getFakturowniaStub($mockResponse);

        $response = (new Products($fakturownia))->getAll();

        $this->assertSame('GET', $mockResponse->getRequestMethod());
        $this->assertSame('https://foo.fakturownia.pl/products.json?api_token=bar', $mockResponse->getRequestUrl());
        $this->assertSame($expectedResponseData, $response->getContent());
        $this->assertSame(200, $response->getStatusCode());
    }

    public function testCreateProduct(): void
    {
        $productData = [
            'name' => 'ProductAA',
            'code' => 'A001',
            'price_net' => 100,
            'tax' => 23,
        ];

        $expectedRequestData = json_encode([
            'product' => $productData,
            'api_token' => 'bar',
        ], JSON_THROW_ON_ERROR);

        $expectedResponseData = [
            'code' => 'success',
        ];

        $mockResponse = new JsonMockResponse($expectedResponseData, ['http_code' => 201]);
        $fakturownia = $this->getFakturowniaStub($mockResponse);

        $response = (new Products($fakturownia))->create($productData);

        $this->assertSame('POST', $mockResponse->getRequestMethod());
        $this->assertSame('https://foo.fakturownia.pl/products.json', $mockResponse->getRequestUrl());
        $this->assertSame($expectedRequestData, $mockResponse->getRequestOptions()['body']);
        $this->assertSame($expectedResponseData, $response->getContent());
        $this->assertSame(201, $response->getStatusCode());
    }

    public function testUpdateProduct(): void
    {
        $productData = [
            'name' => 'ProductAA',
            'code' => 'A001',
            'price_net' => 100,
            'tax' => 23,
        ];

        $expectedRequestData = json_encode([
            'product' => $productData,
            'api_token' => 'bar',
        ], JSON_THROW_ON_ERROR);

        $expectedResponseData = [
            'code' => 'success',
        ];

        $mockResponse = new JsonMockResponse($expectedResponseData, ['http_code' => 200]);
        $fakturownia = $this->getFakturowniaStub($mockResponse);

        $response = (new Products($fakturownia))->update(123, $productData);

        $this->assertSame('PUT', $mockResponse->getRequestMethod());
        $this->assertSame('https://foo.fakturownia.pl/products/123.json', $mockResponse->getRequestUrl());
        $this->assertSame($expectedRequestData, $mockResponse->getRequestOptions()['body']);
        $this->assertSame($expectedResponseData, $response->getContent());
        $this->assertSame(200, $response->getStatusCode());
    }
}
