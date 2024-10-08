<?php

declare(strict_types=1);

namespace Abb\Fakturownia\Api;

use Abb\Fakturownia\Response;

class RecurringInvoices extends AbstractApi
{
    public function getAll(array $params = []): Response
    {
        $params['api_token'] = $this->getApiToken();

        return $this->request('GET', 'recurrings.json', [
            'query' => $params,
        ]);
    }

    public function create(array $recurringInvoiceData): Response
    {
        $data = [
            'recurring' => $recurringInvoiceData,
            'api_token' => $this->getApiToken(),
        ];

        return $this->request('POST', 'recurrings.json', [
            'json' => $data,
        ]);
    }

    public function update(int $recurringInvoiceId, array $recurringInvoiceData): Response
    {
        $data = [
            'recurring' => $recurringInvoiceData,
            'api_token' => $this->getApiToken(),
        ];

        return $this->request('PUT', 'recurrings/' . $recurringInvoiceId . '.json', [
            'json' => $data,
        ]);
    }
}
