<?php

declare(strict_types=1);

namespace Abb\Fakturownia\Api;

final class Products extends AbstractApi
{
    public function getOne(int $productId, ?int $warehouseId = null): array
    {
        $params = [
            'api_token' => $this->getApiToken(),
        ];

        if (null !== $warehouseId) {
            $params['warehouse_id'] = $warehouseId;
        }

        return $this->request('GET', 'products/' . $productId . '.json', ['query' => $params])->toArray();
    }

    public function getAll(array $params = []): array
    {
        $params['api_token'] = $this->getApiToken();

        return $this->request('GET', 'products.json', ['query' => $params])->toArray();
    }

    public function create(array $productData): array
    {
        $data = [
            'product' => $productData,
            'api_token' => $this->getApiToken(),
        ];

        return $this->request('POST', 'products.json', ['body' => $data])->toArray();
    }

    public function update(int $productId, array $productData): array
    {
        $data = [
            'product' => $productData,
            'api_token' => $this->getApiToken(),
        ];

        return $this->request('PUT', 'products/' . $productId . '.json', ['body' => $data])->toArray();
    }

    public function delete(int $productId): array
    {
        $params = [
            'api_token' => $this->getApiToken(),
        ];

        return $this->request('DELETE', 'products/' . $productId . '.json', ['query' => $params])->toArray();
    }
}
