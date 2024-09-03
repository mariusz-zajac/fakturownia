<?php

declare(strict_types=1);

namespace Abb\Fakturownia\Tests\Unit\Api;

use Abb\Fakturownia\Api\Invoices;
use Abb\Fakturownia\Exception\ApiException;
use Abb\Fakturownia\Tests\Unit\AbstractTestCase;
use Symfony\Component\HttpClient\Response\JsonMockResponse;
use Symfony\Component\HttpClient\Response\MockResponse;

final class InvoicesTest extends AbstractTestCase
{
    public function testGetInvoiceById(): void
    {
        $expectedResponseData = [
            'id' => 123,
            'kind' => 'vat',
            'number' => '01/2024',
            'positions' => [
                [
                    'name' => 'Product 1',
                    'tax' => 23,
                    'quantity' => 1,
                    'total_proce_gross' => 10.23,
                ],
            ],
        ];

        $mockResponse = new JsonMockResponse($expectedResponseData, ['http_code' => 200]);
        $client = $this->getApiClient($mockResponse);

        $response = (new Invoices($client))->get(123);

        $this->assertSame('GET', $mockResponse->getRequestMethod());
        $this->assertSame('https://foo.fakturownia.pl/invoices/123.json?api_token=bar', $mockResponse->getRequestUrl());
        $this->assertSame($expectedResponseData, $response->getContent());
        $this->assertSame(200, $response->getStatusCode());
    }

    public function testGetAllInvoicesByParams(): void
    {
        $expectedResponseData = [
            [
                'id' => 123,
                'kind' => 'vat',
                'number' => '01/2024',
                'positions' => [
                    [
                        'name' => 'Product 1',
                        'tax' => 23,
                        'quantity' => 1,
                        'total_proce_gross' => 10.23,
                    ],
                ],
            ],
        ];

        $mockResponse = new JsonMockResponse($expectedResponseData, ['http_code' => 200]);
        $client = $this->getApiClient($mockResponse);

        $response = (new Invoices($client))->getAll(['period' => 'this_month', 'page' => 1]);

        $this->assertSame('GET', $mockResponse->getRequestMethod());
        $this->assertSame(
            'https://foo.fakturownia.pl/invoices.json?period=this_month&page=1&api_token=bar',
            $mockResponse->getRequestUrl()
        );
        $this->assertSame($expectedResponseData, $response->getContent());
        $this->assertSame(200, $response->getStatusCode());
    }

    public function testGetInvoiceAsPdf(): void
    {
        $expectedResponseData = 'some-pdf-content...';

        $mockResponse = new MockResponse($expectedResponseData, ['http_code' => 200]);
        $client = $this->getApiClient($mockResponse);

        $pdfContent = (new Invoices($client))->getPdfContent(123);

        $this->assertSame('GET', $mockResponse->getRequestMethod());
        $this->assertSame('https://foo.fakturownia.pl/invoices/123.pdf?api_token=bar', $mockResponse->getRequestUrl());
        $this->assertSame($expectedResponseData, $pdfContent);
    }

    public function testCreateInvoice(): void
    {
        $invoiceData = [
            'kind' => 'vat',
            'number' => null,
            'sell_date' => '2013-01-16',
            'issue_date' => '2013-01-16',
            'payment_to' => '2013-01-23',
            'seller_name' => 'Wystawca Sp. z o.o.',
            'seller_tax_no' => '6272616681',
            'buyer_name' => 'Klient1 Sp. z o.o.',
            'buyer_email' => 'buyer@testemail.pl',
            'buyer_tax_no' => '6272616681',
            'positions' => [
                [
                    'name' => 'Produkt A1',
                    'tax' => 23,
                    'total_price_gross' => 10.23,
                    'quantity' => 1,
                ],
                [
                    'name' => 'Produkt A2',
                    'tax' => 0,
                    'total_price_gross' => 50,
                    'quantity' => 3,
                ],
            ],
        ];

        $requestParams = [
            'identify_oss' => '1',
        ];

        $expectedRequestData = json_encode($requestParams + [
            'invoice' => $invoiceData,
            'api_token' => 'bar',
        ], JSON_THROW_ON_ERROR);

        $expectedResponseData = [
            'id' => 123,
            'kind' => 'vat',
            // ...
        ];

        $mockResponse = new JsonMockResponse($expectedResponseData, ['http_code' => 201]);
        $client = $this->getApiClient($mockResponse);

        $response = (new Invoices($client))->create($invoiceData, $requestParams);

        $this->assertSame('POST', $mockResponse->getRequestMethod());
        $this->assertSame('https://foo.fakturownia.pl/invoices.json', $mockResponse->getRequestUrl());
        $this->assertSame($expectedRequestData, $mockResponse->getRequestOptions()['body']);
        $this->assertSame($expectedResponseData, $response->getContent());
        $this->assertSame(201, $response->getStatusCode());
    }

    public function testUpdateInvoice(): void
    {
        $invoiceData = [
            'buyer_name' => 'Nowy Klient Sp. z o.o.',
        ];

        $expectedRequestData = json_encode([
            'invoice' => $invoiceData,
            'api_token' => 'bar',
        ], JSON_THROW_ON_ERROR);

        $expectedResponseData = [
            'id' => 123,
            'kind' => 'vat',
            // ...
        ];

        $mockResponse = new JsonMockResponse($expectedResponseData, ['http_code' => 200]);
        $client = $this->getApiClient($mockResponse);

        $response = (new Invoices($client))->update(123, $invoiceData);

        $this->assertSame('PUT', $mockResponse->getRequestMethod());
        $this->assertSame('https://foo.fakturownia.pl/invoices/123.json', $mockResponse->getRequestUrl());
        $this->assertSame($expectedRequestData, $mockResponse->getRequestOptions()['body']);
        $this->assertSame($expectedResponseData, $response->getContent());
        $this->assertSame(200, $response->getStatusCode());
    }

    public function testDeleteInvoice(): void
    {
        $expectedResponseData = [
            'code' => 'success',
        ];

        $mockResponse = new JsonMockResponse($expectedResponseData, ['http_code' => 200]);
        $client = $this->getApiClient($mockResponse);

        $response = (new Invoices($client))->delete(123);

        $this->assertSame('DELETE', $mockResponse->getRequestMethod());
        $this->assertSame('https://foo.fakturownia.pl/invoices/123.json?api_token=bar', $mockResponse->getRequestUrl());
        $this->assertSame($expectedResponseData, $response->getContent());
        $this->assertSame(200, $response->getStatusCode());
    }

    public function testCancelInvoice(): void
    {
        $expectedRequestData = json_encode([
            'api_token' => 'bar',
            'cancel_invoice_id' => 123,
            'cancel_reason' => 'some cancel reason note',
        ], JSON_THROW_ON_ERROR);

        $expectedResponseData = [
            'code' => 'success',
        ];

        $mockResponse = new JsonMockResponse($expectedResponseData, ['http_code' => 200]);
        $client = $this->getApiClient($mockResponse);

        $response = (new Invoices($client))->cancel(123, 'some cancel reason note');

        $this->assertSame('POST', $mockResponse->getRequestMethod());
        $this->assertSame('https://foo.fakturownia.pl/invoices/cancel.json', $mockResponse->getRequestUrl());
        $this->assertSame($expectedRequestData, $mockResponse->getRequestOptions()['body']);
        $this->assertSame($expectedResponseData, $response->getContent());
        $this->assertSame(200, $response->getStatusCode());
    }

    public function testSendInvoiceByEmail(): void
    {
        $requestParams = [
            'email_to' => 'buyer1@testemail.pl,buyer2@testemail.pl',
            'email_pdf' => true,
        ];

        $expectedRequestData = json_encode($requestParams + [
            'api_token' => 'bar',
        ], JSON_THROW_ON_ERROR);

        $expectedResponseData = [
            'code' => 'success',
        ];

        $mockResponse = new JsonMockResponse($expectedResponseData, ['http_code' => 200]);
        $client = $this->getApiClient($mockResponse);

        $response = (new Invoices($client))->sendByEmail(123, $requestParams);

        $this->assertSame('POST', $mockResponse->getRequestMethod());
        $this->assertSame('https://foo.fakturownia.pl/invoices/123/send_by_email.json', $mockResponse->getRequestUrl());
        $this->assertSame($expectedRequestData, $mockResponse->getRequestOptions()['body']);
        $this->assertSame($expectedResponseData, $response->getContent());
        $this->assertSame(200, $response->getStatusCode());
    }

    public function testChangeInvoiceStatus(): void
    {
        $newInvoiceStatus = 'NEW';

        $expectedRequestData = json_encode([
            'status' => $newInvoiceStatus,
            'api_token' => 'bar',
        ], JSON_THROW_ON_ERROR);

        $expectedResponseData = [
            'code' => 'success',
        ];

        $mockResponse = new JsonMockResponse($expectedResponseData, ['http_code' => 200]);
        $client = $this->getApiClient($mockResponse);

        $response = (new Invoices($client))->changeStatus(123, $newInvoiceStatus);

        $this->assertSame('POST', $mockResponse->getRequestMethod());
        $this->assertSame('https://foo.fakturownia.pl/invoices/123/change_status.json', $mockResponse->getRequestUrl());
        $this->assertSame($expectedRequestData, $mockResponse->getRequestOptions()['body']);
        $this->assertSame($expectedResponseData, $response->getContent());
        $this->assertSame(200, $response->getStatusCode());
    }

    public function testAnErrorRequest(): void
    {
        $expectedResponseData = [
            'code' => 'error',
            'message' => 'You must be logged in to gain access to the site',
        ];

        $mockResponse = new JsonMockResponse($expectedResponseData, ['http_code' => 401]);
        $client = $this->getApiClient($mockResponse);

        try {
            (new Invoices($client))->get(123);
            $this->fail('ApiException should be thrown');
        } catch (ApiException $e) {
            $this->assertSame('GET', $mockResponse->getRequestMethod());
            $this->assertSame('https://foo.fakturownia.pl/invoices/123.json?api_token=bar', $mockResponse->getRequestUrl());
            $this->assertSame($expectedResponseData, $e->getResponse()->getContent());
            $this->assertSame(401, $e->getResponse()->getStatusCode());
        }
    }
}
