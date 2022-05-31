<?php

namespace Dinhdjj\Wallet\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @see \Dinhdjj\Wallet\Wallet
 */
class Wallet extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'wallet';
    }
}
