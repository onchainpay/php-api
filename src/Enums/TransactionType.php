<?php namespace OnChainPay\Enums;

enum TransactionType : string
{
    case Withdrawal = 'withdrawal';
    case Deposit = 'deposit';
}
