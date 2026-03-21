<?php

declare(strict_types=1);

namespace Abb\Fakturownia\Tests\Unit\Api;

use Abb\Fakturownia\Api\Issuers;
use Abb\Fakturownia\Tests\Unit\AbstractTestCase;

final class IssuersTest extends AbstractTestCase
{
    public function testGetIssuerById(): void
    {
        $expectedResponseData = [
            'id' => 123,
            'name' => 'Issuer 1',
            'tax_no' => '4170106662',
        ];

        $mockResponse = $this->createJsonMockResponse($expectedResponseData, ['http_code' => 200]);
        $fakturownia = $this->getFakturowniaStub($mockResponse);

        $response = (new Issuers($fakturownia))->getOne(123);

        $this->assertSame('GET', $mockResponse->getRequestMethod());
        $this->assertSame('https://foo.fakturownia.pl/issuers/123.json?api_token=bar', $mockResponse->getRequestUrl());
        $this->assertSame($expectedResponseData, $response);
    }

    public function testGetAllIssuers(): void
    {
        $expectedResponseData = [
            [
                'id' => 123,
                'name' => 'Issuer 1',
                'tax_no' => '4170106662',
            ],
        ];

        $mockResponse = $this->createJsonMockResponse($expectedResponseData, ['http_code' => 200]);
        $fakturownia = $this->getFakturowniaStub($mockResponse);

        $response = (new Issuers($fakturownia))->getAll();

        $this->assertSame('GET', $mockResponse->getRequestMethod());
        $this->assertSame('https://foo.fakturownia.pl/issuers.json?api_token=bar', $mockResponse->getRequestUrl());
        $this->assertSame($expectedResponseData, $response);
    }

    public function testCreateIssuer(): void
    {
        $issuerData = [
            'name' => 'Issuer 1',
            'tax_no' => '4170106662',
        ];

        $expectedRequestData = json_encode([
            'issuer' => $issuerData,
            'api_token' => 'bar',
        ], JSON_THROW_ON_ERROR);

        $expectedResponseData = [
            'code' => 'success',
        ];

        $mockResponse = $this->createJsonMockResponse($expectedResponseData, ['http_code' => 201]);
        $fakturownia = $this->getFakturowniaStub($mockResponse);

        $response = (new Issuers($fakturownia))->create($issuerData);

        $this->assertSame('POST', $mockResponse->getRequestMethod());
        $this->assertSame('https://foo.fakturownia.pl/issuers.json', $mockResponse->getRequestUrl());
        $this->assertSame($expectedRequestData, $mockResponse->getRequestOptions()['body']);
        $this->assertSame($expectedResponseData, $response);
    }

    public function testUpdateIssuer(): void
    {
        $issuerData = [
            'name' => 'Issuer 2',
        ];

        $expectedRequestData = json_encode([
            'issuer' => $issuerData,
            'api_token' => 'bar',
        ], JSON_THROW_ON_ERROR);

        $expectedResponseData = [
            'code' => 'success',
        ];

        $mockResponse = $this->createJsonMockResponse($expectedResponseData, ['http_code' => 200]);
        $fakturownia = $this->getFakturowniaStub($mockResponse);

        $response = (new Issuers($fakturownia))->update(123, $issuerData);

        $this->assertSame('PUT', $mockResponse->getRequestMethod());
        $this->assertSame('https://foo.fakturownia.pl/issuers/123.json', $mockResponse->getRequestUrl());
        $this->assertSame($expectedRequestData, $mockResponse->getRequestOptions()['body']);
        $this->assertSame($expectedResponseData, $response);
    }

    public function testDeleteIssuer(): void
    {
        $expectedResponseData = [
            'code' => 'success',
        ];

        $mockResponse = $this->createJsonMockResponse($expectedResponseData, ['http_code' => 200]);
        $fakturownia = $this->getFakturowniaStub($mockResponse);

        $response = (new Issuers($fakturownia))->delete(123);

        $this->assertSame('DELETE', $mockResponse->getRequestMethod());
        $this->assertSame('https://foo.fakturownia.pl/issuers/123.json?api_token=bar', $mockResponse->getRequestUrl());
        $this->assertSame($expectedResponseData, $response);
    }
}
