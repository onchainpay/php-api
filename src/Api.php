<?php namespace OnChainPay;


class Api
{
    protected Instance $apiInstance;

    public function __construct(string $publicKey, string $privateKey)
    {
        $this->apiInstance = new Instance($publicKey, $privateKey);
        return $this;
    }

    /**
     * You can test your signature in x-api-signature within this method.
     * @return bool
     * @throws Exception
     */
    public function verifySignature(): bool
    {
        return $this->apiInstance->request('test-signature')['checkSignatureResult'] ?? false;
    }

    /**
     * Get price rate from one currency to another
     * @param string $from
     * @param string $to
     * @return float
     * @throws Exception
     */
    public function priceRate(string $from, string $to): float
    {
        return (float) $this->apiInstance->request('price-rate', compact('from', 'to'));
    }

    /**
     * Get list of available currencies for depositing/withdrawing
     * @return array
     * @throws Exception
     */
    public function getAvailableCurrenciesList(): array
    {
        return $this->apiInstance->request('available-currencies');
    }

    /**
     * Get list of advanced balances of user
     * @return array
     * @throws Exception
     */
    public function getAdvancedBalancesList(): array
    {
        return $this->apiInstance->request('advanced-balances');
    }

    /**
     * Get info about advanced balance by its id
     * @param string $advancedBalanceId
     * @return array
     * @throws Exception
     */
    public function getAdvancedBalanceInfo(string $advancedBalanceId): array
    {
        return $this->apiInstance->request('advanced-balance', compact('advancedBalanceId'));
    }

    /**
     * Get payment address for deposit to your advanced balance
     * @param string $advancedBalanceId
     * @param string $network
     * @param string $currency
     * @return array
     * @throws Exception
     */
    public function getAdvancedBalancePaymentAddress(string $advancedBalanceId, string $network, string $currency): array
    {
        return $this->apiInstance->request('advanced-balance-deposit-address',
            compact('advancedBalanceId', 'network', 'currency'));
    }

    /**
     * Get list with info about balances of addresses
     * @param string $advancedBalanceId
     * @return array
     * @throws Exception
     */
    public function getAddressesBalances(string $advancedBalanceId): array
    {
        return $this->apiInstance->request('account-addresses', compact('advancedBalanceId'));
    }

    /**
     * Create business address
     * @param string $advancedBalanceId
     * @param string $network
     * @param string $currency
     * @param string $alias
     * @param string $comment
     * @return array
     * @throws Exception
     */
    public function createBusinessAddress(
        string $advancedBalanceId,
        string $network,
        string $currency,
        string $alias,
        string $comment
    ): array
    {
        return $this->apiInstance->request('business-address',
            compact('advancedBalanceId', 'network', 'currency', 'alias', 'comment'));
    }

    /**
     * Get business addresses list
     * @param string $advancedBalanceId
     * @return array
     * @throws Exception
     */
    public function getBusinessAddressesList(string $advancedBalanceId): array
    {
        return $this->apiInstance->request('business-addresses', compact('advancedBalanceId'));
    }

    /**
     * Get recurrent addresses list
     * @return array
     * @throws Exception
     */
    public function getRecurrentAddressesList(): array
    {
        return $this->apiInstance->request('recurrent-addresses');
    }

    /**
     * @throws Exception
     */
    public function createSubscriberBillingLink(
        string $merchantId,
        string $clientId,
        string $clientEmail,
        string $clientName,
        string $returnUrl,
        string $webhookUrl
    ): array
    {
        return $this->apiInstance->request('recurrents/create-subscriber-billing-link',
            compact('merchantId', 'clientId', 'clientEmail', 'clientName', 'returnUrl', 'webhookUrl'));
    }

    /**
     * @throws Exception
     */
    public function disableSubscriberBillingLink(
        string $id,
        string $merchantId
    ): array
    {
        return $this->apiInstance->request('recurrents/disable-subscriber-billing-link',
            compact('id', 'merchantId'));
    }

    /**
     * @throws Exception
     */
    public function getBillingLink(
        string $id,
        string $merchantId
    ): array
    {
        return $this->apiInstance->request('recurrents/get-billing-link',
            compact('id', 'merchantId'));
    }

    /**
     * @throws Exception
     */
    public function getBillingLinkBySubscriber(
        string $clientId,
        string $merchantId
    ): array
    {
        return $this->apiInstance->request('recurrents/get-billing-links-by-subscriber',
            compact('clientId', 'merchantId'));
    }

    /**
     * Create subscription (periodical payments) to provided billing link.
     * @param string $merchantId Merchant ID
     * @param string $billingLinkId Billink link ID
     * @param string $spendInterval In minutes (or -1 every day; -2 every week; -3 every 28 days)
     * @param string $currency Amount of subscription will be processed in this currency
     * @param float $amount Amount of periodical payment
     * @param string $title Subscription title
     * @param string|null $description Subscription description
     * @param string|null $webhookUrl URL for receiving info about subscription statuses and payments
     * @return array
     * @throws Exception
     */
    public function createSubscription(
        string $merchantId,
        string $billingLinkId,
        string $spendInterval,
        string $currency,
        float $amount,
        string $title,
        string $description = null,
        string $webhookUrl = null
    ): array
    {
        $params = compact('merchantId', 'billingLinkId', 'spendInterval', 'currency','title');
        $params['amount'] = (string) $amount;
        if($description)
            $params['description'] = $description;
        if($webhookUrl)
            $params['webhookUrl'] = $webhookUrl;
        return $this->apiInstance->request('recurrents/create-subscription', $params);
    }

    /**
     * Get subscription by its id.
     * @throws Exception
     */
    public function getSubscription(string $merchantId, string $id): array
    {
        return $this->apiInstance->request('recurrents/get-subscription',
            compact('merchantId', 'id'));
    }

    /**
     * Cancel subscription by its id.
     * @throws Exception
     */
    public function cancelSubscription(string $merchantId, string $id): array
    {
        return $this->apiInstance->request('recurrents/cancel-subscription',
            compact('merchantId', 'id'));
    }

    /**
     * Make one-time payment with specific billing link.
     * @throws Exception
     */
    public function makePayment(
        string $merchantId,
        string $billingLinkId,
        float $amount,
        string $webhookUrl
    ): array
    {
        $params = compact('merchantId', 'billingLinkId', $webhookUrl);
        $params['amount'] = (string) $amount;
        return $this->apiInstance->request('recurrents/make-payment', $params);
    }

    /**
     * Get payout address
     * @param string $network
     * @param string $currency
     * @return array
     * @throws Exception
     */
    public function getPayoutAddress(string $network, string $currency): array
    {
        return $this->apiInstance->request('payout-address', compact('network', 'currency'));
    }

    /**
     * Get list with info about balances of addresses
     * @return array
     * @throws Exception
     */
    public function getPayoutBalancesList(): array
    {
        return $this->apiInstance->request('payout-balances');
    }

    /**
     * Create order and get address for payments
     * @param string $advancedBalanceId
     * @param string $network
     * @param string $currency
     * @param float $amount
     * @param string $order
     * @param int $lifetime
     * @param string $description
     * @param string $successWebhook
     * @param string $errorWebhook
     * @param string $returnUrl
     * @return array
     * @throws Exception
     *
     */
    public function createOrder(
        string $advancedBalanceId,
        string $network,
        string $currency,
        float $amount,
        string $order,
        int $lifetime,
        string $description,
        string $successWebhook,
        string $errorWebhook,
        string $returnUrl
    ): array
    {
        $amount = (string) $amount;
        return $this->apiInstance->request('make-order',
            compact(
                'advancedBalanceId',
                'network',
                'currency',
                'amount',
                'order',
                'lifetime',
                'description',
                'successWebhook',
                'errorWebhook',
                'returnUrl',
            ));
    }

    /**
     * Get information about order
     * @param string $orderId
     * @return array
     * @throws Exception
     */
    public function getOrderInfo(string $orderId): array
    {
        return $this->apiInstance->request('order', compact('orderId'));
    }

    /**
     * You should fetch withdrawal fee amount before actual withdrawal and use token parameter
     * @param string $advancedBalanceId
     * @param string $addressId
     * @param float $amount
     * @return array
     * @throws Exception
     */
    public function getWithdrawalFee(string $advancedBalanceId, string $addressId, float $amount): array
    {
        return $this->apiInstance->request('fee-token',
            compact('advancedBalanceId', 'addressId', 'amount'));
    }

    /**
     * Make withdrawal from address balance. You need to pass feeToken parameter from previous method (getWithdrawalFee)
     * @param string $advancedBalanceId
     * @param string $addressId
     * @param string $address
     * @param float $amount
     * @param string $feeToken
     * @param string $tag
     * @return array
     * @throws Exception
     */
    public function createWithdrawal(
        string $advancedBalanceId,
        string $addressId,
        string $address,
        float $amount,
        string $feeToken,
        string $tag
    ): array
    {

        return $this->apiInstance->request('make-withdrawal',
            compact(
                'advancedBalanceId',
                'addressId',
                'address',
                'amount',
                'feeToken',
                'tag'
            ));
    }

    /**
     * The method allows you to obtain information on a previously made conclusion
     * @param string $withdrawalId
     * @return array
     * @throws Exception
     */
    public function getWithdrawal(string $withdrawalId): array
    {
        return $this->apiInstance->request('get-withdrawal', compact('withdrawalId'));
    }

    /**
     * Invoicing for payment
     * @param string $advancedBalanceId
     * @param string $order
     * @param string $description
     * @param string $currency
     * @param float $amount
     * @param bool $includeFee
     * @param float $insurancePercent
     * @param float $slippagePercent
     * @param string $webhookURL
     * @param string $returnURL
     * @param int $lifetime
     * @param array $currencies
     * @return array
     * @throws Exception
     */
    public function createInvoice(
        string $advancedBalanceId,
        string $order,
        string $description,
        string $currency,
        float $amount,
        bool $includeFee,
        float $insurancePercent,
        float $slippagePercent,
        string $webhookURL,
        string $returnURL,
        int $lifetime,
        array $currencies
    ): array
    {
        return $this->apiInstance->request('make-invoice',
            compact(
                'advancedBalanceId',
                'order',
                'description',
                'currency',
                'amount',
                'includeFee',
                'insurancePercent',
                'slippagePercent',
                'webhookURL',
                'returnURL',
                'lifetime',
                'currencies'
            ));
    }

    /**
     * Get invoice information
     * @param string $invoiceId
     * @return array
     * @throws Exception
     */
    public function getInvoiceInfo(string $invoiceId): array
    {
        return $this->apiInstance->request('get-invoice', compact('invoiceId'));
    }

}