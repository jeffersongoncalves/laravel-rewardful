<?php

namespace JeffersonGoncalves\Rewardful\Exceptions;

use RuntimeException;

/**
 * Raised when the Rewardful API answers a request with a non-2xx HTTP
 * status. Carries the response's error message (falling back to the raw
 * body) and the HTTP status code.
 */
class RewardfulException extends RuntimeException
{
    public function __construct(string $message, public readonly int $statusCode)
    {
        parent::__construct($message, $statusCode);
    }
}
