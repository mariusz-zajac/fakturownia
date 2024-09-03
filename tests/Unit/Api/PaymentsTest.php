<?php

declare(strict_types=1);

namespace Abb\Fakturownia\Tests\Unit\Api;

use Abb\Fakturownia\Api\Payments;
use Abb\Fakturownia\Tests\Unit\AbstractTestCase;
use Symfony\Component\HttpClient\Response\JsonMockResponse;

final class PaymentsTest extends AbstractTestCase
{
    public function testGetPaymentById(): void
    {
        $expectedResponseData = [
            'id' => 123,
            'name' => 'Payment 001',
            'price' => 100.05,
            'invoice_id' => null,
            'paid' => true,
            'kind' => 'api',
        ];

        $mockResponse = new JsonMockResponse($expectedResponseData, ['http_code' => 200]);
        $client = $this->getApiClient($mockResponse);

        $response = (new Payments($client))->get(123);

        $this->assertSame('GET', $mockResponse->getRequestMethod());
        $this->assertSame('https://foo.fakturownia.pl/banking/payments/123.json?api_token=bar', $mockResponse->getRequestUrl());
        $this->assertSame($expectedResponseData, $response->getContent());
        $this->assertSame(200, $response->getStatusCode());
    }

    public function testGetAllPayments(): void
    {
        $expectedResponseData = [
            [
                'id' => 123,
                'name' => 'Payment 001',
                'price' => 100.05,
                'invoice_id' => null,
                'paid' => true,
                'kind' => 'api',
            ],
        ];

        $mockResponse = new JsonMockResponse($expectedResponseData, ['http_code' => 200]);
        $client = $this->getApiClient($mockResponse);

        $response = (new Payments($client))->getAll();

        $this->assertSame('GET', $mockResponse->getRequestMethod());
        $this->assertSame('https://foo.fakturownia.pl/banking/payments.json?api_token=bar', $mockResponse->getRequestUrl());
        $this->assertSame($expectedResponseData, $response->getContent());
        $this->assertSame(200, $response->getStatusCode());
    }

    public function testCreatePayment(): void
    {
        $paymentData = [
            'name' => 'Payment 001',
            'price' => 100.05,
            'invoice_id' => [123, 124],
            'paid' => true,
            'kind' => 'api',
        ];

        $expectedRequestData = json_encode([
            'banking_payment' => $paymentData,
            'api_token' => 'bar',
        ], JSON_THROW_ON_ERROR);

        $expectedResponseData = [
            'code' => 'success',
        ];

        $mockResponse = new JsonMockResponse($expectedResponseData, ['http_code' => 201]);
        $client = $this->getApiClient($mockResponse);

        $response = (new Payments($client))->create($paymentData);

        $this->assertSame('POST', $mockResponse->getRequestMethod());
        $this->assertSame('https://foo.fakturownia.pl/banking/payments.json', $mockResponse->getRequestUrl());
        $this->assertSame($expectedRequestData, $mockResponse->getRequestOptions()['body']);
        $this->assertSame($expectedResponseData, $response->getContent());
        $this->assertSame(201, $response->getStatusCode());
    }

    public function testUpdatePayment(): void
    {
        $paymentData = [
            'name' => 'Payment 001',
            'price' => 100.05,
            'invoice_id' => [123, 124],
            'paid' => true,
            'kind' => 'api',
        ];

        $expectedRequestData = json_encode([
            'banking_payment' => $paymentData,
            'api_token' => 'bar',
        ], JSON_THROW_ON_ERROR);

        $expectedResponseData = [
            'code' => 'success',
        ];

        $mockResponse = new JsonMockResponse($expectedResponseData, ['http_code' => 200]);
        $client = $this->getApiClient($mockResponse);

        $response = (new Payments($client))->update(123, $paymentData);

        $this->assertSame('PUT', $mockResponse->getRequestMethod());
        $this->assertSame('https://foo.fakturownia.pl/banking/payments/123.json', $mockResponse->getRequestUrl());
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
        $client = $this->getApiClient($mockResponse);

        $response = (new Payments($client))->delete(123);

        $this->assertSame('DELETE', $mockResponse->getRequestMethod());
        $this->assertSame('https://foo.fakturownia.pl/banking/payments/123.json?api_token=bar', $mockResponse->getRequestUrl());
        $this->assertSame($expectedResponseData, $response->getContent());
        $this->assertSame(200, $response->getStatusCode());
    }
}
