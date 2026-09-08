<?php

use JeffersonGoncalves\Rewardful\Facades\Rewardful as RewardfulFacade;
use JeffersonGoncalves\Rewardful\Rewardful;

it('registers the Rewardful singleton', function () {
    expect(app(Rewardful::class))->toBeInstanceOf(Rewardful::class);
});

it('resolves the facade to the Rewardful class', function () {
    expect(RewardfulFacade::getFacadeRoot())->toBeInstanceOf(Rewardful::class);
});

it('merges the rewardful config file', function () {
    expect(config('rewardful.base_url'))->toBe('https://api.getrewardful.com/v1');
});
