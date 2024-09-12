<?php

declare(strict_types=1);

namespace Abb\Fakturownia\Tests\Unit\Api;

use Abb\Fakturownia\Api\PriceLists;
use Abb\Fakturownia\Tests\Unit\AbstractTestCase;
use Symfony\Component\HttpClient\Response\JsonMockResponse;

final class PriceListsTest extends AbstractTestCase
{
    public function testGetAllPriceLists(): void
    {
        $expectedResponseData = [
            'id' => 123,
            'name' => 'Nazwa cennika',
            'description' => 'Opis',
            'currency' => 'PLN',
            'price_list_positions_attributes' => [
                [
                    'priceable_id' => 'ID produktu',
                    'priceable_name' => 'Nazwa produktu',
                    'priceable_type' => 'Product',
                    'use_percentage' => '0',
                    'percentage' => '',
                    'price_net' => '111.0',
                    'price_gross' => '136.53',
                    'use_tax' => '1',
                    'tax' => '23',
                ],
            ],
        ];

        $mockResponse = new JsonMockResponse($expectedResponseData, ['http_code' => 200]);
        $fakturownia = $this->getFakturowniaStub($mockResponse);

        $response = (new PriceLists($fakturownia))->getAll();

        $this->assertSame('GET', $mockResponse->getRequestMethod());
        $this->assertSame('https://foo.fakturownia.pl/price_lists.json?api_token=bar', $mockResponse->getRequestUrl());
        $this->assertSame($expectedResponseData, $response->getContent());
        $this->assertSame(200, $response->getStatusCode());
    }

    public function testCreatePriceList(): void
    {
        $priceListData = [
            'name' => 'Nazwa cennika',
            'description' => 'Opis',
            'currency' => 'PLN',
            'price_list_positions_attributes' => [
                [
                    'priceable_id' => 'ID produktu',
                    'priceable_name' => 'Nazwa produktu',
                    'priceable_type' => 'Product',
                    'use_percentage' => '0',
                    'percentage' => '',
                    'price_net' => '111.0',
                    'price_gross' => '136.53',
                    'use_tax' => '1',
                    'tax' => '23',
                ],
            ],
        ];

        $expectedRequestData = json_encode([
            'price_list' => $priceListData,
            'api_token' => 'bar',
        ], JSON_THROW_ON_ERROR);

        $expectedResponseData = [
            'code' => 'success',
        ];

        $mockResponse = new JsonMockResponse($expectedResponseData, ['http_code' => 201]);
        $fakturownia = $this->getFakturowniaStub($mockResponse);

        $response = (new PriceLists($fakturownia))->create($priceListData);

        $this->assertSame('POST', $mockResponse->getRequestMethod());
        $this->assertSame('https://foo.fakturownia.pl/price_lists.json', $mockResponse->getRequestUrl());
        $this->assertSame($expectedRequestData, $mockResponse->getRequestOptions()['body']);
        $this->assertSame($expectedResponseData, $response->getContent());
        $this->assertSame(201, $response->getStatusCode());
    }

    public function testUpdatePayment(): void
    {
        $priceListData = [
            'name' => 'Nazwa cennika',
            'description' => 'Opis',
            'currency' => 'PLN',
            'price_list_positions_attributes' => [
                [
                    'id' => 100,
                    'priceable_id' => 'ID produktu',
                    'price_net' => '10.0',
                    'price_gross' => '10.80',
                    'use_tax' => '1',
                    'tax' => '8',
                ],
            ],
        ];

        $expectedRequestData = json_encode([
            'price_list' => $priceListData,
            'api_token' => 'bar',
        ], JSON_THROW_ON_ERROR);

        $expectedResponseData = [
            'code' => 'success',
        ];

        $mockResponse = new JsonMockResponse($expectedResponseData, ['http_code' => 200]);
        $fakturownia = $this->getFakturowniaStub($mockResponse);

        $response = (new PriceLists($fakturownia))->update(123, $priceListData);

        $this->assertSame('PUT', $mockResponse->getRequestMethod());
        $this->assertSame('https://foo.fakturownia.pl/price_lists/123.json', $mockResponse->getRequestUrl());
        $this->assertSame($expectedRequestData, $mockResponse->getRequestOptions()['body']);
        $this->assertSame($expectedResponseData, $response->getContent());
        $this->assertSame(200, $response->getStatusCode());
    }

    public function testDeletePayment(): void
    {
        $expectedResponseData = [
            'code' => 'success',
        ];

        $mockResponse = new JsonMockResponse($expectedResponseData, ['http_code' => 200]);
        $fakturownia = $this->getFakturowniaStub($mockResponse);

        $response = (new PriceLists($fakturownia))->delete(123);

        $this->assertSame('DELETE', $mockResponse->getRequestMethod());
        $this->assertSame('https://foo.fakturownia.pl/price_lists/123.json?api_token=bar', $mockResponse->getRequestUrl());
        $this->assertSame($expectedResponseData, $response->getContent());
        $this->assertSame(200, $response->getStatusCode());
    }
}
