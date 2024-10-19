<?php

declare(strict_types=1);

namespace Abb\Fakturownia\Api;

use Abb\Fakturownia\Response;

final class PriceLists extends AbstractApi
{
    public function getAll(array $params = []): Response
    {
        $params['api_token'] = $this->getApiToken();

        return $this->request('GET', 'price_lists.json', [
            'query' => $params,
        ]);
    }

    public function create(array $priceListData): Response
    {
        $data = [
            'price_list' => $priceListData,
            'api_token' => $this->getApiToken(),
        ];

        return $this->request('POST', 'price_lists.json', [
            'json' => $data,
        ]);
    }

    public function update(int $priceListId, array $priceListData): Response
    {
        $data = [
            'price_list' => $priceListData,
            'api_token' => $this->getApiToken(),
        ];

        return $this->request('PUT', 'price_lists/' . $priceListId . '.json', [
            'json' => $data,
        ]);
    }

    public function delete(int $priceListId): Response
    {
        $params = [
            'api_token' => $this->getApiToken(),
        ];

        return $this->request('DELETE', 'price_lists/' . $priceListId . '.json', [
            'query' => $params,
        ]);
    }
}
