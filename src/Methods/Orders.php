<?php namespace OnChainPay\Methods;

use OnChainPay\Enums\OrderStatus;
use OnChainPay\Exception;
use OnChainPay\Extends\Method;

class Orders extends Method
{
    /**
     * Create an order for payment
     * @param string $currency Ticker of the coins in which the payment will be made
     * @param string $network The network of the coin in which the payment will be made
     * @param string $amount Payment amount
     * @param string $order Order ID in the merchant system
     * @param int $lifetime Order lifetime in seconds, available values from 1800 (30 minutes) to 43200 (12 hours)
     * @param string|null $advancedBalanceId Identifier of the advance balance for writing off commissions
     * @param string|null $errorWebhook URL to send webhook on error or order expiration
     * @param string|null $successWebhook URL to send webhook on successful payment
     * @param string|null $returnUrl URL to be placed on the payment page as "Return to Store" links
     * @param string|null $description Order Description
     * @param bool|null $checkRisks Whether to check incoming transactions for this order
     * @return array
     * @throws Exception
     */
    public function create(
        string $currency,
        string $network,
        string $amount,
        string $order,
        int $lifetime,
        string $advancedBalanceId = null,
        string $errorWebhook =  null,
        string $successWebhook =  null,
        string $returnUrl = null,
        string $description = null,
        bool $checkRisks = null
    ): array
    {
        if($lifetime < 1800 || $lifetime > 43200)
            throw new Exception("Parameter 'lifetime' should be in the range from 1800 to 43200");

        $params = compact('currency', 'network', 'amount', 'order', 'lifetime');

        $params['advancedBalanceId'] = $advancedBalanceId ?? $this->instance->getAdvId();

        if($errorWebhook != null)
            $params['errorWebhook'] = $errorWebhook;

        if($successWebhook != null)
            $params['successWebhook'] = $successWebhook;

        if($returnUrl != null)
            $params['returnUrl'] = $returnUrl;

        if($description != null)
            $params['description'] = $description;

        if ($checkRisks != null)
            $params['checkRisks'] = $checkRisks;

        return $this->instance->request('make-order', $params);
    }

    /**
     * The method allows you to get information on a previously created order by its identifier in the system
     * @param string $orderId Order ID in the system
     * @return array
     * @throws Exception
     */
    public function get(string $orderId): array
    {
        return $this->instance->request('order', compact('orderId'));
    }

    /**
     * The method allows you to get a list of orders
     * @param OrderStatus|OrderStatus[]|null $statuses Array for filtering orders by status
     * @param int|null $limit Number of elements per page
     * @param int|null $offset Number of items to skip
     * @return array
     * @throws Exception
     */
    public function list(OrderStatus|array $statuses = null, int $limit = null, int $offset = null): array
    {
        $params = [];

        if(is_array($statuses)) {
            foreach ($statuses as $status)
                if ($status instanceof OrderStatus)
                    $params['status'][] = $status->value;
        } elseif($statuses instanceof OrderStatus) {
            $params['status'] = [$statuses->value];
        }

        if($limit !== null)
            $params['limit'] = $limit;

        if($offset !== null)
            $params['offset'] = $offset;

        return $this->instance->request('orders', $params);
    }
}
