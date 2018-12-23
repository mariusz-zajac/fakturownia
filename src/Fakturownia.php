<?php

namespace Abb\Fakturownia;

/**
 * Class Fakturownia
 */
class Fakturownia extends FakturowniaAbstract
{

    /**
     * Get invoices
     *
     * @param array $params
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
     * @param integer $id
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
     * @param array $invoice
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
     * @param integer $id
     * @param array   $invoice
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
     * @param integer $id
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
     * @param integer $id
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
     * @param integer $id
     * @param string  $status
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
     * @param array $params
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
     * @param array $recurringInvoice
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
     * @param integer $id
     * @param array   $recurringInvoice
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
     * @param array $params
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
     * @param integer $id
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
     * @param integer $id
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
     * @param array $client
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
     * @param integer $id
     * @param array   $client
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
     * @param array $params
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
     * @param integer      $id
     * @param integer|null $warehouseId
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
     * @param array $product
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
     * @param integer $id
     * @param array   $product
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
     * @param array $params
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
     * @param integer $id
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
     * @param array $warehouseDocument
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
     * @param integer $id
     * @param array   $warehouseDocument
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
     * @param integer $id
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
     * @param array $account
     * @param array $user
     * @param array $company
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
