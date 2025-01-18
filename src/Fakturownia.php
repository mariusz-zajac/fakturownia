<?php

declare(strict_types=1);

namespace Abb\Fakturownia;

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
use Psr\Http\Client\ClientInterface;
use Symfony\Component\HttpClient\Psr18Client;

final class Fakturownia
{
    public const USER_AGENT = 'fakturownia-php-api-client/v2';

    private Config $config;
    private ApiClient $apiClient;

    private ?Accounts $accounts = null;
    private ?Categories $categories = null;
    private ?Clients $clients = null;
    private ?Departments $departments = null;
    private ?Invoices $invoices = null;
    private ?Payments $payments = null;
    private ?PriceLists $priceLists = null;
    private ?Products $products = null;
    private ?RecurringInvoices $recurringInvoices = null;
    private ?WarehouseActions $warehouseActions = null;
    private ?WarehouseDocuments $warehouseDocuments = null;
    private ?Warehouses $warehouses = null;

    private array $apiClientDefaultHeaders = [
        'Accept' => 'application/json',
        'Content-Type' => 'application/json',
        'User-Agent' => self::USER_AGENT,
    ];

    public function __construct(Config $config, ?ClientInterface $httpClient = null)
    {
        $this->config = $config;
        $this->apiClient = new ApiClient($httpClient ?? new Psr18Client(), $this->apiClientDefaultHeaders);
    }

    public function getConfig(): Config
    {
        return $this->config;
    }

    public function getApiClient(): ApiClient
    {
        return $this->apiClient;
    }

    public function getLastResponse(): ?Response
    {
        return $this->getApiClient()->getLastResponse();
    }

    public function accounts(): Accounts
    {
        return $this->accounts ??= new Accounts($this);
    }

    public function categories(): Categories
    {
        return $this->categories ??= new Categories($this);
    }

    public function clients(): Clients
    {
        return $this->clients ??= new Clients($this);
    }

    public function departments(): Departments
    {
        return $this->departments ??= new Departments($this);
    }

    public function invoices(): Invoices
    {
        return $this->invoices ??= new Invoices($this);
    }

    public function payments(): Payments
    {
        return $this->payments ??= new Payments($this);
    }

    public function priceLists(): PriceLists
    {
        return $this->priceLists ??= new PriceLists($this);
    }

    public function products(): Products
    {
        return $this->products ??= new Products($this);
    }

    public function recurringInvoices(): RecurringInvoices
    {
        return $this->recurringInvoices ??= new RecurringInvoices($this);
    }

    public function warehouseActions(): WarehouseActions
    {
        return $this->warehouseActions ??= new WarehouseActions($this);
    }

    public function warehouseDocuments(): WarehouseDocuments
    {
        return $this->warehouseDocuments ??= new WarehouseDocuments($this);
    }

    public function warehouses(): Warehouses
    {
        return $this->warehouses ??= new Warehouses($this);
    }
}
