<?php

namespace Jeffersongoncalves\Rewardful\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @see \Jeffersongoncalves\Rewardful\Rewardful
 */
class Rewardful extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return 'laravel-rewardful';
    }
}
