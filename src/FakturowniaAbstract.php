<?php

namespace Abb\Fakturownia;

use Abb\Fakturownia\Exception\RequestErrorException;
use Abb\Fakturownia\Exception\InvalidArgumentException;

/**
 * Class FakturowniaAbstract
 */
abstract class FakturowniaAbstract
{

    /**
     * @var string
     */
    protected $apiToken;

    /**
     * @var resource
     */
    protected $curl;

    /**
     * @var string
     */
    protected $baseUrl = 'https://[USERNAME].fakturownia.pl';

    /**
     * @var array
     */
    protected $apiMethodsMapping = [
        // invoice
        'createInvoice'           => 'invoices.json',
        'updateInvoice'           => 'invoices/[ID].json',
        'deleteInvoice'           => 'invoices/[ID].json',
        'getInvoice'              => 'invoices/[ID].json',
        'getInvoices'             => 'invoices.json',
        'getInvoiceByClientId'    => 'invoices.json',
        'sendInvoice'             => 'invoices/[ID]/send_by_email.json',
        'changeInvoiceStatus'     => 'invoices/[ID]/change_status.json',
        // client
        'createClient'            => 'clients.json',
        'updateClient'            => 'clients/[ID].json',
        'getClient'               => 'clients/[ID].json',
        'getClients'              => 'clients.json',
        // product
        'createProduct'           => 'products.json',
        'updateProduct'           => 'products/[ID].json',
        'getProduct'              => 'products/[ID].json',
        'getProducts'             => 'products.json',
        // warehouse document
        'createWarehouseDocument' => 'warehouse_documents.json',
        'updateWarehouseDocument' => 'warehouse_documents/[ID].json',
        'deleteWarehouseDocument' => 'warehouse_documents/[ID].json',
        'getWarehouseDocument'    => 'warehouse_documents/[ID].json',
        // account
        'getAccount'              => 'account.json',
        'createAccountForClient'  => 'account.json',
    ];

    /**
     * Constructor
     *
     * @param string $apiToken
     *
     * @throws InvalidArgumentException
     */
    public function __construct($apiToken)
    {
        $parts = array_filter(explode('/', $apiToken));

        if (count($parts) !== 2) {
            throw new InvalidArgumentException('Invalid Fakturownia Api token');
        }

        $this->apiToken = $apiToken;
        $this->curl = curl_init();
    }

    /**
     * Destructor
     */
    public function __destruct()
    {
        if (is_resource($this->curl)) {
            curl_close($this->curl);
        }
    }

    /**
     * Prepare Api url
     *
     * @param string  $apiMethod
     * @param integer $id
     *
     * @return string
     *
     * @throws InvalidArgumentException
     */
    protected function prepareUrl($apiMethod, $id)
    {
        if (!isset($this->apiMethodsMapping[$apiMethod])) {
            throw new InvalidArgumentException('Unsupported api method');
        }

        $username = explode('/', $this->apiToken)[1];
        $url = $this->baseUrl . '/' . $this->apiMethodsMapping[$apiMethod];
        $url = str_replace('[USERNAME]', $username, $url);
        $url = str_replace('[ID]', $id, $url);

        return $url;
    }

    /**
     * Convert api method to request method
     *
     * @param string $apiMethod
     *
     * @return string
     *
     * @throws InvalidArgumentException
     */
    protected function mapApiMethodToRequestMethod($apiMethod)
    {
        $verb = preg_replace('/^([a-z]+).+$/', '$1', $apiMethod);

        switch ($verb) {
            case 'send':
            case 'create':
            case 'change':
                return 'POST';
            case 'update':
                return 'PUT';
            case 'delete':
                return 'DELETE';
            case 'get':
                return 'GET';
            default:
                throw new InvalidArgumentException(
                    'Undefined request method mapping for api method: ' . $apiMethod
                );
        }
    }

    /**
     * Send a request to the API via curl
     *
     * @param string  $apiMethod
     * @param integer $id
     * @param array   $data
     *
     * @return FakturowniaResponse
     *
     * @throws RequestErrorException
     */
    protected function request($apiMethod, $id = 0, $data = [])
    {
        $requestMethod = $this->mapApiMethodToRequestMethod($apiMethod);

        curl_setopt_array($this->curl, [
            CURLOPT_HTTPHEADER => [
                'Accept: application/json',
                'Content-Type: application/json'
            ],
            CURLOPT_HEADER => false,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_CUSTOMREQUEST => $requestMethod
        ]);

        $url = $this->prepareUrl($apiMethod, $id);

        $data['api_token'] = $this->apiToken;

        if ($requestMethod === 'GET') {
            $url = $url . '?' . http_build_query($data);
        } else {
            curl_setopt($this->curl, CURLOPT_POSTFIELDS, json_encode($data));
        }

        curl_setopt($this->curl, CURLOPT_URL, $url);

        $result = curl_exec($this->curl);

        if (false === $result) {
            throw new RequestErrorException(curl_error($this->curl), curl_errno($this->curl));
        }

        $code = curl_getinfo($this->curl, CURLINFO_RESPONSE_CODE);

        curl_reset($this->curl);

        $data = (array) json_decode($result, true);

        return new FakturowniaResponse($code, $data);
    }
}
