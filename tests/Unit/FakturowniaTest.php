<?php

declare(strict_types=1);

namespace Abb\Fakturownia\Tests\Unit;

use Abb\Fakturownia\Api\Accounts;
use Abb\Fakturownia\Api\Categories;
use Abb\Fakturownia\Api\Clients;
use Abb\Fakturownia\Api\Departments;
use Abb\Fakturownia\Api\Invoices;
use Abb\Fakturownia\Api\Payments;
use Abb\Fakturownia\Api\PriceLists;
use Abb\Fakturownia\Api\Products;
use Abb\Fakturownia\Api\RecurringInvoices;
use Abb\Fakturownia\Api\WarehouseActions;
use Abb\Fakturownia\Api\WarehouseDocuments;
use Abb\Fakturownia\Api\Warehouses;
use Abb\Fakturownia\ApiClient;
use Abb\Fakturownia\Exception\InvalidOptionException;
use Abb\Fakturownia\Fakturownia;

final class FakturowniaTest extends AbstractTestCase
{
    public function testCreateServiceSuccessfully(): void
    {
        $fakturownia = new Fakturownia(['subdomain' => 'foo', 'api_token' => 'bar']);

        $this->assertSame('https://foo.fakturownia.pl', $fakturownia->getBaseUrl());
        $this->assertSame('bar', $fakturownia->getApiToken());
        $this->assertInstanceOf(ApiClient::class, $fakturownia->getApiClient());
        $this->assertInstanceOf(Accounts::class, $fakturownia->accounts());
        $this->assertInstanceOf(Categories::class, $fakturownia->categories());
        $this->assertInstanceOf(Clients::class, $fakturownia->clients());
        $this->assertInstanceOf(Departments::class, $fakturownia->departments());
        $this->assertInstanceOf(Invoices::class, $fakturownia->invoices());
        $this->assertInstanceOf(Payments::class, $fakturownia->payments());
        $this->assertInstanceOf(PriceLists::class, $fakturownia->priceLists());
        $this->assertInstanceOf(Products::class, $fakturownia->products());
        $this->assertInstanceOf(RecurringInvoices::class, $fakturownia->recurringInvoices());
        $this->assertInstanceOf(WarehouseActions::class, $fakturownia->warehouseActions());
        $this->assertInstanceOf(WarehouseDocuments::class, $fakturownia->warehouseDocuments());
        $this->assertInstanceOf(Warehouses::class, $fakturownia->warehouses());
    }

    /**
     * @dataProvider provideInvalidOptions
     */
    public function testThrowExceptionOnInvalidOptions(array $options): void
    {
        $this->expectException(InvalidOptionException::class);

        new Fakturownia($options);
    }

    public function provideInvalidOptions(): iterable
    {
        yield 'missing subdomain' => [
            ['api_token' => 'foo'],
        ];

        yield 'empty subdomain' => [
            ['api_token' => 'foo', 'subdomain' => ''],
        ];

        yield 'missing api_token' => [
            ['subdomain' => 'foo'],
        ];

        yield 'empty api_token' => [
            ['subdomain' => 'foo', 'api_token' => ''],
        ];
    }
}
