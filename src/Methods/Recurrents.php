<?php  namespace OnChainPay\Methods;

use OnChainPay\Exception;
use OnChainPay\Extends\Method;

class Recurrents extends Method
{
    /**
     * The method creates a temporary link to connect the user
     * @param string $merchantId Merchant ID in the system
     * @param string $clientId Client ID in the merchant system
     * @param string $clientEmail Client's mail in the merchant's system
     * @param string|null $clientName Client name in the merchant system
     * @param string|null $returnUrl URL to be used as "Return to Store" link
     * @param string|null $webhookUrl URL to notify about connecting or denying a client's connection request
     * @return array
     * @throws Exception
     */
    public function createPaymentLink(
        string $merchantId,
        string $clientId,
        string $clientEmail,
        string $clientName = null,
        string $returnUrl = null,
        string $webhookUrl = null
    ): array
    {
        $params = compact('merchantId', 'clientId', 'clientEmail');

        if($clientName !== null)
            $params['clientName'] = $clientName;

        if($returnUrl !== null)
            $params['returnUrl'] = $returnUrl;

        if($webhookUrl !== null)
            $params['webhookUrl'] = $webhookUrl;

        return $this->instance->request('recurrents/create-subscriber-billing-link', $params);
    }

    /**
     * The method allows you to get payment link data
     * @param string $id Payment link ID
     * @param string $merchantId Merchant ID in the system
     * @return array
     * @throws Exception
     */
    public function getPaymentLink(string $id, string $merchantId): array
    {
        return $this->instance->request('recurrents/get-billing-link', compact('id', 'merchantId'));
    }

    /**
     * The method allows you to get a list of payment links for a specific user
     * @param string $merchantId Merchant ID in the system
     * @param string|null $clientId Client ID
     * @param string|null $clientEmail Client mail
     * @return array
     * @throws Exception
     */
    public function getPaymentLinkByUser(string $merchantId, string $clientId = null, string $clientEmail = null): array
    {
        $params = compact('merchantId');

        if($clientId !== null)
            $params['clientId'] = $clientId;

        if($clientEmail !== null)
            $params['clientEmail'] = $clientEmail;

        return $this->instance->request('recurrents/get-billing-links-by-subscriber', $params);
    }

    /**
     * The method allows you to disable the payment link
     * @param string $id Payment link ID
     * @param string $merchantId Merchant ID
     * @return array
     * @throws Exception
     */
    public function disablePaymentLink(string $id, string $merchantId): array
    {
        return $this->instance->request('recurrents/disable-subscriber-billing-link', compact('id', 'merchantId'));
    }

    /**
     * The method allows you to connect a subscription
     * @param string $merchantId Merchant ID in the system
     * @param string $billingLinkId Payment link identifier
     * @param string $title Subscription name
     * @param int $spendInterval Write-off period in minutes
     * @param string $currency Payment currency
     * @param string $amount Payment amount in the specified currency
     * @param string|null $description Subscription Description
     * @param string|null $webhookUrl Subscription charge notification URL
     * @return array
     * @throws Exception
     */
    public function createSubscription(
        string $merchantId,
        string $billingLinkId,
        string $title,
        int $spendInterval,
        string $currency,
        string $amount,
        string $description = null,
        string $webhookUrl = null,
    ): array
    {
        $params = compact('merchantId', 'billingLinkId', 'title', 'spendInterval', 'currency', 'amount');

        if($description !== null)
            $params['description'] = $description;

        if($webhookUrl !== null)
            $params['webhookUrl'] = $webhookUrl;

        return $this->instance->request('recurrents/create-subscription', $params);
    }

    /**
     * The method allows you to get information about the subscription
     * @param string $id Subscription ID
     * @param string $merchantId Merchant ID
     * @return array
     * @throws Exception
     */
    public function getsubscription(string $id, string $merchantId): array
    {
        return $this->instance->request('recurrents/get-subscription', compact('id', 'merchantId'));
    }

    /**
     * The method allows you to disable a previously connected subscription
     * @param string $id Subscription ID
     * @param string $merchantId Merchant ID
     * @return array
     * @throws Exception
     */
    public function cancelSubscription(string $id, string $merchantId): array
    {
        return $this->instance->request('recurrents/cancel-subscriptionn', compact('id', 'merchantId'));
    }

    /**
     * The method allows you to create a payment with an arbitrary amount in the coin in which the address was connected
     * @param string $merchantId Merchant ID
     * @param string $billingLinkId Payment link ID
     * @param string $amount Payment amount in the currency in which the payment link was created
     * @param string|null $webhookUrl URL for notification of payment status change
     * @return array
     * @throws Exception
     */
    public function createPayment(
        string $merchantId,
        string $billingLinkId,
        string $amount,
        string $webhookUrl = null,
    ): array
    {
        $params = compact('merchantId', 'billingLinkId', 'amount');

        if($webhookUrl !== null)
            $params['webhookUrl'] = $webhookUrl;

        return $this->instance->request('recurrents/make-payment', $params);
    }
}
