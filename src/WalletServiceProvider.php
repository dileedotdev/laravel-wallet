<?php

namespace Dinhdjj\Wallet;

use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;

class WalletServiceProvider extends PackageServiceProvider
{
    public function configurePackage(Package $package): void
    {
        $package
            ->name('wallet')
            ->hasConfigFile()
            // ->hasViews()
            ->hasMigration('create_wallet_tables')
            // ->hasCommand(LaravelWalletCommand::class)
        ;
    }

    public function packageRegistered(): void
    {
        $this->app->singleton('wallet', fn () => new Wallet());
    }
}
