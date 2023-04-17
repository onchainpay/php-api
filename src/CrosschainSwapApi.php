<?php namespace OnChainPay;

class CrosschainSwapApi
{
    protected Instance $apiInstance;

    public function __construct(string $publicKey, string $privateKey)
    {
        $this->apiInstance = new Instance($publicKey, $privateKey, 'https://ocp.onchainpay.io/api-gateway/swap');
        return $this;
    }

    /**
     * The method allows you to get information about the commission for the exchange
     *
     * @param string $advancedBalanceId
     * @param string $currencyFrom
     * @param string $networkFrom
     * @param string $currencyTo
     * @param string $networkTo
     * @param float $amount
     * @return array
     * @throws Exception
     */
    public function fee(
        string $advancedBalanceId,
        string $currencyFrom,
        string $networkFrom,
        string $currencyTo,
        string $networkTo,
        float $amount
    ): array
    {
        $params = [
            'advancedBalanceId' => $advancedBalanceId,
            'currencyFrom' => $currencyFrom,
            'currency' => $currencyTo,
            'networkFrom' => $networkFrom,
            'networkTo' => $networkTo,
            'amount' => (string) $amount
        ];
        return $this->apiInstance->request('fee-token', $params);
    }

    /**
     * The method allows you to initiate an asset swap operation
     *
     * @param string $advancedBalanceId
     * @param string $clientId External user identificator (in your system)
     * @param string $addressFromId
     * @param string $addressToId
     * @param string $feeToken fee['token']
     * @param string $webhookUrl
     * @return array
     * @throws Exception
     */
    public function create(
        string $advancedBalanceId,
        string $clientId,
        string $addressFromId,
        string $addressToId,
        string $feeToken,
        string $webhookUrl
    ): array
    {
        $params = compact(
            'advancedBalanceId',
            'clientId',
            'addressFromId',
            'addressToId',
            'feeToken',
            'webhookUrl'
        );
        return $this->apiInstance->request('create', $params);
    }

    /**
     * The method allows you to get information on the asset swap operation
     *
     * @param string $id create['id']
     * @return array
     * @throws Exception
     */
    public function get(string $id): array
    {
        return $this->apiInstance->request('get', compact('id'));
    }

    /**
     * The method to receive the min/max limit of the allowable amount for the operation in USD.
     *
     * @return array ['min', 'max']
     * @throws Exception
     */
    public function limits(): array
    {
        return $this->apiInstance->request('limit');
    }


}