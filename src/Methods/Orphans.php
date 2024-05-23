<?php namespace OnChainPay\Methods;

use OnChainPay\Enums\TransactionStage;
use OnChainPay\Enums\TransactionStatus;
use OnChainPay\Exception;
use OnChainPay\Extends\Method;

class Orphans extends Method
{
    /**
     * Getting information about an orphan transaction by its ID
     * @param string $transactionId Transaction ID in the system
     * @return array
     * @throws Exception
     */
    public function get(string $transactionId): array
    {
        return $this->instance->request('orphan-deposits/get-deposit', ['id' => $transactionId]);
    }

    /**
     * Getting a list of orphan transactions with the ability to filter by certain criteria
     * @param int $limit Number of elements per page
     * @param int $offset Number of items to skip
     * @param string|null $id Transaction ID in the system
     * @param TransactionStage|null $stage The current stage of the transaction
     * @param TransactionStatus|null $status Status of the current stage of the transaction
     * @return array
     * @throws Exception
     */
    public function list(
        int $limit = 100,
        int $offset = 0,
        string $id = null,
        TransactionStage  $stage = null,
        TransactionStatus $status = null,
    ): array
    {
        return $this->instance->request('orphan-deposits/get-deposits', [
            'limit' => $limit,
            'offset' => $offset,
            'id' => $id,
            'stage' => $stage->value ?? null,
            'status' => $status->value ?? null,
        ]);
    }

    /**
     * Receiving a commission token to withdraw an orphan transaction
     * @param string $transactionId Transaction ID in the system
     * @return array
     * @throws Exception
     */
    public function getComissionToken(string $transactionId): array
    {
        return $this->instance->request('orphan-deposits/withdrawal-token', ['id' => $transactionId]);
    }

    /**
     * Receiving a commission token to withdraw an orphan transaction
     * @param string $token Withdrawal Token
     * @param string $address Output address
     * @param string|null $comment Comment on the conclusion
     * @param string|null $webhookUrl URL for sending a webhook about the withdrawal
     * @return array
     * @throws Exception
     */
    public function getWithdrawal(string $token, string $address, string $comment = null, string $webhookUrl = null): array
    {
        return $this->instance->request('orphan-deposits/withdrawal', compact(['token', 'address', 'comment', 'webhookUrl']));
    }
}
