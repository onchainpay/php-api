<?php namespace OnChainPay\Enums;

enum InvoiceStatus : string
{

    /**
     * The user proceeded to payment
     */
    case Init = 'INIT';
    /**
     * Error during creation or processing
     */
    case Error = 'ERROR';
    /**
     * Executed
     */
    case Processed = 'PROCESSED';
    /**
     * Waiting for the full amount or waiting for transaction confirmations in the blockchain
     */
    case Pending = 'PENDING';
    /**
     * Invoice expired
     */
    case Expired = 'EXPIRED';
    /**
     * Partial payment
     */
    case Partial = 'PARTIAL';
    /**
     * The invoice was paid in excess of the stated amount
     */
    case Overpaid = 'OVERPAID';
    /**
     * Invoice rejected, contact support for clarification
     */
    case Rejected = 'REJECTED';
}
