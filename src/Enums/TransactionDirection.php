<?php

namespace OnChainPay\Enums;

enum TransactionDirection: string
{
    /**
     * The risks of the completed transaction on the part of the sender will be checked
     */
    case Sent = 'sent';
    /**
     * The risks of receiving coins to your address will be checked
     */
    case Received = 'received';
}
