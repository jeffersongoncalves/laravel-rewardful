<?php

use Illuminate\Http\Client\Request;
use Illuminate\Support\Facades\Http;
use JeffersonGoncalves\Rewardful\Exceptions\RewardfulException;
use JeffersonGoncalves\Rewardful\Facades\Rewardful;

it('lists commissions', function () {
    Http::fake([
        'api.getrewardful.com/v1/commissions*' => Http::response(['data' => []], 200),
    ]);

    expect(Rewardful::listCommissions())->toBe(['data' => []]);
});

it('lists commissions filtered by affiliate id', function () {
    Http::fake([
        'api.getrewardful.com/v1/commissions*' => Http::response(['data' => []], 200),
    ]);

    Rewardful::listCommissions('aff-1');

    Http::assertSent(fn (Request $request) => str_contains($request->url(), 'affiliate_id=aff-1'));
});

it('gets a commission', function () {
    Http::fake([
        'api.getrewardful.com/v1/commissions/com-1' => Http::response(['id' => 'com-1'], 200),
    ]);

    expect(Rewardful::getCommission('com-1'))->toBe(['id' => 'com-1']);
});

it('throws when the commission is not found', function () {
    Http::fake([
        'api.getrewardful.com/v1/commissions/missing' => Http::response(['message' => 'Not found'], 404),
    ]);

    Rewardful::getCommission('missing');
})->throws(RewardfulException::class, 'Not found');
