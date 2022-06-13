<?php

namespace Dinhdjj\Wallet\Tests;

use Illuminate\Database\Eloquent\SoftDeletes;

class SoftUser extends User
{
    use SoftDeletes;
}
