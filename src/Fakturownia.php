<?php

namespace Abb\Fakturownia;

/**
 * Fakturownia client
 */
class Fakturownia
{

    /**
     * @var string
     */
    protected $apiToken;

    /**
     * @var RestClientInterface
     */
    protected $restClient;

    /**
     * @var string
     */
    protected $baseUrl = 'https://[USERNAME].fakturownia.pl';

    /**
     * @var string
     */
    protected $loginUrl = 'https://app.fakturownia.pl/login.json';

    /**
     * Constructor
     *
     * @param string                   $apiToken   Fakturownia API token
     * @param RestClientInterface|null $restClient REST client
     */
    public function __construct(
        $apiToken,
        RestClientInterface $restClient = null
    ) {
        (new FakturowniaTokenValidator())->isValidTokenOrFail($apiToken);
        $this->apiToken = $apiToken;
        $this->restClient = $restClient ?: new FakturowniaRestClient();
        $username = explode('/', $this->apiToken)[1];
        $this->baseUrl = str_replace('[USERNAME]', $username, $this->baseUrl);
    }

    /**
     * Login
     *
     * @param string $login    Login or e-mail
     * @param string $password Password
     *
     * @return ResponseInterface
     *
     * @throws Exception\RequestErrorException
     */
    public function login($login, $password)
    {
        $data = [
            'login' => $login,
            'password' => $password,
        ];

        return $this->restClient->post($this->loginUrl, $data);
    }

    /**
     * Get invoices
     *
     * @param array $params Parameters
     *
     * @return ResponseInterface
     *
     * @throws Exception\RequestErrorException
     */
    public function getInvoices(array $params = [])
    {
        $url = $this->baseUrl . '/invoices.json';
        $params['api_token'] = $this->apiToken;

        return $this->restClient->get($url, $params);
    }

    /**
     * Get invoice
     *
     * @param int $id Invoice ID
     *
     * @return ResponseInterface
     *
     * @throws Exception\RequestErrorException
     */
    public function getInvoice($id)
    {
        $url = $this->baseUrl . '/invoices/' . $id . '.json';
        $params = [
            'api_token' => $this->apiToken,
        ];

        return $this->restClient->get($url, $params);
    }

    /**
     * Create invoice
     *
     * @param array $invoice Invoice data
     *
     * @return ResponseInterface
     *
     * @throws Exception\RequestErrorException
     */
    public function createInvoice(array $invoice)
    {
        $url = $this->baseUrl . '/invoices.json';
        $data = [
            'invoice' => $invoice,
            'api_token' => $this->apiToken,
        ];

        return $this->restClient->post($url, $data);
    }

    /**
     * Update invoice
     *
     * @param int   $id      Invoice ID
     * @param array $invoice Invoice data
     *
     * @return ResponseInterface
     *
     * @throws Exception\RequestErrorException
     */
    public function updateInvoice($id, array $invoice)
    {
        $url = $this->baseUrl . '/invoices/' . $id . '.json';
        $data = [
            'invoice' => $invoice,
            'api_token' => $this->apiToken,
        ];

        return $this->restClient->put($url, $data);
    }

    /**
     * Delete invoice
     *
     * @param int $id Invoice ID
     *
     * @return ResponseInterface
     *
     * @throws Exception\RequestErrorException
     */
    public function deleteInvoice($id)
    {
        $url = $this->baseUrl . '/invoices/' . $id . '.json';
        $params = [
            'api_token' => $this->apiToken,
        ];

        return $this->restClient->delete($url, $params);
    }

    /**
     * Send invoice by e-mail to client
     *
     * @param int $id Invoice ID
     *
     * @return ResponseInterface
     *
     * @throws Exception\RequestErrorException
     */
    public function sendInvoice($id)
    {
        $url = $this->baseUrl . '/invoices/' . $id . '/send_by_email.json';
        $data = [
            'api_token' => $this->apiToken,
        ];

        return $this->restClient->post($url, $data);
    }

    /**
     * Change invoice status
     *
     * @param int    $id     Invoice ID
     * @param string $status Status
     *
     * @return ResponseInterface
     *
     * @throws Exception\RequestErrorException
     */
    public function changeInvoiceStatus($id, $status)
    {
        $url = $this->baseUrl . '/invoices/' . $id . '/change_status.json';
        $data = [
            'status' => $status,
            'api_token' => $this->apiToken,
        ];

        return $this->restClient->post($url, $data);
    }

    /**
     * Get recurring invoices
     *
     * @param array $params Parameters
     *
     * @return ResponseInterface
     *
     * @throws Exception\RequestErrorException
     */
    public function getRecurringInvoices(array $params = [])
    {
        $url = $this->baseUrl . '/recurrings.json';
        $params['api_token'] = $this->apiToken;

        return $this->restClient->get($url, $params);
    }

    /**
     * Create recurring invoice
     *
     * @param array $recurringInvoice Recurring invoice data
     *
     * @return ResponseInterface
     *
     * @throws Exception\RequestErrorException
     */
    public function createRecurringInvoice(array $recurringInvoice)
    {
        $url = $this->baseUrl . '/recurrings.json';
        $data = [
            'recurring' => $recurringInvoice,
            'api_token' => $this->apiToken,
        ];

        return $this->restClient->post($url, $data);
    }

    /**
     * Update recurring invoice
     *
     * @param int   $id               Recurring invoice ID
     * @param array $recurringInvoice Recurring invoice data
     *
     * @return ResponseInterface
     *
     * @throws Exception\RequestErrorException
     */
    public function updateRecurringInvoice($id, array $recurringInvoice)
    {
        $url = $this->baseUrl . '/recurrings/' . $id . '.json';
        $data = [
            'recurring' => $recurringInvoice,
            'api_token' => $this->apiToken,
        ];

        return $this->restClient->put($url, $data);
    }

    /**
     * Get clients
     *
     * @param array $params Parameters
     *
     * @return ResponseInterface
     *
     * @throws Exception\RequestErrorException
     */
    public function getClients(array $params = [])
    {
        $url = $this->baseUrl . '/clients.json';
        $params['api_token'] = $this->apiToken;

        return $this->restClient->get($url, $params);
    }

    /**
     * Get client
     *
     * @param int $id Client ID
     *
     * @return ResponseInterface
     *
     * @throws Exception\RequestErrorException
     */
    public function getClient($id)
    {
        $url = $this->baseUrl . '/clients/' . $id . '.json';
        $params = [
            'api_token' => $this->apiToken,
        ];

        return $this->restClient->get($url, $params);
    }

    /**
     * Get client by external ID
     *
     * @param int $id Client external ID
     *
     * @return ResponseInterface
     *
     * @throws Exception\RequestErrorException
     */
    public function getClientByExternalId($id)
    {
        $url = $this->baseUrl . '/clients.json';
        $params = [
            'external_id' => $id,
            'api_token' => $this->apiToken,
        ];

        return $this->restClient->get($url, $params);
    }

    /**
     * Create client
     *
     * @param array $client Client data
     *
     * @return ResponseInterface
     *
     * @throws Exception\RequestErrorException
     */
    public function createClient(array $client)
    {
        $url = $this->baseUrl . '/clients.json';
        $data = [
            'client' => $client,
            'api_token' => $this->apiToken,
        ];

        return $this->restClient->post($url, $data);
    }

    /**
     * Update client
     *
     * @param int   $id     Client ID
     * @param array $client Client data
     *
     * @return ResponseInterface
     *
     * @throws Exception\RequestErrorException
     */
    public function updateClient($id, array $client)
    {
        $url = $this->baseUrl . '/clients/' . $id . '.json';
        $data = [
            'client' => $client,
            'api_token' => $this->apiToken,
        ];

        return $this->restClient->put($url, $data);
    }

    /**
     * Get products
     *
     * @param array $params Parameters
     *
     * @return ResponseInterface
     *
     * @throws Exception\RequestErrorException
     */
    public function getProducts(array $params = [])
    {
        $url = $this->baseUrl . '/products.json';
        $params['api_token'] = $this->apiToken;

        return $this->restClient->get($url, $params);
    }

    /**
     * Get product
     *
     * @param int      $id          Product ID
     * @param int|null $warehouseId Warehouse ID
     *
     * @return ResponseInterface
     *
     * @throws Exception\RequestErrorException
     */
    public function getProduct($id, $warehouseId = null)
    {
        $url = $this->baseUrl . '/products/' . $id . '.json';
        $params = [
            'api_token' => $this->apiToken,
        ];

        if (null !== $warehouseId) {
            $params['warehouse_id'] = $warehouseId;
        }

        return $this->restClient->get($url, $params);
    }

    /**
     * Create product
     *
     * @param array $product Product data
     *
     * @return ResponseInterface
     *
     * @throws Exception\RequestErrorException
     */
    public function createProduct(array $product)
    {
        $url = $this->baseUrl . '/products.json';
        $data = [
            'product' => $product,
            'api_token' => $this->apiToken,
        ];

        return $this->restClient->post($url, $data);
    }

    /**
     * Update product
     *
     * @param int   $id      Product ID
     * @param array $product Product data
     *
     * @return ResponseInterface
     *
     * @throws Exception\RequestErrorException
     */
    public function updateProduct($id, array $product)
    {
        $url = $this->baseUrl . '/products/' . $id . '.json';
        $data = [
            'product' => $product,
            'api_token' => $this->apiToken,
        ];

        return $this->restClient->put($url, $data);
    }

    /**
     * Get warehouse documents
     *
     * @param array $params Parameters
     *
     * @return ResponseInterface
     *
     * @throws Exception\RequestErrorException
     */
    public function getWarehouseDocuments(array $params = [])
    {
        $url = $this->baseUrl . '/warehouse_documents.json';
        $params['api_token'] = $this->apiToken;

        return $this->restClient->get($url, $params);
    }

    /**
     * Get warehouse document
     *
     * @param int $id Warehouse document ID
     *
     * @return ResponseInterface
     *
     * @throws Exception\RequestErrorException
     */
    public function getWarehouseDocument($id)
    {
        $url = $this->baseUrl . '/warehouse_documents/' . $id . '.json';
        $params = [
            'api_token' => $this->apiToken,
        ];

        return $this->restClient->get($url, $params);
    }

    /**
     * Create warehouse document
     *
     * @param array $warehouseDocument Warehouse document data
     *
     * @return ResponseInterface
     *
     * @throws Exception\RequestErrorException
     */
    public function createWarehouseDocument(array $warehouseDocument)
    {
        $url = $this->baseUrl . '/warehouse_documents.json';
        $data = [
            'warehouse_document' => $warehouseDocument,
            'api_token' => $this->apiToken,
        ];

        return $this->restClient->post($url, $data);
    }

    /**
     * Update warehouse document
     *
     * @param int   $id                Warehouse document ID
     * @param array $warehouseDocument Warehouse document data
     *
     * @return ResponseInterface
     *
     * @throws Exception\RequestErrorException
     */
    public function updateWarehouseDocument($id, array $warehouseDocument)
    {
        $url = $this->baseUrl . '/warehouse_documents/' . $id . '.json';
        $data = [
            'warehouse_document' => $warehouseDocument,
            'api_token' => $this->apiToken,
        ];

        return $this->restClient->put($url, $data);
    }

    /**
     * Delete warehouse document
     *
     * @param int $id Warehouse document ID
     *
     * @return ResponseInterface
     *
     * @throws Exception\RequestErrorException
     */
    public function deleteWarehouseDocument($id)
    {
        $url = $this->baseUrl . '/warehouse_documents/' . $id . '.json';
        $params = [
            'api_token' => $this->apiToken,
        ];

        return $this->restClient->delete($url, $params);
    }

    /**
     * Get warehouses
     *
     * @param array $params Parameters
     *
     * @return ResponseInterface
     *
     * @throws Exception\RequestErrorException
     */
    public function getWarehouses(array $params = [])
    {
        $url = $this->baseUrl . '/warehouse.json';
        $params['api_token'] = $this->apiToken;

        return $this->restClient->get($url, $params);
    }

    /**
     * Get warehouse
     *
     * @param int $id Warehouse ID
     *
     * @return ResponseInterface
     *
     * @throws Exception\RequestErrorException
     */
    public function getWarehouse($id)
    {
        $url = $this->baseUrl . '/warehouse/' . $id . '.json';
        $params = [
            'api_token' => $this->apiToken,
        ];

        return $this->restClient->get($url, $params);
    }

    /**
     * Create warehouse
     *
     * @param array $warehouse Warehouse data
     *
     * @return ResponseInterface
     *
     * @throws Exception\RequestErrorException
     */
    public function createWarehouse(array $warehouse)
    {
        $url = $this->baseUrl . '/warehouse.json';
        $data = [
            'warehouse' => $warehouse,
            'api_token' => $this->apiToken,
        ];

        return $this->restClient->post($url, $data);
    }

    /**
     * Update warehouse
     *
     * @param int   $id        Warehouse ID
     * @param array $warehouse Warehouse data
     *
     * @return ResponseInterface
     *
     * @throws Exception\RequestErrorException
     */
    public function updateWarehouse($id, array $warehouse)
    {
        $url = $this->baseUrl . '/warehouse/' . $id . '.json';
        $data = [
            'warehouse' => $warehouse,
            'api_token' => $this->apiToken,
        ];

        return $this->restClient->put($url, $data);
    }

    /**
     * Delete warehouse
     *
     * @param int $id Warehouse ID
     *
     * @return ResponseInterface
     *
     * @throws Exception\RequestErrorException
     */
    public function deleteWarehouse($id)
    {
        $url = $this->baseUrl . '/warehouse/' . $id . '.json';
        $params = [
            'api_token' => $this->apiToken,
        ];

        return $this->restClient->delete($url, $params);
    }

    /**
     * Get categories
     *
     * @param array $params Parameters
     *
     * @return ResponseInterface
     *
     * @throws Exception\RequestErrorException
     */
    public function getCategories(array $params = [])
    {
        $url = $this->baseUrl . '/categories.json';
        $params['api_token'] = $this->apiToken;

        return $this->restClient->get($url, $params);
    }

    /**
     * Get category
     *
     * @param int $id Category ID
     *
     * @return ResponseInterface
     *
     * @throws Exception\RequestErrorException
     */
    public function getCategory($id)
    {
        $url = $this->baseUrl . '/categories/' . $id . '.json';
        $params = [
            'api_token' => $this->apiToken,
        ];

        return $this->restClient->get($url, $params);
    }

    /**
     * Create category
     *
     * @param array $category Category data
     *
     * @return ResponseInterface
     *
     * @throws Exception\RequestErrorException
     */
    public function createCategory(array $category)
    {
        $url = $this->baseUrl . '/categories.json';
        $data = [
            'category' => $category,
            'api_token' => $this->apiToken,
        ];

        return $this->restClient->post($url, $data);
    }

    /**
     * Update category
     *
     * @param int   $id       Category ID
     * @param array $category Category data
     *
     * @return ResponseInterface
     *
     * @throws Exception\RequestErrorException
     */
    public function updateCategory($id, array $category)
    {
        $url = $this->baseUrl . '/categories/' . $id . '.json';
        $data = [
            'category' => $category,
            'api_token' => $this->apiToken,
        ];

        return $this->restClient->put($url, $data);
    }

    /**
     * Delete category
     *
     * @param int $id Category ID
     *
     * @return ResponseInterface
     *
     * @throws Exception\RequestErrorException
     */
    public function deleteCategory($id)
    {
        $url = $this->baseUrl . '/categories/' . $id . '.json';
        $params = [
            'api_token' => $this->apiToken,
        ];

        return $this->restClient->delete($url, $params);
    }

    /**
     * Get account
     *
     * @return ResponseInterface
     *
     * @throws Exception\RequestErrorException
     */
    public function getAccount()
    {
        $url = $this->baseUrl . '/account.json';
        $params = [
            'api_token' => $this->apiToken,
        ];

        return $this->restClient->get($url, $params);
    }

    /**
     * Create account for client
     *
     * @param array $account Account data
     * @param array $user    User data
     * @param array $company Company data
     *
     * @return ResponseInterface
     *
     * @throws Exception\RequestErrorException
     */
    public function createAccountForClient(array $account, array $user = [], array $company = [])
    {
        $url = $this->baseUrl . '/account.json';
        $data = [
            'account' => $account,
            'api_token' => $this->apiToken,
        ];

        if (!empty($user)) {
            $data['user'] = $user;
        }

        if (!empty($company)) {
            $data['company'] = $company;
        }

        return $this->restClient->post($url, $data);
    }

    /**
     * Get payments
     *
     * @param array $params Parameters
     *
     * @return ResponseInterface
     *
     * @throws Exception\RequestErrorException
     */
    public function getPayments(array $params = [])
    {
        $url = $this->baseUrl . '/banking/payments.json';
        $params['api_token'] = $this->apiToken;

        return $this->restClient->get($url, $params);
    }

    /**
     * Get payment
     *
     * @param int $id Payment ID
     *
     * @return ResponseInterface
     *
     * @throws Exception\RequestErrorException
     */
    public function getPayment($id)
    {
        $url = $this->baseUrl . '/banking/payments/' . $id . '.json';
        $params = [
            'api_token' => $this->apiToken,
        ];

        return $this->restClient->get($url, $params);
    }

    /**
     * Create payment
     *
     * @param array $payment Payment data
     *
     * @return ResponseInterface
     *
     * @throws Exception\RequestErrorException
     */
    public function createPayment(array $payment)
    {
        $url = $this->baseUrl . '/banking/payments.json';
        $data = [
            'banking_payment' => $payment,
            'api_token' => $this->apiToken,
        ];

        return $this->restClient->post($url, $data);
    }

    /**
     * Get departments
     *
     * @param array $params Parameters
     *
     * @return ResponseInterface
     *
     * @throws Exception\RequestErrorException
     */
    public function getDepartments(array $params = [])
    {
        $url = $this->baseUrl . '/departments.json';
        $params['api_token'] = $this->apiToken;

        return $this->restClient->get($url, $params);
    }

    /**
     * Get department
     *
     * @param int $id Department ID
     *
     * @return ResponseInterface
     *
     * @throws Exception\RequestErrorException
     */
    public function getDepartment($id)
    {
        $url = $this->baseUrl . '/departments/' . $id . '.json';
        $params = [
            'api_token' => $this->apiToken,
        ];

        return $this->restClient->get($url, $params);
    }

    /**
     * Create department
     *
     * @param array $payment Department data
     *
     * @return ResponseInterface
     *
     * @throws Exception\RequestErrorException
     */
    public function createDepartment(array $payment)
    {
        $url = $this->baseUrl . '/departments.json';
        $data = [
            'department' => $payment,
            'api_token' => $this->apiToken,
        ];

        return $this->restClient->post($url, $data);
    }

    /**
     * Update department
     *
     * @param int   $id         Department ID
     * @param array $department Department data
     *
     * @return ResponseInterface
     *
     * @throws Exception\RequestErrorException
     */
    public function updateDepartment($id, array $department)
    {
        $url = $this->baseUrl . '/departments/' . $id . '.json';
        $data = [
            'department' => $department,
            'api_token' => $this->apiToken,
        ];

        return $this->restClient->put($url, $data);
    }

    /**
     * Delete department
     *
     * @param int $id Department ID
     *
     * @return ResponseInterface
     *
     * @throws Exception\RequestErrorException
     */
    public function deleteDepartment($id)
    {
        $url = $this->baseUrl . '/departments/' . $id . '.json';
        $params = [
            'api_token' => $this->apiToken,
        ];

        return $this->restClient->delete($url, $params);
    }
}
