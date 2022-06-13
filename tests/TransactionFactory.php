<?php

namespace Dinhdjj\Wallet\Tests;

use Dinhdjj\Wallet\Enums\TransactionStatus;
use Dinhdjj\Wallet\Models\Transaction;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Arr;

class TransactionFactory extends Factory
{
    protected $model = Transaction::class;

    public function definition(): array
    {
        $user = User::create();

        return [
            'transferer_id' => WalletFactory::new(),
            'receiver_id' => WalletFactory::new(),
            'amount' => random_int(0, 999999),
            'description' => $this->faker->sentence(),
            'status' => Arr::random(TransactionStatus::cases())->value,
        ];
    }
}
