<?php

declare(strict_types=1);

namespace Abb\Fakturownia\Api;

use Abb\Fakturownia\Response;

class Products extends AbstractApi
{
    public function getOne(int $productId, ?int $warehouseId = null): Response
    {
        $params = [
            'api_token' => $this->getApiToken(),
        ];

        if (null !== $warehouseId) {
            $params['warehouse_id'] = $warehouseId;
        }

        return $this->request('GET', 'products/' . $productId . '.json', [
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

    public function create(array $productData): Response
    {
        $data = [
            'product' => $productData,
            'api_token' => $this->getApiToken(),
        ];

        return $this->request('POST', 'products.json', [
            'json' => $data,
        ]);
    }

    public function update(int $productId, array $productData): Response
    {
        $data = [
            'product' => $productData,
            'api_token' => $this->getApiToken(),
        ];

        return $this->request('PUT', 'products/' . $productId . '.json', [
            'json' => $data,
        ]);
    }
}
