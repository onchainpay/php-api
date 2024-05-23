<?php namespace OnChainPay\Methods;

use OnChainPay\Exception;
use OnChainPay\Extends\Method;

class CrosschainSwap extends Method
{
    /**
     * The method allows you to get limits for the amount of blockchain exchange
     * @return array ['min', 'max']
     * @throws Exception
     */
    public function limit(): array
    {
        return $this->instance->request('swaps/limit');
    }


    /**
     * The method allows you to get information on a previously created cross-chain exchange
     * @param string $id Swap ID
     * @return array
     * @throws Exception
     */
    public function get(string $id): array
    {
        return $this->instance->request('swaps/get', compact('id'));
    }


    /**
     * The method allows you to get a commission token for cross-chain exchange
     * @param string $currencyFrom Outgoing coin
     * @param string $networkFrom Outgoing network
     * @param string $currencyTo Expected coin
     * @param string $networkTo Expected Network
     * @param string $amount Exchange amount
     * @param string|null $advancedBalanceId Advance balance identifier
     * @return array
     * @throws Exception
     */
    public function feeToken(
        string $currencyFrom,
        string $networkFrom,
        string $currencyTo,
        string $networkTo,
        string $amount,
        string $advancedBalanceId  = null
    ): array
    {
        return $this->instance->request('swaps/fee-token', [
            'advancedBalanceId' => $advancedBalanceId ?? $this->instance->getAdvId(),
            'currencyFrom' => $currencyFrom,
            'currency' => $currencyTo,
            'networkFrom' => $networkFrom,
            'networkTo' => $networkTo,
            'amount' => $amount
        ]);
    }

    /**
     * The method allows you to create a cross-chain exchange
     * @param string $addressFromId Identifier of the outgoing address from which the specified amount will be debited
     * @param string $addressToId Identifier of the destination address where the coins will be credited after the swap
     * @param string $feeToken Commission Token
     * @param string|null $webhookUrl URL address for notifying about the change in the status of the swap operation
     * @param string|null $clientId Unique exchange identifier in the merchant system (to prevent duplicate requests)
     * @param string|null $advancedBalanceId Identifier of the upfront balance specified when creating the commission token
     * @return array
     * @throws Exception
     */
    public function create(
        string $addressFromId,
        string $addressToId,
        string $feeToken,
        string $webhookUrl = null,
        string $clientId = null,
        string $advancedBalanceId = null
    ): array
    {
        $params = [
            'advancedBalanceId' => $advancedBalanceId ?? $this->instance->getAdvId(),
            'addressFromId' => $addressFromId,
            'addressToId' => $addressToId,
            'feeToken' => $feeToken,
        ];

        if($webhookUrl !== null)
            $params['webhookUrl'] = $webhookUrl;

        if($clientId !== null)
            $params['clientId'] = $clientId;

        return $this->instance->request('swaps/create', $params);
    }




}
