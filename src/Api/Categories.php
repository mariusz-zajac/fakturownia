<?php

declare(strict_types=1);

namespace Abb\Fakturownia\Api;

use Abb\Fakturownia\Response;

final class Categories extends AbstractApi
{
    public function getOne(int $categoryId): Response
    {
        $params = [
            'api_token' => $this->getApiToken(),
        ];

        return $this->request('GET', 'categories/' . $categoryId . '.json', [
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

    public function create(array $categoryData): Response
    {
        $data = [
            'category' => $categoryData,
            'api_token' => $this->getApiToken(),
        ];

        return $this->request('POST', 'categories.json', [
            'json' => $data,
        ]);
    }

    public function update(int $categoryId, array $categoryData): Response
    {
        $data = [
            'category' => $categoryData,
            'api_token' => $this->getApiToken(),
        ];

        return $this->request('PUT', 'categories/' . $categoryId . '.json', [
            'json' => $data,
        ]);
    }

    public function delete(int $categoryId): Response
    {
        $params = [
            'api_token' => $this->getApiToken(),
        ];

        return $this->request('DELETE', 'categories/' . $categoryId . '.json', [
            'query' => $params,
        ]);
    }
}
