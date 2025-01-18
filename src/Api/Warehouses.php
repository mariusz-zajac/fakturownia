<?php

declare(strict_types=1);

namespace Abb\Fakturownia\Api;

final class Warehouses extends AbstractApi
{
    public function getOne(int $warehouseId): array
    {
        $params = [
            'api_token' => $this->getApiToken(),
        ];

        return $this->request('GET', 'warehouses/' . $warehouseId . '.json', ['query' => $params])->toArray();
    }

    public function getAll(array $params = []): array
    {
        $params['api_token'] = $this->getApiToken();

        return $this->request('GET', 'warehouses.json', ['query' => $params])->toArray();
    }

    public function create(array $warehouseData): array
    {
        $data = [
            'warehouse' => $warehouseData,
            'api_token' => $this->getApiToken(),
        ];

        return $this->request('POST', 'warehouses.json', ['body' => $data])->toArray();
    }

    public function update(int $warehouseId, array $warehouseData): array
    {
        $data = [
            'warehouse' => $warehouseData,
            'api_token' => $this->getApiToken(),
        ];

        return $this->request('PUT', 'warehouses/' . $warehouseId . '.json', ['body' => $data])->toArray();
    }

    public function delete(int $warehouseId): array
    {
        $params = [
            'api_token' => $this->getApiToken(),
        ];

        return $this->request('DELETE', 'warehouses/' . $warehouseId . '.json', ['query' => $params])->toArray();
    }
}
