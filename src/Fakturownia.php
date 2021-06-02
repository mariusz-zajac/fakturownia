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
    protected $baseUrl;

    /**
     * Constructor
     *
     * @param string                   $apiToken   Fakturownia API token with prefix
     * @param RestClientInterface|null $restClient REST client
     */
    public function __construct(string $apiToken, RestClientInterface $restClient = null)
    {
        (new FakturowniaTokenValidator())->isValidTokenOrFail($apiToken);
        $this->apiToken = $apiToken;
        $this->restClient = $restClient ?: new FakturowniaRestClient();
        $subdomain = explode('/', $this->apiToken)[1];
        $this->baseUrl = sprintf('https://%s.fakturownia.pl', $subdomain);
    }

    /**
     * Login
     *
     * @deprecated This method is deprecated and may be removed in next major release.
     *
     * @param string $login    Login or e-mail
     * @param string $password Password
     *
     * @return ResponseInterface
     *
     * @throws Exception\RequestErrorException
     */
    public function login(string $login, string $password): ResponseInterface
    {
        $data = [
            'login' => $login,
            'password' => $password,
        ];

        return $this->restClient->post('https://app.fakturownia.pl/login.json', $data);
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
    public function getInvoices(array $params = []): ResponseInterface
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
    public function getInvoice(int $id): ResponseInterface
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
    public function createInvoice(array $invoice): ResponseInterface
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
    public function updateInvoice(int $id, array $invoice): ResponseInterface
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
    public function deleteInvoice(int $id): ResponseInterface
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
    public function sendInvoice(int $id): ResponseInterface
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
    public function changeInvoiceStatus(int $id, string $status): ResponseInterface
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
    public function getRecurringInvoices(array $params = []): ResponseInterface
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
    public function createRecurringInvoice(array $recurringInvoice): ResponseInterface
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
    public function updateRecurringInvoice(int $id, array $recurringInvoice): ResponseInterface
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
    public function getClients(array $params = []): ResponseInterface
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
    public function getClient(int $id): ResponseInterface
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
    public function getClientByExternalId(int $id): ResponseInterface
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
    public function createClient(array $client): ResponseInterface
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
    public function updateClient(int $id, array $client): ResponseInterface
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
    public function getProducts(array $params = []): ResponseInterface
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
    public function getProduct(int $id, int $warehouseId = null): ResponseInterface
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
    public function createProduct(array $product): ResponseInterface
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
    public function updateProduct(int $id, array $product)
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
    public function getWarehouseDocuments(array $params = []): ResponseInterface
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
    public function getWarehouseDocument(int $id): ResponseInterface
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
    public function createWarehouseDocument(array $warehouseDocument): ResponseInterface
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
    public function updateWarehouseDocument(int $id, array $warehouseDocument): ResponseInterface
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
    public function deleteWarehouseDocument(int $id): ResponseInterface
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
    public function getWarehouses(array $params = []): ResponseInterface
    {
        $url = $this->baseUrl . '/warehouses.json';
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
    public function getWarehouse(int $id): ResponseInterface
    {
        $url = $this->baseUrl . '/warehouses/' . $id . '.json';
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
    public function createWarehouse(array $warehouse): ResponseInterface
    {
        $url = $this->baseUrl . '/warehouses.json';
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
    public function updateWarehouse(int $id, array $warehouse): ResponseInterface
    {
        $url = $this->baseUrl . '/warehouses/' . $id . '.json';
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
    public function deleteWarehouse(int $id): ResponseInterface
    {
        $url = $this->baseUrl . '/warehouses/' . $id . '.json';
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
    public function getCategories(array $params = []): ResponseInterface
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
    public function getCategory(int $id): ResponseInterface
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
    public function createCategory(array $category): ResponseInterface
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
    public function updateCategory(int $id, array $category): ResponseInterface
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
    public function deleteCategory(int $id): ResponseInterface
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
    public function getAccount(): ResponseInterface
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
    public function createAccountForClient(array $account, array $user = [], array $company = []): ResponseInterface
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
    public function getPayments(array $params = []): ResponseInterface
    {
        $url = $this->baseUrl . '/banking/payments.json';
        $params['api_token'] = $this->apiToken;

        return $this->restClient->get($url, $params);
    }

    /**
     * Get payment
     *
     * @param int   $id     Payment ID
     * @param array $params Parameters
     *
     * @return ResponseInterface
     *
     * @throws Exception\RequestErrorException
     */
    public function getPayment(int $id, array $params = []): ResponseInterface
    {
        $url = $this->baseUrl . '/banking/payments/' . $id . '.json';
        $params['api_token'] = $this->apiToken;

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
    public function createPayment(array $payment): ResponseInterface
    {
        $url = $this->baseUrl . '/banking/payments.json';
        $data = [
            'banking_payment' => $payment,
            'api_token' => $this->apiToken,
        ];

        return $this->restClient->post($url, $data);
    }

    /**
     * Update payment
     *
     * @param int   $id      Payment ID
     * @param array $payment Payment data
     *
     * @return ResponseInterface
     *
     * @throws Exception\RequestErrorException
     */
    public function updatePayment(int $id, array $payment): ResponseInterface
    {
        $url = $this->baseUrl . '/banking/payments/' . $id . '.json';
        $data = [
            'banking_payment' => $payment,
            'api_token' => $this->apiToken,
        ];

        return $this->restClient->put($url, $data);
    }

    /**
     * Delete payment
     *
     * @param int $id Payment ID
     *
     * @return ResponseInterface
     *
     * @throws Exception\RequestErrorException
     */
    public function deletePayment(int $id): ResponseInterface
    {
        $url = $this->baseUrl . '/banking/payments/' . $id . '.json';
        $params = [
            'api_token' => $this->apiToken,
        ];

        return $this->restClient->delete($url, $params);
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
    public function getDepartments(array $params = []): ResponseInterface
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
    public function getDepartment(int $id): ResponseInterface
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
     * @param array $department Department data
     *
     * @return ResponseInterface
     *
     * @throws Exception\RequestErrorException
     */
    public function createDepartment(array $department): ResponseInterface
    {
        $url = $this->baseUrl . '/departments.json';
        $data = [
            'department' => $department,
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
    public function updateDepartment(int $id, array $department): ResponseInterface
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
    public function deleteDepartment(int $id): ResponseInterface
    {
        $url = $this->baseUrl . '/departments/' . $id . '.json';
        $params = [
            'api_token' => $this->apiToken,
        ];

        return $this->restClient->delete($url, $params);
    }
}
