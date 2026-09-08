<?php

use Illuminate\Http\Client\Request;
use Illuminate\Support\Facades\Http;
use JeffersonGoncalves\Rewardful\Exceptions\RewardfulException;
use JeffersonGoncalves\Rewardful\Facades\Rewardful;

it('lists affiliates', function () {
    Http::fake([
        'api.getrewardful.com/v1/affiliates*' => Http::response(['data' => [], 'total_pages' => 1], 200),
    ]);

    expect(Rewardful::listAffiliates(2))->toBe(['data' => [], 'total_pages' => 1]);

    Http::assertSent(fn (Request $request) => str_contains($request->url(), 'page=2'));
});

it('authenticates with basic credentials', function () {
    Http::fake([
        'api.getrewardful.com/v1/affiliates*' => Http::response([], 200),
    ]);

    Rewardful::listAffiliates();

    Http::assertSent(fn (Request $request) => $request->header('Authorization')[0]
        === 'Basic '.base64_encode('fake-api-key:'));
});

it('gets an affiliate', function () {
    Http::fake([
        'api.getrewardful.com/v1/affiliates/aff-1' => Http::response(['id' => 'aff-1'], 200),
    ]);

    expect(Rewardful::getAffiliate('aff-1'))->toBe(['id' => 'aff-1']);
});

it('searches an affiliate by email', function () {
    Http::fake([
        'api.getrewardful.com/v1/affiliates*' => Http::response(['data' => [['email' => 'jane@example.com']]], 200),
    ]);

    expect(Rewardful::searchAffiliateByEmail('jane@example.com'))->toBe(['data' => [['email' => 'jane@example.com']]]);

    Http::assertSent(fn (Request $request) => str_contains($request->url(), 'email=jane%40example.com'));
});

it('updates an affiliate', function () {
    Http::fake([
        'api.getrewardful.com/v1/affiliates/aff-1' => Http::response(['id' => 'aff-1', 'first_name' => 'Jane'], 200),
    ]);

    expect(Rewardful::updateAffiliate('aff-1', ['first_name' => 'Jane']))->toBe(['id' => 'aff-1', 'first_name' => 'Jane']);

    Http::assertSent(fn (Request $request) => $request->method() === 'PUT'
        && $request->data()['first_name'] === 'Jane');
});

it('throws when updating an unknown affiliate', function () {
    Http::fake([
        'api.getrewardful.com/v1/affiliates/missing' => Http::response(['message' => 'Not found'], 404),
    ]);

    Rewardful::updateAffiliate('missing', ['first_name' => 'Jane']);
})->throws(RewardfulException::class, 'Not found');
