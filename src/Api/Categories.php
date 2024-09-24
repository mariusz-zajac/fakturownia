<?php

declare(strict_types=1);

namespace Abb\Fakturownia\Api;

use Abb\Fakturownia\Response;

class Categories extends AbstractApi
{
    public function get(int $id): Response
    {
        $params = [
            'api_token' => $this->getApiToken(),
        ];

        return $this->request('GET', 'categories/' . $id . '.json', [
            'query' => $params,
        ]);
    }

    public function getAll(array $params = []): Response
    {
        $params['api_token'] = $this->getApiToken();

        return $this->request('GET', 'categories.json', [
            'query' => $params,
        ]);
    }

    public function create(array $category): Response
    {
        $data = [
            'category' => $category,
            'api_token' => $this->getApiToken(),
        ];

        return $this->request('POST', 'categories.json', [
            'json' => $data,
        ]);
    }

    public function update(int $id, array $category): Response
    {
        $data = [
            'category' => $category,
            'api_token' => $this->getApiToken(),
        ];

        return $this->request('PUT', 'categories/' . $id . '.json', [
            'json' => $data,
        ]);
    }

    public function delete(int $id): Response
    {
        $params = [
            'api_token' => $this->getApiToken(),
        ];

        return $this->request('DELETE', 'categories/' . $id . '.json', [
            'query' => $params,
        ]);
    }
}
