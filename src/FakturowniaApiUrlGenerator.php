<?php

namespace Abb\Fakturownia;

/**
 * Fakturownia API URL Generator
 */
class FakturowniaApiUrlGenerator
{

    /**
     * @var string
     */
    protected $baseUrl = 'https://[USERNAME].fakturownia.pl';

    /**
     * @var array
     */
    protected $apiMethodsMapping = [
        // invoice
        'urlCreateInvoice'           => 'invoices.json',
        'urlUpdateInvoice'           => 'invoices/[ID].json',
        'urlDeleteInvoice'           => 'invoices/[ID].json',
        'urlGetInvoice'              => 'invoices/[ID].json',
        'urlGetInvoices'             => 'invoices.json',
        'urlSendInvoice'             => 'invoices/[ID]/send_by_email.json',
        'urlChangeInvoiceStatus'     => 'invoices/[ID]/change_status.json',
        // recurring invoice
        'urlGetRecurringInvoices'    => 'recurrings.json',
        'urlCreateRecurringInvoice'  => 'recurrings.json',
        'urlUpdateRecurringInvoice'  => 'recurrings/[ID].json',
        // client
        'urlCreateClient'            => 'clients.json',
        'urlUpdateClient'            => 'clients/[ID].json',
        'urlGetClient'               => 'clients/[ID].json',
        'urlGetClientByExternalId'   => 'clients.json',
        'urlGetClients'              => 'clients.json',
        // product
        'urlCreateProduct'           => 'products.json',
        'urlUpdateProduct'           => 'products/[ID].json',
        'urlGetProduct'              => 'products/[ID].json',
        'urlGetProducts'             => 'products.json',
        // warehouse document
        'urlCreateWarehouseDocument' => 'warehouse_documents.json',
        'urlUpdateWarehouseDocument' => 'warehouse_documents/[ID].json',
        'urlDeleteWarehouseDocument' => 'warehouse_documents/[ID].json',
        'urlGetWarehouseDocument'    => 'warehouse_documents/[ID].json',
        'urlGetWarehouseDocuments'   => 'warehouse_documents.json',
        // warehouse
        'urlCreateWarehouse'         => 'warehouse.json',
        'urlUpdateWarehouse'         => 'warehouse/[ID].json',
        'urlDeleteWarehouse'         => 'warehouse/[ID].json',
        'urlGetWarehouse'            => 'warehouse/[ID].json',
        'urlGetWarehouses'           => 'warehouse.json',
        // category
        'urlCreateCategory'          => 'categories.json',
        'urlUpdateCategory'          => 'categories/[ID].json',
        'urlDeleteCategory'          => 'categories/[ID].json',
        'urlGetCategory'             => 'categories/[ID].json',
        'urlGetCategories'           => 'categories.json',
        // account
        'urlGetAccount'              => 'account.json',
        'urlCreateAccountForClient'  => 'account.json',
        // @todo payments
        // @todo departments
        // @todo login
    ];

    /**
     * Constructor
     *
     * @param string $fakturowniaUsername Fakturownia username
     */
    public function __construct($fakturowniaUsername)
    {
        $this->baseUrl = str_replace('[USERNAME]', $fakturowniaUsername, $this->baseUrl);
    }

    /**
     * Get API URL
     * 
     * @param string $method Method name
     * @param array  $params Parameters
     *
     * @return string
     */
    private function getUrl($method, $params = [])
    {
        if (!isset($this->apiMethodsMapping[$method])) {
            throw new \InvalidArgumentException('Missing mapping for method: ' . $method);
        }

        $apiMethod = strtr($this->apiMethodsMapping[$method], $params);

        return $this->baseUrl . '/' . $apiMethod;
    }

    /**
     * URL to create invoice
     *
     * @return string
     */
    public function urlCreateInvoice()
    {
        return $this->getUrl(__FUNCTION__);
    }

    /**
     * URL to update invoice
     *
     * @param int $id Invoice ID
     *
     * @return string
     */
    public function urlUpdateInvoice($id)
    {
        return $this->getUrl(__FUNCTION__, ['[ID]' => $id]);
    }

    /**
     * URL to delete invoice
     *
     * @param int $id Invoice ID
     *
     * @return string
     */
    public function urlDeleteInvoice($id)
    {
        return $this->getUrl(__FUNCTION__, ['[ID]' => $id]);
    }

    /**
     * URL to get invoice
     *
     * @param int $id Invoice ID
     *
     * @return string
     */
    public function urlGetInvoice($id)
    {
        return $this->getUrl(__FUNCTION__, ['[ID]' => $id]);
    }

    /**
     * URL to get invoices
     *
     * @return string
     */
    public function urlGetInvoices()
    {
        return $this->getUrl(__FUNCTION__);
    }

    /**
     * URL to send invoice
     *
     * @param int $id Invoice ID
     *
     * @return string
     */
    public function urlSendInvoice($id)
    {
        return $this->getUrl(__FUNCTION__, ['[ID]' => $id]);
    }

    /**
     * URL to change invoice status
     *
     * @param int $id Invoice ID
     *
     * @return string
     */
    public function urlChangeInvoiceStatus($id)
    {
        return $this->getUrl(__FUNCTION__, ['[ID]' => $id]);
    }

    /**
     * URL to get recurring invoices
     *
     * @return string
     */
    public function urlGetRecurringInvoices()
    {
        return $this->getUrl(__FUNCTION__);
    }

    /**
     * URL to create recurring invoice
     *
     * @return string
     */
    public function urlCreateRecurringInvoice()
    {
        return $this->getUrl(__FUNCTION__);
    }

    /**
     * URL to update recurring invoice
     *
     * @param int $id Invoice ID
     *
     * @return string
     */
    public function urlUpdateRecurringInvoice($id)
    {
        return $this->getUrl(__FUNCTION__, ['[ID]' => $id]);
    }

    /**
     * URL to create client
     *
     * @return string
     */
    public function urlCreateClient()
    {
        return $this->getUrl(__FUNCTION__);
    }

    /**
     * URL to update client
     *
     * @param int $id Invoice ID
     *
     * @return string
     */
    public function urlUpdateClient($id)
    {
        return $this->getUrl(__FUNCTION__, ['[ID]' => $id]);
    }

    /**
     * URL to get client
     *
     * @param int $id Invoice ID
     *
     * @return string
     */
    public function urlGetClient($id)
    {
        return $this->getUrl(__FUNCTION__, ['[ID]' => $id]);
    }

    /**
     * URL to get client by external ID
     *
     * @return string
     */
    public function urlGetClientByExternalId()
    {
        return $this->getUrl(__FUNCTION__);
    }

    /**
     * URL to get clients
     *
     * @return string
     */
    public function urlGetClients()
    {
        return $this->getUrl(__FUNCTION__);
    }

    /**
     * URL to create product
     *
     * @return string
     */
    public function urlCreateProduct()
    {
        return $this->getUrl(__FUNCTION__);
    }

    /**
     * URL to update product
     *
     * @param int $id Invoice ID
     *
     * @return string
     */
    public function urlUpdateProduct($id)
    {
        return $this->getUrl(__FUNCTION__, ['[ID]' => $id]);
    }

    /**
     * URL to get product
     *
     * @param int $id Invoice ID
     *
     * @return string
     */
    public function urlGetProduct($id)
    {
        return $this->getUrl(__FUNCTION__, ['[ID]' => $id]);
    }

    /**
     * URL to get products
     *
     * @return string
     */
    public function urlGetProducts()
    {
        return $this->getUrl(__FUNCTION__);
    }

    /**
     * URL to create warehouse document
     *
     * @return string
     */
    public function urlCreateWarehouseDocument()
    {
        return $this->getUrl(__FUNCTION__);
    }

    /**
     * URL to update warehouse document
     *
     * @param int $id Invoice ID
     *
     * @return string
     */
    public function urlUpdateWarehouseDocument($id)
    {
        return $this->getUrl(__FUNCTION__, ['[ID]' => $id]);
    }

    /**
     * URL to delete warehouse document
     *
     * @param int $id Invoice ID
     *
     * @return string
     */
    public function urlDeleteWarehouseDocument($id)
    {
        return $this->getUrl(__FUNCTION__, ['[ID]' => $id]);
    }

    /**
     * URL to get warehouse document
     *
     * @param int $id Invoice ID
     *
     * @return string
     */
    public function urlGetWarehouseDocument($id)
    {
        return $this->getUrl(__FUNCTION__, ['[ID]' => $id]);
    }

    /**
     * URL to get warehouse documents
     *
     * @return string
     */
    public function urlGetWarehouseDocuments()
    {
        return $this->getUrl(__FUNCTION__);
    }

    /**
     * URL to create warehouse
     *
     * @return string
     */
    public function urlCreateWarehouse()
    {
        return $this->getUrl(__FUNCTION__);
    }

    /**
     * URL to update warehouse
     *
     * @param int $id Invoice ID
     *
     * @return string
     */
    public function urlUpdateWarehouse($id)
    {
        return $this->getUrl(__FUNCTION__, ['[ID]' => $id]);
    }

    /**
     * URL to delete warehouse
     *
     * @param int $id Invoice ID
     *
     * @return string
     */
    public function urlDeleteWarehouse($id)
    {
        return $this->getUrl(__FUNCTION__, ['[ID]' => $id]);
    }

    /**
     * URL to get warehouse
     *
     * @param int $id Invoice ID
     *
     * @return string
     */
    public function urlGetWarehouse($id)
    {
        return $this->getUrl(__FUNCTION__, ['[ID]' => $id]);
    }

    /**
     * URL to get warehouses
     *
     * @return string
     */
    public function urlGetWarehouses()
    {
        return $this->getUrl(__FUNCTION__);
    }

    /**
     * URL to create category
     *
     * @return string
     */
    public function urlCreateCategory()
    {
        return $this->getUrl(__FUNCTION__);
    }

    /**
     * URL to update category
     *
     * @param int $id Invoice ID
     *
     * @return string
     */
    public function urlUpdateCategory($id)
    {
        return $this->getUrl(__FUNCTION__, ['[ID]' => $id]);
    }

    /**
     * URL to delete category
     *
     * @param int $id Invoice ID
     *
     * @return string
     */
    public function urlDeleteCategory($id)
    {
        return $this->getUrl(__FUNCTION__, ['[ID]' => $id]);
    }

    /**
     * URL to get category
     *
     * @param int $id Invoice ID
     *
     * @return string
     */
    public function urlGetCategory($id)
    {
        return $this->getUrl(__FUNCTION__, ['[ID]' => $id]);
    }

    /**
     * URL to get categories
     *
     * @return string
     */
    public function urlGetCategories()
    {
        return $this->getUrl(__FUNCTION__);
    }

    /**
     * URL to get account
     *
     * @return string
     */
    public function urlGetAccount()
    {
        return $this->getUrl(__FUNCTION__);
    }

    /**
     * URL to create account for client
     *
     * @return string
     */
    public function urlCreateAccountForClient()
    {
        return $this->getUrl(__FUNCTION__);
    }
}
