<?php

declare(strict_types=1);

namespace Abb\Fakturownia\Api;

use Abb\Fakturownia\Response;

class Clients extends AbstractApi
{
    public function get(int $id): Response
    {
        $params = [
            'api_token' => $this->getApiToken(),
        ];

        return $this->request('GET', 'clients/' . $id . '.json', [
            'query' => $params,
        ]);
    }

    public function getAll(array $params = []): Response
    {
        $params['api_token'] = $this->getApiToken();

        return $this->request('GET', 'clients.json', [
            'query' => $params,
        ]);
    }

    public function getByExternalId(string $externalId): Response
    {
        $params = [
            'external_id' => $externalId,
            'api_token' => $this->getApiToken(),
        ];

        return $this->request('GET', 'clients.json', [
            'query' => $params,
        ]);
    }

    public function create(array $client): Response
    {
        $data = [
            'client' => $client,
            'api_token' => $this->getApiToken(),
        ];

        return $this->request('POST', 'clients.json', [
            'json' => $data,
        ]);
    }

    public function update(int $id, array $client): Response
    {
        $data = [
            'client' => $client,
            'api_token' => $this->getApiToken(),
        ];

        return $this->request('PUT', 'clients/' . $id . '.json', [
            'json' => $data,
        ]);
    }

    public function delete(int $id): Response
    {
        $params = [
            'api_token' => $this->getApiToken(),
        ];

        return $this->request('DELETE', 'clients/' . $id . '.json', [
            'query' => $params,
        ]);
    }
}
