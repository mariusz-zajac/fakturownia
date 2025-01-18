<?php

declare(strict_types=1);

namespace Abb\Fakturownia\Api;

final class Categories extends AbstractApi
{
    public function getOne(int $categoryId): array
    {
        $params = [
            'api_token' => $this->getApiToken(),
        ];

        return $this->request('GET', 'categories/' . $categoryId . '.json', ['query' => $params])->toArray();
    }

    public function getAll(array $params = []): array
    {
        $params['api_token'] = $this->getApiToken();

        return $this->request('GET', 'categories.json', ['query' => $params])->toArray();
    }

    public function create(array $categoryData): array
    {
        $data = [
            'category' => $categoryData,
            'api_token' => $this->getApiToken(),
        ];

        return $this->request('POST', 'categories.json', ['body' => $data])->toArray();
    }

    public function update(int $categoryId, array $categoryData): array
    {
        $data = [
            'category' => $categoryData,
            'api_token' => $this->getApiToken(),
        ];

        return $this->request('PUT', 'categories/' . $categoryId . '.json', ['body' => $data])->toArray();
    }

    public function delete(int $categoryId): array
    {
        $params = [
            'api_token' => $this->getApiToken(),
        ];

        return $this->request('DELETE', 'categories/' . $categoryId . '.json', ['query' => $params])->toArray();
    }
}
