<?php

namespace JeffersonGoncalves\Rewardful\Facades;

use Illuminate\Support\Facades\Facade;
use JeffersonGoncalves\Rewardful\Rewardful as RewardfulClient;

/**
 * @see RewardfulClient
 */
class Rewardful extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return RewardfulClient::class;
    }
}
