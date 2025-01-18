<?php

declare(strict_types=1);

namespace Abb\Fakturownia\Api;

final class Accounts extends AbstractApi
{
    public function getOne(array $params = []): array
    {
        $params['api_token'] = $this->getApiToken();

        return $this->request('GET', 'account.json', ['query' => $params])->toArray();
    }

    public function createForClient(
        array $accountData,
        array $userData = [],
        array $companyData = [],
        ?string $integrationToken = null
    ): array {
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

        return $this->request('POST', 'account.json', ['body' => $data])->toArray();
    }

    public function delete(): array
    {
        $data = [
            'api_token' => $this->getApiToken(),
        ];

        return $this->request('POST', 'account/delete.json', ['body' => $data])->toArray();
    }

    public function unlink(array $subdomains): array
    {
        $data = [
            'api_token' => $this->getApiToken(),
            'prefix' => $subdomains,
        ];

        return $this->request('PATCH', 'account/unlink.json', ['body' => $data])->toArray();
    }

    public function addUser(array $userData, string $integrationToken): array
    {
        $data = [
            'api_token' => $this->getApiToken(),
            'integration_token' => $integrationToken,
            'user' => $userData,
        ];

        return $this->request('POST', 'account/add_user.json', ['body' => $data])->toArray();
    }
}
