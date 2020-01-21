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
     * @var FakturowniaApiUrlGenerator
     */
    protected $apiUrlGenerator;

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
        $this->apiUrlGenerator = new FakturowniaApiUrlGenerator($username);
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
        $url = $this->apiUrlGenerator->urlGetInvoices();
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
        $url = $this->apiUrlGenerator->urlGetInvoice($id);
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
        $url = $this->apiUrlGenerator->urlCreateInvoice();
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
        $url = $this->apiUrlGenerator->urlUpdateInvoice($id);
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
        $url = $this->apiUrlGenerator->urlDeleteInvoice($id);
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
        $url = $this->apiUrlGenerator->urlSendInvoice($id);
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
        $url = $this->apiUrlGenerator->urlChangeInvoiceStatus($id);
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
        $url = $this->apiUrlGenerator->urlGetRecurringInvoices();
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
        $url = $this->apiUrlGenerator->urlCreateRecurringInvoice();
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
        $url = $this->apiUrlGenerator->urlUpdateRecurringInvoice($id);
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
        $url = $this->apiUrlGenerator->urlGetClients();
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
        $url = $this->apiUrlGenerator->urlGetClient($id);
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
        $url = $this->apiUrlGenerator->urlGetClientByExternalId();
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
        $url = $this->apiUrlGenerator->urlCreateClient();
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
        $url = $this->apiUrlGenerator->urlUpdateClient($id);
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
        $url = $this->apiUrlGenerator->urlGetProducts();
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
        $url = $this->apiUrlGenerator->urlGetProduct($id);
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
        $url = $this->apiUrlGenerator->urlCreateProduct();
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
        $url = $this->apiUrlGenerator->urlUpdateProduct($id);
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
        $url = $this->apiUrlGenerator->urlGetWarehouseDocuments();
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
        $url = $this->apiUrlGenerator->urlGetWarehouseDocument($id);
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
        $url = $this->apiUrlGenerator->urlCreateWarehouseDocument();
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
        $url = $this->apiUrlGenerator->urlUpdateWarehouseDocument($id);
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
        $url = $this->apiUrlGenerator->urlDeleteWarehouseDocument($id);
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
        $url = $this->apiUrlGenerator->urlGetWarehouses();
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
        $url = $this->apiUrlGenerator->urlGetWarehouse($id);
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
        $url = $this->apiUrlGenerator->urlCreateWarehouse();
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
        $url = $this->apiUrlGenerator->urlUpdateWarehouse($id);
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
        $url = $this->apiUrlGenerator->urlDeleteWarehouse($id);
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
        $url = $this->apiUrlGenerator->urlGetCategories();
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
        $url = $this->apiUrlGenerator->urlGetCategory($id);
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
        $url = $this->apiUrlGenerator->urlCreateCategory();
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
        $url = $this->apiUrlGenerator->urlUpdateCategory($id);
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
        $url = $this->apiUrlGenerator->urlDeleteCategory($id);
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
        $url = $this->apiUrlGenerator->urlGetAccount();
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
        $url = $this->apiUrlGenerator->urlCreateAccountForClient();
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
}
