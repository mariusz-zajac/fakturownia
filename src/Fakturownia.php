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

class Fakturownia
{
    protected ApiClient $apiClient;

    protected string $baseUrl;
    protected string $apiToken;

    protected ?Accounts $accounts = null;
    protected ?Categories $categories = null;
    protected ?Clients $clients = null;
    protected ?Departments $departments = null;
    protected ?Invoices $invoices = null;
    protected ?Payments $payments = null;
    protected ?PriceLists $priceLists = null;
    protected ?Products $products = null;
    protected ?RecurringInvoices $recurringInvoices = null;
    protected ?WarehouseActions $warehouseActions = null;
    protected ?WarehouseDocuments $warehouseDocuments = null;
    protected ?Warehouses $warehouses = null;

    protected array $httpClientDefaultOptions = [
        'headers' => [
            'Accept' => 'application/json',
            'Content-Type' => 'application/json',
            'User-Agent' => 'fakturownia-php-api-client/v2',
        ],
    ];

    /**
     * @param array{subdomain: string, api_token: string} $options
     */
    public function __construct(array $options, ?HttpClientInterface $httpClient = null)
    {
        if (empty($options['subdomain']) || empty($options['api_token'])) {
            throw new InvalidOptionException('Options "subdomain" and "api_token" are required.');
        }

        $this->baseUrl = sprintf('https://%s.fakturownia.pl', $options['subdomain']);
        $this->apiToken = $options['api_token'];

        $httpClient = $httpClient ? $httpClient->withOptions($this->httpClientDefaultOptions) : HttpClient::create($this->httpClientDefaultOptions);
        $this->apiClient = new ApiClient($httpClient);
    }

    public function getApiClient(): ApiClient
    {
        return $this->apiClient;
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
