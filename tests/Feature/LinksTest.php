<?php

use Illuminate\Http\Client\Request;
use Illuminate\Support\Facades\Http;
use JeffersonGoncalves\Rewardful\Facades\Rewardful;

it('creates an affiliate link', function () {
    Http::fake([
        'api.getrewardful.com/v1/affiliates/aff-1/links' => Http::response(['id' => 'link-1', 'url' => 'https://example.com?via=aff-1'], 200),
    ]);

    expect(Rewardful::createAffiliateLink('aff-1', 'my-token', 'https://example.com'))
        ->toBe(['id' => 'link-1', 'url' => 'https://example.com?via=aff-1']);

    Http::assertSent(fn (Request $request) => $request->method() === 'POST'
        && $request->data()['token'] === 'my-token'
        && $request->data()['url'] === 'https://example.com');
});

it('creates an affiliate link without optional params', function () {
    Http::fake([
        'api.getrewardful.com/v1/affiliates/aff-1/links' => Http::response(['id' => 'link-1'], 200),
    ]);

    expect(Rewardful::createAffiliateLink('aff-1'))->toBe(['id' => 'link-1']);

    Http::assertSent(fn (Request $request) => $request->data() === []);
});

it('requires an affiliate id to create a link', function () {
    Rewardful::createAffiliateLink('');
})->throws(InvalidArgumentException::class, 'Affiliate ID is required.');
