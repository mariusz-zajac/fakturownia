<?php

declare(strict_types=1);

namespace Abb\Fakturownia\Api;

class Invoices extends AbstractApi
{
    public function get(int $id, array $params = []): Response
    {
        $params['api_token'] = $this->getApiToken();

        return $this->request('GET', 'invoices/' . $id . '.json', [
            'query' => $params,
        ]);
    }

    public function getAll(array $params = []): Response
    {
        $params['api_token'] = $this->getApiToken();

        return $this->request('GET', 'invoices.json', [
            'query' => $params,
        ]);
    }

    public function getPdfContent(int $id, ?string $printOption = null): string
    {
        $params = [
            'api_token' => $this->getApiToken(),
        ];

        if (null !== $printOption) {
            $params['print_option'] = $printOption;
        }

        $response = $this->request('GET', 'invoices/' . $id . '.pdf', [
            'query' => $params,
        ]);

        return $response->getContent();
    }

    public function create(array $invoice, array $params = []): Response
    {
        $data = $params;
        $data['invoice'] = $invoice;
        $data['api_token'] = $this->getApiToken();

        return $this->request('POST', 'invoices.json', [
            'json' => $data,
        ]);
    }

    public function update(int $id, array $invoice): Response
    {
        $data = [
            'invoice' => $invoice,
            'api_token' => $this->getApiToken(),
        ];

        return $this->request('PUT', 'invoices/' . $id . '.json', [
            'json' => $data,
        ]);
    }

    public function delete(int $id): Response
    {
        $params = [
            'api_token' => $this->getApiToken(),
        ];

        return $this->request('DELETE', 'invoices/' . $id . '.json', [
            'query' => $params,
        ]);
    }

    public function cancel(int $id, ?string $cancelReason = null): Response
    {
        $params = [
            'api_token' => $this->getApiToken(),
            'cancel_invoice_id' => $id,
        ];

        if (null !== $cancelReason) {
            $params['cancel_reason'] = $cancelReason;
        }

        return $this->request('POST', 'invoices/cancel.json', [
            'json' => $params,
        ]);
    }

    public function sendByEmail(int $id, array $params = []): Response
    {
        $params['api_token'] = $this->getApiToken();

        return $this->request('POST', 'invoices/' . $id . '/send_by_email.json', [
            'json' => $params,
        ]);
    }

    public function changeStatus(int $id, string $status): Response
    {
        $data = [
            'status' => $status,
            'api_token' => $this->getApiToken(),
        ];

        return $this->request('POST', 'invoices/' . $id . '/change_status.json', [
            'json' => $data,
        ]);
    }
}
