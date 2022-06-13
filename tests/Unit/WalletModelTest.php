<?php

use Dinhdjj\Wallet\Enums\TransactionStatus;
use Dinhdjj\Wallet\Tests\TransactionFactory;
use Dinhdjj\Wallet\Tests\WalletFactory;
use Illuminate\Database\Eloquent\Model;

beforeEach(function (): void {
    $this->wallet = WalletFactory::new()->create();
});

it('has transferredTransactions', function (): void {
    $transaction = $this->wallet->transferredTransactions()->create(
        TransactionFactory::new()->raw(),
    );

    expect($this->wallet->transferredTransactions()->first()->id)->toBe($transaction->id);
});

it('has receivedTransactions', function (): void {
    $transaction = $this->wallet->receivedTransactions()->create(
        TransactionFactory::new()->raw(),
    );

    expect($this->wallet->receivedTransactions()->first()->id)->toBe($transaction->id);
});

it('has holder', function (): void {
    expect($this->wallet->holder)->toBeInstanceOf(Model::class);
});

it('update transactions on deleting case still exist receivers or transferers', function (): void {
    $transaction1 = $this->wallet->transferredTransactions()->create(
        TransactionFactory::new()->raw([
            'status' => TransactionStatus::SUCCESS,
        ]),
    );
    $transaction2 = $this->wallet->transferredTransactions()->create(
        TransactionFactory::new()->raw([
            'status' => TransactionStatus::CANCELED,
        ]),
    );
    $transaction3 = $this->wallet->transferredTransactions()->create(
        TransactionFactory::new()->raw([
            'status' => TransactionStatus::PENDING,
        ]),
    );
    $transaction4 = $this->wallet->receivedTransactions()->create(
        TransactionFactory::new()->raw([
            'status' => TransactionStatus::SUCCESS,
        ]),
    );
    $transaction5 = $this->wallet->receivedTransactions()->create(
        TransactionFactory::new()->raw([
            'status' => TransactionStatus::CANCELED,
        ]),
    );
    $transaction6 = $this->wallet->receivedTransactions()->create(
        TransactionFactory::new()->raw([
            'status' => TransactionStatus::PENDING,
        ]),
    );

    $this->wallet->delete();
    $transaction1->refresh();
    $transaction2->refresh();
    $transaction3->refresh();
    $transaction4->refresh();
    $transaction5->refresh();
    $transaction6->refresh();

    expect($transaction1->exists)->toBe(true);
    expect($transaction1->transferer_id)->toBe(null);
    expect($transaction1->status)->toBe(TransactionStatus::SUCCESS);
    expect($transaction2->exists)->toBe(true);
    expect($transaction2->transferer_id)->toBe(null);
    expect($transaction2->status)->toBe(TransactionStatus::CANCELED);
    expect($transaction3->exists)->toBe(true);
    expect($transaction3->transferer_id)->toBe(null);
    expect($transaction3->status)->toBe(TransactionStatus::CANCELED);

    expect($transaction4->exists)->toBe(true);
    expect($transaction4->receiver_id)->toBe(null);
    expect($transaction4->status)->toBe(TransactionStatus::SUCCESS);
    expect($transaction5->exists)->toBe(true);
    expect($transaction5->receiver_id)->toBe(null);
    expect($transaction5->status)->toBe(TransactionStatus::CANCELED);
    expect($transaction6->exists)->toBe(true);
    expect($transaction6->receiver_id)->toBe(null);
    expect($transaction6->status)->toBe(TransactionStatus::CANCELED);
});

it('delete transactions on deleting case not exist receivers or transferers', function (): void {
    $transaction1 = $this->wallet->transferredTransactions()->create(
        TransactionFactory::new()->raw([
            'receiver_id' => null,
        ]),
    );
    $transaction2 = $this->wallet->receivedTransactions()->create(
        TransactionFactory::new()->raw([
            'transferer_id' => null,
        ]),
    );

    $this->wallet->delete();

    expect($transaction1->exists())->toBe(false);
    expect($transaction2->exists())->toBe(false);
});
