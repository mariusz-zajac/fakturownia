<?php

declare(strict_types=1);

namespace Abb\Fakturownia\Api;

class Products extends AbstractApi
{
    public function get(int $id, ?int $warehouseId = null): Response
    {
        $params = [
            'api_token' => $this->getApiToken(),
        ];

        if (null !== $warehouseId) {
            $params['warehouse_id'] = $warehouseId;
        }

        return $this->request('GET', 'products/' . $id . '.json', [
            'query' => $params,
        ]);
    }

    public function getAll(array $params = []): Response
    {
        $params['api_token'] = $this->getApiToken();

        return $this->request('GET', 'products.json', [
            'query' => $params,
        ]);
    }

    public function create(array $product): Response
    {
        $data = [
            'product' => $product,
            'api_token' => $this->getApiToken(),
        ];

        return $this->request('POST', 'products.json', [
            'json' => $data,
        ]);
    }

    public function update(int $id, array $product): Response
    {
        $data = [
            'product' => $product,
            'api_token' => $this->getApiToken(),
        ];

        return $this->request('PUT', 'products/' . $id . '.json', [
            'json' => $data,
        ]);
    }
}
