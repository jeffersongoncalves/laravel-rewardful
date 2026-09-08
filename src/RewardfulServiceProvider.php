<?php

namespace Jeffersongoncalves\Rewardful;

use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;

class RewardfulServiceProvider extends PackageServiceProvider
{
    public function configurePackage(Package $package): void
    {
        $package
            ->name('laravel-rewardful')
            ->hasConfigFile()
            ->hasViews()
            ->hasMigrations();
    }
}
