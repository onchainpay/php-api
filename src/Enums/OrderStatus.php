<?php namespace OnChainPay\Enums;

enum OrderStatus : string
{

    /**
     * Order created
     */
    case Init = 'init';
    /**
     * Error during creation or execution
     */
    case Error = 'error';
    /**
     * Successful order payment
     */
    case Processed = 'processed';
    /**
     * Upon receipt of the first payment
     */
    case Pending = 'pending';
    /**
     * Order lifetime expired
     */
    case Expired = 'expired';
    /**
     * The warrant expired, but was partially paid
     */
    case Partial = 'partial';
    /**
     * The order was paid in excess of the specified amount
     */
    case Overpaid = 'overpaid';
}
