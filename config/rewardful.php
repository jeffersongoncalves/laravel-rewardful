<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Rewardful API Key
    |--------------------------------------------------------------------------
    |
    | Your Rewardful API key, sent as the username on every request's HTTP
    | Basic Auth header (with an empty password). Find it in your Rewardful
    | dashboard under Settings > API.
    |
    */
    'api_key' => env('REWARDFUL_API_KEY'),

    /*
    |--------------------------------------------------------------------------
    | Base URL
    |--------------------------------------------------------------------------
    |
    | The Rewardful v1 REST API base URL. Override only if Rewardful gives
    | you a dedicated endpoint.
    |
    */
    'base_url' => env('REWARDFUL_BASE_URL', 'https://api.getrewardful.com/v1'),
];
