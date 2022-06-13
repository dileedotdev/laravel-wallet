<?php

use Dinhdjj\Wallet\Models\Wallet;
use Dinhdjj\Wallet\Tests\SoftUser;
use Dinhdjj\Wallet\Tests\User;

it('has wallet and auto create if not exists', function (): void {
    $user = User::create();
    expect($user->wallet)->toBeInstanceOf(Wallet::class);
});

it('delete wallet on deleting', function (): void {
    $user = User::create();
    $wallet = $user->wallet;

    $user->delete();

    expect($wallet->exists())->toBe(false);
});

it('not delete wallet on soft deleting', function (): void {
    $user = SoftUser::create();
    $wallet = $user->wallet;

    $user->delete();

    expect($wallet->exists())->toBe(true);
});

it('delete wallet on force deleting', function (): void {
    $user = SoftUser::create();
    $wallet = $user->wallet;

    $user->forceDelete();

    expect($wallet->exists())->toBe(false);
});
