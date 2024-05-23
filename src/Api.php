<?php namespace OnChainPay;

use OnChainPay\Methods\AddressBook;
use OnChainPay\Methods\AdvancedAccount;
use OnChainPay\Methods\AutoSwap;
use OnChainPay\Methods\BlockchainAddresses;
use OnChainPay\Methods\CrosschainBridge;
use OnChainPay\Methods\CrosschainSwap;
use OnChainPay\Methods\Invoices;
use OnChainPay\Methods\KYT;
use OnChainPay\Methods\Orders;
use OnChainPay\Methods\Orphans;
use OnChainPay\Methods\PersonalAddresses;
use OnChainPay\Methods\Withdrawals;

class Api
{
    protected Instance $instance;
    public AdvancedAccount $account;
    public BlockchainAddresses $addresses;
    public PersonalAddresses $personal;
    public Orders $order;
    public Withdrawals $withdrawal;
    public Invoices $invoice;
    public AutoSwap $autoSwap;
    public CrosschainBridge $crosschainBridge;
    public CrosschainSwap $crosschainSwap;
    public KYT $kyt;
    public AddressBook $addressBook;
    public Orphans $orphan;

    public function __construct(string $publicKey, string $privateKey)
    {
        $this->instance = new Instance($publicKey, $privateKey, 'https://ocp.onchainpay.io/api-gateway');
        $this->account = new AdvancedAccount($this->instance);
        $this->addresses = new BlockchainAddresses($this->instance);
        $this->personal = new PersonalAddresses($this->instance);
        $this->order = new Orders($this->instance);
        $this->withdrawal = new Withdrawals($this->instance);
        $this->invoice = new Invoices($this->instance);
        $this->autoSwap = new AutoSwap($this->instance);
        $this->crosschainBridge = new CrossChainBridge($this->instance);
        $this->crosschainSwap = new CrossChainSwap($this->instance);
        $this->kyt = new KYT($this->instance);
        $this->addressBook = new AddressBook($this->instance);
        $this->orphan = new Orphans($this->instance);
        return $this;
    }

    /**
     * You can test your signature in x-api-signature within this method.
     * @return bool
     * @throws Exception
     */
    public function verifySignature(): bool
    {
        return $this->instance->request('test-signature')['checkSignatureResult'] ?? false;
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
        return (float) $this->instance->request('price-rate', compact('from', 'to'));
    }

    /**
     * Get list of available currencies for depositing/withdrawing
     * @return array
     * @throws Exception
     */
    public function getAvailableCurrenciesList(): array
    {
        return $this->instance->request('available-currencies');
    }
}
