<?php

// config for Dinhdjj/LaravelWallet
return [
    'wallet' => [
        'table' => 'wallets',
        'model' => \Dinhdjj\Wallet\Models\Wallet::class,
    ],

    'transaction' => [
        'table' => 'transactions',
        'model' => \Dinhdjj\Wallet\Models\Transaction::class,
    ],
];
