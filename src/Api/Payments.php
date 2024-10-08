<?php

declare(strict_types=1);

namespace Abb\Fakturownia\Api;

use Abb\Fakturownia\Response;

class Payments extends AbstractApi
{
    public function getOne(int $paymentId, array $params = []): Response
    {
        $params['api_token'] = $this->getApiToken();

        return $this->request('GET', 'banking/payments/' . $paymentId . '.json', [
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

    public function create(array $paymentData): Response
    {
        $data = [
            'banking_payment' => $paymentData,
            'api_token' => $this->getApiToken(),
        ];

        return $this->request('POST', 'banking/payments.json', [
            'json' => $data,
        ]);
    }

    public function update(int $paymentId, array $paymentData): Response
    {
        $data = [
            'banking_payment' => $paymentData,
            'api_token' => $this->getApiToken(),
        ];

        return $this->request('PUT', 'banking/payments/' . $paymentId . '.json', [
            'json' => $data,
        ]);
    }

    public function delete(int $paymentId): Response
    {
        $params = [
            'api_token' => $this->getApiToken(),
        ];

        return $this->request('DELETE', 'banking/payments/' . $paymentId . '.json', [
            'query' => $params,
        ]);
    }
}
