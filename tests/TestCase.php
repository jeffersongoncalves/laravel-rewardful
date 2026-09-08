<?php

namespace Jeffersongoncalves\Rewardful\Tests;

use Jeffersongoncalves\Rewardful\RewardfulServiceProvider;
use Orchestra\Testbench\TestCase as Orchestra;

class TestCase extends Orchestra
{
    protected function getPackageProviders($app): array
    {
        return [
            RewardfulServiceProvider::class,
        ];
    }
}
