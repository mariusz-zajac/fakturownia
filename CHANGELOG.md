# Changelog

All notable changes to this project will be documented in this file.

## 2.0.0
* New API model
* Dropped support for PHP < 7.4

## 1.6.0
* Added methods to manage price lists
* Added getInvoicePdf method

## 1.5.1
* Fixed warehouses endpoint address

## 1.5.0
* Added updatePayment method
* Added deletePayment method
* Allowed sending of parameter in the getPayment method
* Added .gitattributes

## 1.4.0
* Allowed PHP 8

## 1.3.1
* Deprecated login method
* Updated readme
* Updated message of InvalidTokenException
* Small refactoring

## 1.3.0
* Upgraded to PHP 7.1
* Added type hints
* Added more tests

## 1.2.0
* Added login method
* Added methods to manage payments and departments
* Added tests
* Refactoring

## 1.1.0
* Added changelog
* Added methods to manage categories, warehouses and recurring invoices
* Added getWarehouseDocuments method
* Fix getClientByExternalId method
* Deleted getInvoiceByClientId method. Use getInvoices method with parameter "client_id" instead.
* Updated descriptions

## 1.0.3
* Fixed token validation

## 1.0.2
* Updated readme
* Removed unnecessary constructor override
* Fixed methods parameters
* Fixed token validation

## 1.0.1
* Updated readme
* Added methods to check response status

## 1.0.0
* Init project
