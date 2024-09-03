<?php

declare(strict_types=1);

namespace Abb\Fakturownia\Api;

class Accounts extends AbstractApi
{
    public function get(array $params = []): Response
    {
        $params['api_token'] = $this->getApiToken();

        return $this->request('GET', 'account.json', [
            'query' => $params,
        ]);
    }

    public function createForClient(array $account, array $user = [], array $company = [], ?string $integrationToken = null): Response
    {
        $data = [
            'account' => $account,
            'api_token' => $this->getApiToken(),
        ];

        if (!empty($user)) {
            $data['user'] = $user;
        }

        if (!empty($company)) {
            $data['company'] = $company;
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

    public function addUser(array $user, string $integrationToken): Response
    {
        $data = [
            'api_token' => $this->getApiToken(),
            'integration_token' => $integrationToken,
            'user' => $user,
        ];

        return $this->request('POST', 'account/add_user.json', [
            'json' => $data,
        ]);
    }
}
