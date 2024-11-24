<?php

declare(strict_types=1);

namespace Abb\Fakturownia\Tests\Functional\Api;

use Abb\Fakturownia\Config;
use Abb\Fakturownia\Exception\RequestException;
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
            $this->fail(RequestException::class . ' should be thrown');
        } catch (RequestException $e) {
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

        $response = $this->fakturownia->invoices()->getOne($invoiceId);

        $this->assertSame(200, $response->getStatusCode());
        $this->assertIsArray($response->getContent());
        $this->assertArrayNotHasKey('connected_payments', $response->getContent());
        $this->assertSame($invoiceId, $response->getContent()['id']);
    }

    public function testGetInvoiceWithConnectedPayments(): void
    {
        $this->skipIf(empty($invoiceId = (int) getenv('FAKTUROWNIA_INVOICE_ID')), 'Missing FAKTUROWNIA_INVOICE_ID');

        $response = $this->fakturownia->invoices()->getOne($invoiceId, [
            'additional_fields' => [
                'invoice' => 'connected_payments',
            ],
        ]);

        $this->assertSame(200, $response->getStatusCode());
        $content = $response->getContent();
        $this->assertIsArray($content);
        $this->assertArrayHasKey('connected_payments', $content);
        $this->assertIsArray($content['connected_payments']);
        $this->assertSame($invoiceId, $content['id']);
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
        $this->expectException(RequestException::class);
        $this->expectExceptionMessage('Not Found');
        $this->expectExceptionCode(404);

        $this->fakturownia->invoices()->getOne(1);
    }

    public function testAccessDenied(): void
    {
        $config = new Config(
            subdomain: 'foo',
            apiToken: 'bar',
        );
        $fakturownia = new Fakturownia($config);

        $this->expectException(RequestException::class);
        $this->expectExceptionMessage('You must be logged in to gain access to the site');
        $this->expectExceptionCode(401);

        $fakturownia->invoices()->getOne(1);
    }
}
