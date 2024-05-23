<?php namespace OnChainPay\Methods;

use OnChainPay\Exception;
use OnChainPay\Extends\Method;

class AutoSwap extends Method
{
    /**
     * The method create auto-swap request
     * @param string $address The address to receive
     * @param string $currency The coin you want to receive
     * @param string $network The network where you want to receive coins
     * @param string|null $amountFrom Outgoing amount
     * @param string|null $amountTo The final amount
     * @param bool|null $feeInAmount To include the network commission in the amount to swap, when specifying this parameter, the amountTo will be equal to the amount that the address will receive
     * @param string|null $webhookUrl URL for sending a status change notification
     * @return array
     * @throws Exception
     */
    public function create(
        string $address,
        string $currency,
        string $network,
        string $amountFrom = null,
        string $amountTo = null,
        bool $feeInAmount  = null,
        string $webhookUrl = null
    ): array
    {
        $params = compact('address', 'currency', 'network');

        if($amountFrom !== null)
            $params['amountFrom'] = $amountFrom;

        if($amountTo !== null)
            $params['amountTo'] = $amountTo;

        if($feeInAmount !== null)
            $params['feeInAmount'] = $feeInAmount;

        if($webhookUrl !== null)
            $params['webhookUrl'] = $webhookUrl;

        return $this->instance->request('auto-swaps/create', $params);
    }

    /**
     * Auto-swap ID
     * @param string $id Auto-swap ID
     * @return array
     * @throws Exception
     */
    public function get(string $id): array
    {
        return $this->instance->request('auto-swaps/get', compact('id'));
    }
}
