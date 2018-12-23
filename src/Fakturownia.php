<?php

namespace Abb\Fakturownia;

/**
 * Fakturownia client
 */
class Fakturownia extends FakturowniaAbstract
{

    /**
     * Get invoices
     *
     * @param array $params Parameters
     *
     * @return FakturowniaResponse
     *
     * @throws Exception\RequestErrorException
     */
    public function getInvoices(array $params = [])
    {
        return $this->request(__FUNCTION__, 0, $params);
    }

    /**
     * Get invoice
     *
     * @param integer $id Invoice ID
     *
     * @return FakturowniaResponse
     *
     * @throws Exception\RequestErrorException
     */
    public function getInvoice($id)
    {
        return $this->request(__FUNCTION__, $id);
    }

    /**
     * Create invoice
     *
     * @param array $invoice Invoice data
     *
     * @return FakturowniaResponse
     *
     * @throws Exception\RequestErrorException
     */
    public function createInvoice(array $invoice)
    {
        $data = [
            'invoice' => $invoice,
        ];

        return $this->request(__FUNCTION__, 0, $data);
    }

    /**
     * Update invoice
     *
     * @param integer $id      Invoice ID
     * @param array   $invoice Invoice data
     *
     * @return FakturowniaResponse
     *
     * @throws Exception\RequestErrorException
     */
    public function updateInvoice($id, array $invoice)
    {
        $data = [
            'invoice' => $invoice,
        ];

        return $this->request(__FUNCTION__, $id, $data);
    }

    /**
     * Delete invoice
     *
     * @param integer $id Invoice ID
     *
     * @return FakturowniaResponse
     *
     * @throws Exception\RequestErrorException
     */
    public function deleteInvoice($id)
    {
        return $this->request(__FUNCTION__, $id);
    }

    /**
     * Send invoice by e-mail to client
     *
     * @param integer $id Invoice ID
     *
     * @return FakturowniaResponse
     *
     * @throws Exception\RequestErrorException
     */
    public function sendInvoice($id)
    {
        return $this->request(__FUNCTION__, $id);
    }

    /**
     * Change invoice status
     *
     * @param integer $id     Invoice ID
     * @param string  $status Status
     *
     * @return FakturowniaResponse
     *
     * @throws Exception\RequestErrorException
     */
    public function changeInvoiceStatus($id, $status)
    {
        $data = [
            'status' => $status,
        ];

        return $this->request(__FUNCTION__, $id, $data);
    }

    /**
     * Get recurring invoices
     *
     * @param array $params Parameters
     *
     * @return FakturowniaResponse
     *
     * @throws Exception\RequestErrorException
     */
    public function getRecurringInvoices(array $params = [])
    {
        return $this->request(__FUNCTION__, 0, $params);
    }

    /**
     * Create recurring invoice
     *
     * @param array $recurringInvoice Recurring invoice data
     *
     * @return FakturowniaResponse
     *
     * @throws Exception\RequestErrorException
     */
    public function createRecurringInvoice(array $recurringInvoice)
    {
        $data = [
            'recurring' => $recurringInvoice,
        ];

        return $this->request(__FUNCTION__, 0, $data);
    }

    /**
     * Update recurring invoice
     *
     * @param integer $id               Recurring invoice ID
     * @param array   $recurringInvoice Recurring invoice data
     *
     * @return FakturowniaResponse
     *
     * @throws Exception\RequestErrorException
     */
    public function updateRecurringInvoice($id, array $recurringInvoice)
    {
        $data = [
            'recurring' => $recurringInvoice,
        ];

        return $this->request(__FUNCTION__, $id, $data);
    }

    /**
     * Get clients
     *
     * @param array $params Parameters
     *
     * @return FakturowniaResponse
     *
     * @throws Exception\RequestErrorException
     */
    public function getClients(array $params = [])
    {
        return $this->request(__FUNCTION__, 0, $params);
    }

    /**
     * Get client
     *
     * @param integer $id Client ID
     *
     * @return FakturowniaResponse
     *
     * @throws Exception\RequestErrorException
     */
    public function getClient($id)
    {
        return $this->request(__FUNCTION__, $id);
    }

    /**
     * Get client by external ID
     *
     * @param integer $id Client external ID
     *
     * @return FakturowniaResponse
     *
     * @throws Exception\RequestErrorException
     */
    public function getClientByExternalId($id)
    {
        $data = [
            'external_id' => $id,
        ];

        return $this->request(__FUNCTION__, 0, $data);
    }

    /**
     * Create client
     *
     * @param array $client Client data
     *
     * @return FakturowniaResponse
     *
     * @throws Exception\RequestErrorException
     */
    public function createClient(array $client)
    {
        $data = [
            'client' => $client,
        ];

        return $this->request(__FUNCTION__, 0, $data);
    }

    /**
     * Update client
     *
     * @param integer $id     Client ID
     * @param array   $client Client data
     *
     * @return FakturowniaResponse
     *
     * @throws Exception\RequestErrorException
     */
    public function updateClient($id, array $client)
    {
        $data = [
            'client' => $client,
        ];

        return $this->request(__FUNCTION__, $id, $data);
    }

    /**
     * Get products
     *
     * @param array $params Parameters
     *
     * @return FakturowniaResponse
     *
     * @throws Exception\RequestErrorException
     */
    public function getProducts(array $params = [])
    {
        return $this->request(__FUNCTION__, 0, $params);
    }

    /**
     * Get product
     *
     * @param integer      $id          Product ID
     * @param integer|null $warehouseId Warehouse ID
     *
     * @return FakturowniaResponse
     *
     * @throws Exception\RequestErrorException
     */
    public function getProduct($id, $warehouseId = null)
    {
        $data = [];

        if (null !== $warehouseId) {
            $data['warehouse_id'] = $warehouseId;
        }

        return $this->request(__FUNCTION__, $id, $data);
    }

    /**
     * Create product
     *
     * @param array $product Product data
     *
     * @return FakturowniaResponse
     *
     * @throws Exception\RequestErrorException
     */
    public function createProduct(array $product)
    {
        $data = [
            'product' => $product
        ];

        return $this->request(__FUNCTION__, 0, $data);
    }

    /**
     * Update product
     *
     * @param integer $id      Product ID
     * @param array   $product Product data
     *
     * @return FakturowniaResponse
     *
     * @throws Exception\RequestErrorException
     */
    public function updateProduct($id, array $product)
    {
        $data = [
            'product' => $product
        ];

        return $this->request(__FUNCTION__, $id, $data);
    }

    /**
     * Get warehouse documents
     *
     * @param array $params Parameters
     *
     * @return FakturowniaResponse
     *
     * @throws Exception\RequestErrorException
     */
    public function getWarehouseDocuments(array $params = [])
    {
        return $this->request(__FUNCTION__, 0, $params);
    }

    /**
     * Get warehouse document
     *
     * @param integer $id Warehouse document ID
     *
     * @return FakturowniaResponse
     *
     * @throws Exception\RequestErrorException
     */
    public function getWarehouseDocument($id)
    {
        return $this->request(__FUNCTION__, $id);
    }

    /**
     * Create warehouse document
     *
     * @param array $warehouseDocument Warehouse document data
     *
     * @return FakturowniaResponse
     *
     * @throws Exception\RequestErrorException
     */
    public function createWarehouseDocument(array $warehouseDocument)
    {
        $data = [
            'warehouse_document' => $warehouseDocument,
        ];

        return $this->request(__FUNCTION__, 0, $data);
    }

    /**
     * Update warehouse document
     *
     * @param integer $id                Warehouse document ID
     * @param array   $warehouseDocument Warehouse document data
     *
     * @return FakturowniaResponse
     *
     * @throws Exception\RequestErrorException
     */
    public function updateWarehouseDocument($id, array $warehouseDocument)
    {
        $data = [
            'warehouse_document' => $warehouseDocument,
        ];

        return $this->request(__FUNCTION__, $id, $data);
    }

    /**
     * Delete warehouse document
     *
     * @param integer $id Warehouse document ID
     *
     * @return FakturowniaResponse
     *
     * @throws Exception\RequestErrorException
     */
    public function deleteWarehouseDocument($id)
    {
        return $this->request(__FUNCTION__, $id);
    }

    /**
     * Get warehouses
     *
     * @param array $params Parameters
     *
     * @return FakturowniaResponse
     *
     * @throws Exception\RequestErrorException
     */
    public function getWarehouses(array $params = [])
    {
        return $this->request(__FUNCTION__, 0, $params);
    }

    /**
     * Get warehouse
     *
     * @param integer $id Warehouse ID
     *
     * @return FakturowniaResponse
     *
     * @throws Exception\RequestErrorException
     */
    public function getWarehouse($id)
    {
        return $this->request(__FUNCTION__, $id);
    }

    /**
     * Create warehouse
     *
     * @param array $warehouse Warehouse data
     *
     * @return FakturowniaResponse
     *
     * @throws Exception\RequestErrorException
     */
    public function createWarehouse(array $warehouse)
    {
        $data = [
            'warehouse' => $warehouse,
        ];

        return $this->request(__FUNCTION__, 0, $data);
    }

    /**
     * Update warehouse
     *
     * @param integer $id        Warehouse ID
     * @param array   $warehouse Warehouse data
     *
     * @return FakturowniaResponse
     *
     * @throws Exception\RequestErrorException
     */
    public function updateWarehouse($id, array $warehouse)
    {
        $data = [
            'warehouse' => $warehouse,
        ];

        return $this->request(__FUNCTION__, $id, $data);
    }

    /**
     * Delete warehouse
     *
     * @param integer $id Warehouse ID
     *
     * @return FakturowniaResponse
     *
     * @throws Exception\RequestErrorException
     */
    public function deleteWarehouse($id)
    {
        return $this->request(__FUNCTION__, $id);
    }

    /**
     * Get categories
     *
     * @param array $params Parameters
     *
     * @return FakturowniaResponse
     *
     * @throws Exception\RequestErrorException
     */
    public function getCategories(array $params = [])
    {
        return $this->request(__FUNCTION__, 0, $params);
    }

    /**
     * Get category
     *
     * @param integer $id Category ID
     *
     * @return FakturowniaResponse
     *
     * @throws Exception\RequestErrorException
     */
    public function getCategory($id)
    {
        return $this->request(__FUNCTION__, $id);
    }

    /**
     * Create category
     *
     * @param array $category Category data
     *
     * @return FakturowniaResponse
     *
     * @throws Exception\RequestErrorException
     */
    public function createCategory(array $category)
    {
        $data = [
            'category' => $category,
        ];

        return $this->request(__FUNCTION__, 0, $data);
    }

    /**
     * Update category
     *
     * @param integer $id       Category ID
     * @param array   $category Category data
     *
     * @return FakturowniaResponse
     *
     * @throws Exception\RequestErrorException
     */
    public function updateCategory($id, array $category)
    {
        $data = [
            'category' => $category,
        ];

        return $this->request(__FUNCTION__, $id, $data);
    }

    /**
     * Delete category
     *
     * @param integer $id Category ID
     *
     * @return FakturowniaResponse
     *
     * @throws Exception\RequestErrorException
     */
    public function deleteCategory($id)
    {
        return $this->request(__FUNCTION__, $id);
    }

    /**
     * Get account
     *
     * @return FakturowniaResponse
     *
     * @throws Exception\RequestErrorException
     */
    public function getAccount()
    {
        return $this->request(__FUNCTION__);
    }

    /**
     * Create account for client
     *
     * @param array $account Account data
     * @param array $user    User data
     * @param array $company Company data
     *
     * @return FakturowniaResponse
     *
     * @throws Exception\RequestErrorException
     */
    public function createAccountForClient(array $account, array $user = [], array $company = [])
    {
        $data = [
            'account' => $account,
        ];

        if (!empty($user)) {
            $data['user'] = $user;
        }

        if (!empty($company)) {
            $data['company'] = $company;
        }

        return $this->request(__FUNCTION__, 0, $data);
    }
}
