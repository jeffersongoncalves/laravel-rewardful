<?php

use Illuminate\Http\Client\Request;
use Illuminate\Support\Facades\Http;
use JeffersonGoncalves\Rewardful\Exceptions\RewardfulException;
use JeffersonGoncalves\Rewardful\Facades\Rewardful;

it('lists referrals', function () {
    Http::fake([
        'api.getrewardful.com/v1/referrals*' => Http::response(['data' => []], 200),
    ]);

    expect(Rewardful::listReferrals())->toBe(['data' => []]);

    Http::assertSent(fn (Request $request) => ! str_contains($request->url(), 'affiliate_id'));
});

it('lists referrals filtered by affiliate id', function () {
    Http::fake([
        'api.getrewardful.com/v1/referrals*' => Http::response(['data' => []], 200),
    ]);

    Rewardful::listReferrals('aff-1');

    Http::assertSent(fn (Request $request) => str_contains($request->url(), 'affiliate_id=aff-1'));
});

it('gets a referral by stripe customer id', function () {
    Http::fake([
        'api.getrewardful.com/v1/referrals*' => Http::response(['data' => [['id' => 'ref-1']]], 200),
    ]);

    expect(Rewardful::getReferral('cus_123'))->toBe(['data' => [['id' => 'ref-1']]]);

    Http::assertSent(fn (Request $request) => str_contains($request->url(), 'stripe_customer_id=cus_123'));
});

it('throws when the referrals request fails', function () {
    Http::fake([
        'api.getrewardful.com/v1/referrals*' => Http::response(['message' => 'Server error'], 500),
    ]);

    Rewardful::getReferral('cus_missing');
})->throws(RewardfulException::class, 'Server error');
