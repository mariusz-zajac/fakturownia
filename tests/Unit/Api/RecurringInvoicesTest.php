<?php

declare(strict_types=1);

namespace Abb\Fakturownia\Tests\Unit\Api;

use Abb\Fakturownia\Api\RecurringInvoices;
use Abb\Fakturownia\Tests\Unit\AbstractTestCase;
use Symfony\Component\HttpClient\Response\JsonMockResponse;

final class RecurringInvoicesTest extends AbstractTestCase
{
    public function testGetAllRecurringInvoices(): void
    {
        $expectedResponseData = [
            [
                'id' => 123,
                'name' => 'Name',
                'invoice_id' => 1,
                'start_date' => '2024-09-01',
                'every' => '1m',
                'issue_working_day_only' => false,
                'send_email' => true,
                'buyer_email' => 'mail1@mail.pl,mail2@mail.pl',
                'end_date' => null,
            ],
        ];

        $mockResponse = new JsonMockResponse($expectedResponseData, ['http_code' => 200]);
        $fakturownia = $this->getFakturowniaStub($mockResponse);

        $response = (new RecurringInvoices($fakturownia))->getAll();

        $this->assertSame('GET', $mockResponse->getRequestMethod());
        $this->assertSame('https://foo.fakturownia.pl/recurrings.json?api_token=bar', $mockResponse->getRequestUrl());
        $this->assertSame($expectedResponseData, $response->getContent());
        $this->assertSame(200, $response->getStatusCode());
    }

    public function testCreateRecurringInvoice(): void
    {
        $recurringInvoiceData = [
            'name' => 'Name',
            'invoice_id' => 1,
            'start_date' => '2024-09-01',
            'every' => '1m',
            'issue_working_day_only' => false,
            'send_email' => true,
            'buyer_email' => 'mail1@mail.pl,mail2@mail.pl',
            'end_date' => null,
        ];

        $expectedRequestData = json_encode([
            'recurring' => $recurringInvoiceData,
            'api_token' => 'bar',
        ], JSON_THROW_ON_ERROR);

        $expectedResponseData = [
            'code' => 'success',
        ];

        $mockResponse = new JsonMockResponse($expectedResponseData, ['http_code' => 201]);
        $fakturownia = $this->getFakturowniaStub($mockResponse);

        $response = (new RecurringInvoices($fakturownia))->create($recurringInvoiceData);

        $this->assertSame('POST', $mockResponse->getRequestMethod());
        $this->assertSame('https://foo.fakturownia.pl/recurrings.json', $mockResponse->getRequestUrl());
        $this->assertSame($expectedRequestData, $mockResponse->getRequestOptions()['body']);
        $this->assertSame($expectedResponseData, $response->getContent());
        $this->assertSame(201, $response->getStatusCode());
    }

    public function testUpdateRecurringInvoice(): void
    {
        $recurringInvoiceData = [
            'next_invoice_date' => '2024-10-01',
        ];

        $expectedRequestData = json_encode([
            'recurring' => $recurringInvoiceData,
            'api_token' => 'bar',
        ], JSON_THROW_ON_ERROR);

        $expectedResponseData = [
            'code' => 'success',
        ];

        $mockResponse = new JsonMockResponse($expectedResponseData, ['http_code' => 200]);
        $fakturownia = $this->getFakturowniaStub($mockResponse);

        $response = (new RecurringInvoices($fakturownia))->update(123, $recurringInvoiceData);

        $this->assertSame('PUT', $mockResponse->getRequestMethod());
        $this->assertSame('https://foo.fakturownia.pl/recurrings/123.json', $mockResponse->getRequestUrl());
        $this->assertSame($expectedRequestData, $mockResponse->getRequestOptions()['body']);
        $this->assertSame($expectedResponseData, $response->getContent());
        $this->assertSame(200, $response->getStatusCode());
    }
}
