<?php

declare(strict_types=1);

namespace Abb\Fakturownia\Tests\Unit\Api;

use Abb\Fakturownia\Api\Invoices;
use Abb\Fakturownia\Exception\ApiException;
use Abb\Fakturownia\Tests\Unit\AbstractTestCase;
use Psr\Http\Message\ResponseInterface;

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

        $mockResponse = $this->createJsonMockResponse($expectedResponseData, ['http_code' => 200]);
        $fakturownia = $this->getFakturowniaStub($mockResponse);

        $response = (new Invoices($fakturownia))->getOne(123);

        $this->assertSame('GET', $mockResponse->getRequestMethod());
        $this->assertSame('https://foo.fakturownia.pl/invoices/123.json?api_token=bar', $mockResponse->getRequestUrl());
        $this->assertSame($expectedResponseData, $response);
    }

    public function testGetInvoiceWithConnectedPayments(): void
    {
        $requestParams = [
            'additional_fields' => [
                'invoice' => 'connected_payments',
            ],
        ];

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
            'connected_payments' => [],
        ];

        $mockResponse = $this->createJsonMockResponse($expectedResponseData, ['http_code' => 200]);
        $fakturownia = $this->getFakturowniaStub($mockResponse);

        $response = (new Invoices($fakturownia))->getOne(123, $requestParams);

        $this->assertSame('GET', $mockResponse->getRequestMethod());
        $this->assertSame(
            'https://foo.fakturownia.pl/invoices/123.json?additional_fields%5Binvoice%5D=connected_payments&api_token=bar',
            $mockResponse->getRequestUrl()
        );
        $this->assertSame($expectedResponseData, $response);
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

        $mockResponse = $this->createJsonMockResponse($expectedResponseData, ['http_code' => 200]);
        $fakturownia = $this->getFakturowniaStub($mockResponse);

        $response = (new Invoices($fakturownia))->getAll(['period' => 'this_month', 'page' => 1]);

        $this->assertSame('GET', $mockResponse->getRequestMethod());
        $this->assertSame(
            'https://foo.fakturownia.pl/invoices.json?period=this_month&page=1&api_token=bar',
            $mockResponse->getRequestUrl()
        );
        $this->assertSame($expectedResponseData, $response);
    }

    public function testGetInvoiceAsPdf(): void
    {
        $expectedResponseData = '%PDF-1.4-some-pdf-content...';

        $mockResponse = $this->createMockResponse($expectedResponseData, ['http_code' => 200]);
        $fakturownia = $this->getFakturowniaStub($mockResponse);

        $pdfContent = (new Invoices($fakturownia))->getPdf(123);

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

        $mockResponse = $this->createJsonMockResponse($expectedResponseData, ['http_code' => 201]);
        $fakturownia = $this->getFakturowniaStub($mockResponse);

        $response = (new Invoices($fakturownia))->create($invoiceData, $requestParams);

        $this->assertSame('POST', $mockResponse->getRequestMethod());
        $this->assertSame('https://foo.fakturownia.pl/invoices.json', $mockResponse->getRequestUrl());
        $this->assertSame($expectedRequestData, $mockResponse->getRequestOptions()['body']);
        $this->assertSame($expectedResponseData, $response);
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

        $mockResponse = $this->createJsonMockResponse($expectedResponseData, ['http_code' => 200]);
        $fakturownia = $this->getFakturowniaStub($mockResponse);

        $response = (new Invoices($fakturownia))->update(123, $invoiceData);

        $this->assertSame('PUT', $mockResponse->getRequestMethod());
        $this->assertSame('https://foo.fakturownia.pl/invoices/123.json', $mockResponse->getRequestUrl());
        $this->assertSame($expectedRequestData, $mockResponse->getRequestOptions()['body']);
        $this->assertSame($expectedResponseData, $response);
    }

    public function testDeleteInvoice(): void
    {
        $expectedResponseData = [
            'code' => 'success',
        ];

        $mockResponse = $this->createJsonMockResponse($expectedResponseData, ['http_code' => 200]);
        $fakturownia = $this->getFakturowniaStub($mockResponse);

        $response = (new Invoices($fakturownia))->delete(123);

        $this->assertSame('DELETE', $mockResponse->getRequestMethod());
        $this->assertSame('https://foo.fakturownia.pl/invoices/123.json?api_token=bar', $mockResponse->getRequestUrl());
        $this->assertSame($expectedResponseData, $response);
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

        $mockResponse = $this->createJsonMockResponse($expectedResponseData, ['http_code' => 200]);
        $fakturownia = $this->getFakturowniaStub($mockResponse);

        $response = (new Invoices($fakturownia))->cancel(123, 'some cancel reason note');

        $this->assertSame('POST', $mockResponse->getRequestMethod());
        $this->assertSame('https://foo.fakturownia.pl/invoices/cancel.json', $mockResponse->getRequestUrl());
        $this->assertSame($expectedRequestData, $mockResponse->getRequestOptions()['body']);
        $this->assertSame($expectedResponseData, $response);
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

        $mockResponse = $this->createJsonMockResponse($expectedResponseData, ['http_code' => 200]);
        $fakturownia = $this->getFakturowniaStub($mockResponse);

        $response = (new Invoices($fakturownia))->sendByEmail(123, $requestParams);

        $this->assertSame('POST', $mockResponse->getRequestMethod());
        $this->assertSame('https://foo.fakturownia.pl/invoices/123/send_by_email.json', $mockResponse->getRequestUrl());
        $this->assertSame($expectedRequestData, $mockResponse->getRequestOptions()['body']);
        $this->assertSame($expectedResponseData, $response);
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

        $mockResponse = $this->createJsonMockResponse($expectedResponseData, ['http_code' => 200]);
        $fakturownia = $this->getFakturowniaStub($mockResponse);

        $response = (new Invoices($fakturownia))->changeStatus(123, $newInvoiceStatus);

        $this->assertSame('POST', $mockResponse->getRequestMethod());
        $this->assertSame('https://foo.fakturownia.pl/invoices/123/change_status.json', $mockResponse->getRequestUrl());
        $this->assertSame($expectedRequestData, $mockResponse->getRequestOptions()['body']);
        $this->assertSame($expectedResponseData, $response);
    }

    public function testAnErrorRequest(): void
    {
        $expectedResponseData = [
            'code' => 'error',
            'message' => 'You must be logged in to gain access to the site',
        ];

        $mockResponse = $this->createJsonMockResponse($expectedResponseData, ['http_code' => 401]);
        $fakturownia = $this->getFakturowniaStub($mockResponse);

        try {
            (new Invoices($fakturownia))->getOne(123);
            $this->fail(ApiException::class . ' should be thrown');
        } catch (ApiException $e) {
            $this->assertSame('You must be logged in to gain access to the site', $e->getMessage());
            $this->assertSame(401, $e->getCode());
            $this->assertSame('GET', $mockResponse->getRequestMethod());
            $this->assertSame('https://foo.fakturownia.pl/invoices/123.json?api_token=bar', $mockResponse->getRequestUrl());
            $this->assertSame($expectedResponseData, $e->getDetails());
            $this->assertInstanceOf(ResponseInterface::class, $fakturownia->getLastResponse());
            $this->assertSame(401, $fakturownia->getLastResponse()->getStatusCode());
            $this->assertSame(json_encode($expectedResponseData), (string) $fakturownia->getLastResponse()->getBody());
        }
    }
}
