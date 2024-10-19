<?php

declare(strict_types=1);

namespace Abb\Fakturownia\Api;

use Abb\Fakturownia\Response;

final class Warehouses extends AbstractApi
{
    public function getOne(int $warehouseId): Response
    {
        $params = [
            'api_token' => $this->getApiToken(),
        ];

        return $this->request('GET', 'warehouses/' . $warehouseId . '.json', [
            'query' => $params,
        ]);
    }

    public function getAll(array $params = []): Response
    {
        $params['api_token'] = $this->getApiToken();

        return $this->request('GET', 'warehouses.json', [
            'query' => $params,
        ]);
    }

    public function create(array $warehouseData): Response
    {
        $data = [
            'warehouse' => $warehouseData,
            'api_token' => $this->getApiToken(),
        ];

        return $this->request('POST', 'warehouses.json', [
            'json' => $data,
        ]);
    }

    public function update(int $warehouseId, array $warehouseData): Response
    {
        $data = [
            'warehouse' => $warehouseData,
            'api_token' => $this->getApiToken(),
        ];

        return $this->request('PUT', 'warehouses/' . $warehouseId . '.json', [
            'json' => $data,
        ]);
    }

    public function delete(int $warehouseId): Response
    {
        $params = [
            'api_token' => $this->getApiToken(),
        ];

        return $this->request('DELETE', 'warehouses/' . $warehouseId . '.json', [
            'query' => $params,
        ]);
    }
}
