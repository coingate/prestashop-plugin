<?php

namespace CoinGate\Exception;

if (!defined('_PS_VERSION_')) {
    exit;
}

/**
 * RateLimitException is thrown when API request limit is exceeded and HTTP Status: 429 (Too Many Requests).
 */
class RateLimitException extends ApiErrorException
{
}
