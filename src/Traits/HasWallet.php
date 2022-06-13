<?php

namespace Dinhdjj\Wallet\Traits;

use Dinhdjj\Wallet\Models\Wallet;
use Illuminate\Database\Eloquent\Relations\MorphOne;

trait HasWallet
{
    protected static function bootHasWallet(): void
    {
        static::deleting(function (self $holder): void {
            if (method_exists($holder, 'isForceDeleting') ? $holder->isForceDeleting() : true) {
                $holder->wallet->delete();
            }
        });
    }

    public function wallet(): MorphOne
    {
        return $this->morphOne(config('wallet.wallet.model', Wallet::class), 'holder')
            ->withDefault(fn () => $this->wallet()->create())
        ;
    }
}
