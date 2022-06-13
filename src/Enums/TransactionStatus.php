<?php

namespace Dinhdjj\Wallet\Enums;

enum TransactionStatus :int
{
    case PENDING = 0;
    case SUCCESS = 1;
    case CANCELED = 2;
}
