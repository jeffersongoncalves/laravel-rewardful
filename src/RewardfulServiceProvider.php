<?php

namespace JeffersonGoncalves\Rewardful;

use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;

class RewardfulServiceProvider extends PackageServiceProvider
{
    public function configurePackage(Package $package): void
    {
        $package
            ->name('rewardful')
            ->hasConfigFile();
    }

    public function packageRegistered(): void
    {
        $this->app->singleton(Rewardful::class);
    }
}
