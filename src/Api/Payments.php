<?php

declare(strict_types=1);

namespace Abb\Fakturownia\Api;

final class Payments extends AbstractApi
{
    public function getOne(int $paymentId, array $params = []): array
    {
        $params['api_token'] = $this->getApiToken();

        return $this->request('GET', 'banking/payments/' . $paymentId . '.json', ['query' => $params])->toArray();
    }

    public function getAll(array $params = []): array
    {
        $params['api_token'] = $this->getApiToken();

        return $this->request('GET', 'banking/payments.json', ['query' => $params])->toArray();
    }

    public function create(array $paymentData): array
    {
        $data = [
            'banking_payment' => $paymentData,
            'api_token' => $this->getApiToken(),
        ];

        return $this->request('POST', 'banking/payments.json', ['body' => $data])->toArray();
    }

    public function update(int $paymentId, array $paymentData): array
    {
        $data = [
            'banking_payment' => $paymentData,
            'api_token' => $this->getApiToken(),
        ];

        return $this->request('PUT', 'banking/payments/' . $paymentId . '.json', ['body' => $data])->toArray();
    }

    public function delete(int $paymentId): array
    {
        $params = [
            'api_token' => $this->getApiToken(),
        ];

        return $this->request('DELETE', 'banking/payments/' . $paymentId . '.json', ['query' => $params])->toArray();
    }
}
