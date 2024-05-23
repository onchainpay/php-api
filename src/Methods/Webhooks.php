<?php namespace OnChainPay\Methods;

use OnChainPay\Enums\WebhookField;
use OnChainPay\Exception;
use OnChainPay\Extends\Method;

class Webhooks extends Method
{
    /**
     * The method allows you to get the original body of the webhook
     * @param string $webhookId Webhook ID
     * @return array
     * @throws Exception
     */
    public function get(string $webhookId): array
    {
        return $this->instance->request('webhooks/get', compact('webhookId'));
    }

    /**
     * The method allows you to get full information about the webhook
     * @param string $webhookId Webhook ID
     * @param WebhookField|WebhookField[]|null $fields
     * @return array
     * @throws Exception
     */
    public function getVerbose(string $webhookId, WebhookField|array $fields = null): array
    {
        $params = compact('webhookId');

        if(is_array($fields)) {
            foreach ($fields as $field)
                if ($field instanceof WebhookField)
                    $params['fields'][] = $field->value;
        } elseif($fields instanceof WebhookField) {
            $params['fields'] = [$fields->value];
        }

        return $this->instance->request('webhooks/get-verbose', $params);
    }
}
