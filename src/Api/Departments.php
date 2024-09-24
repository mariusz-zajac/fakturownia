<?php

declare(strict_types=1);

namespace Abb\Fakturownia\Api;

use Abb\Fakturownia\Response;

class Departments extends AbstractApi
{
    public function get(int $id): Response
    {
        $params = [
            'api_token' => $this->getApiToken(),
        ];

        return $this->request('GET', 'departments/' . $id . '.json', [
            'query' => $params,
        ]);
    }

    public function getAll(array $params = []): Response
    {
        $params['api_token'] = $this->getApiToken();

        return $this->request('GET', 'departments.json', [
            'query' => $params,
        ]);
    }

    public function create(array $department): Response
    {
        $data = [
            'department' => $department,
            'api_token' => $this->getApiToken(),
        ];

        return $this->request('POST', 'departments.json', [
            'json' => $data,
        ]);
    }

    public function update(int $id, array $department): Response
    {
        $data = [
            'department' => $department,
            'api_token' => $this->getApiToken(),
        ];

        return $this->request('PUT', 'departments/' . $id . '.json', [
            'json' => $data,
        ]);
    }

    public function delete(int $id): Response
    {
        $params = [
            'api_token' => $this->getApiToken(),
        ];

        return $this->request('DELETE', 'departments/' . $id . '.json', [
            'query' => $params,
        ]);
    }
}
