<?php

declare(strict_types=1);

namespace Abb\Fakturownia\Api;

use Abb\Fakturownia\Response;

final class Departments extends AbstractApi
{
    public function getOne(int $departmentId): Response
    {
        $params = [
            'api_token' => $this->getApiToken(),
        ];

        return $this->request('GET', 'departments/' . $departmentId . '.json', query: $params);
    }

    public function getAll(array $params = []): Response
    {
        $params['api_token'] = $this->getApiToken();

        return $this->request('GET', 'departments.json', query: $params);
    }

    public function create(array $departmentData): Response
    {
        $data = [
            'department' => $departmentData,
            'api_token' => $this->getApiToken(),
        ];

        return $this->request('POST', 'departments.json', body: $data);
    }

    public function update(int $departmentId, array $departmentData): Response
    {
        $data = [
            'department' => $departmentData,
            'api_token' => $this->getApiToken(),
        ];

        return $this->request('PUT', 'departments/' . $departmentId . '.json', body: $data);
    }

    public function delete(int $departmentId): Response
    {
        $params = [
            'api_token' => $this->getApiToken(),
        ];

        return $this->request('DELETE', 'departments/' . $departmentId . '.json', query: $params);
    }
}
