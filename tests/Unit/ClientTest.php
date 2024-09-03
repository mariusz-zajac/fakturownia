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
use Abb\Fakturownia\Client;
use Abb\Fakturownia\Exception\InvalidOptionException;
use Symfony\Contracts\HttpClient\HttpClientInterface;

final class ClientTest extends AbstractTestCase
{
    public function testCreateServiceSuccessfully(): void
    {
        $client = new Client(['subdomain' => 'foo', 'api_token' => 'bar']);

        $this->assertSame('https://foo.fakturownia.pl', $client->getBaseUrl());
        $this->assertSame('bar', $client->getApiToken());
        $this->assertInstanceOf(HttpClientInterface::class, $client->getHttpClient());
        $this->assertInstanceOf(Accounts::class, $client->accounts());
        $this->assertInstanceOf(Categories::class, $client->categories());
        $this->assertInstanceOf(Clients::class, $client->clients());
        $this->assertInstanceOf(Departments::class, $client->departments());
        $this->assertInstanceOf(Invoices::class, $client->invoices());
        $this->assertInstanceOf(Payments::class, $client->payments());
        $this->assertInstanceOf(PriceLists::class, $client->priceLists());
        $this->assertInstanceOf(Products::class, $client->products());
        $this->assertInstanceOf(RecurringInvoices::class, $client->recurringInvoices());
        $this->assertInstanceOf(WarehouseActions::class, $client->warehouseActions());
        $this->assertInstanceOf(WarehouseDocuments::class, $client->warehouseDocuments());
        $this->assertInstanceOf(Warehouses::class, $client->warehouses());
    }

    /**
     * @dataProvider provideInvalidOptions
     */
    public function testThrowExceptionOnInvalidOptions(array $options): void
    {
        $this->expectException(InvalidOptionException::class);

        new Client($options);
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
