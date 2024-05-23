<?php

namespace OnChainPay\Methods;

use OnChainPay\Enums\InvoiceStatus;
use OnChainPay\Exception;
use OnChainPay\Extends\Method;

class Invoices extends Method
{
    /**
     * The method allows you to create an invoice for payment without a strict indication of the coin and network
     * @param string $currency Coins for payment
     * @param float $amount Amount payable in the specified coin
     * @param array $currencies List of coins and networks available for payment
     * @param int $lifetime Invoice lifetime in minutes
     * @param string|null $order Order ID in the merchant system
     * @param string|null $description Order Description
     * @param string|null $externalId A unique identifier in the merchant's system to prevent duplication of invoices
     * @param bool|null $includeFee The flag allows you to include the commission of the blockchain network selected for payment in the amount payable
     * @param array|null $additionalFees Array with the tariff names, which allows you to include commission in final amount for the specified tariffs
     * @param float|null $insurancePercent Allows you to add the specified percentage to the payment amount
     * @param float|null $slippagePercent When opening the invoice page, the user can spend so much time on it that the exchange rate changes
     * @param string|null $webhookURL URL for notifications when the status of an invoice or amount received changes
     * @param string|null $returnURL URL to specify as "Return to Store" on the checkout page
     * @param string|null $advancedBalanceId Identifier of the advance balance for writing off commissions
     * @return array
     * @throws Exception
     */
    public function create(
        string $currency,
        float $amount,
        array $currencies,
        int $lifetime,
        string $order = null,
        string $description = null,
        string $externalId = null,
        bool $includeFee = null,
        array $additionalFees = null,
        float $insurancePercent = null,
        float $slippagePercent = null,
        string $webhookURL = null,
        string $returnURL = null,
        string $advancedBalanceId = null
    ): array
    {
        $params  = [
            'advancedBalanceId' => $advancedBalanceId ?? $this->instance->getAdvId(),
            'currency' => $currency,
            'amount' => $amount,
            'currencies' => $currencies,
            'lifetime' => $lifetime,
        ];

        if($order !== null)
            $params['order'] = $order;

        if($description !== null)
            $params['description'] = $description;

        if($externalId !== null)
            $params['externalId'] = $externalId;

        if($includeFee !== null)
            $params['includeFee'] = $includeFee;

        if($additionalFees !== null)
            $params['additionalFees'] = $additionalFees;

        if($insurancePercent !== null)
            $params['insurancePercent'] = $insurancePercent;

        if($slippagePercent !== null)
            $params['slippagePercent'] = $slippagePercent;

        if($webhookURL !== null)
            $params['webhookURL'] = $webhookURL;

        if($returnURL !== null)
            $params['returnURL'] = $returnURL;

        return $this->instance->request('make-invoice', $params);
    }

    /**
     * The method allows you to get information about the invoice
     * @param string $invoiceId Invoice ID
     * @return array
     * @throws Exception
     */
    public function get(string $invoiceId): array
    {
        return $this->instance->request('get-invoice', compact('invoiceId'));
    }

    /**
     * @param InvoiceStatus|InvoiceStatus[]|null $statuses
     * @param int|null $limit
     * @param int|null $offset
     * @return array
     * @throws Exception
     */
    public function list(InvoiceStatus|array $statuses = null, int $limit = null, int $offset = null): array
    {
        $params = [];

        if(is_array($statuses)) {
            foreach ($statuses as $status)
                if ($status instanceof InvoiceStatus)
                    $params['status'][] = $status->value;
        } elseif($statuses instanceof InvoiceStatus) {
            $params['status'] = [$statuses->value];
        }

        if($limit !== null)
            $params['limit'] = $limit;

        if($offset !== null)
            $params['offset'] = $offset;

        return $this->instance->request('get-invoices', $params);
    }
}
