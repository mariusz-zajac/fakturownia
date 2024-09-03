<?php

declare(strict_types=1);

namespace Abb\Fakturownia\Api;

class Payments extends AbstractApi
{
    public function get(int $id, array $params = []): Response
    {
        $params['api_token'] = $this->getApiToken();

        return $this->request('GET', 'banking/payments/' . $id . '.json', [
            'query' => $params,
        ]);
    }

    public function getAll(array $params = []): Response
    {
        $params['api_token'] = $this->getApiToken();

        return $this->request('GET', 'banking/payments.json', [
            'query' => $params,
        ]);
    }

    public function create(array $payment): Response
    {
        $data = [
            'banking_payment' => $payment,
            'api_token' => $this->getApiToken(),
        ];

        return $this->request('POST', 'banking/payments.json', [
            'json' => $data,
        ]);
    }

    public function update(int $id, array $payment): Response
    {
        $data = [
            'banking_payment' => $payment,
            'api_token' => $this->getApiToken(),
        ];

        return $this->request('PUT', 'banking/payments/' . $id . '.json', [
            'json' => $data,
        ]);
    }

    public function delete(int $id): Response
    {
        $params = [
            'api_token' => $this->getApiToken(),
        ];

        return $this->request('DELETE', 'banking/payments/' . $id . '.json', [
            'query' => $params,
        ]);
    }
}
