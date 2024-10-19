<?php

declare(strict_types=1);

namespace Abb\Fakturownia\Api;

use Abb\Fakturownia\Response;

final class Accounts extends AbstractApi
{
    public function getOne(array $params = []): Response
    {
        $params['api_token'] = $this->getApiToken();

        return $this->request('GET', 'account.json', [
            'query' => $params,
        ]);
    }

    public function createForClient(
        array $accountData,
        array $userData = [],
        array $companyData = [],
        ?string $integrationToken = null,
    ): Response {
        $data = [
            'account' => $accountData,
            'api_token' => $this->getApiToken(),
        ];

        if (!empty($userData)) {
            $data['user'] = $userData;
        }

        if (!empty($companyData)) {
            $data['company'] = $companyData;
        }

        if (null !== $integrationToken) {
            $data['integration_token'] = $integrationToken;
        }

        return $this->request('POST', 'account.json', [
            'json' => $data,
        ]);
    }

    public function delete(): Response
    {
        $data = [
            'api_token' => $this->getApiToken(),
        ];

        return $this->request('POST', 'account/delete.json', [
            'json' => $data,
        ]);
    }

    public function unlink(array $subdomains): Response
    {
        $data = [
            'api_token' => $this->getApiToken(),
            'prefix' => $subdomains,
        ];

        return $this->request('PATCH', 'account/unlink.json', [
            'json' => $data,
        ]);
    }

    public function addUser(array $userData, string $integrationToken): Response
    {
        $data = [
            'api_token' => $this->getApiToken(),
            'integration_token' => $integrationToken,
            'user' => $userData,
        ];

        return $this->request('POST', 'account/add_user.json', [
            'json' => $data,
        ]);
    }
}
