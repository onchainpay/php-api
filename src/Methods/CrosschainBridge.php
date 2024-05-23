<?php namespace OnChainPay\Methods;


use OnChainPay\Exception;
use OnChainPay\Extends\Method;

class CrosschainBridge extends Method
{
    /**
     * The method to receive the min/max limit of the allowable amount for the operation in USD.
     * @return array ['min', 'max']
     * @throws Exception
     */
    public function limit(): array
    {
        return $this->instance->request('bridge/limit');
    }

    /**
     * The method allows you to get information on a previously created cross-chain transfer
     * @param string $id Cross-chain transfer ID
     * @return array
     * @throws Exception
     */
    public function get(string $id): array
    {
        return $this->instance->request('bridge/get', compact('id'));
    }

    /**
     * The method allows you to get a commission token for cross-chain transfer
     * @param string $currency The coin you want to exchange
     * @param string $networkFrom Outgoing network
     * @param string $networkTo Network where you want to receive coins
     * @param string $amount Amount to transfer
     * @param string|null $advancedBalanceId Identifier of the advance balance that will act as the payer of commissions
     * @return array
     * @throws Exception
     */
    public function feeToken(
        string $currency,
        string $networkFrom,
        string $networkTo,
        string $amount,
        string $advancedBalanceId = null
    ): array
    {
        return $this->instance->request('bridge/fee-token', [
            'advancedBalanceId' => $advancedBalanceId ?? $this->instance->getAdvId(),
            'currency' => $currency,
            'networkFrom' => $networkFrom,
            'networkTo' => $networkTo,
            'amount' => $amount,
        ]);
    }

    /**
     * The method allows you to create a cross-chain transfer
     * @param string $clientId Unique transaction identifier in the merchant system, to prevent duplication of creation
     * @param string $addressFromId Identifier of the outgoing address in the system, in the specified coin and network when creating the commission token.
     * @param string $addressToId Identifier of the destination address in the system where the coins should be delivered
     * @param string $feeToken Commission Token
     * @param string|null $webhookUrl URL address for operation status notification
     * @param string|null $advancedBalanceId Identifier of the advance balance specified when creating the commission token
     * @return array
     * @throws Exception
     */
    public function create(
        string $clientId,
        string $addressFromId,
        string $addressToId,
        string $feeToken,
        string $webhookUrl = null,
        string $advancedBalanceId = null
    ): array
    {
        $params = [
            'advancedBalanceId' => $advancedBalanceId ?? $this->instance->getAdvId(),
            'clientId' => $clientId,
            'addressFromId' => $addressFromId,
            'addressToId' => $addressToId,
            'feeToken' => $feeToken,
        ];

        if($webhookUrl !== null)
            $params['webhookUrl'] = $webhookUrl;

        return $this->instance->request('bridge/create', $params);
    }


}
