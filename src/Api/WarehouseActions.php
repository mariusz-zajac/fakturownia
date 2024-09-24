<?php

declare(strict_types=1);

namespace Abb\Fakturownia\Api;

use Abb\Fakturownia\Response;

class WarehouseActions extends AbstractApi
{
    public function getAll(array $params = []): Response
    {
        $params['api_token'] = $this->getApiToken();

        return $this->request('GET', 'warehouse_actions.json', [
            'query' => $params,
        ]);
    }
}
