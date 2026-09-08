<div class="filament-hidden">

![Laravel Rewardful](https://raw.githubusercontent.com/jeffersongoncalves/laravel-rewardful/main/art/jeffersongoncalves-laravel-rewardful.png)

</div>

# Laravel Rewardful

[![Latest Version on Packagist](https://img.shields.io/packagist/v/jeffersongoncalves/laravel-rewardful.svg?style=flat-square)](https://packagist.org/packages/jeffersongoncalves/laravel-rewardful)
[![GitHub Tests Action Status](https://img.shields.io/github/actions/workflow/status/jeffersongoncalves/laravel-rewardful/tests.yml?branch=main&label=tests&style=flat-square)](https://github.com/jeffersongoncalves/laravel-rewardful/actions?query=workflow%3Atests+branch%3Amain)
[![GitHub Code Style Action Status](https://img.shields.io/github/actions/workflow/status/jeffersongoncalves/laravel-rewardful/pint.yml?branch=main&label=code%20style&style=flat-square)](https://github.com/jeffersongoncalves/laravel-rewardful/actions?query=workflow%3A%22Fix+PHP+code+styling%22+branch%3Amain)
[![Total Downloads](https://img.shields.io/packagist/dt/jeffersongoncalves/laravel-rewardful.svg?style=flat-square)](https://packagist.org/packages/jeffersongoncalves/laravel-rewardful)
[![License](https://img.shields.io/packagist/l/jeffersongoncalves/laravel-rewardful.svg?style=flat-square)](LICENSE.md)

A Laravel client for the [Rewardful](https://www.getrewardful.com) affiliate and referral tracking API. A fluent `Rewardful` facade covers affiliates, referrals, commissions and affiliate links, authenticates every request with your API key as the HTTP Basic Auth username (empty password), and throws a `RewardfulException` on a non-2xx response instead of returning a silent error array.

## Features

- **Affiliates** — `listAffiliates()`, `getAffiliate()`, `searchAffiliateByEmail()`, `updateAffiliate()`
- **Referrals** — `listReferrals()`, `getReferral()`
- **Commissions** — `listCommissions()`, `getCommission()`
- **Affiliate Links** — `createAffiliateLink()`
- **Thin by design** — every method returns the raw decoded JSON response as an array, no DTOs
- **Fails loud** — a non-2xx API response throws `RewardfulException` carrying the API's error message and HTTP status code

## Installation

You can install the package via composer:

```bash
composer require jeffersongoncalves/laravel-rewardful
```

Optionally publish the config file:

```bash
php artisan vendor:publish --tag="rewardful-config"
```

## Configuration

Add to your `.env`:

```env
REWARDFUL_API_KEY=your-api-key
```

Find your API key in your Rewardful dashboard under **Settings > API**.

### Config Options

```php
// config/rewardful.php
return [
    'api_key' => env('REWARDFUL_API_KEY'),
    'base_url' => env('REWARDFUL_BASE_URL', 'https://api.getrewardful.com/v1'),
];
```

## Usage

```php
use JeffersonGoncalves\Rewardful\Exceptions\RewardfulException;
use JeffersonGoncalves\Rewardful\Facades\Rewardful;
```

### Affiliates

```php
Rewardful::listAffiliates(); // page 1
Rewardful::listAffiliates(2); // page 2

Rewardful::getAffiliate('affiliate-id');

Rewardful::searchAffiliateByEmail('jane@example.com');

Rewardful::updateAffiliate('affiliate-id', [
    'first_name' => 'Jane',
    'last_name' => 'Doe',
    'paypal_email' => 'jane@example.com',
]);
```

### Referrals

```php
Rewardful::listReferrals(); // all referrals
Rewardful::listReferrals('affiliate-id'); // filtered by affiliate

Rewardful::getReferral('stripe-customer-id');
```

### Commissions

```php
Rewardful::listCommissions(); // all commissions
Rewardful::listCommissions('affiliate-id'); // filtered by affiliate

Rewardful::getCommission('commission-id');
```

### Affiliate Links

```php
Rewardful::createAffiliateLink('affiliate-id');
Rewardful::createAffiliateLink('affiliate-id', token: 'my-token', url: 'https://example.com');
```

### Handling errors

```php
try {
    $affiliate = Rewardful::getAffiliate('affiliate-id');
} catch (RewardfulException $e) {
    // $e->getMessage()  — the API's error message, or the raw response body
    // $e->statusCode    — the HTTP status code returned by Rewardful
}
```

## Testing

```bash
composer test
```

## Static Analysis

```bash
composer analyse
```

## Code Formatting

```bash
composer format
```

## Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information on what has changed recently.

## Contributing

Please see [CONTRIBUTING](.github/CONTRIBUTING.md) for details.

## Security

Please review [our security policy](.github/SECURITY.md) on how to report security vulnerabilities.

## Credits

- [Jefferson Simão Gonçalves](https://github.com/jeffersongoncalves)
- [All Contributors](../../contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
