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
use Abb\Fakturownia\Exception\InvalidOptionException;
use Symfony\Component\HttpClient\HttpClient;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class Client
{
    private HttpClientInterface $httpClient;
    private string $baseUrl;
    private string $apiToken;

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

    /**
     * @param array{subdomain: string, api_token: string} $options
     */
    public function __construct(
        #[\SensitiveParameter] array $options,
        ?HttpClientInterface $httpClient = null,
    ) {
        if (empty($options['subdomain']) || empty($options['api_token'])) {
            throw new InvalidOptionException('Options "subdomain" and "api_token" are required.');
        }

        $this->baseUrl = sprintf('https://%s.fakturownia.pl', $options['subdomain']);
        $this->apiToken = $options['api_token'];

        $httpClientOptions = [
            'headers' => [
                'Accept' => 'application/json',
                'Content-Type' => 'application/json',
            ],
        ];

        $this->httpClient = $httpClient ? $httpClient->withOptions($httpClientOptions) : HttpClient::create($httpClientOptions);
    }

    public function getHttpClient(): HttpClientInterface
    {
        return $this->httpClient;
    }

    public function getBaseUrl(): string
    {
        return $this->baseUrl;
    }

    public function getApiToken(): string
    {
        return $this->apiToken;
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
