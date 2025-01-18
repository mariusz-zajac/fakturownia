<?php

declare(strict_types=1);

namespace Abb\Fakturownia\Tests\Unit\Api;

use Abb\Fakturownia\Api\Clients;
use Abb\Fakturownia\Tests\Unit\AbstractTestCase;

final class ClientsTest extends AbstractTestCase
{
    public function testGetClientById(): void
    {
        $expectedResponseData = [
            'id' => 123,
            'email' => 'foo@test.pl',
            'name' => 'Client name',
            'tax_no' => '6272616681',
            'city' => 'City',
        ];

        $mockResponse = $this->createJsonMockResponse($expectedResponseData, ['http_code' => 200]);
        $fakturownia = $this->getFakturowniaStub($mockResponse);

        $response = (new Clients($fakturownia))->getOne(123);

        $this->assertSame('GET', $mockResponse->getRequestMethod());
        $this->assertSame('https://foo.fakturownia.pl/clients/123.json?api_token=bar', $mockResponse->getRequestUrl());
        $this->assertSame($expectedResponseData, $response);
    }

    public function testGetClientByExternalId(): void
    {
        $expectedResponseData = [
            'id' => 123,
            'email' => 'foo@test.pl',
            'name' => 'Client name',
            'tax_no' => '6272616681',
            'city' => 'City',
        ];

        $mockResponse = $this->createJsonMockResponse($expectedResponseData, ['http_code' => 200]);
        $fakturownia = $this->getFakturowniaStub($mockResponse);

        $response = (new Clients($fakturownia))->getAllByExternalId('123');

        $this->assertSame('GET', $mockResponse->getRequestMethod());
        $this->assertSame('https://foo.fakturownia.pl/clients.json?external_id=123&api_token=bar', $mockResponse->getRequestUrl());
        $this->assertSame($expectedResponseData, $response);
    }

    public function testGetAllClients(): void
    {
        $requestParams = [
            'email' => 'foo@test.pl',
        ];

        $expectedResponseData = [
            [
                'id' => 123,
                'name' => 'Client name',
                'tax_no' => '6272616681',
                'city' => 'City',
            ],
        ];

        $mockResponse = $this->createJsonMockResponse($expectedResponseData, ['http_code' => 200]);
        $fakturownia = $this->getFakturowniaStub($mockResponse);

        $response = (new Clients($fakturownia))->getAll($requestParams);

        $this->assertSame('GET', $mockResponse->getRequestMethod());
        $this->assertSame('https://foo.fakturownia.pl/clients.json?email=foo%40test.pl&api_token=bar', $mockResponse->getRequestUrl());
        $this->assertSame($expectedResponseData, $response);
    }

    public function testCreateClient(): void
    {
        $clientData = [
            'name' => 'Klient1',
            'tax_no' => '6272616681',
            'bank' => 'bank1',
            'bank_account' => 'bank_account1',
            'city' => 'city1',
            'country' => '',
            'email' => 'email@gmail.com',
            'person' => 'person1',
            'post_code' => 'post-code1',
            'phone' => 'phone1',
            'street' => 'street1',
        ];

        $expectedRequestData = json_encode([
            'client' => $clientData,
            'api_token' => 'bar',
        ], JSON_THROW_ON_ERROR);

        $expectedResponseData = [
            'code' => 'success',
        ];

        $mockResponse = $this->createJsonMockResponse($expectedResponseData, ['http_code' => 201]);
        $fakturownia = $this->getFakturowniaStub($mockResponse);

        $response = (new Clients($fakturownia))->create($clientData);

        $this->assertSame('POST', $mockResponse->getRequestMethod());
        $this->assertSame('https://foo.fakturownia.pl/clients.json', $mockResponse->getRequestUrl());
        $this->assertSame($expectedRequestData, $mockResponse->getRequestOptions()['body']);
        $this->assertSame($expectedResponseData, $response);
    }

    public function testUpdateClient(): void
    {
        $clientData = [
            'name' => 'Klient1',
            'tax_no' => '6272616681',
            'bank' => 'bank1',
            'bank_account' => 'bank_account1',
            'city' => 'city1',
            'country' => '',
            'email' => 'email@gmail.com',
            'person' => 'person1',
            'post_code' => 'post-code1',
            'phone' => 'phone1',
            'street' => 'street1',
        ];

        $expectedRequestData = json_encode([
            'client' => $clientData,
            'api_token' => 'bar',
        ], JSON_THROW_ON_ERROR);

        $expectedResponseData = [
            'code' => 'success',
        ];

        $mockResponse = $this->createJsonMockResponse($expectedResponseData, ['http_code' => 200]);
        $fakturownia = $this->getFakturowniaStub($mockResponse);

        $response = (new Clients($fakturownia))->update(123, $clientData);

        $this->assertSame('PUT', $mockResponse->getRequestMethod());
        $this->assertSame('https://foo.fakturownia.pl/clients/123.json', $mockResponse->getRequestUrl());
        $this->assertSame($expectedRequestData, $mockResponse->getRequestOptions()['body']);
        $this->assertSame($expectedResponseData, $response);
    }

    public function testDeleteClient(): void
    {
        $expectedResponseData = [
            'code' => 'success',
        ];

        $mockResponse = $this->createJsonMockResponse($expectedResponseData, ['http_code' => 200]);
        $fakturownia = $this->getFakturowniaStub($mockResponse);

        $response = (new Clients($fakturownia))->delete(123);

        $this->assertSame('DELETE', $mockResponse->getRequestMethod());
        $this->assertSame('https://foo.fakturownia.pl/clients/123.json?api_token=bar', $mockResponse->getRequestUrl());
        $this->assertSame($expectedResponseData, $response);
    }
}
