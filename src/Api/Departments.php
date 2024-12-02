<?php

declare(strict_types=1);

namespace Abb\Fakturownia\Api;

final class Departments extends AbstractApi
{
    public function getOne(int $departmentId): array
    {
        $params = [
            'api_token' => $this->getApiToken(),
        ];

        return $this->request('GET', 'departments/' . $departmentId . '.json', query: $params)->toArray();
    }

    public function getAll(array $params = []): array
    {
        $params['api_token'] = $this->getApiToken();

        return $this->request('GET', 'departments.json', query: $params)->toArray();
    }

    public function create(array $departmentData): array
    {
        $data = [
            'department' => $departmentData,
            'api_token' => $this->getApiToken(),
        ];

        return $this->request('POST', 'departments.json', body: $data)->toArray();
    }

    public function update(int $departmentId, array $departmentData): array
    {
        $data = [
            'department' => $departmentData,
            'api_token' => $this->getApiToken(),
        ];

        return $this->request('PUT', 'departments/' . $departmentId . '.json', body: $data)->toArray();
    }

    public function delete(int $departmentId): array
    {
        $params = [
            'api_token' => $this->getApiToken(),
        ];

        return $this->request('DELETE', 'departments/' . $departmentId . '.json', query: $params)->toArray();
    }
}
