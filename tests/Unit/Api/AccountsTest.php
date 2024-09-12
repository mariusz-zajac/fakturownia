<?php

declare(strict_types=1);

namespace Abb\Fakturownia\Tests\Unit\Api;

use Abb\Fakturownia\Api\Accounts;
use Abb\Fakturownia\Tests\Unit\AbstractTestCase;
use Symfony\Component\HttpClient\Response\JsonMockResponse;

final class AccountsTest extends AbstractTestCase
{
    public function testGetAccount(): void
    {
        $requestParams = [
            'integration_token' => 'baz',
        ];

        $expectedResponseData = [
            'prefix' => 'foo',
            'api_token' => 'bar',
            'url' => 'https://foo.fakturownia.pl',
            'login' => 'login1',
            'email' => 'email1@email.pl',
        ];

        $mockResponse = new JsonMockResponse($expectedResponseData, ['http_code' => 200]);
        $fakturownia = $this->getFakturowniaStub($mockResponse);

        $response = (new Accounts($fakturownia))->get($requestParams);

        $this->assertSame('GET', $mockResponse->getRequestMethod());
        $this->assertSame('https://foo.fakturownia.pl/account.json?integration_token=baz&api_token=bar', $mockResponse->getRequestUrl());
        $this->assertSame($expectedResponseData, $response->getContent());
        $this->assertSame(200, $response->getStatusCode());
    }

    public function testCreateAccountForClient(): void
    {
        $accountData = [
            'prefix' => 'foo',
            'lang' => 'pl',
        ];

        $userData = [
            'prefix' => 'foo',
            'api_token' => 'bar',
            'url' => 'https://foo.fakturownia.pl',
            'login' => 'login1',
            'email' => 'email1@email.pl',
        ];

        $companyData = [
            'name' => 'Company1',
            'tax_no' => '5252445700',
            'post_code' => '00-112',
            'city' => 'Warsaw',
            'street' => 'Street 1/10',
            'person' => 'Jan Nowak',
            'bank' => 'Bank1',
            'bank_account' => '111222333444555666111',
        ];

        $integrationToken = 'baz';

        $expectedRequestData = json_encode([
            'account' => $accountData,
            'api_token' => 'bar',
            'user' => $userData,
            'company' => $companyData,
            'integration_token' => $integrationToken,
        ], JSON_THROW_ON_ERROR);

        $expectedResponseData = [
            'prefix' => 'foo',
            'api_token' => 'bar',
            'url' => 'https://foo.fakturownia.pl',
            'login' => 'login1',
            'email' => 'email1@email.pl',
        ];

        $mockResponse = new JsonMockResponse($expectedResponseData, ['http_code' => 201]);
        $fakturownia = $this->getFakturowniaStub($mockResponse);

        $response = (new Accounts($fakturownia))->createForClient($accountData, $userData, $companyData, $integrationToken);

        $this->assertSame('POST', $mockResponse->getRequestMethod());
        $this->assertSame('https://foo.fakturownia.pl/account.json', $mockResponse->getRequestUrl());
        $this->assertSame($expectedRequestData, $mockResponse->getRequestOptions()['body']);
        $this->assertSame($expectedResponseData, $response->getContent());
        $this->assertSame(201, $response->getStatusCode());
    }

    public function testDeleteAccount(): void
    {
        $expectedRequestData = json_encode([
            'api_token' => 'bar',
        ], JSON_THROW_ON_ERROR);

        $expectedResponseData = [
            'code' => 'success',
            'message' => 'Link do usunięcia konta wysłany!',
        ];

        $mockResponse = new JsonMockResponse($expectedResponseData, ['http_code' => 200]);
        $fakturownia = $this->getFakturowniaStub($mockResponse);

        $response = (new Accounts($fakturownia))->delete();

        $this->assertSame('POST', $mockResponse->getRequestMethod());
        $this->assertSame('https://foo.fakturownia.pl/account/delete.json', $mockResponse->getRequestUrl());
        $this->assertSame($expectedRequestData, $mockResponse->getRequestOptions()['body']);
        $this->assertSame($expectedResponseData, $response->getContent());
        $this->assertSame(200, $response->getStatusCode());
    }

    public function testUnlinkAccount(): void
    {
        $subdomains = [
            'SUB_DOMAIN_1',
            'SUB_DOMAIN_2',
            'SUB_DOMAIN_3',
        ];

        $expectedRequestData = json_encode([
            'api_token' => 'bar',
            'prefix' => $subdomains,
        ], JSON_THROW_ON_ERROR);

        $expectedResponseData = [
            'code' => 'success',
            'message' => 'Konta odłączone',
            'result' => [
                'unlinked' => [
                    'SUB_DOMAIN_1',
                    'SUB_DOMAIN_2',
                ],
                'not_unlinked' => [
                    'SUB_DOMAIN_3',
                ],
            ],
        ];

        $mockResponse = new JsonMockResponse($expectedResponseData, ['http_code' => 200]);
        $fakturownia = $this->getFakturowniaStub($mockResponse);

        $response = (new Accounts($fakturownia))->unlink($subdomains);

        $this->assertSame('PATCH', $mockResponse->getRequestMethod());
        $this->assertSame('https://foo.fakturownia.pl/account/unlink.json', $mockResponse->getRequestUrl());
        $this->assertSame($expectedRequestData, $mockResponse->getRequestOptions()['body']);
        $this->assertSame($expectedResponseData, $response->getContent());
        $this->assertSame(200, $response->getStatusCode());
    }

    public function testAddUser(): void
    {
        $userData = [
            'invite' => true,
            'email' => 'email@test.pl',
            'password' => 'Password123',
            'role' => 'member',
            'department_ids' => [],
        ];

        $integrationToken = 'baz';

        $expectedRequestData = json_encode([
            'api_token' => 'bar',
            'integration_token' => $integrationToken,
            'user' => $userData,
        ], JSON_THROW_ON_ERROR);

        $expectedResponseData = [
            'code' => 'success',
        ];

        $mockResponse = new JsonMockResponse($expectedResponseData, ['http_code' => 200]);
        $fakturownia = $this->getFakturowniaStub($mockResponse);

        $response = (new Accounts($fakturownia))->addUser($userData, $integrationToken);

        $this->assertSame('POST', $mockResponse->getRequestMethod());
        $this->assertSame('https://foo.fakturownia.pl/account/add_user.json', $mockResponse->getRequestUrl());
        $this->assertSame($expectedRequestData, $mockResponse->getRequestOptions()['body']);
        $this->assertSame($expectedResponseData, $response->getContent());
        $this->assertSame(200, $response->getStatusCode());
    }
}
