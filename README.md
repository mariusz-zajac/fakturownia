# Fakturownia (InvoiceOcean)

PHP client for [Fakturownia](https://fakturownia.pl) ([InvoiceOcean](https://invoiceocean.com)) API.

## Requirements

* PHP 8.2 or higher with curl and json extensions.

## Installation

The recommended way to install is through [Composer](http://getcomposer.org).

```bash
$ composer require abb/fakturownia
```

## Example of usage

```php
$fakturownia = new \Abb\Fakturownia\Fakturownia(['subdomain' => 'foo', 'api_token' => 'bar']);

// Get invoice by ID
$response = $fakturownia->invoices()->getOne(123);

// Get invoices by parameters
$params = [
    'period' => 'this_month',
    'page' => '1',
];
$response = $fakturownia->invoices()->getAll($params);

// Get invoice as PDF and save to file
$pdfContent = $fakturownia->invoices()->getPdf(123)->getContent();
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

// Update invoice
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

// Delete invoice
$response = $fakturownia->invoices()->delete(123);
```

## API documentation

More info about the required parameters for each method can be found here: [PL](https://app.fakturownia.pl/api) | [EN](http://app.invoiceocean.com/api).
