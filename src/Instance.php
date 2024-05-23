<?php namespace OnChainPay;

class Instance
{

    private string $publicKey;
    private string $privateKey;
    private string $endpoint;
    private float $nonce;
    private array $params = [];
    private string $baseUrl;
    private ?string $advId = null;


    public function __construct(string $publicKey, string $privateKey, string $baseUrl = 'https://ocp.onchainpay.io/api-gateway')
    {
        $this->publicKey = $publicKey;
        $this->privateKey = $privateKey;
        $this->baseUrl = $baseUrl;
    }

    private function updNonce()
    {
        $this->nonce = floor(microtime(true) * 1000);
    }

    public function setEndpoint(string $endpoint = null): Instance
    {
        if($endpoint)
            $this->endpoint = $endpoint;
        return $this;
    }

    public function getEndpoint(): ?string
    {
        return sprintf('%s/%s/',$this->baseUrl, trim($this->endpoint, '/\\'));
    }

    public function setParams(array $params = null): Instance
    {
        if($params)
            $this->params = array_merge($this->params, $params);

        ksort($this->params);

        return $this;
    }

    public function getParams(): ?array
    {
        return array_merge($this->params, ['nonce' => $this->nonce]);
    }

    public function getParam(string $name)
    {
        return $this->params[$name] ?? null;
    }

    private function getSignature(): string
    {
        return hash_hmac('sha256', json_encode($this->getParams()), $this->privateKey);
    }

    /**
     * @throws Exception
     */
    public function request(string $endpoint = null, array $params = null)
    {
        $this->setEndpoint($endpoint);
        $this->setParams($params);
        $this->updNonce();

        $curlOptions = [
            CURLOPT_URL => $this->getEndpoint(),
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_CONNECTTIMEOUT => 20,
            CURLOPT_HTTPHEADER => [
                'Content-Type:application/json',
                'x-api-public-key:'.$this->publicKey,
                'x-api-signature:'.$this->getSignature(),
            ],
            CURLOPT_POST  => true,
            CURLOPT_POSTFIELDS => json_encode($this->getParams()),
        ];

        $curlHandle = curl_init();
        curl_setopt_array($curlHandle, $curlOptions);
        $responseJSON = curl_exec($curlHandle);
        $response = json_decode($responseJSON, true);
        $responseInfo = curl_getinfo($curlHandle);

        if (curl_errno($curlHandle)) {
            throw new Exception(curl_error($curlHandle), $responseInfo['http_code']);
        }

        if(substr($responseInfo['http_code'],0,1) !== '2' || !($response['success'] ?? false)) {
            $error = $response['error'] ?? null;
            if($error)
                throw new Exception(
                    $error['name']
                        ? $error['name'].': '.($error['message'] ?? '')
                        : ($error['message']??  ''),
                    $error['code'] ?? 0
                );
            if(is_array($response['response']['errors']))
                throw new Exception(implode(' ', $response['response']['errors']));

            throw new Exception();
        }

        return $response['response'] ?? [];
    }


    /**
     * Get id advanced balance
     * @return string
     * @throws Exception
     */
    public function getAdvId(): ?string
    {
        if($this->advId === null) {
            $list = $this->request('advanced-balances');

            $this->advId = $list[0]['advancedBalanceId'] ?? null;
        }

        return $this->advId;
    }
}
