<?php

declare(strict_types=1);

namespace Abb\Fakturownia\Tests\Unit\Api;

use Abb\Fakturownia\Api\Categories;
use Abb\Fakturownia\Tests\Unit\AbstractTestCase;
use Symfony\Component\HttpClient\Response\JsonMockResponse;

final class CategoriesTest extends AbstractTestCase
{
    public function testGetCategoryById(): void
    {
        $expectedResponseData = [
            'id' => 123,
            'name' => 'Category 1',
            'description' => null,
        ];

        $mockResponse = new JsonMockResponse($expectedResponseData, ['http_code' => 200]);
        $fakturownia = $this->getFakturowniaStub($mockResponse);

        $response = (new Categories($fakturownia))->getOne(123);

        $this->assertSame('GET', $mockResponse->getRequestMethod());
        $this->assertSame('https://foo.fakturownia.pl/categories/123.json?api_token=bar', $mockResponse->getRequestUrl());
        $this->assertSame($expectedResponseData, $response->getContent());
        $this->assertSame(200, $response->getStatusCode());
    }

    public function testGetAllCategories(): void
    {
        $expectedResponseData = [
            [
                'id' => 123,
                'name' => 'Category 1',
                'description' => null,
            ],
            [
                'id' => 124,
                'name' => 'Category 2',
                'description' => null,
            ],
        ];

        $mockResponse = new JsonMockResponse($expectedResponseData, ['http_code' => 200]);
        $fakturownia = $this->getFakturowniaStub($mockResponse);

        $response = (new Categories($fakturownia))->getAll();

        $this->assertSame('GET', $mockResponse->getRequestMethod());
        $this->assertSame('https://foo.fakturownia.pl/categories.json?api_token=bar', $mockResponse->getRequestUrl());
        $this->assertSame($expectedResponseData, $response->getContent());
        $this->assertSame(200, $response->getStatusCode());
    }

    public function testCreateCategory(): void
    {
        $categoryData = [
            'name' => 'Category 1',
            'description' => null,
        ];

        $expectedRequestData = json_encode([
            'category' => $categoryData,
            'api_token' => 'bar',
        ], JSON_THROW_ON_ERROR);

        $expectedResponseData = [
            'code' => 'success',
        ];

        $mockResponse = new JsonMockResponse($expectedResponseData, ['http_code' => 201]);
        $fakturownia = $this->getFakturowniaStub($mockResponse);

        $response = (new Categories($fakturownia))->create($categoryData);

        $this->assertSame('POST', $mockResponse->getRequestMethod());
        $this->assertSame('https://foo.fakturownia.pl/categories.json', $mockResponse->getRequestUrl());
        $this->assertSame($expectedRequestData, $mockResponse->getRequestOptions()['body']);
        $this->assertSame($expectedResponseData, $response->getContent());
        $this->assertSame(201, $response->getStatusCode());
    }

    public function testUpdateCategory(): void
    {
        $categoryData = [
            'name' => 'New category name',
            'description' => 'New category description',
        ];

        $expectedRequestData = json_encode([
            'category' => $categoryData,
            'api_token' => 'bar',
        ], JSON_THROW_ON_ERROR);

        $expectedResponseData = [
            'code' => 'success',
        ];

        $mockResponse = new JsonMockResponse($expectedResponseData, ['http_code' => 200]);
        $fakturownia = $this->getFakturowniaStub($mockResponse);

        $response = (new Categories($fakturownia))->update(123, $categoryData);

        $this->assertSame('PUT', $mockResponse->getRequestMethod());
        $this->assertSame('https://foo.fakturownia.pl/categories/123.json', $mockResponse->getRequestUrl());
        $this->assertSame($expectedRequestData, $mockResponse->getRequestOptions()['body']);
        $this->assertSame($expectedResponseData, $response->getContent());
        $this->assertSame(200, $response->getStatusCode());
    }

    public function testDeleteCategory(): void
    {
        $expectedResponseData = [
            'code' => 'success',
        ];

        $mockResponse = new JsonMockResponse($expectedResponseData, ['http_code' => 200]);
        $fakturownia = $this->getFakturowniaStub($mockResponse);

        $response = (new Categories($fakturownia))->delete(123);

        $this->assertSame('DELETE', $mockResponse->getRequestMethod());
        $this->assertSame('https://foo.fakturownia.pl/categories/123.json?api_token=bar', $mockResponse->getRequestUrl());
        $this->assertSame($expectedResponseData, $response->getContent());
        $this->assertSame(200, $response->getStatusCode());
    }
}
