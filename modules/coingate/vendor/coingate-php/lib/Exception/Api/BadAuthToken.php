<?php

namespace CoinGate\Exception\Api;

use CoinGate\Exception\ApiErrorException;

if (!defined('_PS_VERSION_')) {
    exit;
}

/**
 * BadAuthToken is thrown when auth token is not valid and HTTP Status: 401 (Unauthorized).
 */
class BadAuthToken extends ApiErrorException
{
}
