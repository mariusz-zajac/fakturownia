<?php

declare(strict_types=1);

namespace Abb\Fakturownia\Tests\Functional\Api;

use Abb\Fakturownia\Config;
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
            $this->fail(ApiException::class . ' should be thrown');
        } catch (ApiException $e) {
            $this->assertSame('Invalid data', $e->getMessage());
            $this->assertSame(422, $e->getCode());
            $details = $e->getDetails();
            $this->assertIsArray($details);
            $this->assertArrayHasKey('message', $details);
            $this->assertIsArray($details['message']);
            $this->assertArrayHasKey('buyer_name', $details['message']);
        }
    }

    public function testUpdateInvoice(): void
    {
        $this->skipIf(empty($invoiceId = (int) getenv('FAKTUROWNIA_INVOICE_ID')), 'Missing FAKTUROWNIA_INVOICE_ID');

        $description = 'Updated at ' . (new \DateTimeImmutable())->format('Y-m-d H:i:s');
        $response = $this->fakturownia->invoices()->update($invoiceId, [
            'description' => $description,
        ]);

        $this->assertIsArray($response);
        $this->assertSame($invoiceId, $response['id']);
        $this->assertSame($description, $response['description']);
    }

    public function testGetInvoice(): void
    {
        $this->skipIf(empty($invoiceId = (int) getenv('FAKTUROWNIA_INVOICE_ID')), 'Missing FAKTUROWNIA_INVOICE_ID');

        $response = $this->fakturownia->invoices()->getOne($invoiceId);

        $this->assertIsArray($response);
        $this->assertArrayNotHasKey('connected_payments', $response);
        $this->assertSame($invoiceId, $response['id']);
    }

    public function testGetInvoiceWithConnectedPayments(): void
    {
        $this->skipIf(empty($invoiceId = (int) getenv('FAKTUROWNIA_INVOICE_ID')), 'Missing FAKTUROWNIA_INVOICE_ID');

        $response = $this->fakturownia->invoices()->getOne($invoiceId, [
            'additional_fields' => [
                'invoice' => 'connected_payments',
            ],
        ]);

        $this->assertIsArray($response);
        $this->assertArrayHasKey('connected_payments', $response);
        $this->assertIsArray($response['connected_payments']);
        $this->assertSame($invoiceId, $response['id']);
    }

    public function testGetInvoiceAsPdf(): void
    {
        $this->skipIf(empty($invoiceId = (int) getenv('FAKTUROWNIA_INVOICE_ID')), 'Missing FAKTUROWNIA_INVOICE_ID');

        $response = $this->fakturownia->invoices()->getPdf($invoiceId);

        $this->assertIsString($response);
        $this->assertStringStartsWith('%PDF', $response);
    }

    public function testSendInvoiceByEmail(): void
    {
        $this->skipIf(empty($invoiceId = (int) getenv('FAKTUROWNIA_INVOICE_ID')), 'Missing FAKTUROWNIA_INVOICE_ID');
        $this->skipIf(empty($recipientEmail = getenv('FAKTUROWNIA_RECIPIENT_EMAIL')), 'Missing FAKTUROWNIA_RECIPIENT_EMAIL');

        $response = $this->fakturownia->invoices()->sendByEmail($invoiceId, [
            'email_to' => $recipientEmail,
        ]);

        $this->assertIsArray($response);
        $this->assertSame('ok', $response['status']);
    }

    public function testInvoiceNotFound(): void
    {
        $this->expectException(ApiException::class);
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

        $this->expectException(ApiException::class);
        $this->expectExceptionMessage('You must be logged in to gain access to the site');
        $this->expectExceptionCode(401);

        $fakturownia->invoices()->getOne(1);
    }
}
