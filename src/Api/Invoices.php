<?php

declare(strict_types=1);

namespace Abb\Fakturownia\Api;

use Abb\Fakturownia\Response;

class Invoices extends AbstractApi
{
    public function getOne(int $invoiceId, array $params = []): Response
    {
        $params['api_token'] = $this->getApiToken();

        return $this->request('GET', 'invoices/' . $invoiceId . '.json', [
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

    public function getPdf(int $invoiceId, ?string $printOption = null): Response
    {
        $params = [
            'api_token' => $this->getApiToken(),
        ];

        if (null !== $printOption) {
            $params['print_option'] = $printOption;
        }

        return $this->request('GET', 'invoices/' . $invoiceId . '.pdf', [
            'query' => $params,
        ]);
    }

    public function create(array $invoiceData, array $params = []): Response
    {
        $data = $params;
        $data['invoice'] = $invoiceData;
        $data['api_token'] = $this->getApiToken();

        return $this->request('POST', 'invoices.json', [
            'json' => $data,
        ]);
    }

    public function update(int $invoiceId, array $invoiceData): Response
    {
        $data = [
            'invoice' => $invoiceData,
            'api_token' => $this->getApiToken(),
        ];

        return $this->request('PUT', 'invoices/' . $invoiceId . '.json', [
            'json' => $data,
        ]);
    }

    public function delete(int $invoiceId): Response
    {
        $params = [
            'api_token' => $this->getApiToken(),
        ];

        return $this->request('DELETE', 'invoices/' . $invoiceId . '.json', [
            'query' => $params,
        ]);
    }

    public function cancel(int $invoiceId, ?string $cancelReason = null): Response
    {
        $params = [
            'api_token' => $this->getApiToken(),
            'cancel_invoice_id' => $invoiceId,
        ];

        if (null !== $cancelReason) {
            $params['cancel_reason'] = $cancelReason;
        }

        return $this->request('POST', 'invoices/cancel.json', [
            'json' => $params,
        ]);
    }

    public function sendByEmail(int $invoiceId, array $params = []): Response
    {
        $params['api_token'] = $this->getApiToken();

        return $this->request('POST', 'invoices/' . $invoiceId . '/send_by_email.json', [
            'json' => $params,
        ]);
    }

    public function changeStatus(int $invoiceId, string $status): Response
    {
        $data = [
            'status' => $status,
            'api_token' => $this->getApiToken(),
        ];

        return $this->request('POST', 'invoices/' . $invoiceId . '/change_status.json', [
            'json' => $data,
        ]);
    }
}
