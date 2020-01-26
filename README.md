# Fakturownia (InvoiceOcean)
PHP client for Fakturownia (InvoiceOcean) API ([fakturownia.pl](https://fakturownia.pl), [invoiceocean.com](https://invoiceocean.com)).

## Requirements
* PHP 5.4 or higher with curl and json extensions.

## Installation
The recommended way to install is through [Composer](http://getcomposer.org).

```bash
$ composer require abb/fakturownia
```

## Available methods

* login($login, $password)
* getInvoices(array $params = [])
* getInvoice($id)
* createInvoice(array $invoice)
* updateInvoice($id, array $invoice)
* deleteInvoice($id)
* sendInvoice($id)
* changeInvoiceStatus($id, $status)
* getRecurringInvoices(array $params = [])
* createRecurringInvoice(array $recurringInvoice)
* updateRecurringInvoice($id, array $recurringInvoice)
* getClients(array $params = [])
* getClient($id)
* getClientByExternalId($id)
* createClient(array $client)
* updateClient($id, array $client)
* getProducts(array $params = [])
* getProduct($id, $warehouseId = null)
* createProduct(array $product)
* updateProduct($id, array $product)
* getWarehouseDocuments(array $params = [])
* getWarehouseDocument($id)
* createWarehouseDocument(array $warehouseDocument)
* updateWarehouseDocument($id, array $warehouseDocument)
* deleteWarehouseDocument($id)
* getWarehouses(array $params = [])
* getWarehouse($id)
* createWarehouse(array $warehouse)
* updateWarehouse($id, array $warehouse)
* deleteWarehouse($id)
* getCategories(array $params = [])
* getCategory($id)
* createCategory(array $category)
* updateCategory($id, array $category)
* deleteCategory($id)
* getAccount()
* createAccountForClient(array $account, array $user = [], array $company = [])
* getPayments(array $params = [])
* getPayment($id)
* createPayment(array $payment)
* getDepartments(array $params = [])
* getDepartment($id)
* createDepartment(array $payment)
* updateDepartment($id, array $department)
* deleteDepartment($id)

## Examples of usage

### Example 1 - Get invoices

```php
$fakturownia = new \Abb\Fakturownia\Fakturownia('fakturownia_api_token');
$response = $fakturownia->getInvoices();
$status = $response->getStatus(); // e.g. 'SUCCESS', 'ERROR', 'NOT_FOUND'
$code = $response->getCode();
$invoices = $response->getData();
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

### Example 5 - Update invoice

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

### Example 6 - Delete invoice

```php
$fakturownia = new \Abb\Fakturownia\Fakturownia('fakturownia_api_token');
$invoiceId = 123456;
$result = $fakturownia->deleteInvoice($invoiceId)->getData();
```

More info about the required parameters for every method: [PL](https://app.fakturownia.pl/api) | [EN](http://app.invoiceocean.com/api).

## Changelog

Changelog is available [here](CHANGELOG.md).
