<?php

namespace Abb\Fakturownia\Tests;

use Abb\Fakturownia\Fakturownia;
use Abb\Fakturownia\FakturowniaResponse;
use PHPUnit\Framework\TestCase;

class FakturowniaTest  extends TestCase
{

    /**
     * @var string
     */
    private $apiToken = '123456/username';

    /**
     * @var Fakturownia
     */
    private $fakturownia;

    /**
     * {@inheritDoc}
     */
    protected function setUp()
    {
        parent::setUp();
        $this->fakturownia = new Fakturownia($this->apiToken, $this->mockRestClient());
    }

    /**
     * {@inheritDoc}
     */
    protected function tearDown()
    {
        parent::tearDown();
        unset($this->fakturownia);
    }

    /**
     * Mock REST client
     *
     * @return \PHPUnit_Framework_MockObject_MockObject
     */
    private function mockRestClient()
    {
        $restClient = $this->createMock('Abb\Fakturownia\RestClientInterface');

        $responseCallback = function ($code) {
            return function ($url, array $params) use ($code) {
                $params['url'] = $url;
                return new FakturowniaResponse($code, $params);
            };
        };

        $restClient->expects($this->any())
            ->method('get')
            ->willReturnCallback($responseCallback(200));

        $restClient->expects($this->any())
            ->method('post')
            ->willReturnCallback($responseCallback(201));

        $restClient->expects($this->any())
            ->method('put')
            ->willReturnCallback($responseCallback(202));

        $restClient->expects($this->any())
            ->method('delete')
            ->willReturnCallback($responseCallback(203));

        return $restClient;
    }

    public function testCreateFakturowniaWithInvalidToken()
    {
        self::expectException('Abb\Fakturownia\Exception\InvalidTokenException');
        new Fakturownia('invalid_token');
    }

    public function testLogin()
    {
        $responseData = [
            'login' => 'john_doe',
            'password' => 'p4ssw0rd!',
            'url' => 'https://app.fakturownia.pl/login.json',
        ];
        $response = $this->fakturownia->login('john_doe', 'p4ssw0rd!');
        self::assertEquals(201, $response->getCode());
        self::assertEquals($responseData, $response->getData());
    }

    public function testGetInvoices()
    {
        $params = [
            'period' => 'this_month',
        ];
        $responseData = [
            'period' => 'this_month',
            'api_token' => $this->apiToken,
            'url' => 'https://username.fakturownia.pl/invoices.json',
        ];
        $response = $this->fakturownia->getInvoices($params);
        self::assertEquals(200, $response->getCode());
        self::assertEquals($responseData, $response->getData());
    }

    public function testGetInvoice()
    {
        $responseData = [
            'api_token' => $this->apiToken,
            'url' => 'https://username.fakturownia.pl/invoices/123.json',
        ];
        $response = $this->fakturownia->getInvoice(123);
        self::assertEquals(200, $response->getCode());
        self::assertEquals($responseData, $response->getData());
    }

    public function testCreateInvoice()
    {
        $params = [
            'name' => 'Test',
        ];
        $responseData = [
            'invoice' => $params,
            'api_token' => $this->apiToken,
            'url' => 'https://username.fakturownia.pl/invoices.json',
        ];
        $response = $this->fakturownia->createInvoice($params);
        self::assertEquals(201, $response->getCode());
        self::assertEquals($responseData, $response->getData());
    }

    public function testUpdateInvoice()
    {
        $params = [
            'name' => 'Test',
        ];
        $responseData = [
            'invoice' => $params,
            'api_token' => $this->apiToken,
            'url' => 'https://username.fakturownia.pl/invoices/123.json',
        ];
        $response = $this->fakturownia->updateInvoice(123, $params);
        self::assertEquals(202, $response->getCode());
        self::assertEquals($responseData, $response->getData());
    }

    public function testDeleteInvoice()
    {
        $responseData = [
            'api_token' => $this->apiToken,
            'url' => 'https://username.fakturownia.pl/invoices/123.json',
        ];
        $response = $this->fakturownia->deleteInvoice(123);
        self::assertEquals(203, $response->getCode());
        self::assertEquals($responseData, $response->getData());
    }

    public function testSendInvoice()
    {
        $responseData = [
            'api_token' => $this->apiToken,
            'url' => 'https://username.fakturownia.pl/invoices/123/send_by_email.json',
        ];
        $response = $this->fakturownia->sendInvoice(123);
        self::assertEquals(201, $response->getCode());
        self::assertEquals($responseData, $response->getData());
    }

    public function testChangeInvoiceStatus()
    {
        $responseData = [
            'status' => 'new',
            'api_token' => $this->apiToken,
            'url' => 'https://username.fakturownia.pl/invoices/123/change_status.json',
        ];
        $response = $this->fakturownia->changeInvoiceStatus(123, 'new');
        self::assertEquals(201, $response->getCode());
        self::assertEquals($responseData, $response->getData());
    }

    public function testGetRecurringInvoices()
    {
        $params = [
            'period' => 'this_month',
        ];
        $responseData = [
            'period' => 'this_month',
            'api_token' => $this->apiToken,
            'url' => 'https://username.fakturownia.pl/recurrings.json',
        ];
        $response = $this->fakturownia->getRecurringInvoices($params);
        self::assertEquals(200, $response->getCode());
        self::assertEquals($responseData, $response->getData());
    }

    public function testCreateRecurringInvoice()
    {
        $params = [
            'name' => 'Test',
        ];
        $responseData = [
            'recurring' => $params,
            'api_token' => $this->apiToken,
            'url' => 'https://username.fakturownia.pl/recurrings.json',
        ];
        $response = $this->fakturownia->createRecurringInvoice($params);
        self::assertEquals(201, $response->getCode());
        self::assertEquals($responseData, $response->getData());
    }

    public function testUpdateRecurringInvoice()
    {
        $params = [
            'name' => 'Test',
        ];
        $responseData = [
            'recurring' => $params,
            'api_token' => $this->apiToken,
            'url' => 'https://username.fakturownia.pl/recurrings/123.json',
        ];
        $response = $this->fakturownia->updateRecurringInvoice(123, $params);
        self::assertEquals(202, $response->getCode());
        self::assertEquals($responseData, $response->getData());
    }

    public function testGetClients()
    {
        $params = [
            'page' => '1',
        ];
        $responseData = [
            'page' => '1',
            'api_token' => $this->apiToken,
            'url' => 'https://username.fakturownia.pl/clients.json',
        ];
        $response = $this->fakturownia->getClients($params);
        self::assertEquals(200, $response->getCode());
        self::assertEquals($responseData, $response->getData());
    }

    public function testGetClient()
    {
        $responseData = [
            'api_token' => $this->apiToken,
            'url' => 'https://username.fakturownia.pl/clients/123.json',
        ];
        $response = $this->fakturownia->getClient(123);
        self::assertEquals(200, $response->getCode());
        self::assertEquals($responseData, $response->getData());
    }

    public function testGetClientByExternalId()
    {
        $responseData = [
            'external_id' => 123,
            'api_token' => $this->apiToken,
            'url' => 'https://username.fakturownia.pl/clients.json',
        ];
        $response = $this->fakturownia->getClientByExternalId(123);
        self::assertEquals(200, $response->getCode());
        self::assertEquals($responseData, $response->getData());
    }

    public function testCreateClient()
    {
        $params = [
            'name' => 'John Doe',
        ];
        $responseData = [
            'client' => $params,
            'api_token' => $this->apiToken,
            'url' => 'https://username.fakturownia.pl/clients.json',
        ];
        $response = $this->fakturownia->createClient($params);
        self::assertEquals(201, $response->getCode());
        self::assertEquals($responseData, $response->getData());
    }

    public function testUpdateClient()
    {
        $params = [
            'name' => 'John Doe',
        ];
        $responseData = [
            'client' => $params,
            'api_token' => $this->apiToken,
            'url' => 'https://username.fakturownia.pl/clients/123.json',
        ];
        $invoice = $this->fakturownia->updateClient(123, $params);
        self::assertEquals(202, $invoice->getCode());
        self::assertEquals($responseData, $invoice->getData());
    }

    public function testGetProducts()
    {
        $params = [
            'page' => '1',
        ];
        $responseData = [
            'page' => '1',
            'api_token' => $this->apiToken,
            'url' => 'https://username.fakturownia.pl/products.json',
        ];
        $response = $this->fakturownia->getProducts($params);
        self::assertEquals(200, $response->getCode());
        self::assertEquals($responseData, $response->getData());
    }

    public function testGetProduct()
    {
        $responseData = [
            'api_token' => $this->apiToken,
            'url' => 'https://username.fakturownia.pl/products/123.json',
        ];
        $response = $this->fakturownia->getProduct(123);
        self::assertEquals(200, $response->getCode());
        self::assertEquals($responseData, $response->getData());
    }

    public function testGetProductWithWarehouse()
    {
        $responseData = [
            'warehouse_id' => 321,
            'api_token' => $this->apiToken,
            'url' => 'https://username.fakturownia.pl/products/123.json',
        ];
        $response = $this->fakturownia->getProduct(123, 321);
        self::assertEquals(200, $response->getCode());
        self::assertEquals($responseData, $response->getData());
    }

    public function testCreateProduct()
    {
        $params = [
            'name' => 'Test',
        ];
        $responseData = [
            'product' => $params,
            'api_token' => $this->apiToken,
            'url' => 'https://username.fakturownia.pl/products.json',
        ];
        $response = $this->fakturownia->createProduct($params);
        self::assertEquals(201, $response->getCode());
        self::assertEquals($responseData, $response->getData());
    }

    public function testUpdateProduct()
    {
        $params = [
            'name' => 'Test',
        ];
        $responseData = [
            'product' => $params,
            'api_token' => $this->apiToken,
            'url' => 'https://username.fakturownia.pl/products/123.json',
        ];
        $invoice = $this->fakturownia->updateProduct(123, $params);
        self::assertEquals(202, $invoice->getCode());
        self::assertEquals($responseData, $invoice->getData());
    }

    public function testGetWarehouseDocuments()
    {
        $params = [
            'page' => '1',
        ];
        $responseData = [
            'page' => '1',
            'api_token' => $this->apiToken,
            'url' => 'https://username.fakturownia.pl/warehouse_documents.json',
        ];
        $response = $this->fakturownia->getWarehouseDocuments($params);
        self::assertEquals(200, $response->getCode());
        self::assertEquals($responseData, $response->getData());
    }

    public function testGetWarehouseDocument()
    {
        $responseData = [
            'api_token' => $this->apiToken,
            'url' => 'https://username.fakturownia.pl/warehouse_documents/123.json',
        ];
        $response = $this->fakturownia->getWarehouseDocument(123);
        self::assertEquals(200, $response->getCode());
        self::assertEquals($responseData, $response->getData());
    }

    public function testCreateWarehouseDocument()
    {
        $params = [
            'name' => 'Test',
        ];
        $responseData = [
            'warehouse_document' => $params,
            'api_token' => $this->apiToken,
            'url' => 'https://username.fakturownia.pl/warehouse_documents.json',
        ];
        $response = $this->fakturownia->createWarehouseDocument($params);
        self::assertEquals(201, $response->getCode());
        self::assertEquals($responseData, $response->getData());
    }

    public function testUpdateWarehouseDocument()
    {
        $params = [
            'name' => 'Test',
        ];
        $responseData = [
            'warehouse_document' => $params,
            'api_token' => $this->apiToken,
            'url' => 'https://username.fakturownia.pl/warehouse_documents/123.json',
        ];
        $invoice = $this->fakturownia->updateWarehouseDocument(123, $params);
        self::assertEquals(202, $invoice->getCode());
        self::assertEquals($responseData, $invoice->getData());
    }

    public function testDeleteWarehouseDocument()
    {
        $responseData = [
            'api_token' => $this->apiToken,
            'url' => 'https://username.fakturownia.pl/warehouse_documents/123.json',
        ];
        $response = $this->fakturownia->deleteWarehouseDocument(123);
        self::assertEquals(203, $response->getCode());
        self::assertEquals($responseData, $response->getData());
    }

    public function testGetWarehouses()
    {
        $params = [
            'page' => '1',
        ];
        $responseData = [
            'page' => '1',
            'api_token' => $this->apiToken,
            'url' => 'https://username.fakturownia.pl/warehouse.json',
        ];
        $response = $this->fakturownia->getWarehouses($params);
        self::assertEquals(200, $response->getCode());
        self::assertEquals($responseData, $response->getData());
    }

    public function testGetWarehouse()
    {
        $responseData = [
            'api_token' => $this->apiToken,
            'url' => 'https://username.fakturownia.pl/warehouse/123.json',
        ];
        $response = $this->fakturownia->getWarehouse(123);
        self::assertEquals(200, $response->getCode());
        self::assertEquals($responseData, $response->getData());
    }

    public function testCreateWarehouse()
    {
        $params = [
            'name' => 'Test',
        ];
        $responseData = [
            'warehouse' => $params,
            'api_token' => $this->apiToken,
            'url' => 'https://username.fakturownia.pl/warehouse.json',
        ];
        $response = $this->fakturownia->createWarehouse($params);
        self::assertEquals(201, $response->getCode());
        self::assertEquals($responseData, $response->getData());
    }

    public function testUpdateWarehouse()
    {
        $params = [
            'name' => 'Test',
        ];
        $responseData = [
            'warehouse' => $params,
            'api_token' => $this->apiToken,
            'url' => 'https://username.fakturownia.pl/warehouse/123.json',
        ];
        $invoice = $this->fakturownia->updateWarehouse(123, $params);
        self::assertEquals(202, $invoice->getCode());
        self::assertEquals($responseData, $invoice->getData());
    }

    public function testDeleteWarehouse()
    {
        $responseData = [
            'api_token' => $this->apiToken,
            'url' => 'https://username.fakturownia.pl/warehouse/123.json',
        ];
        $response = $this->fakturownia->deleteWarehouse(123);
        self::assertEquals(203, $response->getCode());
        self::assertEquals($responseData, $response->getData());
    }

    public function testGetCategories()
    {
        $params = [
            'page' => '1',
        ];
        $responseData = [
            'page' => '1',
            'api_token' => $this->apiToken,
            'url' => 'https://username.fakturownia.pl/categories.json',
        ];
        $response = $this->fakturownia->getCategories($params);
        self::assertEquals(200, $response->getCode());
        self::assertEquals($responseData, $response->getData());
    }

    public function testGetCategory()
    {
        $responseData = [
            'api_token' => $this->apiToken,
            'url' => 'https://username.fakturownia.pl/categories/123.json',
        ];
        $response = $this->fakturownia->getCategory(123);
        self::assertEquals(200, $response->getCode());
        self::assertEquals($responseData, $response->getData());
    }

    public function testCreateCategory()
    {
        $params = [
            'name' => 'Test',
        ];
        $responseData = [
            'category' => $params,
            'api_token' => $this->apiToken,
            'url' => 'https://username.fakturownia.pl/categories.json',
        ];
        $response = $this->fakturownia->createCategory($params);
        self::assertEquals(201, $response->getCode());
        self::assertEquals($responseData, $response->getData());
    }

    public function testUpdateCategory()
    {
        $params = [
            'name' => 'Test',
        ];
        $responseData = [
            'category' => $params,
            'api_token' => $this->apiToken,
            'url' => 'https://username.fakturownia.pl/categories/123.json',
        ];
        $invoice = $this->fakturownia->updateCategory(123, $params);
        self::assertEquals(202, $invoice->getCode());
        self::assertEquals($responseData, $invoice->getData());
    }

    public function testDeleteCategory()
    {
        $responseData = [
            'api_token' => $this->apiToken,
            'url' => 'https://username.fakturownia.pl/categories/123.json',
        ];
        $response = $this->fakturownia->deleteCategory(123);
        self::assertEquals(203, $response->getCode());
        self::assertEquals($responseData, $response->getData());
    }

    public function testGetAccount()
    {
        $responseData = [
            'api_token' => $this->apiToken,
            'url' => 'https://username.fakturownia.pl/account.json',
        ];
        $response = $this->fakturownia->getAccount(123);
        self::assertEquals(200, $response->getCode());
        self::assertEquals($responseData, $response->getData());
    }

    public function testCreateAccountForClient()
    {
        $account = [
            'prefix' => 'prefix1',
        ];
        $user = [
            'login' => 'login1',
        ];
        $company = [
            'name' => 'Company1',
        ];
        $responseData = [
            'account' => $account,
            'user' => $user,
            'company' => $company,
            'api_token' => $this->apiToken,
            'url' => 'https://username.fakturownia.pl/account.json',
        ];
        $response = $this->fakturownia->createAccountForClient($account, $user, $company);
        self::assertEquals(201, $response->getCode());
        self::assertEquals($responseData, $response->getData());
    }

    public function testGetPayments()
    {
        $params = [
            'page' => '1',
        ];
        $responseData = [
            'page' => '1',
            'api_token' => $this->apiToken,
            'url' => 'https://username.fakturownia.pl/banking/payments.json',
        ];
        $response = $this->fakturownia->getPayments($params);
        self::assertEquals(200, $response->getCode());
        self::assertEquals($responseData, $response->getData());
    }

    public function testGetPayment()
    {
        $responseData = [
            'api_token' => $this->apiToken,
            'url' => 'https://username.fakturownia.pl/banking/payments/123.json',
        ];
        $response = $this->fakturownia->getPayment(123);
        self::assertEquals(200, $response->getCode());
        self::assertEquals($responseData, $response->getData());
    }

    public function testCreatePayment()
    {
        $params = [
            'name' => 'Test',
        ];
        $responseData = [
            'banking_payment' => $params,
            'api_token' => $this->apiToken,
            'url' => 'https://username.fakturownia.pl/banking/payments.json',
        ];
        $response = $this->fakturownia->createPayment($params);
        self::assertEquals(201, $response->getCode());
        self::assertEquals($responseData, $response->getData());
    }

    public function testGetDepartments()
    {
        $params = [
            'page' => '1',
        ];
        $responseData = [
            'page' => '1',
            'api_token' => $this->apiToken,
            'url' => 'https://username.fakturownia.pl/departments.json',
        ];
        $response = $this->fakturownia->getDepartments($params);
        self::assertEquals(200, $response->getCode());
        self::assertEquals($responseData, $response->getData());
    }

    public function testGetDepartment()
    {
        $responseData = [
            'api_token' => $this->apiToken,
            'url' => 'https://username.fakturownia.pl/departments/123.json',
        ];
        $response = $this->fakturownia->getDepartment(123);
        self::assertEquals(200, $response->getCode());
        self::assertEquals($responseData, $response->getData());
    }

    public function testCreateDepartment()
    {
        $params = [
            'name' => 'Test',
        ];
        $responseData = [
            'department' => $params,
            'api_token' => $this->apiToken,
            'url' => 'https://username.fakturownia.pl/departments.json',
        ];
        $response = $this->fakturownia->createDepartment($params);
        self::assertEquals(201, $response->getCode());
        self::assertEquals($responseData, $response->getData());
    }

    public function testUpdateDepartment()
    {
        $params = [
            'name' => 'Test',
        ];
        $responseData = [
            'department' => $params,
            'api_token' => $this->apiToken,
            'url' => 'https://username.fakturownia.pl/departments/123.json',
        ];
        $invoice = $this->fakturownia->updateDepartment(123, $params);
        self::assertEquals(202, $invoice->getCode());
        self::assertEquals($responseData, $invoice->getData());
    }

    public function testDeleteDepartment()
    {
        $responseData = [
            'api_token' => $this->apiToken,
            'url' => 'https://username.fakturownia.pl/departments/123.json',
        ];
        $response = $this->fakturownia->deleteDepartment(123);
        self::assertEquals(203, $response->getCode());
        self::assertEquals($responseData, $response->getData());
    }
}
