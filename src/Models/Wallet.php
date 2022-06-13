<?php

namespace Dinhdjj\Wallet\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphTo;

/**
 * @property int                                                                           $id
 * @property int                                                                           $balance
 * @property int                                                                           $holder_id
 * @property string                                                                        $holder_type
 * @property ?\Illuminate\Support\Carbon                                                   $created_at
 * @property ?\Illuminate\Support\Carbon                                                   $updated_at
 * @property \Illuminate\Database\Eloquent\Model                                           $holder
 * @property \Illuminate\Database\Eloquent\Collection&\Dinhdjj\Wallet\Models\Transaction[] $transferredTransactions
 * @property \Illuminate\Database\Eloquent\Collection&\Dinhdjj\Wallet\Models\Transaction[] $receivedTransactions
 */
class Wallet extends Model
{
    protected $hidden = [
    ];

    protected $fillable = [
        'balance',
    ];

    protected $casts = [
        'is_confirmed' => 'boolean',
    ];

    protected $appends = [
    ];

    protected static function booted(): void
    {
        static::deleting(function (self $wallet): void {
            $wallet->transferredTransactions->each->deleteAsTransferer();
            $wallet->receivedTransactions->each->deleteAsReceiver();
        });
    }

    public function holder(): MorphTo
    {
        return $this->morphTo();
    }

    public function transferredTransactions(): HasMany
    {
        return $this->hasMany(config('wallet.transaction.model', Transaction::class), 'transferer_id');
    }

    public function receivedTransactions(): HasMany
    {
        return $this->hasMany(config('wallet.transaction.model', Transaction::class), 'receiver_id');
    }
}
