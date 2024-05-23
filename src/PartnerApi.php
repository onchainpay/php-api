<?php namespace OnChainPay;

use OnChainPay\Enums\TariffActions;
use OnChainPay\Enums\TariffTypes;

class PartnerApi
{
    protected Instance $instance;

    public function __construct(string $publicKey, string $privateKey)
    {
        $this->instance = new Instance($publicKey, $privateKey, 'https://ocp.onchainpay.io/partner/api');
    }

    /**
     * The method allows you to create a user
     * @param string $email User's email
     * @return array
     * @throws Exception
     */
    public function createUser(string $email): array
    {
        return $this->instance->request('create-user', compact('email'));
    }

    /**
     * The method allows you to get the user
     * @param string $userId User ID
     * @return array
     * @throws Exception
     */
    public function getUser(string $userId): array
    {
        return $this->instance->request('get-user', compact('userId'));
    }

    /**
     * The method allows you to get all users
     * @param string|null $limit Number of elements per page
     * @param string|null $offset Number of items to skip
     * @return array
     * @throws Exception
     */
    public function getAllUsers(string $limit = null, string $offset = null): array
    {
        $params = [];

        if($limit !== null)
            $params['limit'] = $limit;

        if($offset !== null)
            $params['offset'] = $offset;

        return $this->instance->request('get-users', $params);
    }

    /**
     * The method allows you to create an organization for the user
     * @param string $userId User's email
     * @param string|null $name Organization's name
     * @return array
     * @throws Exception
     */
    public function createOrganization(string $userId, string $name = null): array
    {
        $params = compact('userId');

        if($name !== null)
            $params['name'] = $name;

        return $this->instance->request('create-organization', $params);
    }

    /**
     * The method allows you to get a list of organizations
     * @param string $userId User ID
     * @param string|null $limit Number of elements per page
     * @param string|null $offset Number of items to skip
     * @return array
     * @throws Exception
     */
    public function getOrganizations(string $userId, string $limit = null, string $offset = null): array
    {
        $params = [];

        if($limit !== null)
            $params['limit'] = $limit;

        if($offset !== null)
            $params['offset'] = $offset;

        return $this->instance->request('get-user-organizations', $params);
    }

    /**
     * The method allows you to get user's advanced balances
     * @param string $userId User ID
     * @param string|null $organizationId ID of the created organization
     * @return array
     * @throws Exception
     */
    public function getOrganizationAdvancedBalances(string $userId, string $organizationId = null): array
    {
        $params = compact('userId');

        if($organizationId !== null)
            $params['organizationId'] = $organizationId;

        return $this->instance->request('get-organization-advanced-balances', $params);
    }

    /**
     * The method allows you to top up the user's advance balance
     * @param string $userId User ID
     * @param string $advancedBalanceId Advanced balance ID
     * @param string $amount The amount of replenishment
     * @return array
     * @throws Exception
     */
    public function topUpAdvancedBalance(string $userId, string $advancedBalanceId, string $amount): array
    {
        return $this->instance->request('get-organization-advanced-balances', compact('userId', 'advancedBalanceId', 'amount'));
    }

    /**
     * The method allows you to get all the general rates on the service
     * @return array
     * @throws Exception
     */
    public function getDefaultTariffs(): array
    {
        return $this->instance->request('get-default-tariffs');
    }

    /**
     * The method allows you to create or update an individual tariff
     * @param string $userId User ID
     * @param string $organizationId Organization ID
     * @param TariffActions $action Tariff action
     * @param string $amount The commission percentage of the transaction amount
     * @param TariffTypes $type Type of fare amount
     * @param string|null $comment Comment/note for tariff
     * @param string|null $minAmount The minimum commission for charging
     * @param string|null $maxAmount The maximum commission for charging
     * @return array
     * @throws Exception
     */
    public function setTariff(
        string        $userId,
        string        $organizationId,
        TariffActions $action,
        string        $amount,
        TariffTypes   $type,
        string        $comment = null,
        string        $minAmount = null,
        string        $maxAmount = null,
    ): array
    {
        return $this->instance->request('set-organization-tariff', [
            'userId' => $userId,
            'organizationId' => $organizationId,
            'action' => $action->value,
            'amount' => $amount,
            'type' => $type->value,
            'comment' => $comment,
            'minAmount' => $minAmount,
            'maxAmount' => $maxAmount,
        ]);
    }

    /**
     * The method allows you to get all individual tariffs
     * @param string $userId User ID
     * @param string $organizationId Organization ID
     * @return array
     * @throws Exception
     */
    public function getTariff(string $userId, string $organizationId): array
    {
        return $this->instance->request('get-organization-tariffs', compact('userId', 'organizationId'));
    }

    /**
     * The method allows you to create an API key for the user
     * @param string $userId User ID
     * @param string $organizationId Organization ID
     * @param string $alias API key name
     * @return array
     * @throws Exception
     */
    public function createApiKey(string $userId, string $organizationId, string $alias): array
    {
        return $this->instance->request('create-api-keys', compact('userId', 'organizationId', 'alias'));
    }

    /**
     * The method allows you to get user's API keys
     * @param string $userId User ID
     * @param string $organizationId Organization ID
     * @param int|null $limit Number of elements per page
     * @param int|null $offset Number of items to skip
     * @return array
     * @throws Exception
     */
    public function getApiKeys(string $userId, string $organizationId, int $limit = null, int $offset = null): array
    {
        $params = compact('userId', 'organizationId');

        if($limit !== null)
            $params['limit'] = $limit;

        if($offset !== null)
            $params['offset'] = $offset;

        return $this->instance->request('get-api-keys',$params);
    }

    /**
     * The method allows you to delete the user's API key
     * @param string $userId User ID
     * @param string $organizationId Organization ID
     * @param string $keyId API key ID
     * @return array
     * @throws Exception
     */
    public function deleteApiKey(string $userId, string $organizationId, string $keyId): array
    {
        return $this->instance->request('delete-api-keys', compact('userId', 'organizationId', 'keyId'));
    }
}
