# Fakturownia (InvoiceOcean)

PHP client for Fakturownia (InvoiceOcean) API ([fakturownia.pl](https://fakturownia.pl), [invoiceocean.com](https://invoiceocean.com)).

## Requirements

* PHP 7.1 or higher with curl and json extensions.

## Installation

The recommended way to install is through [Composer](http://getcomposer.org).

```bash
$ composer require abb/fakturownia
```

## Supported API tokens

Fakturownia.pl provides two types of tokens - with prefix (i.e. with your subdomain) and without prefix.
Only **tokens with prefix** are supported. You can generate it in fakturownia.pl service
(Settings -> Account settings -> Integration -> Show ApiTokens -> Add new Token -> Kind: Token with a prefix).

## Available methods

* login(string $login, string $password)
* getInvoices(array $params = [])
* getInvoice(int $id)
* createInvoice(array $invoice)
* updateInvoice(int $id, array $invoice)
* deleteInvoice(int $id)
* sendInvoice(int $id)
* changeInvoiceStatus(int $id, $status)
* getRecurringInvoices(array $params = [])
* createRecurringInvoice(array $recurringInvoice)
* updateRecurringInvoice(int $id, array $recurringInvoice)
* getClients(array $params = [])
* getClient(int $id)
* getClientByExternalId(int $id)
* createClient(array $client)
* updateClient(int $id, array $client)
* getProducts(array $params = [])
* getProduct(int $id, int $warehouseId = null)
* createProduct(array $product)
* updateProduct(int $id, array $product)
* getWarehouseDocuments(array $params = [])
* getWarehouseDocument(int $id)
* createWarehouseDocument(array $warehouseDocument)
* updateWarehouseDocument(int $id, array $warehouseDocument)
* deleteWarehouseDocument(int $id)
* getWarehouses(array $params = [])
* getWarehouse(int $id)
* createWarehouse(array $warehouse)
* updateWarehouse(int $id, array $warehouse)
* deleteWarehouse(int $id)
* getCategories(array $params = [])
* getCategory(int $id)
* createCategory(array $category)
* updateCategory(int $id, array $category)
* deleteCategory(int $id)
* getAccount()
* createAccountForClient(array $account, array $user = [], array $company = [])
* getPayments(array $params = [])
* getPayment(int $id)
* createPayment(array $payment)
* getDepartments(array $params = [])
* getDepartment(int $id)
* createDepartment(array $payment)
* updateDepartment(int $id, array $department)
* deleteDepartment(int $id)

## Examples of usage

### Example 1 - Get invoices

```php
$fakturownia = new \Abb\Fakturownia\Fakturownia('fakturownia_api_token');
$response = $fakturownia->getInvoices();
if ($response->isSuccess()) {
    $invoices = $response->getData();
} else {
    $errors = $response->getData();
}
```

### Example 2 - Get invoices by parameters

```php
$fakturownia = new \Abb\Fakturownia\Fakturownia('fakturownia_api_token');
$params = [
    'period' => 'this_month',
    'page' => '1',
];
$invoices = $fakturownia->getInvoices($params)->getData();
```

### Example 3 - Get invoice by ID

```php
$fakturownia = new \Abb\Fakturownia\Fakturownia('fakturownia_api_token');
$invoiceId = 123456;
$invoice = $fakturownia->getInvoice($invoiceId)->getData();
```

### Example 4 - Create an invoice

```php
$fakturownia = new \Abb\Fakturownia\Fakturownia('fakturownia_api_token');
$invoiceData = [
    'kind' => 'vat',
    'number' => null,
    'sell_date' => '2013-01-16',
    'issue_date' => '2013-01-16',
    'payment_to' => '2013-01-23',
    'seller_name' => 'Wystawca Sp. z o.o.',
    'seller_tax_no' => '5252445767',
    'buyer_name' => 'Klient1 Sp. z o.o.',
    'buyer_email' => 'buyer@testemail.pl',
    'buyer_tax_no' => '5252445767',
    'positions' => [
        [
            'name' => 'Produkt A1',
            'tax' => 23,
            'total_price_gross' => 10.23,
            'quantity' => 1,
        ],
        [
            'name' => 'Produkt A2',
            'tax' => 0,
            'total_price_gross' => 50,
            'quantity' => 3,
        ],
    ],
];
$createdInvoice = $fakturownia->createInvoice($invoiceData)->getData();
```

### Example 5 - Create an invoice and send to client by email

```php
$fakturownia = new \Abb\Fakturownia\Fakturownia('fakturownia_api_token');
$invoiceData = [
    'buyer_email' => 'buyer@testemail.pl',
    // ...
];
$response = $fakturownia->createInvoice($invoiceData);
if ($response->isSuccess()) {
    $createdInvoice = $response->getData();
    $fakturownia->sendInvoice($createdInvoice['id']); // Invoice will be sent to buyer_email
}
```

### Example 6 - Update invoice

```php
$fakturownia = new \Abb\Fakturownia\Fakturownia('fakturownia_api_token');
$invoiceId = 123456;
$invoiceData = [
    'buyer_name' => 'Nowa nazwa klienta Sp. z o.o.',
    'positions' =>  [
        [
            'id' => 32649087,
            'name' => 'Nowa nazwa pozycji na fakturze',
        ],
    ],
];
$updatedInvoice = $fakturownia->updateInvoice($invoiceId, $invoiceData)->getData();
```

### Example 7 - Delete invoice

```php
$fakturownia = new \Abb\Fakturownia\Fakturownia('fakturownia_api_token');
$invoiceId = 123456;
$result = $fakturownia->deleteInvoice($invoiceId)->getData();
```

More info about the required parameters for every method: [PL](https://app.fakturownia.pl/api) | [EN](http://app.invoiceocean.com/api).

## Changelog

Changelog is available [here](CHANGELOG.md).
