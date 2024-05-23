<?php namespace OnChainPay\Methods;

use OnChainPay\Exception;
use OnChainPay\Extends\Method;

class Withdrawals extends Method
{
    /**
     * The method allows you to get data on the commission that will be debited during the withdrawal
     * @param string $addressId Identifier of the address from which you want to withdraw
     * @param string $amount Amount you want to withdraw
     * @param string|null $advancedBalanceId Identifier of the advance balance from which the commission will be paid
     * @param bool|null $native Deduct the gas fee (network fee) from the native balance of the address (available for payment addresses, PAY_OUT type)
     * @return array
     * @throws Exception
     */
    public function getCommission(string $addressId, string $amount, string $advancedBalanceId = null, bool $native = null): array
    {
        $params = [
            'advancedBalanceId' => $advancedBalanceId ?? $this->instance->getAdvId(),
            'addressId' => $addressId,
            'amount' => $amount,
        ];

        if($native !== null)
            $params['native'] = $native;

        return $this->instance->request('withdrawal-fee-token', $params);
    }

    /**
     * The method allows you to create a request to withdraw coins from an address
     * @param string $addressId Identifier of the address from which the coins should be withdrawn
     * @param string $address Address for sending coins
     * @param string $amount Withdrawal amount
     * @param string $feeToken Fee token
     * @param string|null $tag Tag (memo) address
     * @param string|null $advancedBalanceId Identifier of the advance balance for writing off commissions
     * @return array
     * @throws Exception
     */
    public function create(
        string $addressId,
        string $address,
        string $amount,
        string $feeToken,
        string $tag = null,
        string $advancedBalanceId = null
    ): array
    {
        return $this->instance->request('make-withdrawal', [
            'advancedBalanceId' => $advancedBalanceId ?? $this->instance->getAdvId(),
            'addressId' => $addressId,
            'address' => $address,
            'tag' => $tag,
            'amount' => $amount,
            'feeToken' => $feeToken,
        ]);
    }

    /**
     * The method allows you to create a request to withdraw coins from an address and get the execution result to the specified URL
     * @param string $addressId Identifier of the address from which the coins should be withdrawn
     * @param string $address Address for sending coins
     * @param string $amount Withdrawal amount
     * @param string $feeToken Fee token
     * @param string|null $tag Tag (memo) address
     * @param string|null $webhookUrl URL to send webhook when output status changes
     * @param string|null $advancedBalanceId Identifier of the advance balance for writing off commissions
     * @return array
     * @throws Exception
     */
    public function createAsync(
        string $addressId,
        string $address,
        string $amount,
        string $feeToken,
        string $tag = null,
        string $webhookUrl = null,
        string $advancedBalanceId = null
    ): array
    {
        $params = [
            'advancedBalanceId' => $advancedBalanceId ?? $this->instance->getAdvId(),
            'addressId' => $addressId,
            'address' => $address,
            'tag' => $tag,
            'amount' => $amount,
            'feeToken' => $feeToken,
        ];

        if($webhookUrl !== null)
            $params['webhookUrl'] = $webhookUrl;

        return $this->instance->request('make-withdrawal-async', $params);
    }

    /**
     * The method allows you to get information about the output
     * @param string $withdrawalId Withdrawal ID in the system
     * @return array
     * @throws Exception
     */
    public function get(string $withdrawalId): array
    {
        return $this->instance->request('get-withdrawal', compact('withdrawalId'));
    }
}
