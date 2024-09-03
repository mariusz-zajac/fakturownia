<?php

declare(strict_types=1);

namespace Abb\Fakturownia\Api;

class WarehouseDocuments extends AbstractApi
{
    public function get(int $id): Response
    {
        $params = [
            'api_token' => $this->getApiToken(),
        ];

        return $this->request('GET', 'warehouse_documents/' . $id . '.json', [
            'query' => $params,
        ]);
    }

    public function getAll(array $params = []): Response
    {
        $params['api_token'] = $this->getApiToken();

        return $this->request('GET', 'warehouse_documents.json', [
            'query' => $params,
        ]);
    }

    public function create(array $warehouseDocument): Response
    {
        $data = [
            'warehouse_document' => $warehouseDocument,
            'api_token' => $this->getApiToken(),
        ];

        return $this->request('POST', 'warehouse_documents.json', [
            'json' => $data,
        ]);
    }

    public function update(int $id, array $warehouseDocument): Response
    {
        $data = [
            'warehouse_document' => $warehouseDocument,
            'api_token' => $this->getApiToken(),
        ];

        return $this->request('PUT', 'warehouse_documents/' . $id . '.json', [
            'json' => $data,
        ]);
    }

    public function delete(int $id): Response
    {
        $params = [
            'api_token' => $this->getApiToken(),
        ];

        return $this->request('DELETE', 'warehouse_documents/' . $id . '.json', [
            'query' => $params,
        ]);
    }
}
