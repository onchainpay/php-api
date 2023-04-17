<?php namespace OnChainPay;

class PersonalAddressesApi
{
    protected Instance $apiInstance;

    public function __construct(string $publicKey, string $privateKey)
    {
        $this->apiInstance = new Instance($publicKey, $privateKey, 'https://ocp.onchainpay.io/api-gateway/personal-addresses');
        return $this;
    }

    /**
     * Create/Update user data
     *
     * @param string $clientId External user identificator (in your system)
     * @param string $clientEmail User's email
     * @param string|null $clientName User's name
     * @param string|null $depositWebhookUrl URL for receiving webhooks about deposits to user addresses
     * @return array
     * @throws Exception
     */
    public function createUser(
        string $clientId,
        string $clientEmail,
        string $clientName = null,
        string $depositWebhookUrl = null
    ): array
    {
        $params = compact('clientId', 'clientEmail');
        if($clientName) $params['clientName'] = $clientName;
        if($depositWebhookUrl) $params['depositWebhookUrl'] = $depositWebhookUrl;
        return $this->apiInstance->request('create-user', $params);
    }

    /**
     * Get user data by providing its identificator
     *
     * @param string $id User ID
     * @return array
     * @throws Exception
     */
    public function getUser(string $id): array
    {
        return $this->apiInstance->request('get-user', compact('id'));
    }

    /**
     * Get user data by providing external user identificator
     *
     * @param string $clientId External user ID (in your system)
     * @return array
     * @throws Exception
     */
    public function getUserByClientId(string $clientId): array
    {
        return $this->apiInstance->request('get-user', compact('clientId'));
    }

    /**
     * Get the address for the user in the specified coin and network
     *
     * @param string $id User ID
     * @param string $currency 	Currency
     * @param string $network Network
     * @param bool $renewAddress Generate new address
     * @return array
     * @throws Exception
     */
    public function getUserAddress(string $id, string $currency, string $network, bool $renewAddress = false): array
    {
        $params = compact('id', 'currency', 'network');
        if($renewAddress === true) $params['renewAddress'] = true;
        return $this->apiInstance->request('get-user-address', $params);
    }

    /**
     * The method allows you to get all the user's personal addresses.
     *
     * @param string $id User ID
     * @param bool $onlyActive Filter by parameter isActive
     * @return array
     * @throws Exception
     */
    public function getAllUserAddress(string $id, bool $onlyActive = false): array
    {
        $params = compact('id');
        if($onlyActive === true) $params['isActive'] = true;
        return $this->apiInstance->request('get-user-addresses', $params);
    }
}