<?php

use Dinhdjj\Wallet\Models\Wallet;
use Dinhdjj\Wallet\Tests\TransactionFactory;

beforeEach(function (): void {
    $this->transaction = TransactionFactory::new()->create();
});

it('has receiver and transferer', function (): void {
    expect($this->transaction->transferer)->toBeInstanceOf(Wallet::class);
    expect($this->transaction->receiver)->toBeInstanceOf(Wallet::class);
});
