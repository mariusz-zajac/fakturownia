<?php

declare(strict_types=1);

namespace Abb\Fakturownia\Api;

use Abb\Fakturownia\Response;

class Warehouses extends AbstractApi
{
    public function get(int $id): Response
    {
        $params = [
            'api_token' => $this->getApiToken(),
        ];

        return $this->request('GET', 'warehouses/' . $id . '.json', [
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

    public function create(array $warehouse): Response
    {
        $data = [
            'warehouse' => $warehouse,
            'api_token' => $this->getApiToken(),
        ];

        return $this->request('POST', 'warehouses.json', [
            'json' => $data,
        ]);
    }

    public function update(int $id, array $warehouse): Response
    {
        $data = [
            'warehouse' => $warehouse,
            'api_token' => $this->getApiToken(),
        ];

        return $this->request('PUT', 'warehouses/' . $id . '.json', [
            'json' => $data,
        ]);
    }

    public function delete(int $id): Response
    {
        $params = [
            'api_token' => $this->getApiToken(),
        ];

        return $this->request('DELETE', 'warehouses/' . $id . '.json', [
            'query' => $params,
        ]);
    }
}
