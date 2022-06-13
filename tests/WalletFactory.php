<?php

namespace Dinhdjj\Wallet\Tests;

use Dinhdjj\Wallet\Models\Wallet;
use Illuminate\Database\Eloquent\Factories\Factory;

class WalletFactory extends Factory
{
    protected $model = Wallet::class;

    public function definition(): array
    {
        $user = User::create();

        return [
            'holder_id' => $user->id,
            'holder_type' => $user->getMorphClass(),
            'balance' => random_int(0, 999999),
        ];
    }
}
