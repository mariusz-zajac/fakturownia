<?php

namespace Abb\Fakturownia\Tests;

use Abb\Fakturownia\FakturowniaApiUrlGenerator;
use PHPUnit\Framework\TestCase;

class FakturowniaApiUrlGeneratorTest extends TestCase
{

    /**
     * @var FakturowniaApiUrlGenerator
     */
    private $fakturowniaApiUrlGenerator;

    /**
     * {@inheritDoc}
     */
    protected function setUp()
    {
        parent::setUp();
        $this->fakturowniaApiUrlGenerator = new FakturowniaApiUrlGenerator('username');
    }

    /**
     * {@inheritDoc}
     */
    protected function tearDown()
    {
        parent::tearDown();
        unset($this->fakturowniaApiUrlGenerator);
    }

    /**
     * @dataProvider providerUrls
     */
    public function testFakturowniaApiUrlGenerator($method, $arguments, $expectedUrl)
    {
        $generatedUrl = call_user_func_array([$this->fakturowniaApiUrlGenerator, $method], $arguments);
        self::assertEquals($expectedUrl, $generatedUrl);
    }

    /**
     * @return array
     */
    public function providerUrls()
    {
        return [
            [
                'urlCreateInvoice', // method
                [], // method arguments
                'https://username.fakturownia.pl/invoices.json', // expected url
            ],
            [
                'urlUpdateInvoice',
                [123],
                'https://username.fakturownia.pl/invoices/123.json',
            ],
            [
                'urlDeleteInvoice',
                [123],
                'https://username.fakturownia.pl/invoices/123.json',
            ],
            [
                'urlGetInvoice',
                [123],
                'https://username.fakturownia.pl/invoices/123.json',
            ],
            [
                'urlGetInvoices',
                [],
                'https://username.fakturownia.pl/invoices.json',
            ],
            [
                'urlSendInvoice',
                [123],
                'https://username.fakturownia.pl/invoices/123/send_by_email.json',
            ],
            [
                'urlChangeInvoiceStatus',
                [123],
                'https://username.fakturownia.pl/invoices/123/change_status.json',
            ],
            [
                'urlGetRecurringInvoices',
                [],
                'https://username.fakturownia.pl/recurrings.json',
            ],
            [
                'urlCreateRecurringInvoice',
                [],
                'https://username.fakturownia.pl/recurrings.json',
            ],
            [
                'urlUpdateRecurringInvoice',
                [123],
                'https://username.fakturownia.pl/recurrings/123.json',
            ],
            [
                'urlCreateClient',
                [],
                'https://username.fakturownia.pl/clients.json',
            ],
            [
                'urlUpdateClient',
                [123],
                'https://username.fakturownia.pl/clients/123.json',
            ],
            [
                'urlGetClient',
                [123],
                'https://username.fakturownia.pl/clients/123.json',
            ],
            [
                'urlGetClientByExternalId',
                [],
                'https://username.fakturownia.pl/clients.json',
            ],
            [
                'urlGetClients',
                [],
                'https://username.fakturownia.pl/clients.json',
            ],
            [
                'urlCreateProduct',
                [],
                'https://username.fakturownia.pl/products.json',
            ],
            [
                'urlUpdateProduct',
                [123],
                'https://username.fakturownia.pl/products/123.json',
            ],
            [
                'urlGetProduct',
                [123],
                'https://username.fakturownia.pl/products/123.json',
            ],
            [
                'urlGetProducts',
                [],
                'https://username.fakturownia.pl/products.json',
            ],
            [
                'urlCreateWarehouseDocument',
                [],
                'https://username.fakturownia.pl/warehouse_documents.json',
            ],
            [
                'urlUpdateWarehouseDocument',
                [123],
                'https://username.fakturownia.pl/warehouse_documents/123.json',
            ],
            [
                'urlDeleteWarehouseDocument',
                [123],
                'https://username.fakturownia.pl/warehouse_documents/123.json',
            ],
            [
                'urlGetWarehouseDocument',
                [123],
                'https://username.fakturownia.pl/warehouse_documents/123.json',
            ],
            [
                'urlGetWarehouseDocuments',
                [],
                'https://username.fakturownia.pl/warehouse_documents.json',
            ],
            [
                'urlCreateWarehouse',
                [],
                'https://username.fakturownia.pl/warehouse.json',
            ],
            [
                'urlUpdateWarehouse',
                [123],
                'https://username.fakturownia.pl/warehouse/123.json',
            ],
            [
                'urlDeleteWarehouse',
                [123],
                'https://username.fakturownia.pl/warehouse/123.json',
            ],
            [
                'urlGetWarehouse',
                [123],
                'https://username.fakturownia.pl/warehouse/123.json',
            ],
            [
                'urlGetWarehouses',
                [],
                'https://username.fakturownia.pl/warehouse.json',
            ],
            [
                'urlCreateCategory',
                [],
                'https://username.fakturownia.pl/categories.json',
            ],
            [
                'urlUpdateCategory',
                [123],
                'https://username.fakturownia.pl/categories/123.json',
            ],
            [
                'urlDeleteCategory',
                [123],
                'https://username.fakturownia.pl/categories/123.json',
            ],
            [
                'urlGetCategory',
                [123],
                'https://username.fakturownia.pl/categories/123.json',
            ],
            [
                'urlGetCategories',
                [],
                'https://username.fakturownia.pl/categories.json',
            ],
            [
                'urlGetAccount',
                [],
                'https://username.fakturownia.pl/account.json',
            ],
            [
                'urlCreateAccountForClient',
                [],
                'https://username.fakturownia.pl/account.json',
            ],
        ];
    }
}
