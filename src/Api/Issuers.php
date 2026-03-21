<?php

declare(strict_types=1);

namespace Abb\Fakturownia\Api;

final class Issuers extends AbstractApi
{
    public function getOne(int $issuerId): array
    {
        $params = [
            'api_token' => $this->getApiToken(),
        ];

        return $this->request('GET', 'issuers/' . $issuerId . '.json', ['query' => $params])->toArray();
    }

    public function getAll(array $params = []): array
    {
        $params['api_token'] = $this->getApiToken();

        return $this->request('GET', 'issuers.json', ['query' => $params])->toArray();
    }

    public function create(array $issuerData): array
    {
        $data = [
            'issuer' => $issuerData,
            'api_token' => $this->getApiToken(),
        ];

        return $this->request('POST', 'issuers.json', ['body' => $data])->toArray();
    }

    public function update(int $issuerId, array $issuerData): array
    {
        $data = [
            'issuer' => $issuerData,
            'api_token' => $this->getApiToken(),
        ];

        return $this->request('PUT', 'issuers/' . $issuerId . '.json', ['body' => $data])->toArray();
    }

    public function delete(int $issuerId): array
    {
        $params = [
            'api_token' => $this->getApiToken(),
        ];

        return $this->request('DELETE', 'issuers/' . $issuerId . '.json', ['query' => $params])->toArray();
    }
}
