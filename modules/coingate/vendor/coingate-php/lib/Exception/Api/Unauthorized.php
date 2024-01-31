<?php

namespace CoinGate\Exception\Api;

use CoinGate\Exception\ApiErrorException;

if (!defined('_PS_VERSION_')) {
    exit;
}

/**
 * Unauthorized is thrown when HTTP Status: 401 (Unauthorized).
 */
class Unauthorized extends ApiErrorException
{
}
