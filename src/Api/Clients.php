<?php

declare(strict_types=1);

namespace Abb\Fakturownia\Api;

final class Clients extends AbstractApi
{
    public function getOne(int $clientId): array
    {
        $params = [
            'api_token' => $this->getApiToken(),
        ];

        return $this->request('GET', 'clients/' . $clientId . '.json', query: $params)->toArray();
    }

    public function getAll(array $params = []): array
    {
        $params['api_token'] = $this->getApiToken();

        return $this->request('GET', 'clients.json', query: $params)->toArray();
    }

    public function getAllByExternalId(string $externalId): array
    {
        $params = [
            'external_id' => $externalId,
            'api_token' => $this->getApiToken(),
        ];

        return $this->request('GET', 'clients.json', query: $params)->toArray();
    }

    public function create(array $clientData): array
    {
        $data = [
            'client' => $clientData,
            'api_token' => $this->getApiToken(),
        ];

        return $this->request('POST', 'clients.json', body: $data)->toArray();
    }

    public function update(int $clientId, array $clientData): array
    {
        $data = [
            'client' => $clientData,
            'api_token' => $this->getApiToken(),
        ];

        return $this->request('PUT', 'clients/' . $clientId . '.json', body: $data)->toArray();
    }

    public function delete(int $clientId): array
    {
        $params = [
            'api_token' => $this->getApiToken(),
        ];

        return $this->request('DELETE', 'clients/' . $clientId . '.json', query: $params)->toArray();
    }
}
