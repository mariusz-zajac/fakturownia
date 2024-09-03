<?php

declare(strict_types=1);

namespace Abb\Fakturownia\Api;

class PriceLists extends AbstractApi
{
    public function getAll(array $params = []): Response
    {
        $params['api_token'] = $this->getApiToken();

        return $this->request('GET', 'price_lists.json', [
            'query' => $params,
        ]);
    }

    public function create(array $priceList): Response
    {
        $data = [
            'price_list' => $priceList,
            'api_token' => $this->getApiToken(),
        ];

        return $this->request('POST', 'price_lists.json', [
            'json' => $data,
        ]);
    }

    public function update(int $id, array $priceList): Response
    {
        $data = [
            'price_list' => $priceList,
            'api_token' => $this->getApiToken(),
        ];

        return $this->request('PUT', 'price_lists/' . $id . '.json', [
            'json' => $data,
        ]);
    }

    public function delete(int $id): Response
    {
        $params = [
            'api_token' => $this->getApiToken(),
        ];

        return $this->request('DELETE', 'price_lists/' . $id . '.json', [
            'query' => $params,
        ]);
    }
}
