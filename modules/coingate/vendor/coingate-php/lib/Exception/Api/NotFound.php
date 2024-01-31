<?php

namespace CoinGate\Exception\Api;

use CoinGate\Exception\ApiErrorException;

if (!defined('_PS_VERSION_')) {
    exit;
}

/**
 * NotFound is thrown when HTTP Status: 404 (Not Found).
 */
class NotFound extends ApiErrorException
{
}
