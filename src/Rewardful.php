<?php

namespace JeffersonGoncalves\Rewardful;

use Illuminate\Http\Client\PendingRequest;
use Illuminate\Http\Client\Response;
use Illuminate\Support\Facades\Http;
use InvalidArgumentException;
use JeffersonGoncalves\Rewardful\Exceptions\RewardfulException;

/**
 * Thin client for the Rewardful v1 REST API
 * (https://api.getrewardful.com/v1). Every method returns the raw decoded
 * JSON response as an array and authenticates the request via HTTP Basic
 * Auth, sending the API key as the username with an empty password.
 */
class Rewardful
{
    /**
     * @return array<string, mixed>
     */
    public function listAffiliates(int $page = 1): array
    {
        return $this->get('/affiliates', ['page' => $page]);
    }

    /**
     * @return array<string, mixed>
     */
    public function getAffiliate(string $id): array
    {
        return $this->get("/affiliates/{$id}");
    }

    /**
     * @return array<string, mixed>
     */
    public function searchAffiliateByEmail(string $email): array
    {
        return $this->get('/affiliates', ['email' => $email]);
    }

    /**
     * @param  array{first_name?: string, last_name?: string, paypal_email?: string}  $data
     * @return array<string, mixed>
     */
    public function updateAffiliate(string $id, array $data): array
    {
        return $this->put("/affiliates/{$id}", $data);
    }

    /**
     * @return array<string, mixed>
     */
    public function listReferrals(?string $affiliateId = null): array
    {
        return $this->get('/referrals', array_filter(['affiliate_id' => $affiliateId]));
    }

    /**
     * @return array<string, mixed>
     */
    public function getReferral(string $stripeCustomerId): array
    {
        return $this->get('/referrals', ['stripe_customer_id' => $stripeCustomerId]);
    }

    /**
     * @return array<string, mixed>
     */
    public function listCommissions(?string $affiliateId = null): array
    {
        return $this->get('/commissions', array_filter(['affiliate_id' => $affiliateId]));
    }

    /**
     * @return array<string, mixed>
     */
    public function getCommission(string $id): array
    {
        return $this->get("/commissions/{$id}");
    }

    /**
     * @return array<string, mixed>
     *
     * @throws InvalidArgumentException if `$affiliateId` is empty
     */
    public function createAffiliateLink(string $affiliateId, ?string $token = null, ?string $url = null): array
    {
        if ($affiliateId === '') {
            throw new InvalidArgumentException('Affiliate ID is required.');
        }

        $body = array_filter(['token' => $token, 'url' => $url]);

        return $this->post("/affiliates/{$affiliateId}/links", $body);
    }

    /**
     * @param  array<string, mixed>  $query
     * @return array<string, mixed>
     */
    private function get(string $uri, array $query = []): array
    {
        return $this->handle($this->http()->get($uri, $query));
    }

    /**
     * @param  array<string, mixed>  $body
     * @return array<string, mixed>
     */
    private function post(string $uri, array $body = []): array
    {
        return $this->handle($this->http()->post($uri, $body));
    }

    /**
     * @param  array<string, mixed>  $body
     * @return array<string, mixed>
     */
    private function put(string $uri, array $body = []): array
    {
        return $this->handle($this->http()->put($uri, $body));
    }

    private function http(): PendingRequest
    {
        return Http::withBasicAuth((string) config('rewardful.api_key'), '')
            ->baseUrl((string) config('rewardful.base_url', 'https://api.getrewardful.com/v1'))
            ->acceptJson();
    }

    /**
     * @return array<string, mixed>
     *
     * @throws RewardfulException
     */
    private function handle(Response $response): array
    {
        if ($response->failed()) {
            throw new RewardfulException($this->errorMessage($response), $response->status());
        }

        $data = $response->json();

        return is_array($data) ? $data : [];
    }

    private function errorMessage(Response $response): string
    {
        $data = $response->json();

        if (is_array($data)) {
            foreach (['message', 'error'] as $field) {
                if (is_string($data[$field] ?? null)) {
                    return $data[$field];
                }
            }
        }

        return $response->body() !== ''
            ? $response->body()
            : "Rewardful API request failed with status {$response->status()}.";
    }
}
