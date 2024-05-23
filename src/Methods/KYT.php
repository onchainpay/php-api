<?php namespace OnChainPay\Methods;

use OnChainPay\Enums\TransactionDirection;
use OnChainPay\Exception;
use OnChainPay\Extends\Method;

class KYT extends Method
{
    /**
     * The method allows you to check the risks of a completed transaction
     * @param string $tx Transaction hash
     * @param string $currency Coin
     * @param string $network Network
     * @param string $outputAddress Address-recipient of coins
     * @param TransactionDirection $direction The party to check the risks
     * @return array
     * @throws Exception
     */
    public function checkTransaction(
        string $tx,
        string $currency,
        string $network,
        string $outputAddress,
        TransactionDirection $direction,
    ): array
    {
        return $this->instance->request('kyt/check-transfer', [
            'tx' => $tx,
            'currency' => $currency,
            'network' => $network,
            'outputAddress' => $outputAddress,
            'direction' => $direction->value,
        ]);
    }

    /**
     * The method allows you to check the risks of withdrawal before making it
     * @param string $currency Currency
     * @param string $network Network
     * @param string $address Address-recipient of coins
     * @param string $amount Withdrawal amount
     * @return array
     * @throws Exception
     */
    public function checkWithdrawal(
        string $currency,
        string $network,
        string $address,
        string $amount,
    ): array
    {
        return $this->instance->request('kyt/check-withdrawal-address', compact('currency', 'network', 'address', 'amount'));
    }


    /**
     * The method allows you to get information about the risk level of withdrawal to the address
     * @param string $currency Coin
     * @param string $network Network
     * @param string $address Address-recipient of coins
     * @return array
     * @throws Exception
     */
    public function checkWithdrawalProvided(
        string $currency,
        string $network,
        string $address,
    ): array
    {
        return $this->instance->request('kyt/withdrawal-address-screening', compact('currency', 'network', 'address'));
    }

}
