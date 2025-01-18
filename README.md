# Fakturownia (InvoiceOcean)

PHP client for [Fakturownia](https://fakturownia.pl) ([InvoiceOcean](https://invoiceocean.com)) API.

## Requirements

* PHP 7.4 or higher with curl and json extensions.

## Installation

The recommended way to install is through [Composer](http://getcomposer.org).

```bash
$ composer require abb/fakturownia
```

## Example of usage

```php
$config = new \Abb\Fakturownia\Config('your_subdomain', 'api_token');
$fakturownia = new \Abb\Fakturownia\Fakturownia($config);

// Get invoice with ID 123
$response = $fakturownia->invoices()->getOne(123);

// Get invoices by parameters
$params = [
    'period' => 'this_month',
    'page' => '1',
];
$response = $fakturownia->invoices()->getAll($params);

// Get invoice with ID 123 as PDF and save it to file
$pdfContent = $fakturownia->invoices()->getPdf(123);
file_put_contents('/path/to/invoice_123.pdf', $pdfContent);

// Create an invoice
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
$response = $fakturownia->invoices()->create($invoiceData);

// Update invoice with ID 123
$invoiceData = [
    'buyer_name' => 'Nowa nazwa klienta Sp. z o.o.',
    'positions' =>  [
        [
            'id' => 32649087,
            'name' => 'Nowa nazwa pozycji na fakturze',
        ],
    ],
];
$response = $fakturownia->invoices()->update(123, $invoiceData);

// Delete invoice with ID 123
$response = $fakturownia->invoices()->delete(123);
```

### Error handling

```php
$fakturownia = new \Abb\Fakturownia\Fakturownia($config);
$invoiceData = [
    // ...
];

try {
    $response = $fakturownia->invoices()->create($invoiceData);
} catch (\Abb\Fakturownia\Exception\ApiException $e) {
    $msg = $e->getMessage(); // error message
    $statusCode = $e->getCode(); // status code, e.g. 400, 401, 500 etc.
    $details = $e->getDetails(); // error details (if available)
} catch (\Abb\Fakturownia\Exception\RuntimeException $e) {
    $msg = $e->getMessage();
}

$lastResponse = $fakturownia->getLastResponse(); // last API response or NULL if not available
```

## API documentation

More info about the required parameters for each method can be found here: [PL](https://app.fakturownia.pl/api) | [EN](http://app.invoiceocean.com/api).
