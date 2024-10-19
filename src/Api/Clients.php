<?php

declare(strict_types=1);

namespace Abb\Fakturownia\Api;

use Abb\Fakturownia\Response;

final class Clients extends AbstractApi
{
    public function getOne(int $clientId): Response
    {
        $params = [
            'api_token' => $this->getApiToken(),
        ];

        return $this->request('GET', 'clients/' . $clientId . '.json', [
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

    public function getAllByExternalId(string $externalId): Response
    {
        $params = [
            'external_id' => $externalId,
            'api_token' => $this->getApiToken(),
        ];

        return $this->request('GET', 'clients.json', [
            'query' => $params,
        ]);
    }

    public function create(array $clientData): Response
    {
        $data = [
            'client' => $clientData,
            'api_token' => $this->getApiToken(),
        ];

        return $this->request('POST', 'clients.json', [
            'json' => $data,
        ]);
    }

    public function update(int $clientId, array $clientData): Response
    {
        $data = [
            'client' => $clientData,
            'api_token' => $this->getApiToken(),
        ];

        return $this->request('PUT', 'clients/' . $clientId . '.json', [
            'json' => $data,
        ]);
    }

    public function delete(int $clientId): Response
    {
        $params = [
            'api_token' => $this->getApiToken(),
        ];

        return $this->request('DELETE', 'clients/' . $clientId . '.json', [
            'query' => $params,
        ]);
    }
}
