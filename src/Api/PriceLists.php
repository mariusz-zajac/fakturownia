<?php

declare(strict_types=1);

namespace Abb\Fakturownia\Api;

final class PriceLists extends AbstractApi
{
    public function getAll(array $params = []): array
    {
        $params['api_token'] = $this->getApiToken();

        return $this->request('GET', 'price_lists.json', query: $params)->toArray();
    }

    public function create(array $priceListData): array
    {
        $data = [
            'price_list' => $priceListData,
            'api_token' => $this->getApiToken(),
        ];

        return $this->request('POST', 'price_lists.json', body: $data)->toArray();
    }

    public function update(int $priceListId, array $priceListData): array
    {
        $data = [
            'price_list' => $priceListData,
            'api_token' => $this->getApiToken(),
        ];

        return $this->request('PUT', 'price_lists/' . $priceListId . '.json', body: $data)->toArray();
    }

    public function delete(int $priceListId): array
    {
        $params = [
            'api_token' => $this->getApiToken(),
        ];

        return $this->request('DELETE', 'price_lists/' . $priceListId . '.json', query: $params)->toArray();
    }
}
