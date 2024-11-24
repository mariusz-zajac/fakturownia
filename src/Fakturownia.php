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
use Symfony\Component\HttpClient\HttpClient;
use Symfony\Contracts\HttpClient\HttpClientInterface;

final class Fakturownia
{
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
        'User-Agent' => 'fakturownia-php-api-client/v2',
    ];

    public function __construct(Config $config, ?HttpClientInterface $httpClient = null)
    {
        $this->config = $config;
        $this->apiClient = new ApiClient($httpClient ?? HttpClient::create(), $this->apiClientDefaultHeaders);
    }

    public function getConfig(): Config
    {
        return $this->config;
    }

    public function getApiClient(): ApiClient
    {
        return $this->apiClient;
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
