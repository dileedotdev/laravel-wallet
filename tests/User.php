<?php

namespace Dinhdjj\Wallet\Tests;

use Dinhdjj\Wallet\Traits\HasWallet;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class User extends Model
{
    use HasFactory;
    use HasWallet;

    public function getTable()
    {
        return 'users';
    }
}
