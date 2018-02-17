# Fakturownia (InvoiceOcean)
PHP client for Fakturownia (InvoiceOcean) API ([fakturownia.pl](https://fakturownia.pl), [invoiceocean.com](https://invoiceocean.com)).

## Requirements
* PHP 5.4 or higher.

## Installation
The recommended way to install is through [Composer](http://getcomposer.org).

```bash
$ composer require abb/fakturownia
```

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
