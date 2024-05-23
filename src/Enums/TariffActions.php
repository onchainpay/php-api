<?php  namespace OnChainPay\Enums;

enum TariffActions: string
{
    /**
     * Internal transfer
     */
    case InternalTransfer = 'INTERNAL_TRANSFER';
    /**
     * Accepting payments for order
     */
    case OrderDeposit = 'ORDER_DEPOSIT';
    /**
     * Deposit to wallet
     */
    case WalletDeposit = 'WALLET_DEPOSIT';
    /**
     * Withdrawal from wallet
     */
    case WalletWithdrawal = 'WALLET_WITHDRAWAL';
    /**
     * Deposit to payout balance
     */
    case PayoutDeposit = 'PAYOUT_DEPOSIT';
    /**
     * Withdrawal from payout balance
     */
    case PayoutWithdrawal = 'PAYOUT_WITHDRAWAL';
    /**
     *
     * Deposit to personal address
     */
    case PersonalDeposit = 'PERSONAL_DEPOSIT';
    /**
     * Withdrawal from personal address
     */
    case PersonalWithdrawal = 'PERSONAL_WITHDRAWAL';
    /**
     * Deposit to recurrent address
     */
    case RecurrentDeposit = 'RECURRENT_DEPOSIT';
    /**
     * Withdrawal from recurrent address
     */
    case RecurrentWithdrawal = 'RECURRENT_WITHDRAWAL';
    /**
     * Blockchain bridge (change network)
     */
    case BridgeInternal = 'BRIDGE_INTERNAL';
    /**
     * Blockchain bridge via API
     */
    case BridgeExternal = 'BRIDGE_EXTERNAL';
    /**
     * Exchange
     */
    case ExchangeInternal = 'EXCHANGE_INTERNAL';
    /**
     * Exchange via API
     */
    case ExchangeAuto = 'EXCHANGE_AUTO';
    case KytTransaction = 'KYT_TRANSACTION';
    case KytWithdrawalAddress = 'KYT_WITHDRAWAL_ADDRESS';
    case KytAddress = 'KYT_ADDRESS';
    case OrphanDepositWithdrawal = 'ORPHAN_DEPOSIT_WITHDRAWAL';
    case SepaWithdrawal = 'SEPA_WITHDRAWAL';
    case SepaDeposit = 'SEPA_DEPOSIT';
    case FiatCryptoExchange = 'FIAT_CRYPTO_EXCHANGE';
}
