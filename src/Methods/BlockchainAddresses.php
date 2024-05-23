<?php namespace OnChainPay\Methods;

use OnChainPay\Enums\TransactionStatus;
use OnChainPay\Enums\TransactionType;
use OnChainPay\Exception;
use OnChainPay\Extends\Method;

class BlockchainAddresses extends Method
{
    /**
     * The method allows you to find an address belonging to an organization by its ID, regardless of its type
     * @param string $id
     * @return array
     * @throws Exception
     */
    public function findById(string $id): array
    {
        return $this->instance->request('addresses/find-by-id', compact('id'));
    }

    /**
     * The method allows you to find addresses belonging to an organization at an address in the blockchain,
     * regardless of the type and network. Returns an array of addresses found
     * @param string $address
     * @return array
     * @throws Exception
     */
    public function findByAddress(string $address): array
    {
        return $this->instance->request('addresses/find-by-address', compact($address));
    }

    /**
     * Transactions tracking
     * @param string $address
     * @param string $webhookUrl
     * @return array
     * @throws Exception
     */
    public function trackAddress(string $address, string $webhookUrl): array
    {
        return $this->instance->request('track-addresses/add-address', compact('address', 'webhookUrl'));
    }

    /**
     * The method allows you to set the meta-data for the address.
     * @param string $id
     * @param array|string|null $meta
     * @return array
     * @throws Exception
     */
    public function setMeta(string $id, array|string|null $meta): array
    {
        return $this->instance->request('track-addresses/add-address', compact('id', 'meta'));
    }

    /**
     * The method allows you to get a list of transactions at the address.
     * @param string $id Address ID
     * @param TransactionType|null $type Transaction type
     * @param TransactionStatus[]|null $statuses Transaction status
     * @param int|null $limit Number of elements per page
     * @param int|null $offset Number of items to skip
     * @return array
     * @throws Exception
     */
    public function transactions(string $id, TransactionType $type = null, array $statuses = null, int $limit = null, int $offset = null): array
    {
        $params = compact('id');

        if ($type)
            $params['type'] = $type->value;

        foreach($statuses as $status)
            if($status instanceof TransactionStatus)
                $params['status'][] = $status->value;

        if ($limit)
            $params['limit'] = $limit;

        if ($offset)
            $params['offset'] = $offset;

        return $this->instance->request('addresses/transactions', $params);
    }

    /**
     * The method allows you to get the last transaction of the address.
     * @param string|null $id Address ID. Required, if 'address' was not provided
     * @param string|null $address Blockchain address. Required, if 'id' was not provided
     * @return array
     * @throws Exception
     */
    public function lastTransaction(string $id = null, string $address = null): array
    {
        if($id === null && $address === null)
            throw new Exception('id/address is required');

        $params = [];

        if($id !== null)
            $params['id'] = $id;

        if($address !== null)
            $params['address'] = $address;

        return $this->instance->request('addresses/last-transaction', $params);
    }

    /**
     * The method allows you to get PayIn address data (address, balance, identifier, etc.)
     * @param string|null $advancedBalanceId Advance balance identifier
     * @return array
     * @throws Exception
     */
    public function getPayInAddresses(string $advancedBalanceId = null): array
    {
        return $this->instance->request('account-addresses', [
            'advancedBalanceId' => $advancedBalanceId ?? $this->instance->getAdvId(),
        ]);
    }

    /**
     * Get business addresses for your advanced balance
     * @param string|null $advancedBalanceId Advance balance identifier
     * @return array
     * @throws Exception
     */
    public function getBusinessAddresses(string $advancedBalanceId = null): array
    {
        return $this->instance->request('business-addresses', [
            'advancedBalanceId' => $advancedBalanceId ?? $this->instance->getAdvId(),
        ]);
    }

    /**
     * The method allows you to create a new business address.
     * @param string $currency Coin ticker
     * @param string $network Network name
     * @param string $alias Address alias
     * @param string $comment Comment to the address
     * @param string|null $advancedBalanceId Advance balance identifier
     * @return array
     * @throws Exception
     */
    public function createBusinessAddress(
        string $currency,
        string $network,
        string $alias,
        string $comment,
        string $advancedBalanceId = null
    ): array
    {
        return $this->instance->request('business-address', [
            'advancedBalanceId' => $advancedBalanceId ?? $this->instance->getAdvId(),
            'currency' => $currency,
            'network' => $network,
            'alias' => $alias,
            'comment' => $comment,
        ]);
    }

    /**
     * Get recurrent addresses for your advanced balance
     * @param string|null $advancedBalanceId Advance balance identifier
     * @return array
     * @throws Exception
     */
    public function getRecurrentAddresses(string $advancedBalanceId = null): array
    {
        return $this->instance->request('recurrent-addresses', [
            'advancedBalanceId' => $advancedBalanceId ?? $this->instance->getAdvId(),
        ]);
    }

    /**
     * The method allows you to get balances for this account.
     * @param string|null $advancedBalanceId
     * @return array
     * @throws Exception
     */
    public function getPayOutAddresses(string $advancedBalanceId = null): array
    {
        return $this->instance->request('payout-balances', [
            'advancedBalanceId' => $advancedBalanceId ?? $this->instance->getAdvId(),
        ]);
    }

    /**
     * The method allows you to create a new PayOut address.
     * @param string $currency Coin ticker
     * @param string $network Network name
     * @return array
     * @throws Exception
     */
    public function createPayOutAddresses(string $currency, string $network): array
    {
        return $this->instance->request('create-payout-address', [
            'currency' => $currency,
            'network' => $network,
        ]);
    }
}
