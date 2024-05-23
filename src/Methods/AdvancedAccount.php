<?php namespace OnChainPay\Methods;

use OnChainPay\Exception;
use OnChainPay\Extends\Method;

class AdvancedAccount extends Method
{

    /**
     * Get list of advanced balances of user
     * @return array
     * @throws Exception
     */
    public function getAdvancedBalancesList(): array
    {
        return $this->instance->request('advanced-balances');
    }

    /**
     * Get info about advanced balance by its id
     * @param ?string $advancedBalanceId
     * @return array
     * @throws Exception
     */
    public function getAdvancedBalanceInfo(string $advancedBalanceId  = null): array
    {
        return $this->instance->request('advanced-balance', [
            'advancedBalanceId' => $advancedBalanceId ?? $this->instance->getAdvId(),
        ]);
    }

    /**
     * Get payment address for deposit to your advanced balance
     * @param string $network
     * @param string $currency
     * @param ?string $advancedBalanceId
     * @return array
     * @throws Exception
     */
    public function getAdvancedBalancePaymentAddress(string $network, string $currency, string $advancedBalanceId = null): array
    {
        return $this->instance->request('advanced-balance-deposit-address', [
            'advancedBalanceId' => $advancedBalanceId ?? $this->instance->getAdvId(),
            'network' => $network,
            'currency' => $currency,
        ]);
    }
}
