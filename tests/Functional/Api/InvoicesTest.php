<?php

declare(strict_types=1);

namespace Abb\Fakturownia\Tests\Functional\Api;

use Abb\Fakturownia\Exception\ApiException;
use Abb\Fakturownia\Fakturownia;
use Abb\Fakturownia\Tests\Functional\AbstractTestCase;

final class InvoicesTest extends AbstractTestCase
{
    public function testShouldNotCreateInvoiceIfRequiredFieldsAreMissing(): void
    {
        try {
            $this->fakturownia->invoices()->create([
                'positions' => [
                    ['name' => 'Product 1', 'tax' => 23],
                ],
            ]);
            $this->fail('ApiException should be thrown');
        } catch (ApiException $e) {
            $response = $e->getResponse();
            $this->assertSame('Invalid data', $e->getMessage());
            $this->assertSame(422, $e->getCode());
            $this->assertSame(422, $response->getStatusCode());
            $this->assertIsArray($response->getContent());
            $this->assertArrayHasKey('message', $response->getContent());
            $this->assertIsArray($response->getContent()['message']);
            $this->assertArrayHasKey('buyer_name', $response->getContent()['message']);
        }
    }

    public function testGetInvoice(): void
    {
        $this->skipIf(empty($invoiceId = (int) getenv('FAKTUROWNIA_INVOICE_ID')), 'Missing FAKTUROWNIA_INVOICE_ID');

        $response = $this->fakturownia->invoices()->get($invoiceId);

        $this->assertSame(200, $response->getStatusCode());
        $this->assertIsArray($response->getContent());
        $this->assertSame($invoiceId, $response->getContent()['id']);
    }

    public function testGetInvoiceAsPdf(): void
    {
        $this->skipIf(empty($invoiceId = (int) getenv('FAKTUROWNIA_INVOICE_ID')), 'Missing FAKTUROWNIA_INVOICE_ID');

        $response = $this->fakturownia->invoices()->getPdf($invoiceId);

        $this->assertSame(200, $response->getStatusCode());
        $this->assertIsString($response->getContent());
        $this->assertStringStartsWith('%PDF', $response->getContent());
    }

    public function testInvoiceNotFound(): void
    {
        $this->expectException(ApiException::class);
        $this->expectExceptionMessage('Not Found');
        $this->expectExceptionCode(404);

        $this->fakturownia->invoices()->get(1);
    }

    public function testAccessDenied(): void
    {
        $fakturownia = new Fakturownia([
            'subdomain' => 'foo',
            'api_token' => 'bar',
        ]);

        $this->expectException(ApiException::class);
        $this->expectExceptionMessage('You must be logged in to gain access to the site');
        $this->expectExceptionCode(401);

        $fakturownia->invoices()->get(1);
    }
}
