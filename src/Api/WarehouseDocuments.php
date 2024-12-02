<?php

declare(strict_types=1);

namespace Abb\Fakturownia\Api;

final class WarehouseDocuments extends AbstractApi
{
    public function getOne(int $warehouseDocumentId): array
    {
        $params = [
            'api_token' => $this->getApiToken(),
        ];

        return $this->request('GET', 'warehouse_documents/' . $warehouseDocumentId . '.json', query: $params)->toArray();
    }

    public function getAll(array $params = []): array
    {
        $params['api_token'] = $this->getApiToken();

        return $this->request('GET', 'warehouse_documents.json', query: $params)->toArray();
    }

    public function create(array $warehouseDocumentData): array
    {
        $data = [
            'warehouse_document' => $warehouseDocumentData,
            'api_token' => $this->getApiToken(),
        ];

        return $this->request('POST', 'warehouse_documents.json', body: $data)->toArray();
    }

    public function update(int $warehouseDocumentId, array $warehouseDocumentData): array
    {
        $data = [
            'warehouse_document' => $warehouseDocumentData,
            'api_token' => $this->getApiToken(),
        ];

        return $this->request('PUT', 'warehouse_documents/' . $warehouseDocumentId . '.json', body: $data)->toArray();
    }

    public function delete(int $warehouseDocumentId): array
    {
        $params = [
            'api_token' => $this->getApiToken(),
        ];

        return $this->request('DELETE', 'warehouse_documents/' . $warehouseDocumentId . '.json', query: $params)->toArray();
    }
}
