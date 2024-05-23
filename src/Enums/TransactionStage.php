<?php

namespace OnChainPay\Enums;

enum TransactionStage: string
{
    case Deposit = 'DEPOSIT';
    case Withdrawal = 'WITHDRAWAL';
}
