<?php

namespace Dinhdjj\Wallet\Models;

use Dinhdjj\Wallet\Enums\TransactionStatus;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property int                                     $id
 * @property int                                     $amount
 * @property string                                  $description
 * @property ?int                                    $transferer_id
 * @property ?int                                    $receiver_id
 * @property \Dinhdjj\Wallet\Enums\TransactionStatus $status
 * @property ?\Illuminate\Support\Carbon             $created_at
 * @property ?\Illuminate\Support\Carbon             $updated_at
 * @property \Dinhdjj\Wallet\Models\Wallet           $transferer
 * @property \Dinhdjj\Wallet\Models\Wallet           $receiver
 */
class Transaction extends Model
{
    protected $hidden = [
    ];

    protected $fillable = [
        'transferer_id',
        'receiver_id',
        'amount',
        'message',
        'status',
    ];

    protected $casts = [
        'status' => TransactionStatus::class,
    ];

    protected $appends = [
    ];

    public function transferer(): BelongsTo
    {
        return $this->belongsTo(config('wallet.wallet.model', Wallet::class), 'transferer_id');
    }

    public function receiver(): BelongsTo
    {
        return $this->belongsTo(config('wallet.wallet.model', Wallet::class), 'receiver_id');
    }

    public function deleteAsTransferer(): void
    {
        if (null === $this->receiver_id) {
            $this->delete();

            return;
        }

        if (TransactionStatus::PENDING === $this->status) {
            $this->status = TransactionStatus::CANCELED;
        }

        $this->transferer_id = null;
        $this->save();
    }

    public function deleteAsReceiver(): void
    {
        if (null === $this->transferer_id) {
            $this->delete();

            return;
        }

        if (TransactionStatus::PENDING === $this->status) {
            $this->status = TransactionStatus::CANCELED;
        }

        $this->receiver_id = null;
        $this->save();
    }
}
