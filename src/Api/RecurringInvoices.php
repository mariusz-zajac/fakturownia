<?php

declare(strict_types=1);

namespace Abb\Fakturownia\Api;

final class RecurringInvoices extends AbstractApi
{
    public function getAll(array $params = []): array
    {
        $params['api_token'] = $this->getApiToken();

        return $this->request('GET', 'recurrings.json', query: $params)->toArray();
    }

    public function create(array $recurringInvoiceData): array
    {
        $data = [
            'recurring' => $recurringInvoiceData,
            'api_token' => $this->getApiToken(),
        ];

        return $this->request('POST', 'recurrings.json', body: $data)->toArray();
    }

    public function update(int $recurringInvoiceId, array $recurringInvoiceData): array
    {
        $data = [
            'recurring' => $recurringInvoiceData,
            'api_token' => $this->getApiToken(),
        ];

        return $this->request('PUT', 'recurrings/' . $recurringInvoiceId . '.json', body: $data)->toArray();
    }
}
