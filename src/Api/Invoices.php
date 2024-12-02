<?php

declare(strict_types=1);

namespace Abb\Fakturownia\Api;

final class Invoices extends AbstractApi
{
    public function getOne(int $invoiceId, array $params = []): array
    {
        $params['api_token'] = $this->getApiToken();

        return $this->request('GET', 'invoices/' . $invoiceId . '.json', query: $params)->toArray();
    }

    public function getAll(array $params = []): array
    {
        $params['api_token'] = $this->getApiToken();

        return $this->request('GET', 'invoices.json', query: $params)->toArray();
    }

    public function getPdf(int $invoiceId, ?string $printOption = null): string
    {
        $params = [
            'api_token' => $this->getApiToken(),
        ];

        if (null !== $printOption) {
            $params['print_option'] = $printOption;
        }

        return $this->request('GET', 'invoices/' . $invoiceId . '.pdf', query: $params)->getContent();
    }

    public function create(array $invoiceData, array $params = []): array
    {
        $data = $params;
        $data['invoice'] = $invoiceData;
        $data['api_token'] = $this->getApiToken();

        return $this->request('POST', 'invoices.json', body: $data)->toArray();
    }

    public function update(int $invoiceId, array $invoiceData): array
    {
        $data = [
            'invoice' => $invoiceData,
            'api_token' => $this->getApiToken(),
        ];

        return $this->request('PUT', 'invoices/' . $invoiceId . '.json', body: $data)->toArray();
    }

    public function delete(int $invoiceId): array
    {
        $params = [
            'api_token' => $this->getApiToken(),
        ];

        return $this->request('DELETE', 'invoices/' . $invoiceId . '.json', query: $params)->toArray();
    }

    public function cancel(int $invoiceId, ?string $cancelReason = null): array
    {
        $params = [
            'api_token' => $this->getApiToken(),
            'cancel_invoice_id' => $invoiceId,
        ];

        if (null !== $cancelReason) {
            $params['cancel_reason'] = $cancelReason;
        }

        return $this->request('POST', 'invoices/cancel.json', body: $params)->toArray();
    }

    public function sendByEmail(int $invoiceId, array $params = []): array
    {
        $params['api_token'] = $this->getApiToken();

        return $this->request('POST', 'invoices/' . $invoiceId . '/send_by_email.json', body: $params)->toArray();
    }

    public function changeStatus(int $invoiceId, string $status): array
    {
        $data = [
            'status' => $status,
            'api_token' => $this->getApiToken(),
        ];

        return $this->request('POST', 'invoices/' . $invoiceId . '/change_status.json', body: $data)->toArray();
    }
}
