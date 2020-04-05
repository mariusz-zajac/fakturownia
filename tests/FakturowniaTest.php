<?php

namespace Abb\Fakturownia\Tests;

use Abb\Fakturownia\Fakturownia;
use Abb\Fakturownia\FakturowniaResponse;
use PHPUnit\Framework\MockObject\MockObject;
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
     * @return MockObject
     */
    private function mockRestClient(): MockObject
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

    public function testCreateFakturowniaWithInvalidToken(): void
    {
        $this->expectException('Abb\Fakturownia\Exception\InvalidTokenException');
        new Fakturownia('invalid_token');
    }

    public function testLogin(): void
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

    public function testGetInvoices(): void
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

    public function testGetInvoice(): void
    {
        $responseData = [
            'api_token' => $this->apiToken,
            'url' => 'https://username.fakturownia.pl/invoices/123.json',
        ];
        $response = $this->fakturownia->getInvoice(123);
        self::assertEquals(200, $response->getCode());
        self::assertEquals($responseData, $response->getData());
    }

    public function testCreateInvoice(): void
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

    public function testUpdateInvoice(): void
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

    public function testDeleteInvoice(): void
    {
        $responseData = [
            'api_token' => $this->apiToken,
            'url' => 'https://username.fakturownia.pl/invoices/123.json',
        ];
        $response = $this->fakturownia->deleteInvoice(123);
        self::assertEquals(203, $response->getCode());
        self::assertEquals($responseData, $response->getData());
    }

    public function testSendInvoice(): void
    {
        $responseData = [
            'api_token' => $this->apiToken,
            'url' => 'https://username.fakturownia.pl/invoices/123/send_by_email.json',
        ];
        $response = $this->fakturownia->sendInvoice(123);
        self::assertEquals(201, $response->getCode());
        self::assertEquals($responseData, $response->getData());
    }

    public function testChangeInvoiceStatus(): void
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

    public function testGetRecurringInvoices(): void
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

    public function testCreateRecurringInvoice(): void
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

    public function testUpdateRecurringInvoice(): void
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

    public function testGetClients(): void
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

    public function testGetClient(): void
    {
        $responseData = [
            'api_token' => $this->apiToken,
            'url' => 'https://username.fakturownia.pl/clients/123.json',
        ];
        $response = $this->fakturownia->getClient(123);
        self::assertEquals(200, $response->getCode());
        self::assertEquals($responseData, $response->getData());
    }

    public function testGetClientByExternalId(): void
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

    public function testCreateClient(): void
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

    public function testUpdateClient(): void
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

    public function testGetProducts(): void
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

    public function testGetProduct(): void
    {
        $responseData = [
            'api_token' => $this->apiToken,
            'url' => 'https://username.fakturownia.pl/products/123.json',
        ];
        $response = $this->fakturownia->getProduct(123);
        self::assertEquals(200, $response->getCode());
        self::assertEquals($responseData, $response->getData());
    }

    public function testGetProductWithWarehouse(): void
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

    public function testCreateProduct(): void
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

    public function testUpdateProduct(): void
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

    public function testGetWarehouseDocuments(): void
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

    public function testGetWarehouseDocument(): void
    {
        $responseData = [
            'api_token' => $this->apiToken,
            'url' => 'https://username.fakturownia.pl/warehouse_documents/123.json',
        ];
        $response = $this->fakturownia->getWarehouseDocument(123);
        self::assertEquals(200, $response->getCode());
        self::assertEquals($responseData, $response->getData());
    }

    public function testCreateWarehouseDocument(): void
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

    public function testUpdateWarehouseDocument(): void
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

    public function testDeleteWarehouseDocument(): void
    {
        $responseData = [
            'api_token' => $this->apiToken,
            'url' => 'https://username.fakturownia.pl/warehouse_documents/123.json',
        ];
        $response = $this->fakturownia->deleteWarehouseDocument(123);
        self::assertEquals(203, $response->getCode());
        self::assertEquals($responseData, $response->getData());
    }

    public function testGetWarehouses(): void
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

    public function testGetWarehouse(): void
    {
        $responseData = [
            'api_token' => $this->apiToken,
            'url' => 'https://username.fakturownia.pl/warehouse/123.json',
        ];
        $response = $this->fakturownia->getWarehouse(123);
        self::assertEquals(200, $response->getCode());
        self::assertEquals($responseData, $response->getData());
    }

    public function testCreateWarehouse(): void
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

    public function testUpdateWarehouse(): void
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

    public function testDeleteWarehouse(): void
    {
        $responseData = [
            'api_token' => $this->apiToken,
            'url' => 'https://username.fakturownia.pl/warehouse/123.json',
        ];
        $response = $this->fakturownia->deleteWarehouse(123);
        self::assertEquals(203, $response->getCode());
        self::assertEquals($responseData, $response->getData());
    }

    public function testGetCategories(): void
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

    public function testGetCategory(): void
    {
        $responseData = [
            'api_token' => $this->apiToken,
            'url' => 'https://username.fakturownia.pl/categories/123.json',
        ];
        $response = $this->fakturownia->getCategory(123);
        self::assertEquals(200, $response->getCode());
        self::assertEquals($responseData, $response->getData());
    }

    public function testCreateCategory(): void
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

    public function testUpdateCategory(): void
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

    public function testDeleteCategory(): void
    {
        $responseData = [
            'api_token' => $this->apiToken,
            'url' => 'https://username.fakturownia.pl/categories/123.json',
        ];
        $response = $this->fakturownia->deleteCategory(123);
        self::assertEquals(203, $response->getCode());
        self::assertEquals($responseData, $response->getData());
    }

    public function testGetAccount(): void
    {
        $responseData = [
            'api_token' => $this->apiToken,
            'url' => 'https://username.fakturownia.pl/account.json',
        ];
        $response = $this->fakturownia->getAccount(123);
        self::assertEquals(200, $response->getCode());
        self::assertEquals($responseData, $response->getData());
    }

    public function testCreateAccountForClient(): void
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

    public function testGetPayments(): void
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

    public function testGetPayment(): void
    {
        $responseData = [
            'api_token' => $this->apiToken,
            'url' => 'https://username.fakturownia.pl/banking/payments/123.json',
        ];
        $response = $this->fakturownia->getPayment(123);
        self::assertEquals(200, $response->getCode());
        self::assertEquals($responseData, $response->getData());
    }

    public function testCreatePayment(): void
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

    public function testGetDepartments(): void
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

    public function testGetDepartment(): void
    {
        $responseData = [
            'api_token' => $this->apiToken,
            'url' => 'https://username.fakturownia.pl/departments/123.json',
        ];
        $response = $this->fakturownia->getDepartment(123);
        self::assertEquals(200, $response->getCode());
        self::assertEquals($responseData, $response->getData());
    }

    public function testCreateDepartment(): void
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

    public function testUpdateDepartment(): void
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

    public function testDeleteDepartment(): void
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
