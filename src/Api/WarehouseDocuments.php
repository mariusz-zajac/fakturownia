<?php

declare(strict_types=1);

namespace Abb\Fakturownia\Api;

use Abb\Fakturownia\Response;

final class WarehouseDocuments extends AbstractApi
{
    public function getOne(int $warehouseDocumentId): Response
    {
        $params = [
            'api_token' => $this->getApiToken(),
        ];

        return $this->request('GET', 'warehouse_documents/' . $warehouseDocumentId . '.json', query: $params);
    }

    public function getAll(array $params = []): Response
    {
        $params['api_token'] = $this->getApiToken();

        return $this->request('GET', 'warehouse_documents.json', query: $params);
    }

    public function create(array $warehouseDocumentData): Response
    {
        $data = [
            'warehouse_document' => $warehouseDocumentData,
            'api_token' => $this->getApiToken(),
        ];

        return $this->request('POST', 'warehouse_documents.json', body: $data);
    }

    public function update(int $warehouseDocumentId, array $warehouseDocumentData): Response
    {
        $data = [
            'warehouse_document' => $warehouseDocumentData,
            'api_token' => $this->getApiToken(),
        ];

        return $this->request('PUT', 'warehouse_documents/' . $warehouseDocumentId . '.json', body: $data);
    }

    public function delete(int $warehouseDocumentId): Response
    {
        $params = [
            'api_token' => $this->getApiToken(),
        ];

        return $this->request('DELETE', 'warehouse_documents/' . $warehouseDocumentId . '.json', query: $params);
    }
}
