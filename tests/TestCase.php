<?php

namespace JeffersonGoncalves\Rewardful\Tests;

use JeffersonGoncalves\Rewardful\RewardfulServiceProvider;
use Orchestra\Testbench\TestCase as Orchestra;

class TestCase extends Orchestra
{
    protected function getPackageProviders($app): array
    {
        return [
            RewardfulServiceProvider::class,
        ];
    }

    protected function defineEnvironment($app): void
    {
        $app['config']->set('rewardful.api_key', 'fake-api-key');
        $app['config']->set('rewardful.base_url', 'https://api.getrewardful.com/v1');
    }
}
