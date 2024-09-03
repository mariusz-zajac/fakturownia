<?php

declare(strict_types=1);

namespace Abb\Fakturownia\Tests\Unit\Api;

use Abb\Fakturownia\Api\Departments;
use Abb\Fakturownia\Tests\Unit\AbstractTestCase;
use Symfony\Component\HttpClient\Response\JsonMockResponse;

final class DepartmentsTest extends AbstractTestCase
{
    public function testGetDepartmentById(): void
    {
        $expectedResponseData = [
            'id' => 123,
            'name' => 'Department 1',
            'shortcut' => 'Dep 1',
            'tax_no' => '-',
        ];

        $mockResponse = new JsonMockResponse($expectedResponseData, ['http_code' => 200]);
        $client = $this->getApiClient($mockResponse);

        $response = (new Departments($client))->get(123);

        $this->assertSame('GET', $mockResponse->getRequestMethod());
        $this->assertSame('https://foo.fakturownia.pl/departments/123.json?api_token=bar', $mockResponse->getRequestUrl());
        $this->assertSame($expectedResponseData, $response->getContent());
        $this->assertSame(200, $response->getStatusCode());
    }

    public function testGetAllDepartments(): void
    {
        $expectedResponseData = [
            [
                'id' => 123,
                'name' => 'Department 1',
                'shortcut' => 'Dep 1',
                'tax_no' => '-',
            ],
        ];

        $mockResponse = new JsonMockResponse($expectedResponseData, ['http_code' => 200]);
        $client = $this->getApiClient($mockResponse);

        $response = (new Departments($client))->getAll();

        $this->assertSame('GET', $mockResponse->getRequestMethod());
        $this->assertSame('https://foo.fakturownia.pl/departments.json?api_token=bar', $mockResponse->getRequestUrl());
        $this->assertSame($expectedResponseData, $response->getContent());
        $this->assertSame(200, $response->getStatusCode());
    }

    public function testCreateDepartment(): void
    {
        $departmentData = [
            'name' => 'Department 1',
            'shortcut' => 'Dep 1',
            'tax_no' => '-',
        ];

        $expectedRequestData = json_encode([
            'department' => $departmentData,
            'api_token' => 'bar',
        ], JSON_THROW_ON_ERROR);

        $expectedResponseData = [
            'code' => 'success',
        ];

        $mockResponse = new JsonMockResponse($expectedResponseData, ['http_code' => 201]);
        $client = $this->getApiClient($mockResponse);

        $response = (new Departments($client))->create($departmentData);

        $this->assertSame('POST', $mockResponse->getRequestMethod());
        $this->assertSame('https://foo.fakturownia.pl/departments.json', $mockResponse->getRequestUrl());
        $this->assertSame($expectedRequestData, $mockResponse->getRequestOptions()['body']);
        $this->assertSame($expectedResponseData, $response->getContent());
        $this->assertSame(201, $response->getStatusCode());
    }

    public function testUpdateDepartment(): void
    {
        $departmentData = [
            'name' => 'Department 1',
            'shortcut' => 'Dep 1',
            'tax_no' => 'xxx-xxx-xx-xx',
        ];

        $expectedRequestData = json_encode([
            'department' => $departmentData,
            'api_token' => 'bar',
        ], JSON_THROW_ON_ERROR);

        $expectedResponseData = [
            'code' => 'success',
        ];

        $mockResponse = new JsonMockResponse($expectedResponseData, ['http_code' => 200]);
        $client = $this->getApiClient($mockResponse);

        $response = (new Departments($client))->update(123, $departmentData);

        $this->assertSame('PUT', $mockResponse->getRequestMethod());
        $this->assertSame('https://foo.fakturownia.pl/departments/123.json', $mockResponse->getRequestUrl());
        $this->assertSame($expectedRequestData, $mockResponse->getRequestOptions()['body']);
        $this->assertSame($expectedResponseData, $response->getContent());
        $this->assertSame(200, $response->getStatusCode());
    }

    public function testDeleteDepartment(): void
    {
        $expectedResponseData = [
            'code' => 'success',
        ];

        $mockResponse = new JsonMockResponse($expectedResponseData, ['http_code' => 200]);
        $client = $this->getApiClient($mockResponse);

        $response = (new Departments($client))->delete(123);

        $this->assertSame('DELETE', $mockResponse->getRequestMethod());
        $this->assertSame('https://foo.fakturownia.pl/departments/123.json?api_token=bar', $mockResponse->getRequestUrl());
        $this->assertSame($expectedResponseData, $response->getContent());
        $this->assertSame(200, $response->getStatusCode());
    }
}
